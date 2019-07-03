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
$lastname = cleanData($_POST['lastname']);
$email = cleanData($_POST['email']);
$phone = cleanData($_POST['tel']);
$country = "New Zealand";
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
if (isset($_POST['subject'])) {
    $subject = cleanData($_POST['subject']);
} else {
    $subject = "";
}
$enquiry = cleanData($_POST['enquiry']);
if (isset($_COOKIE['viewedopp'])) {
    $opportunity = cleanData($_COOKIE['viewedopp']);
} else {
    $opportunity = "";
};
$honeypot = cleanData($_POST['website']);
if (isset($_POST['frompage'])) {
    $frompage = cleanData($_POST['frompage']);
} else {
    $frompage = "";
}
$formpage = $frompage;
$identifier = "Oncore Contact - General Enquiry";
if (isset($_COOKIE['fromcampaign'])) {
    $campaign = cleanData($_COOKIE['fromcampaign']);
} else {
    $campaign = "N/A";
};
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
    } else{
        $source = "Oncore Consumer Website";
    }
}else{
    $source = "Oncore Consumer Website";
};
if (isset($_COOKIE['frommedium'])) {
    $medium = cleanData($_COOKIE['frommedium']);
}
if (isset($_COOKIE['fromkeyword'])) {
    $keyword = cleanData($_COOKIE['fromkeyword']);
} else {
    $keyword = "N/A";
};
if (isset($_COOKIE['fromcreative'])) {
    $creative = cleanData($_COOKIE['fromcreative']);
} else {
    $creative = "N/A";
};

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

        $spamsubject = "SPAM from Oncore Services website - General Enquiry";
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

        // Set up Opted out value
        if ($subscribe == "on") {
            $subscribe = "False"; // Has not opted out
        } else {
            $subscribe = "True";
        }

        $url = "https://api.ubiquity.co.nz/forms/jJLy6C19Z0aQsAjWTu9vMg/submit?apiToken=vaxIncJDcdcyEaK6KaIUV8uAtJOKR5uCB2HJhWtd4LGbeh7KORxzeqQNjPIaOREIrsK7he-3zjY8zoG4OJwIQk7ORyCuHgQA4BwqSK2V-2IH3mwvH0rMzrqQscjMLW5rOXUQXgksMjs";

        $jsonData = "{
	  \"data\": [
		{
		  \"fieldID\": \"qia5LPwUi0m26AjWTu-llg\",
		  \"value\": \"$firstname\"
		},
		{
		  \"fieldID\": \"PN7jdhtLoEegewjWTu-nJA\",
		  \"value\": \"$lastname\"
		},
		{
		  \"fieldID\": \"xNVraxYEnUyiWQjWTu-olQ\",
		  \"value\": \"$email\"
		},
		{
		  \"fieldID\": \"qpXhTbPKXkqJnAjWwnniVg\",
		  \"value\": \"$phone\"
		},
		{
		  \"fieldID\": \"x9oxG3B8XkWeTwjWTvBXsg\",
		  \"value\": \"$country\"
		},
		{
		  \"fieldID\": \"Grq2IcN1mEGVzAjWTvBr0Q\",
		  \"value\": \"$source\"
		},
		{
		  \"fieldID\": \"2E_-RIEMFk2KiwjWTv5Lrw\",
		  \"value\": \"$privacy\"
		},
		{
		  \"fieldID\": \"BHG8rCE1zEupWgjWT4YxEQ\",
		  \"value\": \"$subscribe\"
		},
        {
		  \"fieldID\": \"fRAJ4A8sY0CqQwjWTv4m_Q\",
		  \"value\": \"$medium\"
		},
		{
		  \"fieldID\": \"znq2Qp_sQ0SlTwjWTwUmrg\",
		  \"value\": \"$campaign\"
        },
        {
		  \"fieldID\": \"BuUlbKKqn0ioaQjWUFgRXA\",
		  \"value\": \"$keyword\"
		},
		{
		  \"fieldID\": \"2UkdM00uzES_tgjWUFgihQ\",
		  \"value\": \"$creative\"
        },
		{
		  \"fieldID\": \"kVxA-ShxDUqmBgjWTwUSGA\",
		  \"value\": \"$frompage\"
		}
	  ],
	  \"source\": \"Oncore Contact - General Enquiry - used for Consumer Enquiry\"  
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
                $emailsubject = "Submission from Oncore Services website - General Enquiry - Ubiquity down";
                $emailmessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Read and accepted Privacy Policy : " . $privacy . "\n\n" . "Opted out setting: " . $subscribe . "\n\n" . "Page Enquiry Made On: " . $frompage;
                mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n"); // If any headers come via form input ensure this is sanitised
                echo "Successful"; // So that user sees their info has been collected.
            }
        }
    }
}
?>