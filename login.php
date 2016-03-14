<?php

header('Content-type: text/html; charset=utf-8');
define('LINE_API_ENDPOINT', 'https://api.line.me/v1/oauth/accessToken');

$authcode = $_REQUEST["code"];

// Determine if authcode has been taken, if not, authentication and authorization is failed
if (isset($authcode)) {
	// use the authorization code and other information to issue an access token
	$info = array(
			'grant_type'=> "authorization_code",
			'client_id'=> "1441719742",
			'client_secret'=> "565d90464ccd3a1aa5d679ed26e3c6d5",
			'code'=> $authcode,
			'redirec_uri'=> 'https://trial-tw-pay.line.me/line_login' 
			);
	
	$userToken = get_token($info); // send infomation to get access token
	$tmp = json_decode($userToken);
	$token = $tmp->access_token;
	$res = get_user_profile($token);

	echo $res;
} 
else { // authentication and authorization is failed, display error code & message on screen
    $errorCode = $_REQUEST["errorCode"];
	$errorMsg = $_REQUEST["errorMessage"];
	
	$eArray = array(
		"errorCode" => $errorCode,
        "errorMessage" => $errorMsg
	);
	// make it more readable and display.
	$output = json_encode($eArray,JSON_PRETTY_PRINT);
	echo "<pre>" . $output . "</pre>";
}   

function get_token($data) {
	$ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, LINE_API_ENDPOINT);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	
	//getting response from server
    $response = curl_exec($ch);
	
    if (curl_errno($ch)) {
        // moving to display page to display curl errors
        print_r(curl_error($ch));
    } 
    else {
        //closing the curl
        curl_close($ch);
    }
	return $response;
}

function get_user_profile($token) {
	// setting the curl parameters
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, "https://api.line.me/v1/profile");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:'. "Bearer ". $token));
		
	//getting response from server
    $response = curl_exec($ch);
	
    if (curl_errno($ch)) {
        // moving to display page to display curl errors
        print_r(curl_error($ch));
    } 
    else {
        //closing the curl
        curl_close($ch);
    }
	return $response;
}

?>