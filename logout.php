<?php

header('Content-type: text/html; charset=utf-8');
define('LINE_API_ENDPOINT', 'https://api.line.me/v1/oauth/logout');

$url = LINE_API_ENDPOINT;
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

curl_close($ch);
echo $result;

?>