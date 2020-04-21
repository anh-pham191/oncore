<?php
include 'sync-spreadsheet.php';
isset($firstname)? : $firstname="";
isset($email)? : $email="";
isset($phone)? : $phone="";
isset($tenant_email)? : $tenant_email="";

const ROW_DIFF = 2;
const EMAIL = 5;
const UPDATE_FROM_COL = 'AI';

$result = $service->spreadsheets_values->get($spreadsheetId, $rangeName);

foreach ($result as $key => $r) {
    if($r[EMAIL] == $tenant_email) {
        $row = $key + ROW_DIFF;
    }
}
//var_dump($result); die; //

$options = array('valueInputOption' => 'RAW');
$values = [
    [$firstname, $email, $phone]
];

//
$body = new Google_Service_Sheets_ValueRange(['values' => $values]);
if(!empty($row) && isset($row)) {
    $result = $service->spreadsheets_values->update($spreadsheetId, $workSheet.UPDATE_FROM_COL.''.$row.':AK' , $body, $options);
    $time = date('m/d/Y h:i:s a', time());
    $fp = fopen('../log/sheet-stage2-log.csv', 'a+');
    fputcsv($fp,array($time, $workSheet.UPDATE_FROM_COL.''.$row.':AK',$firstname, $email,$mobile, $tenant_email));
    fclose($fp);

} else {
    $time = date('m/d/Y h:i:s a', time());
    $fp = fopen('../log/sheet-stage2-log.csv', 'a+');
    fputcsv($fp,array($time, 'different email', $workSheet.UPDATE_FROM_COL.''.$row.':AG',$firstname, $email,$mobile,$tenant_email));
    fclose($fp);

    $emailsubject = "Submission from Oncore - HHS Enquiry - Spreadsheet API Stage 2 down - Can't find matching row";
    $emailmessage = "Time: " .$time. "\n\n". "Row" .$workSheet.UPDATE_FROM_COL.''.$row.':AK'.'\n\n' ."Owner name: ".$firstname . "\n\n". "Owner Email: ".$email ."\n\n" ."Owner Mobile: ".$phone."\n\n". "Tenant email: "
        .$tenant_email ."\n\n"
       ;
    mail('anhpt@traffic.net.nz',$emailsubject,$emailmessage,"From: ".$emailfromaddress."\r\n"."Content-type: text/plain; charset=utf-8\r\n");	// If any headers come via form input ensure this is sanitised
}


?>
