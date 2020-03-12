<?php
include 'sync-spreadsheet.php';
/** @var ListEntry */
date_default_timezone_set('Pacific/Auckland');
$rangeName = 'Oncore NZ!A2:AG';
$options = array('valueInputOption' => 'RAW');
isset($firstname)? : $firstname="";
isset($lastname)? : $lastname="";
isset($email)? : $email="";
isset($phone)? : $phone="";
isset($enquiry)? : $enquiry="";
isset($privacy)? : $privacy="";
isset($wheretoopen)? : $wheretoopen="";
isset($howsoon)? : $howsoon="";
isset($source)? : $source="";
isset($campaign)? : $campaign="";
isset($medium)? : $medium="";
isset($formpage)? : $formpage="";
isset($identifier)? : $identifier="";
isset($location)? : $location="";
isset($country)? : $country="";
isset($how)? : $how="";
$v = [
    [
        ROW['STATUS'] => '',
        ROW['NOTES'] => '',
        ROW['DATE'] => date("Y-m-d H:i:s"),
        ROW['FIRST_NAME'] => $firstname,
        ROW['LAST_NAME'] => $lastname,
        ROW['EMAIL'] => $email,
        ROW['PHONE'] => $phone,
        ROW['PREFERRED_TIME'] => '',
        ROW['MESSAGE'] => $enquiry,
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
        ROW['SUBURB'] => $location,
        ROW['COUNTRY'] => $country,
        ROW['BUDGET'] => '',
        ROW['DAY_START'] => '',
        ROW['MONTH_START'] => '',
        ROW['YEAR_START'] => '',
        ROW['TYPE'] => '',
        ROW['SEEN_HEARD'] => '',
        ROW['HOW_CAN_WE_HELP'] => $how,
    ]
];
$body = new Google_Service_Sheets_ValueRange(['values' => $v]);

$result = $service->spreadsheets_values->append($spreadsheetId, $rangeName, $body, $options);
// END APPEND NEW ROW
?>
