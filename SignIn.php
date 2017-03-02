<?php
session_start();

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
$json_response = null;


// Connect to database
$conn = new mysqli($dbServer, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $response->details = $conn->connect_error;
	$json_response = json_encode($response);
	echo $json_response;
	session_destroy(); 
	return;
} 

//check that user name and password are given
$userName = $_REQUEST["userName"];
$Password = $_REQUEST["Password"];

$valid = true;
$response->details = "";

if($userName == ""){
	$valid = false;
	$response->details = $response->details."No Username Provided <br></br>";
}

if($Password == ""){
	$valid = false;
	$response->details = $response->details."No Password Provided <br></br>";
}
if(!$valid){
	$json_response = json_encode($response);
	echo $json_response;
	session_destroy(); 
	$conn->close();
	return;
}

$_SESSION["userName"] = $userName;

//check user name and password are a matching set in data base
//if not end session, else send success response
$sql2 = "SELECT UserName, UserPass, UserPic, ID FROM users";
$users = $conn->query($sql2);

if($users == false){
	$response->details = $conn->error;
	$json_response = json_encode($response);
	echo $json_response;
	session_destroy(); 
	$conn->close();
	return;
}

if ($users->num_rows > 0) {
    while($user = $users->fetch_assoc()) {
		if($user["UserName"] == $userName){
			
			//success
			if($user["UserPass"] == $Password){
				$_SESSION["profilePicture"] = $user["UserPic"];
				$_SESSION["UserID"] = $user["ID"];
				$response->details = "Success";
				$response->success = true;
				$json_response = json_encode($response);
				echo $json_response;
				$conn->close();
				return;
			}
			//wrong password
			else{
				$response->details = "Incorrect Password";
				$json_response = json_encode($response);
				echo $json_response;
				$conn->close();
				session_destroy(); 
				return;
			}
		}
    }
}
//username does not exist
$response->details = "Username Does Not Exist";
$json_response = json_encode($response);
echo $json_response;
session_destroy(); 
$conn->close();
?>
