<?php
include 'sync-spreadsheet.php';
/** @var ListEntry */
date_default_timezone_set('Pacific/Auckland');
$rangeName = 'Test fu name!A2:AG';
//$result = $service->spreadsheets_values->get($spreadsheetId, $rangeName);
//echo var_export($result, true), "\n";
$firstname = "TEst";
$email = 'test@gmia.col,';
$phone = 1232132;
$enquiry = '';
$subscribe = TRUE;
$wheretoopen = 'here';
$howsoon = 'Now';
$source = "test";
$medium = "test";
$campaign = "test";
$formpage = "test";
$identifier = "test";
$location = "test";
$country = "test";
$options = array('valueInputOption' => 'RAW');
$values = [
    ["", "", date("Y-m-d H:i:s"), 'Anh', '', 'anhpt@traffic.net.nz', 1231233, 'none', 'message', 'policy', 'optout', '', '', 'source', '', '', '', '', 'url', 'form', '', '', 'auckland', '1025', '', '', '', '', '', '', 'types', 'seen']
];
$v = [
    [
        ROW['STATUS'] => '',
        ROW['NOTES'] => '',
        ROW['DATE'] => date("Y-m-d H:i:s"),
        ROW['FIRST_NAME'] => $firstname,
        ROW['LAST_NAME'] => '',
        ROW['EMAIL'] => $email,
        ROW['PHONE'] => $phone,
        ROW['MESSAGE'] => $enquiry,
        ROW['PREFERRED_TIME'] => '',
        ROW['PRIVACY_POLICY'] => $privacy,
        ROW['OPT_OUT'] => FALSE,
        ROW['WHERE_TO'] => $wheretoopen,
        ROW['HOW_SOON'] => $howsoon,
        ROW['UTM_SOURCE'] => $source,
        ROW['UTM_CAMPAIGN'] => $campaign,
        ROW['UTM_MEDIUM'] => $medium,
        ROW['UTM_CONTENT'] => '',
        ROW['UTM_KEYWORD'] => '',
        ROW['LANDING_PAGE'] => $formpage,
        ROW['FORM_IDENTIFIER'] => $identifier,
        ROW['MOBILE'] => '',
        ROW['ADDRESS'] => '',
        ROW['CITY'] => '',
        ROW['POSTCODE'] => '',
        ROW['SUBURB'] => '',
        ROW['COUNTRY'] => $country,
        ROW['BUDGET'] => '',
        ROW['DAY_START'] => '',
        ROW['MONTH_START'] => '',
        ROW['YEAR_START'] => '',
        ROW['TYPE'] => '',
        ROW['SEEN_HEARD'] => '',
    ]
];
var_dump($v);
//die;
$body = new Google_Service_Sheets_ValueRange(['values' => $v]);

$result = $service->spreadsheets_values->append($spreadsheetId, $rangeName, $body, $options);
// END APPEND NEW ROW
?>
