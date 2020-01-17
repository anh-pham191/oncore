<?php

// Ubiquity form: 0001 Refresh Contact - Business Opportunity - used for Franchise Enquiry
// Uses UTM Campaign field to say the submission was from the Franchise site
include '../includes/email.php';

function cleanData($input) {
    $output = trim($input);
    $output = addslashes($input); // Needed for Ubiquity
    $output = htmlspecialchars($output, ENT_NOQUOTES, 'UTF-8'); // Disallows code tags
    return $output;
}

$firstname = cleanData($_POST['firstname']);
$lastname = cleanData($_POST['lastname']);
$email = cleanData($_POST['email']);
$phone = cleanData($_POST['tel']);
if (isset($_POST['privacy'])) {
    $privacy = cleanData($_POST['privacy']);
} else {
    $privacy = "";
};
if (isset($_POST['subscribe'])) {
    $subscribe = cleanData($_POST['subscribe']);
} else {
    $subscribe = "";
};
$country = "New Zealand";
$frompage = cleanData($_POST['frompage']);
$honeypot = cleanData($_POST['form-website']);
if (isset($_COOKIE['fromsource'])){
    if ($_COOKIE['fromsource']=="google") {
        $source = "Google AdWords";
    } else if ($_COOKIE['fromsource']=="bing") {
        $source = "Bing";
    } else if ($_COOKIE['fromsource']=="facebook") {
        $source = "Facebook";
    } else if ($_COOKIE['fromsource']=="LinkedIn") {
        $source = "LinkedIn";
    } else if ($_COOKIE['fromsource']=="Social Media Post") {
        $source = "Social Media";
    } else if ($_COOKIE['fromsource']=="Mailout") {
        $source = "Mailout";
    } else if ($_COOKIE['fromsource']=="Social Media Post") {
        $source = "Social Media";
    } else if ($_COOKIE['fromsource']=="Harmoney") {
        $source = "Harmoney";
    } else if ($_COOKIE['fromsource']=="referral") {
        $source = "Referral";
    } else if ($_COOKIE['fromsource']=="Local Print Media") {
        $source = "Local Print Media";
    } else if ($_COOKIE['fromsource']=="banner") {
        $source = "Banner";
    } else if ($_COOKIE['fromsource']=="local digital") {
        $source = "Local Digital Campaign";
    } else if ($_COOKIE['fromsource']=="instagram") {
        $source = "Instagram";
    } else if ($_COOKIE['fromsource']=="twitter") {
        $source = "Twitter";
    } else if ($_COOKIE['fromsource']=="pinterest") {
        $source = "Pinterest";
    } else if ($_COOKIE['fromsource']=="renovate") {
        $source = "Renovate Website";
    } else if ($_COOKIE['fromsource']=="promotions") {
        $source = "Competitions";
    } else if ($_COOKIE['fromsource']=="Friend") {
        $source = "Friend Referral";
    } else if ($_COOKIE['fromsource']=="Customer") {
        $source = "Customer Referral";
    } else if ($_COOKIE['fromsource']=="Repeat") {
        $source = "Customer repeat work";
    } else if ($_COOKIE['fromsource']=="Trade") {
        $source = "Trade Referral";
    } else if ($_COOKIE['fromsource']=="Designer") {
        $source = "Designer Referral";
    } else if ($_COOKIE['fromsource']=="Distributor") {
        $source = "Distributor Referral";
    } else if ($_COOKIE['fromsource']=="site sign") {
        $source = "Site Sign";
    } else if ($_COOKIE['fromsource']=="tv") {
        $source = "TV";
    } else if ($_COOKIE['fromsource']=="radio") {
        $source = "Radio";
    } else if ($_COOKIE['fromsource']=="vehicle") {
        $source = "Branded Vehicle";
    } else if ($_COOKIE['fromsource']=="event") {
        $source = "Local Event";
    } else if ($_COOKIE['fromsource']=="network") {
        $source = "Network";
    } else if ($_COOKIE['fromsource']=="outdoor") {
        $source = "Outdoor";
    } else if ($_COOKIE['fromsource']=="sponsorship") {
        $source = "Sponsorship";
    } else if ($_COOKIE['fromsource']=="leaflet") {
        $source = "Letter Box Drop";
    } else if ($_COOKIE['fromsource']=="merchandise") {
        $source = "Branded merchandise";
    } else if ($_COOKIE['fromsource']=="walk in") {
        $source = "Local Office";
    } else if ($_COOKIE['fromsource']=="permanent expo") {
        $source = "Permanent Exhibition Centre";
    } else if ($_COOKIE['fromsource']=="home show") {
        $source = "Home Show";
    } else if ($_COOKIE['fromsource']=="seminar") {
        $source = "Seminars";
    } else if ($_COOKIE['fromsource']=="directory") {
        $source = "Directory";
    } else if ($_COOKIE['fromsource']=="cinema") {
        $source = "Cinema";
    } else if ($_COOKIE['fromsource']=="other") {
        $source = "Other";
    } else if ($_COOKIE['fromsource']=="Re-engagement") {
        $source = "Re-engagement";
    } else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "trademe") {
        $source = "Trademe";
    } else{
        $source = "Oncore Consumer Website";
    }
}else{
    $source = "Oncore Consumer Website";
};
if (isset($_COOKIE['frommedium'])) {
    $medium = cleanData($_COOKIE['frommedium']);
}

$businessunit = "Oncore NZ Franchise Lead";


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
//
//include '../includes/reCAPTCHA.php';
//if(isset($_POST['g-recaptcha-response'])){
//    $captcha=$_POST['g-recaptcha-response'];
//}
//
//if(!$captcha){
//    echo 'NoCaptcha';
//    exit;
//}
//$ip = $_SERVER['REMOTE_ADDR'];
//$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
//$responseKeys = json_decode($response,true);
//if(intval($responseKeys["success"]) !== 1) {
//    echo 'EnquirySent';
//    exit;
//}


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

        $spamsubject = "SPAM from Oncore Consumer website - Franchise Enquiry";
        $spammessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Read and accepted Privacy Policy : " . $privacy . "\n\n" . "Opted out setting: " . $subscribe . "\n\n" . "Message subject: " . $subject . "\n\n" . "Enquiry: " . $enquiry . "\n\n". "Page Enquiry Made On: " . $frompage . "\n\n". "Region Interested In(UK website): " . $region . "\n\n" . "Spam field contents: " . $honeypot;
        mail($emailtoaddress, $spamsubject, $spammessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n"); // If any headers come via form input ensure this is sanitised
        $goodtogo = "no"; // Do not post to Ubiquity
        echo "EnquirySent"; // Pretend to the spammer that their enquiry was sent
    }
    // Otherwise, carry on as for a human and submit to database :-)
    else {
        // If Privacy not checked
        if ($privacy == "on" || $locale == 'en_nz') {
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

        $url = "https://api.ubiquity.co.nz/forms/L6PnmWPceEmCjAjW2RCTxw/submit?apiToken=vaxIncJDcdcyEaK6KaIUV8uAtJOKR5uCB2HJhWtd4LGbeh7KORxzeqQNjPIaOREIrsK7he-3zjY8zoG4OJwIQk7ORyCuHgQA4BwqSK2V-2IH3mwvH0rMzrqQscjMLW5rOXUQXgksMjs";

        $jsonData = "{
	  \"data\": [
		{
		  \"fieldID\": \"XzTPYZ5AYUmruwjW2RCn0g\",
		  \"value\": \"$firstname\"
		},
		{
		  \"fieldID\": \"aNYg14fdhEmBmAjW2RCpgg\",
		  \"value\": \"$lastname\"
		},
		{
		  \"fieldID\": \"GN0RWb8sTEatowjW2RCrtQ\",
		  \"value\": \"$email\"
		},
		{
		  \"fieldID\": \"MAjytDbyoESAaQjW2RCuOQ\",
		  \"value\": \"$phone\"
		},
		{
		  \"fieldID\": \"dujtHdKhj0uQ6wjW2RC0kw\",
		  \"value\": \"$country\"
		},
		{
		  \"fieldID\": \"K94nDPCBrka_RQjW2RDkzg\",
		  \"value\": \"$source\"
		},
		{
		  \"fieldID\": \"_VWC3t0ai06K0AjW2RDVqQ\",
		  \"value\": \"$subscribe\"
		},
        {
          \"fieldID\": \"ihRc6emVjECoYQjW2RDuiw\",
          \"value\": \"$businessunit\"
        },
        {
		  \"fieldID\": \"4QmagZQHuECOGQjW2RDpNg\",
		  \"value\": \"$medium\"
		},
		{
		  \"fieldID\": \"fAysLew1ek6kfAjW2RCxbQ\",
		  \"value\": \"$campaign\"
        },
		{
			\"fieldID\": \"Q-aYLI_fhUOE0wjW2RDwzg\",
			\"value\": \"$frompage\"
		}
	  ],
	  \"source\": \"0003 Oncore - Franchise enquiry form\"
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
        include 'SpreadsheetFW-API.php'; //need change to franchise sheet

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
//        $params = $params . "description=OncoreNewZealandWebsite";
//
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
//                $emailsubject = "Submission from Oncore Consumer website - Franchise Enquiry - Sharpspring down";
//                $emailmessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Read and accepted Privacy Policy : " . $privacy . "\n\n" . "Opted out setting: " . $subscribe . "\n\n" . "Message subject: " . $subject . "\n\n" . "Enquiry: " . $enquiry . "\n\n" . "Page Enquiry Made On: " . $frompage . "\n\n". "Region Interested In(UK website): " . $region;
//                mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n"); // If any headers come via form input ensure this is sanitised
//                echo "Successful mailout"; // So that user sees their info has been collected.
//            }
//        }
    }
}
?>