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
$spreadsheetId = '1vPnMsHP-UnRCjl0rYqsiJ7Y_RL4ZzuhqqEyphlkRe0s';  // Oncore FW spreadsheet id.
if($privacy == "on" || $privacy == "1" || $privacy == 1 || $privacy == "True") {
    $privacy = "TRUE";
} else {
    $privacy = "FALSE";
}
$sheetInfo = $service->spreadsheets->get($spreadsheetId)->getProperties();
const ROW = [
    'STATUS' => 0,
    'DATE' => 1,
    'FIRST_NAME' => 2,
    'LAST_NAME' => 3,
    'EMAIL' => 4,
    'PHONE' => 5,
    'CAPITAL' => 6,
    'WHERE_TO' => 7,
    'HOW_SOON' => 8,
    'UTM_SOURCE' => 9,
    'UTM_CAMPAIGN' => 10,
    'UTM_MEDIUM' => 11,
    'UTM_CONTENT' => 12,
    'UTM_KEYWORD' => 13,
    'GCLID' => 14,
    'LANDING_PAGE' => 15,
    'PIPELINE' => 16,
    'TERRITORY' => 17,
    'COMMENTS' => 18,
    'LINKEDIN_PROFILE' => 19
];