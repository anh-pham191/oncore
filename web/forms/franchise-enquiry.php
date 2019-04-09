<?php

// Ubiquity form: 0001 Refresh Contact - Business Opportunity - used for Franchise Enquiry
// Uses UTM Campaign field to say the submission was from the Franchise site

include '../includes/emails.php';
include '../includes/locale.php';

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
if (isset($_COOKIE['fromcampaign'])) {
    $campaign = cleanData($_COOKIE['fromcampaign']);
} else {
    $campaign = "N/A";
};
if (isset($_COOKIE['fromsource'])&& $_COOKIE['fromsource']=="google") {
    $source = "Google AdWords";
} else if (isset($_COOKIE['fromsource'])&& $_COOKIE['fromsource']=="bing") {
    $source = "Bing";
} else if (isset($_COOKIE['fromsource'])&& $_COOKIE['fromsource']=="facebook") {
    $source = "Facebook";
} else if (isset($_COOKIE['fromsource'])&& $_COOKIE['fromsource']=="LinkedIn") {
    $source = "LinkedIn";
} else if (isset($_COOKIE['fromsource'])&& $_COOKIE['fromsource']=="LinkedInRecruiter") {
    $source = "LinkedIn Recruiter";
} else if (isset($_COOKIE['fromsource'])&& $_COOKIE['fromsource']=="portal") {
    $source = "Franchise Portal";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Franchise Magazine") {
    $source = "Franchise Magazine";
} else {
    $source = "Refresh Franchise ".$country." Website";
};
if (isset($_COOKIE['frommedium'])) {
    $medium = cleanData($_COOKIE['frommedium']);
}

$businessunit = "Oncore NZ Franchise Lead";

include '../includes/reCAPTCHA.php';
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

        $spamsubject = "SPAM from Refresh Franchise website - Franchise Enquiry";
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

//        $url = "https://api.ubiquity.co.nz/forms/VzKw9zB0x0KqBgjQNXn6Xg/submit?apiToken=vaxIncJDcdcyEaK6KaIUV8uAtJOKR5uCB2HJhWtd4LGbeh7KORxzeqQNjPIaOREIrsK7he-3zjY8zoG4OJwIQk7ORyCuHgQA4BwqSK2V-2IH3mwvH0rMzrqQscjMLW5rOXUQXgksMjs";
//
//        $jsonData = "{
//	  \"data\": [
//		{
//		  \"fieldID\": \"pZ9o1Q-LokiluAjQNXn6jA\",
//		  \"value\": \"$firstname\"
//		},
//		{
//		  \"fieldID\": \"VlwpDi-gwkCAEwjQNXn6jA\",
//		  \"value\": \"$lastname\"
//		},
//		{
//		  \"fieldID\": \"yUP_vmQWjE6ZJgjQNXn6jA\",
//		  \"value\": \"$email\"
//		},
//		{
//		  \"fieldID\": \"sO4-R6ObgEaTkgjQNXn6jA\",
//		  \"value\": \"$phone\"
//		},
//		{
//		  \"fieldID\": \"x6CoNlSPUk-o6QjQNXn6jA\",
//		  \"value\": \"$subject\"
//		},
//		{
//		  \"fieldID\": \"fFEpDsMZYU6rDgjRsEdcSg\",
//		  \"value\": \"$enquiry\"
//		},
//		{
//		  \"fieldID\": \"CVXee1qyrE-FlAjRBdplTw\",
//		  \"value\": \"$country\"
//		},
//		{
//		  \"fieldID\": \"le9Ba_aQMkynIwjS8BHFoA\",
//		  \"value\": \"$source\"
//		},
//		{
//		  \"fieldID\": \"HWTZxFu3c0ioAQjRBdpXug\",
//		  \"value\": \"$privacy\"
//		},
//		{
//		  \"fieldID\": \"sUc9Gh9CjkqYtgjQNXn6jQ\",
//		  \"value\": \"$subscribe\"
//		},
//        {
//          \"fieldID\": \"SyxAD14EIkKRNgjUtKyXmw\",
//          \"value\": \"$businessunit\"
//        },
//        {
//		  \"fieldID\": \"kdTi3DvN30yWWAjT7eqkGQ\",
//		  \"value\": \"$medium\"
//		},
//		{
//		  \"fieldID\": \"DMjB23aVGkqGPAjRsEdgRw\",
//		  \"value\": \"$campaign\"
//        },
//        {
//            \"fieldID\": \"8r9VGqLl10KmagjVg3DgHg\",
//            \"value\": \"$region\"
//        },
//		{
//			\"fieldID\": \"vfAeg-4f6ka0qgjVNmbPXQ\",
//			\"value\": \"$frompage\"
//		}
//	  ],
//	  \"source\": \"0001 Refresh Contact - Business Opportunity - used for Franchise Enquiry\"
//	}";
        $baseURL = "https://app-3QNH83TKIO.marketingautomation.services/webforms/receivePostback/MzawMDE3MjMwAwA/";
        $endPoint = "5853b48a-0848-4273-baaf-e390a33800f4";

// Prepare parameters
        $params = $params . "firstName=" . urlencode($firstname) . "&lastName=" . urlencode($lastname) . "&emailAddress=" . urlencode($email) . "&phoneNumber=" . urlencode($phone) . "&country=" . urlencode($country) . "&website=" . urlencode($frompage) . "&privacy=" . urlencode($privacy) . "&subscribe=" . urlencode($subscribe) . "&";

        if (!empty($region)) {
            $params = $params . "state=" . urlencode($region) . "&";
        }

        if (!empty($enquiry)) {
            $params = $params . "enquiry=" . urlencode($enquiry) . "&";
        }

        if (!empty($source)) {
            $params = $params . "campaignSource=" . urlencode($source) . "&";
        }

        if (!empty($medium)) {
            $params = $params . "campaignMedium=" . urlencode($medium) . "&";
        }

        if (!empty($campaign)) {
            $params = $params . "campaignName=" . urlencode($campaign) . "&";
        }

        $params = $params . "description=OncoreNewZealandWebsite";

        if ($goodtogo != "no" && !preg_match('/\d+/',$firstname) && !preg_match('/\d+/',$lastname)) {

            // Prepare URL
            $ssRequest = $baseURL . $endPoint . "/jsonp/?" . $params;


// Send request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $ssRequest);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpcode != "400") { //check successful response out put
                // Buffer all upcoming output...
                ob_start();

                // Send response.
                echo "Successful";
                echo $httpcode;

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
            } else {
                // Info was not sent to Ubiquity - send the info in an email to be manually entered
                $emailsubject = "Submission from Refresh Franchise website - Franchise Enquiry - Sharpspring down";
                $emailmessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Read and accepted Privacy Policy : " . $privacy . "\n\n" . "Opted out setting: " . $subscribe . "\n\n" . "Message subject: " . $subject . "\n\n" . "Enquiry: " . $enquiry . "\n\n" . "Page Enquiry Made On: " . $frompage . "\n\n". "Region Interested In(UK website): " . $region;
                mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n"); // If any headers come via form input ensure this is sanitised
                echo "Successful mailout"; // So that user sees their info has been collected.
            }
        }
    }
}
?>