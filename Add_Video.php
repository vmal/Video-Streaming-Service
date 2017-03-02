<?php
session_start();

//function for incrementing a string value for the videos paths
//and the thumbnail paths. This is use along with preg_replace_callback
function increaseCount($integer_part) {
    return ++$integer_part[1];
}

//database info
$username = "root";
$password = "root";
$dbServer = "localhost"; 
$dbname = "Portfolio2";

//variables necessary for adding new video
$ThumbNail;
$Video;
$newVideoPath;
$newThumbNailPath;
$creatorID;
$VideoName;
$Tags;


//create response object that is returned to the user
//based on results of request
$response = new stdClass();
$response->success = false;
$response->details = null;
$json_response = null;


// Connect to database
$conn = new mysqli($dbServer, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $response->details = $conn->connect_error;
	$json_response = json_encode($response);
	echo $json_response;
	return;
} 

//check that all required info is provided

$response->details = "";
$success = true;

//ThumbNail
//check file is uploaded
if(!isset($_FILES['ThumbNail']) || $_FILES['ThumbNail']['error'] == UPLOAD_ERR_NO_FILE) {
    $response->details = $response->details."No ThumbNail File Uploaded<br>";
	$success = false;
} 
$ThumbNail = $_FILES['ThumbNail'];
$ThumbNailExt = pathinfo($ThumbNail["name"], PATHINFO_EXTENSION);
//check file is of correct type
if($ThumbNailExt != "png"){
	$response->details = $response->details."Invalid Video File Uploaded<br>";
	$success = false;
}

//Video
//check file is uploaded
if(!isset($_FILES['Video']) || $_FILES['Video']['error'] == UPLOAD_ERR_NO_FILE) {
    $response->details = $response->details."No Video File Uploaded<br>";
	$success = false;
} 
$Video = $_FILES['Video'];
$VideoExt = pathinfo($Video["name"], PATHINFO_EXTENSION);
//check file is of correct type
if($VideoExt != "mp4"){
	$response->details = $response->details."Invalid Video File Uploaded<br>";
	$success = false;
}

//video name
if(!isset($_REQUEST["VideoName"])){
	$response->details = $response->details."Video Name Not Provided<br>";
	$success = false;
}

//Binary Tag
if(!isset($_REQUEST["Tags"])){
	$response->details = $response->details."Tag Info Not Provided<br>";
	$success = false;
}
else{
	$Tags = $_REQUEST["Tags"];
	if(strlen($Tags) != 8){
		$response->details = $response->details."Invalid Tag Info Provided<br>";
		$success = false;
	}
	else{
		for( $i = 0; $i < 8; $i++ ) {
			$char = substr( $Tags, $i, 1 );
			if($char == "0" || $char == "1"){
				continue;
			}
			else{
				$response->details = $response->details."Invalid Tag Info Provided<br>";
				$success = false;
				break;
			}
		}
	}
}

//user name
if(!isset($_SESSION["userName"])){
	$response->details = $response->details."Session Expired<br>";
	$success = false;
}


//check verification
if(!$success){
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}

$VideoName = $_REQUEST["VideoName"];

//find the next available video path
$sql = "SELECT videoPath FROM videos ORDER BY videoPath DESC";
$videoPaths = $conn->query($sql);

if($videoPaths == false){
	$response->details = $conn->error;
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}

if ($videoPaths->num_rows > 0) {
	$videopath = $videoPaths->fetch_assoc();
	$newVideoPath = $videopath["videoPath"];	
	$newVideoPath =  preg_replace_callback( "|(\d+)|", "increaseCount", $newVideoPath);
	// need to fix mp4 since the increase count made it mp5
 	$newVideoPath = substr($newVideoPath, 0, -1)."4";  
}
else{
	$newVideoPath = "Videos/vid1.mp4";
}


//find the next available thumbnail path.
$sql2 = "SELECT videoPic FROM videos ORDER BY videoPic DESC";
$ThumbNailPaths = $conn->query($sql2);

if($ThumbNailPaths == false){
	$response->details = $conn->error;
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}


if ($ThumbNailPaths->num_rows > 0) {
	$ThumbNailPath = $ThumbNailPaths->fetch_assoc();
	$newThumbNailPath = $ThumbNailPath["videoPic"];	
	$newThumbNailPath =  preg_replace_callback( "|(\d+)|", "increaseCount", $newThumbNailPath);
	
}
else{
	$newThumbNailPath = "ThumbNails/thumb1.png";
}

//get the creatorID
$UserName = $_SESSION["userName"];
$sql3 = "SELECT ID FROM users WHERE UserName=\"$UserName\"";
$User = $conn->query($sql3);

if($User == false){
	$response->details = $conn->error;
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}

if ($User->num_rows > 0) {
	$ID = $User->fetch_assoc();
	$creatorID = $ID["ID"];
}
else{
	$response->details = "Session ID Lost";
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}

//everything is prepared time to add files 
//to there folders and add entry to database
move_uploaded_file($ThumbNail["tmp_name"], $newThumbNailPath);
move_uploaded_file($Video["tmp_name"], $newVideoPath);

$sql4 = "INSERT INTO videos (creatorID,videoPath,videoName,videoPic,videoTags,uploadDate)
VALUES ($creatorID, \"$newVideoPath\", \"$VideoName\", \"$newThumbNailPath\", \"$Tags\", NOW())";

if ($conn->query($sql4) == false) {
	$response->details = $conn->error;
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
} 

$response->details = "Video Added";
$response->success = true;
$json_response = json_encode($response);
echo $json_response;

//close connection to database
$conn->close();
?>
