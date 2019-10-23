<?php
require_once 'google-api-php-client-2.2.2/vendor/autoload.php';
require '../../vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/client_secret.json');

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
$client = new Google_Client;
$client->useApplicationDefaultCredentials();

$client->setApplicationName("Something to do with my representatives");

$client->setScopes(['https://www.googleapis.com/auth/drive', 'https://spreadsheets.google.com/feeds']);

if ($client->isAccessTokenExpired()) {
    $client->refreshTokenWithAssertion();
}
$accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
\Google\Spreadsheet\ServiceRequestFactory::setInstance(
    new \Google\Spreadsheet\DefaultServiceRequest($accessToken)
);
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1todvmVvg3h54Iog6pxm9GYeVDO8AEzCMHC4wTAdmBe0';  // Oncore spreadsheet id.
if($privacy == "on" || $privacy == "1" || $privacy == 1 || $privacy == "True" || $privacy == True) {
    $privacy = "TRUE";
} else if ($privacy == "off" || $privacy == "0" || $privacy == 0 || $privacy == "False" || $privacy == False) {
    $privacy = "FALSE";
} else {
    $privacy = "";
}
$sheetInfo = $service->spreadsheets->get($spreadsheetId)->getProperties();
const ROW = [
    'STATUS' => 0,
    'NOTES' => 1,
    'DATE' => 2,
    'FIRST_NAME' => 3,
    'LAST_NAME' => 4,
    'EMAIL' => 5,
    'PHONE' => 6,
    'PREFERRED_TIME' => 7,
    'MESSAGE' => 8,
    'PRIVACY_POLICY' => 9,
    'OPT_OUT' => 10,
    'WHERE_TO' => 11,
    'HOW_SOON' => 12,
    'UTM_SOURCE' => 13,
    'UTM_CAMPAIGN' => 14,
    'UTM_MEDIUM' => 15,
    'UTM_CONTENT' => 16,
    'UTM_KEYWORD' => 17,
    'LANDING_PAGE' => 18,
    'FORM_IDENTIFIER' => 19,
    'MOBILE' => 20,
    'ADDRESS' => 21,
    'CITY' => 22,
    'POSTCODE' => 23,
    'SUBURB' => 24,
    'COUNTRY' => 25,
    'BUDGET' => 26,
    'DAY_START' => 27,
    'MONTH_START' => 28,
    'YEAR_START' => 29,
    'TYPE' => 30,
    'SEEN_HEARD' => 31,
];