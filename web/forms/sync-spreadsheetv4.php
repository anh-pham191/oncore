<?php
require $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';


putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/client_secret.json');
if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

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
$spreadsheetId = '1GkglwKt8c0_FKcyY2bUYCk1s5RxA5aD5fL7-lu3mkwA';  // TODO: Update zones spreadsheet id.

$sheetInfo = $service->spreadsheets->get($spreadsheetId)->getProperties();
print($sheetInfo['title']. PHP_EOL);

//$options = array('valueInputOption' => 'RAW');
//$values = [
//   ["", "", date("Y-m-d H:i:s"), 'Anh', '', 'anhpt@traffic.net.nz', 1231233, 'none', 'message','policy', 'optout', '', '', 'source', '', '', '', '', 'url','form', '', '', 'auckland', '1025', '', '', '', '', '', '', 'types', 'seen']
//];
//
//$body   = new Google_Service_Sheets_ValueRange(['values' => $values]);
//
//$result = $service->spreadsheets_values->append($spreadsheetId, 'Test fu name!A1:C1', $body, $options);


$options = array('valueInputOption' => 'RAW');
$values = [
    ["", "", date("Y-m-d H:i:s"), 'Anh', '', 'anhpt@traffic.net.nz', 1231233, 'none', 'message','policy', 'optout', '', '', 'source', '', '', '', '', 'url','form', '', '', 'auckland', '1025', '', '', '', '', '', '', 'types', 'seen']
];

$body   = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(['values' => $values]);

$result = $service->spreadsheets->batchUpdate($spreadsheetId, $body, $options);

print($result->updatedRange. PHP_EOL);
