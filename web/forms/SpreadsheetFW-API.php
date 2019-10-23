<?php
include 'sync-spreadsheetFW.php';
/** @var ListEntry */
date_default_timezone_set('Pacific/Auckland');
$rangeName = 'Lead Data NZ!A2:AG';
$options = array('valueInputOption' => 'RAW');
isset($firstname)? : $firstname="";
isset($email)? : $email="";
isset($phone)? : $phone="";
isset($wheretoopen)? : $wheretoopen="";
isset($howsoon)? : $howsoon="";
isset($source)? : $source="";
isset($campaign)? : $campaign="";
isset($medium)? : $medium="";
isset($formpage)? : $formpage="";
isset($gclid)? : $gclid="";
$v = [
    [
        ROW['STATUS'] => '',
        ROW['DATE'] => date("Y-m-d H:i:s"),
        ROW['FIRST_NAME'] => $firstname,
        ROW['LAST_NAME'] => '',
        ROW['EMAIL'] => $email,
        ROW['PHONE'] => $phone,
        ROW['CAPITAL'] => '',
        ROW['WHERE_TO'] => $wheretoopen,
        ROW['HOW_SOON'] => $howsoon,
        ROW['UTM_SOURCE'] => $source,
        ROW['UTM_CAMPAIGN'] => $campaign,
        ROW['UTM_MEDIUM'] => $medium,
        ROW['UTM_CONTENT'] => '',
        ROW['UTM_KEYWORD'] => '',
        ROW['GCLID'] => $gclid,
        ROW['LANDING_PAGE'] => $formpage,
    ]
];
$body = new Google_Service_Sheets_ValueRange(['values' => $v]);

$result = $service->spreadsheets_values->append($spreadsheetId, $rangeName, $body, $options);
// END APPEND NEW ROW
?>
