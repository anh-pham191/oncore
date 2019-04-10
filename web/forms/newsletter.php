<?php
// Ubiquity form: 0002 Zones Newsletter - Footer - Subscribe to newsletter
include '../includes/email.php';
if(isset($_POST['firstname'])){
    $firstname = trim(addslashes($_POST['firstname']));
} else {
    $firstname = '';
}

if(isset($_POST['lastname'])){
    $lastname = trim(addslashes($_POST['lastname']));
} else {
    $lastname = '';
}
if(isset($_POST['email'])){
    $email = trim($_POST['email']);
}

if(isset($_POST['tel'])){
    $phone = trim($_POST['tel']);
}
else {
    $phone = '';
}

if(isset($_POST['frompage'])){
    $frompage = trim($_POST['frompage']);
}
else {
    $frompage = '';
}
$subscribe = "False";

$url = "https://api.ubiquity.co.nz/forms/ZOhgVVclZkqJQwjWvY5-wg/submit?apiToken=vaxIncJDcdcyEaK6KaIUV8uAtJOKR5uCB2HJhWtd4LGbeh7KORxzeqQNjPIaOREIrsK7he-3zjY8zoG4OJwIQk7ORyCuHgQA4BwqSK2V-2IH3mwvH0rMzrqQscjMLW5rOXUQXgksMjs";

$jsonData = "{
  \"data\": [
    {
      \"fieldID\": \"PflaaGlELU2CnQjWvY7bmQ\",
      \"value\": \"$firstname\"
    },
    {
       \"fieldID\": \"WZbRLLRMhkGgdwjWvY8BWg\",
       \"value\": \"$lastname\"
    },
    {
      \"fieldID\": \"oq0Peq20_0a6XQjWvY8NEw\",
      \"value\": \"$email\"
    },
	{
      \"fieldID\": \"X7X_cTxbTkyPngjWvY8rVg\",
      \"value\": \"$phone\"
    },
	{
      \"fieldID\": \"mgT4g0SDtU-FbgjWvZHnPg\",
      \"value\": \"New Zealand\"
    },
	{
      \"fieldID\": \"8jNW_rnfyEGCTQjWvZD00w\",
      \"value\": \"$subscribe\"
    },
    {
        \"fieldID\": \"OdiYtGs2VUyf9gjWvZIsdg\",
        \"value\": \"$frompage\"
    }
  ],
  \"source\": \"0002 Oncore Newsletter - Footer - Subscribe to newsletter\"
}";

// perform the curl transaction
if(!preg_match('/\d+/',$firstname)){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData))
    );

    $response = curl_exec($ch);
    $decodedArray = json_decode($response,true);

// echo $response;

    if (in_array("FailedValidation", $decodedArray)) {
        echo "Your form submission was Invalid. Please go back and try again.";
    }
    elseif ((in_array("UpdatedRow", $decodedArray)) || (in_array("AppendedRow", $decodedArray))) {
        echo "Successful";
    }
    else {
        // Info was not sent to Ubiquity - send the info in an email to be manually entered
        $emailsubject = "Submission from 0002 Oncore Newsletter - Footer - Subscribe to newsletter - Ubiquity down";
        $emailmessage = "First name: ".$firstname."\n\n"."Email: ".$email."\n\n"."Phone: ".$phone."\n\n"."Country: New Zealand"."\n\n"."Opted out setting: ".$subscribe;
        mail($emailtoaddress,$emailsubject,$emailmessage,"From: ".$emailfromaddress."\r\n"."Content-type: text/plain; charset=utf-8\r\n");	// If any headers come via form input ensure this is sanitised
        echo "Successful"; // So that user sees their info has been collected.
    }
}
?>