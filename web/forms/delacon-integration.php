<?PHP
function cleanData($input) {
    $output = trim($input);
    $output = addslashes($input); // Needed for Ubiquity
    $output = htmlspecialchars($output, ENT_NOQUOTES, 'UTF-8'); // Disallows code tags
    return $output;
}
$request_body = file_get_contents("php://input");
$data = json_decode($request_body,true);
$phone = cleanData($data["PLA_Caller_Phone_Number"]);
$source = cleanData($data["PLA_Search_Engine_Used"]);
$medium = cleanData($data["PLA_Search_Type"]);
$city = cleanData($data["PLA_City"]);
$identifier = "Delacon API";
$formpage = cleanData($data['PLA_Page']);
$assignee = cleanData($data['PLA_assignee']);
if($assignee != "Oncore NZ Consumer Website") {
    $enquiry = $assignee;
}

$campaign = "Delacon call tracking";
$country = "New Zealand";
if($source == "google" && $medium == "paid"){
    $source = "Google AdWords";
}else if($source == "facebook"){
    if($medium == "paid"){
        $source = "Facebook";
    }else{
        $source = "Social Media Post";
    }
}else if($source == "bing" && $medium == "paid"){
    $source = "Bing";
}else if($source == "internal" || $source == "free"){
    $source = "Call Centre";
}else if($source == "mailout"){
    $source = "Mailout";
}else{
    $source = "Oncore Consumer Website";
}

if(!empty($phone)){
    include 'Spreadsheet-API.php';

}

$time = date('m/d/Y h:i:s a', time());

$message = array(
    'PLA_Call_Id' => $data['PLA_Call_Id'],
    'success' => 'true'
);
echo json_encode($message);
$fp = fopen('../log/delaconlog.csv', 'a+');
fputcsv($fp,array("Phone_number" => $phone, "phone_id" => $test));
fclose($fp);

?>