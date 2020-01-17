<?php

// Ubiquity form: 0001 Refresh Contact - Business Opportunity - used for Franchise Enquiry
// Uses UTM Campaign field to say the submission was from the Franchise site

include '../includes/emails.php';
include '../includes/locale.php';

function cleanData($input)
{
    $output = trim($input);
    $output = addslashes($input); // Needed for Ubiquity
    $output = htmlspecialchars($output, ENT_NOQUOTES, 'UTF-8'); // Disallows code tags
    return $output;
}

$firstname = cleanData($_POST['firstName']);
$lastname = cleanData($_POST['lastName']);
$email = cleanData($_POST['email']);
$phone = cleanData($_POST['mobile']);
$country = cleanData($_POST['form-country']);
$formpage = cleanData($_POST['frompage']);
$contacttype = "Franchise Lead";
$country = "New Zealand";
$gclid = cleanData($_POST['gclid_field']);

if (isset($_POST['formf-privacy'])) {
    $privacy = cleanData($_POST['formf-privacy']);
} else {
    $privacy = "";
};
if (isset($_POST['form-subscribe'])) {
    $subscribe = cleanData($_POST['form-subscribe']);
} else {
    $subscribe = "";
};
$wheretoopen = cleanData($_POST['where']);
$howsoon = cleanData($_POST['how']);
if (isset($_POST['form-country-filled'])) {
    $countryFilled = cleanData($_POST['form-country-filled']);
    $enquiry = "Interested country: " . $countryFilled . ". Message: " . cleanData($_POST['form-enquiry']);
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
if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "google") {
    $source = "Google AdWords";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "bing") {
    $source = "Bing";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "banner") {
    $source = "Banner";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "local digital") {
    $source = "Local Digital Campaign";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "instagram") {
    $source = "Instagram";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "facebook") {
    $source = "Facebook";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "twitter") {
    $source = "Twitter";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "LinkedIn") {
    $source = "LinkedIn";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "LinkedInRecruiter") {
    $source = "LinkedIn Recruiter";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "pinterest") {
    $source = "Pinterest";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Mailout") {
    $source = "Mailout";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "referral") {
    $source = "referral";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Social Media Post") {
    $source = "Social Media";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Harmoney") {
    $source = "Harmoney";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "renovate") {
    $source = "Renovate Website";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "promotions") {
    $source = "Competitions";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Friend") {
    $source = "Friend Referral";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Customer") {
    $source = "Customer Referral";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Repeat") {
    $source = "Customer repeat work";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Trade") {
    $source = "Trade referral";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Designer") {
    $source = "Designer Referral";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Distributor") {
    $source = "Distributor Referral";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "site sign") {
    $source = "Site Sign";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "tv") {
    $source = "TV";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "radio") {
    $source = "Radio";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "vehicle") {
    $source = "Branded Vehicle";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "event") {
    $source = "Local Event";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "network") {
    $source = "Network";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "outdoor") {
    $source = "Outdoor";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "sponsorship") {
    $source = "Sponsorship";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "leaflet") {
    $source = "Letterbox Drop";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Local Print Media") {
    $source = "Local Print Media";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "merchandise") {
    $source = "Branded merchandise";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "walk in") {
    $source = "Local Office";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "permanent expo") {
    $source = "Permanent Exhibition Centre";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "home show") {
    $source = "Home Show";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "seminar") {
    $source = "Seminars";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "directory") {
    $source = "Directory";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "cinema") {
    $source = "Cinema";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "other") {
    $source = "Other";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Re-engagement") {
    $source = "Re-engagement";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "portal") {
    $source = "Franchise Portal";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "Franchise Magazine") {
    $source = "Franchise Magazine";
} else if (isset($_COOKIE['fromsource']) && $_COOKIE['fromsource'] == "trademe") {
    $source = "Trademe";
}


else {
    $source = "Oncore " . $country . " Website";
};
if (isset($_COOKIE['frommedium'])) {
    $medium = cleanData($_COOKIE['frommedium']);
}

if (isset($_COOKIE['fromcontent'])) {
    $content = cleanData($_COOKIE['fromcontent']);
}
if (isset($_COOKIE['fromkeyword'])) {
    $keyword = cleanData($_COOKIE['fromkeyword']);
}

$businessunit = "Oncore NZ Franchise Lead";

//start recaptcha
$secretKey = '6LdbAZkUAAAAABmmDIBGZb2BOV8RGODvtwzXN8Po';

if (isset($_POST['g-recaptcha-response'])) {
    $captcha = $_POST['g-recaptcha-response'];
}

if (!$captcha) {
    echo 'NoCaptcha';
    exit;
}
$ip = $_SERVER['REMOTE_ADDR'];
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
$responseKeys = json_decode($response, true);
if (intval($responseKeys["success"]) !== 1) {
    echo 'EnquirySent';
    exit;
}

//end recaptcha


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
        $spammessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Read and accepted Privacy Policy : " . $privacy . "\n\n" . "Opted out setting: " . $subscribe . "\n\n" . "Message subject: " . $subject . "\n\n" . "Enquiry: " . $enquiry . "\n\n" . "Page Enquiry Made On: " . $frompage . "\n\n" . "Region Interested In(UK website): " . $region . "\n\n" . "Spam field contents: " . $honeypot;
        mail($emailtoaddress, $spamsubject, $spammessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n"); // If any headers come via form input ensure this is sanitised
        $goodtogo = "no"; // Do not post to Ubiquity
        echo "EnquirySent"; // Pretend to the spammer that their enquiry was sent
    } // Otherwise, carry on as for a human and submit to database :-)
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

            $url = "https://api.ubiquity.co.nz/forms/a96QPnF3NkKgdgjXN46GMQ/submit?apiToken=vaxIncJDcdcyEaK6KaIUV8uAtJOKR5uCB2HJhWtd4LGbeh7KORxzeqQNjPIaOREIrsK7he-3zjY8zoG4OJwIQk7ORyCuHgQA4BwqSK2V-2IH3mwvH0rMzrqQscjMLW5rOXUQXgksMjs";

            $jsonData = "{
	  \"data\": [
		{
		  \"fieldID\": \"CYoFNAcEXUuThwjXN46X8w\",
		  \"value\": \"$firstname\"
		},
		{
		  \"fieldID\": \"UGZtOMC7iEa3rwjXN46aVw\",
		  \"value\": \"$lastname\"
		},
		{
		  \"fieldID\": \"eC4lUs-LnkuJ1gjXN46c-w\",
		  \"value\": \"$email\"
		},
		{
		  \"fieldID\": \"KJG26NM1b06GzAjXN46fZg\",
		  \"value\": \"$phone\"
		},
		{
		  \"fieldID\": \"Yfh-_62lGEGjEgjXN466XA\",
		  \"value\": \"$wheretoopen\"
		},
		{
		  \"fieldID\": \"cu41NHyTrEasFAjXN468Qg\",
		  \"value\": \"$howsoon\"
		},
		{
		  \"fieldID\": \"CzZuxodDH0mpNwjXN46wwQ\",
		  \"value\": \"$country\"
		},
		{
		  \"fieldID\": \"v1-H2T_R1UuwywjXN47PfA\",
		  \"value\": \"$source\"
		},
		{
		  \"fieldID\": \"zm4CMyuigkeSnwjXN46szQ\",
		  \"value\": \"$privacy\"
		},
		{
		  \"fieldID\": \"MKWehdtk4kK2zAjXN47n8w\",
		  \"value\": \"$contacttype\"
		},
		
		{
		  \"fieldID\": \"UonZM4IMuEaWxAjXN46n1g\",
		  \"value\": \"$subscribe\"
		},
        {
          \"fieldID\": \"fxGiRIULckiM3wjXN47hSg\",
          \"value\": \"$businessunit\"
        },
        {
		  \"fieldID\": \"ydDRjW4Ya0aZQwjXN47dLw\",
		  \"value\": \"$medium\"
		},
		{
		  \"fieldID\": \"obhIqX72u0GyFQjXN46_Cw\",
		  \"value\": \"$campaign\"
        },
        {
            \"fieldID\": \"-y0BPkKTF0CX7QjXN47l9Q\",
            \"value\": \"$region\"
        },
		{
			\"fieldID\": \"X-htBb2oAUec-wjXN47kLQ\",
			\"value\": \"$frompage\"
		}
	  ],
	  \"source\": \"0003 Oncore Contact - Business Opportunity - Landing Page\"
	}";
            // perform the curl transaction
            if (!preg_match('/\d+/', $firstname) && !preg_match('/\d+/', $lastname)) {
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
                $decodedArray = json_decode($response, true);

// echo $response;

                if (in_array("FailedValidation", $decodedArray)) {
                    echo "Your form submission was Invalid. Please go back and try again.";
                } elseif ((in_array("UpdatedRow", $decodedArray)) || (in_array("AppendedRow", $decodedArray))) {

                    echo "Successful";
                    //send data to pipedrive
                    $deal['b02f1fdf1d4985094631af3a6a4dea9d3acb99f2'] = "0003 Oncore Contact - Business Opportunity - Landing Page"; //Form used
                    if ($cityinterest != "") {
                        $deal['685a0f82690ad447fd1d72a67b0eb2329cd26cac'] = $cityinterest; //Region interested in
                    }
                    include 'sync-pipedrive.php';
                    include 'SpreadsheetFW-API.php'; //need change to franchise sheet

                } else {
                    // Info was not sent to Ubiquity - send the info in an email to be manually entered
                    $emailsubject = "Submission from 0003 Oncore Contact - Business Opportunity - Landing Page - Ubiquity down";
                    $emailmessage = "First Name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country interested in: " . $countryinterest . "\n\n" . "City / State / Town interested in: " . $cityinterest . "\n\n" . "Enquiry: " . $enquiry . "\n\n" . "Country: " . $country;
                    mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n"); // If any headers come via form input ensure this is sanitised
                    echo "Successful";
                }
            }
        }

}

?>