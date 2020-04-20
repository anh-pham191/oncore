<?php
// Ubiquity form: Oncore Contact - General Enquiry - used for Consumer Enquiry

include '../includes/email.php';

function cleanData($input) {
    $output = trim($input);
    $output = addslashes($input); // Needed for Ubiquity
    $output = htmlspecialchars($output, ENT_NOQUOTES, 'UTF-8'); // Disallows code tags
    return $output;
}

$firstname = cleanData($_POST['firstname']);
$email = cleanData($_POST['email']);
$tenant_email = cleanData($_POST['tenant-email']);
$tenant_name = cleanData($_POST['tenant-name']);
$tenant_phone = cleanData($_POST['tenant-phone']);
$tenant_address = cleanData($_POST['tenant-address']);
$phone = cleanData($_POST['tel']);

if (isset($_POST['privacy'])) {
    $privacy = cleanData($_POST['privacy']);
} else {
    $privacy = "";
};

if (isset($_POST['frompage'])) {
    $frompage = cleanData($_POST['frompage']);
} else {
    $frompage = "";
}
$formpage = $frompage;
$identifier = "Oncore Contact - Healthy Home Landing Page Stage 2";


if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
}

if(!$captcha){
    echo 'NoCaptcha';
    exit;
}
$secretKey = '6LdbAZkUAAAAABmmDIBGZb2BOV8RGODvtwzXN8Po';
$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);
if(intval($responseKeys["success"]) !== 1) {
    echo 'EnquirySent';
    exit;
}


// Check if fields that shouldn't do contain a URL
$testString = $firstname . $lastname . $phone;
$isHTTP = strpos($testString, 'http:');
$isHTTPS = strpos($testString, 'https:');
if (($isHTTP !== false) || ($isHTTPS !== false)) {
    $probSpam = "yes";
    echo "ContainsLink";
} else {
    $probSpam = "no";
}

// Only proceed if no links were found
if ($probSpam != "yes") {
    // If Honeypot filled out send submission to spam and pretend it was successful
    if ($honeypot != '') {
        // Trim field length as the database limits will not be applied for emailed submissions
        $firstname = substr($firstname, 0, 100);
        $lastname = substr($lastname, 0, 100);
        $email = substr($email, 0, 100);
        $phone = substr($phone, 0, 100);
        $country = substr($country, 0, 100);
        $privacy = substr($privacy, 0, 100);
        $subscribe = substr($subscribe, 0, 100);
        $honeypot = substr($honeypot, 0, 5000);
        $frompage = substr($frompage, 0, 100);

        $spamsubject = "SPAM from Oncore Services website - Healthy Home Landing Page";
        $spammessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Read and accepted Privacy Policy : " . $privacy . "\n\n" . "Opted out setting: " . $subscribe . "\n\n" . "Page Enquiry Made On: " . $frompage . "\n\n" . "Spam field contents: " . $honeypot;
        mail($emailtoaddress, $spamsubject, $spammessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n"); // If any headers come via form input ensure this is sanitised
        $goodtogo = "no"; // Do not post to Ubiquity
        echo "EnquirySent"; // Pretend to the spammer that their enquiry was sent
    }
    // Otherwise, carry on as for a human and submit to database :-)
    else {
        // If Privacy not checked
        if ($privacy == "on") {
            $privacy = "True";
            $goodtogo = "yes";
        } else {
            $goodtogo = "no";
            echo "NoPrivacy";
        }


        $url = "https://api.ubiquity.co.nz/forms/ten25B4n2EaT0gjX5RuzRw/submit?apiToken=vaxIncJDcdcyEaK6KaIUV8uAtJOKR5uCB2HJhWtd4LGbeh7KORxzeqQNjPIaOREIrsK7he-3zjY8zoG4OJwIQk7ORyCuHgQA4BwqSK2V-2IH3mwvH0rMzrqQscjMLW5rOXUQXgksMjs";

        $jsonData = "{
	  \"data\": [
		{
		  \"fieldID\": \"veUKHchif0uh7wjX5RwuRA\",
		  \"value\": \"$tenant_email\"
		},
		{
		  \"fieldID\": \"J_Yo1ez1U0iaLAjX5R3McA\",
		  \"value\": \"$tenant_name\"
		},
		{
		  \"fieldID\": \"mG97POvD7kGZzgjX5R3QTw\",
		  \"value\": \"$tenant_phone\"
		},
		{
		  \"fieldID\": \"w2wCvf2--Eap8wjX5Rw06Q\",
		  \"value\": \"$email\"
		},
		{
		  \"fieldID\": \"2TkXPls_DkODWgjX5Rwxhg\",
		  \"value\": \"$firstname\"
		},
		{
		  \"fieldID\": \"SM0PXcmCDkCdUgjX5Rw3FQ\",
		  \"value\": \"$phone\"
		},
		{
		  \"fieldID\": \"YAedqj-ZkkmvCgjX5R4QSw\",
		  \"value\": \"$tenant_address\"
		}
	  ],
	  \"source\": \"Oncore Contact - HHS Landing Page - Stage 2\"  
	}";

        if ($goodtogo != "no" && !preg_match('/\d+/',$firstname) && !preg_match('/\d+/',$lastname)) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData)));

            $response = curl_exec($ch);
            $decodedArray = json_decode($response, true);
            //echo $response;

            if (in_array("FailedValidation", $decodedArray)) {
                echo "Your form submission was Invalid. Please go back and try again.";
            } elseif ((in_array("UpdatedRow", $decodedArray)) || (in_array("AppendedRow", $decodedArray))) {
                // Buffer all upcoming output...
                ob_start();

                // Send response.
                echo "Successful";

                // Get the size of the output.
                $size = ob_get_length();

                // Disable compression (in case content length is compressed).
                header("Content-Encoding: none");

                // Set the content length of the response.
                header("Content-Length: {$size}");

                // Close the connection.
                header("Connection: close");

                // Flush all output.
                ob_end_flush();
                ob_flush();
                flush();

                // Close current session (if it exists).
                if (session_id()){
                    session_write_close();
                }

                //add lead record to log
                include '../includes/log.php';
                include "Spreadsheet-API.php";

            } else {
                // Info was not sent to Ubiquity - send the info in an email to be manually entered
                $emailsubject = "Submission from Oncore Services website - Healthy Home Landing Page - Ubiquity down";
                $emailmessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Read and accepted Privacy Policy : " . $privacy . "\n\n" . "Opted out setting: " . $subscribe . "\n\n" . "Page Enquiry Made On: " . $frompage;
                mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n"); // If any headers come via form input ensure this is sanitised
                echo "Successful"; // So that user sees their info has been collected.
            }
        }
    }
}
?>