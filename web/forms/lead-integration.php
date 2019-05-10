<?php
$request_body = file_get_contents("php://input");
$data = json_decode($request_body,true);
$time = date('m/d/Y h:i:s a', time());
$fp = fopen('../log/testlog.csv', 'a+');
fputcsv($fp,array($time,$request_body));
fclose($fp);
//exit;
include '../includes/emails.php';

function cleanData($input) {
    $output = trim($input);
    $output = addslashes($input); // Needed for Ubiquity
    $output = htmlspecialchars($output, ENT_NOQUOTES, 'UTF-8'); // Disallows code tags
    return $output;
}

$firstname = cleanData($data['firstname']);
$lastname = cleanData($data['lastname']);
$email = cleanData($data['email']);
$phone = cleanData($data['phone']);
$country = cleanData($data['country']);
$frompage = cleanData($data['website']);
$campaign = cleanData($data['campaign']);
$source = cleanData($data['source']);
$medium = cleanData($data['medium']);
$leadsource = cleanData($data['leadsource']);
$wheretoopen = cleanData($data['wheretoopen']);
$howsoontoopen = cleanData($data['howsoontoopen']);
$enquiry = cleanData($data['enquiry']);


if($leadsource == "Lead PPC"){
    if($source=="Facebook Ads" || $source=="Facebooks Ads" || $source=="Facebook+Ads" || $source=="Facebooks+Ads"){
        $source = "CPC - Facebook Lead PPC";
        $medium = "CPC";
    }else if($source=="Google Ads"){
        $source = "CPC - Google Ads Lead PPC";
        $medium = "CPC";
    }
}



$url = "https://api.ubiquity.co.nz/forms/8Fa2lrc_oU23fQjW1VFr1A/submit?apiToken=vaxIncJDcdcyEaK6KaIUV8uAtJOKR5uCB2HJhWtd4LGbeh7KORxzeqQNjPIaOREIrsK7he-3zjY8zoG4OJwIQk7ORyCuHgQA4BwqSK2V-2IH3mwvH0rMzrqQscjMLW5rOXUQXgksMjs";

$jsonData = "{
\"data\": [
{
\"fieldID\": \"264TK0rLE0CpNgjW1VF-jw\",
\"value\": \"$firstname\"
},
{
\"fieldID\": \"iyhjYVrvCkqqtAjW1VGAGw\",
\"value\": \"$lastname\"
},
{
\"fieldID\": \"IdTPoOPn8EqimAjW1VGBcw\",
\"value\": \"$email\"
},
{
\"fieldID\": \"7e-Wei6rKkOepQjW1VGDaA\",
\"value\": \"$phone\"
},
{
\"fieldID\": \"6JcV9fBT8kOFHAjW1VGJ2w\",
\"value\": \"$enquiry\"
},
{
\"fieldID\": \"h_gdjJIQ-kezUgjW1VGWHw\",
\"value\": \"$country\"
},
{
\"fieldID\": \"oVY2ddnaHEaJWQjW1VGTKw\",
\"value\": \"Yes\"
},
{
\"fieldID\": \"9TPjm9GCck6rwwjW1VGkjg\",
\"value\": \"$source\"
},
{
\"fieldID\": \"68Qn-SoylEGV9QjW1VGZZw\",
\"value\": \"$campaign\"
},
{
\"fieldID\": \"8C9uxKhqfEahUQjW1VGtrg\",
\"value\": \"$medium\"
},
{
\"fieldID\": \"nv_eIV04U0uTUgjW1VGQbQ\",
\"value\": \"No\"
},
{
\"fieldID\": \"Z4ca5L_1IUinNAjW1VG7BQ\",
\"value\": \"$wheretoopen\"
},
{
\"fieldID\": \"DZD_tRAILEuzAQjW1VHAJw\",
\"value\": \"$howsoontoopen\"
},
{
\"fieldID\": \"OuHUNqKWR0qwfgjW1VG2wg\",
\"value\": \"$frompage\"
}
],
\"source\": \"$leadsource Enquiry Page\"  
}";



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)));

$response = curl_exec($ch);
$decodedArray = json_decode($response,true);

// echo $response;
// exit;
if (!in_array("UpdatedRow", $decodedArray) && !in_array("AppendedRow", $decodedArray)) {
    // Info was not sent to Ubiquity - send the info in an email to be manually entered
    $emailsubject = "Submission from ".$leadsource." Enquiry Page - Ubiquity down";
    $emailmessage = "First Name: ".$firstname."\n\n"."Last Name: ".$lastname."\n\n"."Email: ".$email."\n\n"."Phone: ".$phone."\n\n"."Referral source: ".$source."\n\n"."Country: ".$country."\n\n"."Where to open franchise: ".$wheretoopen."\n\n"."How soon to open franchise: ".$howsoontoopen;
    mail($emailtoaddress,$emailsubject,$emailmessage,"From: ".$emailfromaddress."\r\n"."Content-type: text/plain; charset=utf-8\r\n");	// If any headers come via form input ensure this is sanitised
}


//send data to pipedrive
$deal['b02f1fdf1d4985094631af3a6a4dea9d3acb99f2'] = $leadsource." Enquiry Page"; //Form used
$deal['8918c06b4712a1c50af08f1194dedc8f57b3f6c1'] = $wheretoopen; //Where to open franchise
$deal['f7b5023db425ac0ce02237080f15523c98927559'] = $howsoontoopen; //how soon to open franchise
include 'sync-pipedrive.php';

//add lead record to log
include '../includes/log.php';

// Send response.
//echo "Successful";


?>