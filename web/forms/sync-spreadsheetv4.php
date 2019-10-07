<?php
require_once 'google-api-php-client-2.2.2/vendor/autoload.php';
require '../../vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/client_secret.json');
set_time_limit(0);
$client = new Google_Client;
$client->useApplicationDefaultCredentials();

$client->setApplicationName("Something to do with my representatives");

$client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);

if ($client->isAccessTokenExpired()) {
    $client->refreshTokenWithAssertion();
}
$accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
\Google\Spreadsheet\ServiceRequestFactory::setInstance(
    new \Google\Spreadsheet\DefaultServiceRequest($accessToken)
);
//  Initiate curl
$ch = curl_init();
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,"https://www.googleapis.com/drive/v3/files
             ?q=mimeType%3D'application%2Fvnd.google-apps.spreadsheet");
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
var_dump(json_decode($result, true));


//
//
//// Get our spreadsheet
//$spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
//    ->getSpreadsheetFeed()
//    ->getByTitle('Oncore International - Consumer Lead Tracker - DO NOT EDIT');
//
//// Get the first worksheet (tab)
//$worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
//$worksheet = $worksheets[0];
//
//$listFeed = $worksheet->getListFeed();
//if($privacy == "on" || $privacy == "1" || $privacy == 1 || $privacy == "True") {
//    $privacy = "TRUE";
//} else {
//    $privacy = "FALSE";
//}