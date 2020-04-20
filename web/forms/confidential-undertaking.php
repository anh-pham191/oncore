<?php

// Ubiquity form: Traffic website new contact form
include '../includes/emails.php';
include '../includes/locale.php';

function cleanData($input) {
    $output = trim($input);
    $output = addslashes($input); // Needed for Ubiquity
    $output = htmlspecialchars($output, ENT_NOQUOTES, 'UTF-8'); // Disallows code tags
    return $output;
}

$email = cleanData($_POST['email']);
$pdf = $_POST['pdf'];

//$pdf = $_POST['pdf'];
$currentTime = time();
$path = "../log/" .$email ." - " . $currentTime . ".pdf";
file_put_contents( $path, $pdf );

//$myfile = fopen("../design/" . $currentTime . ".pdf", "w") or die("Unable to open file!");
//fwrite($myfile, $pdf);
//fclose($myfile);

// If Privacy not checked
//Write data back to pdf file



if ($locale == 'en_au'){ // Using recaptcha 3 secret key not recaptcha 2
    $secretKey = '6LcFRbYUAAAAAGTJsMgOC14s6WW1EpI7mrTFbV7O';
}else if ($locale == 'en_nz'){
    $secretKey = '6LfIRLYUAAAAABHkfmQNb7FqsULfObQa9UMUe8bb';
}else if ($locale == 'en_gb'){
    $secretKey = '6LcQRbYUAAAAAM-IcMPfExz53hlfzn5gTzxiT_an';
}else if ($locale == 'en_us'){
    $secretKey = '6LfZh7YUAAAAACW8QJRGWE_W5sqx5Yln4wEYpIm1';
}
if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
}
if(!$captcha){
    echo 'NoCaptcha';
    exit;
}
$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);
if(intval($responseKeys["success"]) !== 1) {
    echo 'EnquirySent';
    exit;
}
include 'sync-pipedrive-find-deal.php';
if($pipeline_id === 42) { // NZ webinar pipeline
    $country = "New Zealand";
    $stage_id = 284;  // Confidentially accepted stage NZ
} elseif ($pipeline_id === 43) { // AU webinar pipeline
    $country = "Australia";
    $stage_id = 297;  // Confidentially accepted stage AU
} elseif ($pipeline_id === 44) { // UK webinar pipeline
    $country = "United Kingdom";
    $stage_id = 310;  // Confidentially accepted stage AU
} elseif ($pipeline_id === 45) { // US webinar pipeline
    $country = "United States";
    $stage_id = 320;  // Confidentially accepted stage AU
}
//send to zoom
//$cFile = curl_file_create($path, 'application/pdf', $email . " Agreement");
$new_data = array(
    'email_address' => $email,
    'deal_id' => $deal_id,
    'stage_id' => $stage_id,
//    'pdf' => $cFile,
);
$fileName = new CURLFile($path);
$fileName->setPostFilename("Signed Confidentiality Undertaking - ".$email. " - ".$currentTime);
$dataFile = array(
//    Signed Confidentiality Undertaking

    'file' => $fileName,
    'deal_id' => $deal_id
);
$api->add_files_to_deal($dataFile);

$updated = updateDealStage($api, $deal_id, $stage_id);

echo "Successful";


//$zoom_json = stripslashes(json_encode($new_data));
//
//$zoom_url = "https://hooks.zapier.com/hooks/catch/4402745/ohtxsin/";
//$ch = curl_init();
//
//curl_setopt($ch, CURLOPT_URL, $zoom_url);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $zoom_json);
//curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
//
//curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//    'Content-Type: application/json',
//    'Content-Length: ' . strlen($zoom_json)));
//$result = curl_exec($ch);


function updateDealStage($api, $dealID, $stage_id) {
    $data = array(
        'stage_id' => $stage_id
    );
    $updated = $api->update_deal($dealID, $data);
    return $updated;
}



?>