<?php


include '../includes/emails.php';

function cleanData($input) {
    $output = trim($input);
    $output = addslashes($input); // Needed for Ubiquity
    $output = htmlspecialchars($output, ENT_NOQUOTES, 'UTF-8'); // Disallows code tags
    return $output;
}

$firstname = cleanData($_POST['form-firstname']);
$lastname = cleanData($_POST['form-lastname']);
$email = cleanData($_POST['form-email']);
$phone = cleanData($_POST['form-tel']);
$country = cleanData($_POST['form-country']);
$type = "franchise";

if (isset($_POST['form-privacy'])) {
    $privacy = cleanData($_POST['form-privacy']);
} else {
    $privacy = "";
};
if (isset($_POST['form-subscribe'])) {
    $subscribe = cleanData($_POST['form-subscribe']);
} else {
    $subscribe = "";
};
$subject = cleanData($_POST['form-subject']);
if (isset($_POST['form-country-filled'])) {
    $countryFilled = cleanData($_POST['form-country-filled']);
    $enquiry = "Interested country: ". $countryFilled . ". Message: ".cleanData($_POST['form-enquiry']);
} else {
    $countryFilled = "";
    $enquiry = cleanData($_POST['form-enquiry']);
};
if (isset($_COOKIE['viewedopp'])) {
    $opportunity = cleanData($_COOKIE['viewedopp']);
} else {
    $opportunity = "";
};
$honeypot = cleanData($_POST['form-website']);
$frompage = cleanData($_POST['frompage']);
$region = cleanData($_POST['form-region']);


$source = cleanData($_POST['form-source']);
if ($_POST['form-lead']=="cpc") {
    $campaign = $source;
} else {
    $campaign = cleanData($_POST['form-campaign']);
}

if ($_POST['form-lead']=="general-marketing") {
    $medium = $campaign;
} else {
    $medium = cleanData($_POST['form-medium']);
}

$content = cleanData($_POST['form-content']);
$businessunit = "Oncore NZ Franchise Lead";

$secretKey = '6LdbAZkUAAAAABmmDIBGZb2BOV8RGODvtwzXN8Po';

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
        $subject = substr($subject, 0, 5000);
        $enquiry = substr($enquiry, 0, 5000);
        $honeypot = substr($honeypot, 0, 5000);
        $frompage = substr($frompage, 0, 100);
        $region = substr($region, 0, 100);

        $spamsubject = "SPAM from Oncore website - Franchise Enquiry";
        $spammessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Read and accepted Privacy Policy : " . $privacy . "\n\n" . "Opted out setting: " . $subscribe . "\n\n" . "Message subject: " . $subject . "\n\n" . "Enquiry: " . $enquiry . "\n\n". "Page Enquiry Made On: " . $frompage . "\n\n". "Region Interested In(UK website): " . $region . "\n\n" . "Spam field contents: " . $honeypot;
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

        // Set up Opted out value
        if ($subscribe == "on") {
            $subscribe = "False"; // Has not opted out
        } else {
            $subscribe = "True";
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
		  \"fieldID\": \"H9WBiITOCUecHQjYAhVFkA\",
		  \"value\": \"$type\"
		},
		{
		  \"fieldID\": \"7e-Wei6rKkOepQjW1VGDaA\",
		  \"value\": \"$phone\"
		},
		{
		  \"fieldID\": \"pyE8L_V_tkSmdgjW1VGHuw\",
		  \"value\": \"$subject\"
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
		  \"fieldID\": \"9TPjm9GCck6rwwjW1VGkjg\",
		  \"value\": \"$source\"
		},
		{
		  \"fieldID\": \"oVY2ddnaHEaJWQjW1VGTKw\",
		  \"value\": \"$privacy\"
		},
		{
		  \"fieldID\": \"nv_eIV04U0uTUgjW1VGQbQ\",
		  \"value\": \"$subscribe\"
		},
        {
          \"fieldID\": \"M1l-_mjCRU-HPwjW1VGzoQ\",
          \"value\": \"$businessunit\"
        },
        {
		  \"fieldID\": \"8C9uxKhqfEahUQjW1VGtrg\",
		  \"value\": \"$medium\"
		},
		{
		  \"fieldID\": \"68Qn-SoylEGV9QjW1VGZZw\",
		  \"value\": \"$campaign\"
        },
        {
            \"fieldID\": \"LB9Uf1UkZEyKhAjW1VGq8g\",
            \"value\": \"$region\"
        },
		{
			\"fieldID\": \"OuHUNqKWR0qwfgjW1VG2wg\",
			\"value\": \"$frompage\"
		}
	  ],
	  \"source\": \"0003 Oncore - Lead Integration with 3rd Party Services\"
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
            $emailmessage = "First Name: ".$firstname."\n\n"."Last Name: ".$lastname."\n\n"."Email: ".$email."\n\n"."Phone: ".$phone."\n\n"."Referral source: ".$source."\n\n"."Country: ".$country."\n\n";
            mail($emailtoaddress,$emailsubject,$emailmessage,"From: ".$emailfromaddress."\r\n"."Content-type: text/plain; charset=utf-8\r\n");	// If any headers come via form input ensure this is sanitised
        }


//send data to pipedrive
        $deal['b02f1fdf1d4985094631af3a6a4dea9d3acb99f2'] = $leadsource." Enquiry Page"; //Form used
        $deal['8918c06b4712a1c50af08f1194dedc8f57b3f6c1'] = $wheretoopen; //Where to open franchise
        $deal['f7b5023db425ac0ce02237080f15523c98927559'] = $howsoontoopen; //how soon to open franchise
        $deal['0c6b81c4f28d707c80ab5ba9ae24676817b8f66f'] = $source;
        include 'sync-pipedrive.php';

//add lead record to log
        include '../includes/log.php';

// Send response.
//echo "Successful";



//        $baseURL = "https://app-3QNH83TKIO.marketingautomation.services/webforms/receivePostback/MzawMDE3MjMwAwA/";
//        $endPoint = "5853b48a-0848-4273-baaf-e390a33800f4";
//
//// Prepare parameters
//        $params = $params . "firstName=" . urlencode($firstname) . "&lastName=" . urlencode($lastname) . "&emailAddress=" . urlencode($email) . "&phoneNumber=" . urlencode($phone) . "&country=" . urlencode($country) . "&website=" . urlencode($frompage) . "&privacy=" . urlencode($privacy) . "&subscribe=" . urlencode($subscribe) . "&";
//
//        if (!empty($region)) {
//            $params = $params . "state=" . urlencode($region) . "&";
//        }
//
//        if (!empty($enquiry)) {
//            $params = $params . "enquiry=" . urlencode($enquiry) . "&";
//        }
//
//        if (!empty($source)) {
//            $params = $params . "campaignSource=" . urlencode($source) . "&";
//        }
//
//        if (!empty($medium)) {
//            $params = $params . "campaignMedium=" . urlencode($medium) . "&";
//        }
//
//        if (!empty($campaign)) {
//            $params = $params . "campaignName=" . urlencode($campaign) . "&";
//        }
//
//        if (!empty($content)) {
//            $params = $params . "campaignContent=" . urlencode($content) . "&";
//        }
//
//        if($country=="Australia"){
//            $params = $params . "description=OncoreAustraliaWebsite";
//        }
//        else if($country=="New Zealand"){
////NZ
//            $params = $params . "description=OncoreNewZealandWebsite";
//
//        }else if($country=="United Kingdom"){
////UK
//            $params = $params . "description=OncoreUnitedKingdomWebsite";
//
//        }
//        if ($goodtogo != "no" && !preg_match('/\d+/',$firstname) && !preg_match('/\d+/',$lastname)) {
//
//            // Prepare URL
//            $ssRequest = $baseURL . $endPoint . "/jsonp/?" . $params;
//
//
//// Send request
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $ssRequest);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            $response = curl_exec($ch);
//            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//            curl_close($ch);
//            if ($httpcode != "400") { //check successful response out put
//                // Buffer all upcoming output...
//                ob_start();
//
//                // Send response.
//                echo "Successful";
//                echo $httpcode;
//
//                // Get the size of the output.
//                $size = ob_get_length();
//
//                // Disable compression (in case content length is compressed).
//                header("Content-Encoding: none");
//
//                // Set the content length of the response.
//                header("Content-Length: {$size}");
//
//                // Close the connection.
//                header("Connection: close");
//
//                // Flush all output.
//                ob_end_flush();
//                ob_flush();
//                flush();
//
//                // Close current session (if it exists).
//                if (session_id()){
//                    session_write_close();
//                }
//
//                //add lead record to log
//                include '../includes/log.php';
//            } else {
//                // Info was not sent to Ubiquity - send the info in an email to be manually entered
//                $emailsubject = "Submission from Oncore website - Franchise Enquiry - Sharpspring down";
//                $emailmessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Read and accepted Privacy Policy : " . $privacy . "\n\n" . "Opted out setting: " . $subscribe . "\n\n" . "Message subject: " . $subject . "\n\n" . "Enquiry: " . $enquiry . "\n\n" . "Page Enquiry Made On: " . $frompage . "\n\n". "Region Interested In(UK website): " . $region;
//                mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n"); // If any headers come via form input ensure this is sanitised
//                echo "Successful mailout"; // So that user sees their info has been collected.
//            }
//        }
    }
}
?>