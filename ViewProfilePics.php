<?php


//create response object that is returned to the user
//based on results of request
$response = new stdClass();
$response->success = false;
$response->details = null;
$response->Pics = null;
$json_response = null;

$profilePics = scandir ( "ProfilePics");

if(!$profilePics){
	$response->success = false;
	$response->details = "Failed To Locate Profile Pictures";
	$json_response = json_encode($response);
	echo $json_response;
	return;
}



$size = sizeOf($profilePics);
//no profile pics found
if($size == 0){
	$response->success = false;
	$response->details = "No Profile Pictures Found";
	$json_response = json_encode($response);
	echo $json_response;
	return;
}

$result;

//remove all non profile pics from pics array
foreach ($profilePics as $pic){
	//is a png file
	if (strpos($pic , '.png') !== false) {
		$result[] = "ProfilePics/".$pic;
	}
}

$size = sizeOf($result);
//no profile pics found after false removals
if($size == 0){

	$response->success = false;
	$response->details = "No Profile Pictures Found";
	$json_response = json_encode($response);
	echo $json_response;
	return;
}

$response->Pics = $result;
$response->details = "Success";
$response->success = true;
$json_response = json_encode($response);
echo $json_response;

?>
