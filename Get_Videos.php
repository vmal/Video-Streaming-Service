<?php
session_start();

function getTags($bintags) {
    $tags = "";
	if(($bintags & "10000000") === "10000000"){
		$tags = $tags."Funny ";
	}
	if(($bintags & "01000000") === "01000000"){
		$tags = $tags."Educational ";
	}
	if(($bintags & "00100000") === "00100000"){
		$tags = $tags."Music ";
	}
	if(($bintags & "00010000") === "00010000"){
		$tags = $tags."News ";
	}
	if(($bintags & "00001000") === "00001000"){
		$tags = $tags."Animal ";
	}
	if(($bintags & "00000100") === "00000100"){
		$tags = $tags."VideoGame ";
	}
	if(($bintags & "00000010") === "00000010"){
		$tags = $tags."Sport ";
	}
	if(($bintags & "00000001") === "00000001"){
		$tags = $tags."MovieTrailer ";
	}
	
	if($tags === ""){
		$tags = "None";
	}
	return $tags;
}

//database info
$username = "root";
$password = "root";
$dbServer = "localhost"; 
$dbname = "Portfolio2";

//create response object that is returned to the user
//based on results of request
$response = new stdClass();
$response->success = false;
$response->details = null;
$response->videos = null;
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

//check byOrder field given
if(!isset($_REQUEST['byOrder'])){
    $response->details = "Video Order Not Specified";
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
} 

$Order = $_REQUEST['byOrder'];
$vids = []; 

if($Order == "username"){
	//get all videos by session user
	if(!isset($_SESSION["UserID"])){
		$response->details = "Session Expired";
		$json_response = json_encode($response);
		echo $json_response;
		$conn->close();
		return;
	}
	
	$USERID = $_SESSION["UserID"];
	
	$sql = "SELECT UserName, videoPath, videoName, videoPic, videoTags
	FROM videos
	INNER JOIN users
	ON ID=creatorID
	WHERE ID=$USERID
	ORDER BY uploadDate DESC;";
	
	$videos = $conn->query($sql);
	if($videos == false){
		$response->details = $conn->error;
		$json_response = json_encode($response);
		echo $json_response;
		$conn->close();	
		return;
	}


	if ($videos->num_rows > 0) {
		while($video = $videos->fetch_assoc()) {
			$vid = new stdClass();
			$vid->name = $video["videoName"];
			$vid->path = $video["videoPath"];
			$vid->thumb = $video["videoPic"];
			$vid->creator = $video["UserName"];
			$binTags = $video["videoTags"];
			$vid->tags = getTags($binTags);
			$vids[] = $vid;
		}
	}
	else{
		$response->details = "No Videos Found";
		$json_response = json_encode($response);
		echo $json_response;
		$conn->close();
		return;
	}
}
else if($Order == "tag"){
	//get all videos by tag
	if(!isset($_REQUEST['Tags'])){
		$response->details = "Video Order Not Specified";
		$json_response = json_encode($response);
		echo $json_response;
		$conn->close();
		return;
	} 
	
	$givenTag = $_REQUEST['Tags'];
	
	$sql = "SELECT users.UserName, videoPath, videoName, videoPic, videoTags
	FROM videos
	INNER JOIN users
	ON ID=creatorID
	ORDER BY uploadDate DESC";
	
	$videos = $conn->query($sql);
	if($videos == false){
		$response->details = $conn->error;
		$json_response = json_encode($response);
		echo $json_response;
		$conn->close();	
		return;
	}


	if ($videos->num_rows > 0) {
		while($video = $videos->fetch_assoc()) {
			$vidTag = $video["videoTags"];
			$check = $vidTag & $givenTag;
			if($check === $givenTag){
				$vid = new stdClass();
				$vid->name = $video["videoName"];
				$vid->path = $video["videoPath"];
				$vid->thumb = $video["videoPic"];
				$vid->creator = $video["UserName"];
				$binTags = $video["videoTags"];
				$vid->tags = getTags($binTags);
				$vids[] = $vid;
			}
		}
	}
	else{
		$response->details = "No Videos Found";
		$json_response = json_encode($response);
		echo $json_response;
		$conn->close();
		return;
	}
	

}
else{
	$response->details = "Invalid Order Given";
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}

if(count($vids) == 0){
	$response->details = "No Videos Found";
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}

$response->details = "success";
$response->success = true;
$response->videos = $vids;
$json_response = json_encode($response);
echo $json_response;
$conn->close();
?>
