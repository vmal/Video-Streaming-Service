<?php

//database info
$username = "root";
$password = "root";
$dbServer = "localhost"; 
$dbName   = "Portfolio2";

//create response object that is returned to the user
//based on results of request
$response = new stdClass();
$response->success = false;
$response->details = null;
$json_response = null;


// Connect to database
$conn = new mysqli($dbServer, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    //die("Failed To Connect To DataBase: " . $conn->connect_error);
	$response->details = $conn->connect_error;
	$json_response = json_encode($response);
	echo $json_response;
	return;
} 

//confirm all the needed information is given to add a new user.
$userName = $_REQUEST["userName"];
$Password = $_REQUEST["Password"];
$userPic = $_REQUEST["UserPic"];

//verify all the given information is valid
$result = true;
$response->details = "";
		
		//confirm user name
		if($userName == ""){
			$result = false;
			$response->details = $response->details."User Name Is Empty <br></br>";
		}
		else if(!ctype_alnum($userName)){
			$result = false;
			$response->details = $response->details."User Name Is Not AlphaNumeric <br></br>";
		}
       

        //confirm password
        if ($Password == "") {
            $result = false;
            $response->details = $response->details."Password Is Empty <br></br>";
        }

		//confirm file path for user pic exists
		if(!file_exists ( $userPic)){
			$result = false;
			$response->details = $response->details."User Picture Is Invalid <br></br>";
		}


//some problem was found
if(!$result){
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}

//check if username is already in use on the table.
$sql2 = "SELECT UserName FROM users";
$users = $conn->query($sql2);
if($users == false){
	$response->details = $conn->error;
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}

if ($users->num_rows > 0) {
    while($user = $users->fetch_assoc()) {
		if($user["UserName"] == $userName){
			$response->details = "Username Taken";
			$json_response = json_encode($response);
			echo $json_response;
			$conn->close();
			return;
		}
    }
}

//find next available userID
$sql3 = "SELECT ID FROM users ORDER BY ID DESC;";
$IDS = $conn->query($sql3);
$newID;

if($IDS == false){
	$response->details = $conn->error;
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
}

if ($IDS->num_rows > 0) {
	$ID = $IDS->fetch_assoc();
    $newID = $ID["ID"] + 1;
}
else{
	$newID = 1;
}


//add new user to database
$sql3 = "INSERT INTO users (UserName, UserPass, UserPic, ID) 
 VALUES(
 '$userName'
 ,'$Password'
 ,'$userPic'
 ,$newID)";


if ($conn->query($sql3) == false) {
	$response->details = $conn->error;
	$json_response = json_encode($response);
	echo $json_response;
	$conn->close();
	return;
} 

$response->details = "Added User";
$response->success = true;
$json_response = json_encode($response);
echo $json_response;

//close connection to database
$conn->close();
?>
