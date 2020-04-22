<?php

include '../includes/emails.php';
// Include the refresh configuration helper file.
include_once '../includes/master-config.php';

function cleanData($input) {
    $output = trim($input);
    $output = stripslashes($input);
    //$output = htmlspecialchars($output, ENT_NOQUOTES, 'UTF-8'); // Disallows code tags
    return $output;
}

$firstname = cleanData($_POST['firstName']);
$lastname = cleanData($_POST['lastName']);
$email = cleanData($_POST['email']);
$phone = cleanData($_POST['mobile']);
$region = cleanData($_POST['region']);
$enquiry = cleanData($_POST['enquiry']);
$country = cleanData($_POST['country']);
$formpage = $_POST['formpage'];
$privacy = cleanData($_POST['privacy']);
$subscribe = cleanData($_POST['privacy']);
$honeypot = cleanData($_POST['website']);
$step = cleanData($_POST['step']);
$lead = cleanData($_POST['lead']);
$identifier = "0003 Oncore Contact - Renovate Handbook Download";
if (isset($_COOKIE['fromcampaign'])) {
    $campaign = cleanData($_COOKIE['fromcampaign']);
} else {
    $campaign = "";
}

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
    } else if ($_COOKIE['fromsource']=="boosted") {
        $source = "Boosted Social Media Post";
    } else{
        $source = "Oncore Consumer Website";
    }
}else{
    $source = "Oncore Consumer Website";
};
if (isset($_COOKIE['frommedium'])) {
    $medium = cleanData($_COOKIE['frommedium']);
}else {
    $medium = "";
};

// Check if fields that shouldn't do contain a URL

$testString = $firstname.$lastname.$phone;
$isHTTP = strpos($testString, 'http:');
$isHTTPS = strpos($testString, 'https:');
if (($isHTTP !== false) || ($isHTTPS !== false)) {
    $probSpam = "yes";
    echo "ContainsLink";
}

else {
    $probSpam = "no";
}

/* Get the reCAPTCHA secret key base on the current locale for the current host.
 */

// Only proceed if no links were found
if ($probSpam != "yes") {
    // If Honeypot filled out send submission to spam and pretend it was successful
    if($honeypot != '') {
        // Trim field length as the database limits will not be applied for emailed submissions

        $firstname = substr($firstname,0,100);
        $lastname = substr($lastname,0,100);
        $email = substr($email,0,100);
        $mobile = substr($mobile,0,100);
        $privacy = substr($privacy,0,100);
        $formpage = substr($subscribe,0,100);
        $honeypot = substr($honeypot,0,5000);
        $campaign = substr($campaign,0,100);


        $spamsubject = "SPAM from Oncore website form - Competition - ".$formpage;
        $spammessage = "First name: ".$firstname."\n\n"."Last name: ".$lastname."\n\n"."Email: ".$email."\n\n"."Phone: ".$phone."\n\n"."Country: ".$country."\n\n"."Read and accepted Privacy Policy : ".$privacy."\n\n"."Page enquiry made on: ".$formpage."\n\n"."Lead Source: ".$source."\n\n"."Campaign: ".$campaign."\n\n"."Medium: ".$medium;
        mail($emailtoaddress,$spamsubject,$spammessage,"From: ".$emailfromaddress."\r\n"."Content-type: text/plain; charset=utf-8\r\n");	// If any headers come via form input ensure this is sanitised
        $goodtogo = "no"; // Do not post to Ubiquity
        echo "EnquirySent"; // Pretend to the spammer that their enquiry was sent
    }

    // Otherwise, carry on as for a human and submit to database :-)
    else {
        //If Privacy not checked
        if ($privacy == "on") {
            $privacy = True;
            $goodtogo = "yes";
        }else{
            $goodtogo = "no";
            echo "noprivacy";
            exit;
        }

        // Set up Opted out value
        if ($subscribe == "on") {
            $subscribe = "False"; // Has not opted out
        }else{
            $subscribe = "True";
        }




        if ($goodtogo != "no") {


            if($lead == "yes" && $step == "step3"){ //it's a lead, send form data to Ubiquity - 0002 Zones Contact - Stage 1 form
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
		  \"fieldID\": \"-QDJELbn9U6jgQjVW_SyIA\",
		  \"value\": \"New Zealand\"
		},
		{
		  \"fieldID\": \"0UAa1jAy2Uy62AjWs3PiKA\",
		  \"value\": \"$enquiry\"
		},
		{
		  \"fieldID\": \"Grq2IcN1mEGVzAjWTvBr0Q\",
		  \"value\": \"$source\"
		},
		{
      \"fieldID\": \"bjwU41yUvkGEJQjVW_WXCg\",
      \"value\": \"Zones NZ Consumer Lead\"
    },
		{
		  \"fieldID\": \"znq2Qp_sQ0SlTwjWTwUmrg\",
		  \"value\": \"$campaign\"
		},
		{
		  \"fieldID\": \"fRAJ4A8sY0CqQwjWTv4m_Q\",
		  \"value\": \"$medium\"
		},
		{
			\"fieldID\": \"kVxA-ShxDUqmBgjWTwUSGA\",
			\"value\": \"$formpage\"
		},
		{
			\"fieldID\": \"BHG8rCE1zEupWgjWT4YxEQ\",
			\"value\": \"$subscribe\"
		},
		{
			\"fieldID\": \"2E_-RIEMFk2KiwjWTv5Lrw\",
			\"value\": \"$privacy\"
		}
	  ],
	  \"source\": \"Oncore Contact - General enquiry\"
	}";
                if(!preg_match('/\d+/',$firstname) && !preg_match('/\d+/',$lastname)){
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

                    //echo $response;

                    if (in_array("FailedValidation", $decodedArray)) {
                        echo "Your form submission was Invalid. Please go back and try again.";
                    }
                    elseif ((in_array("UpdatedRow", $decodedArray)) || (in_array("AppendedRow", $decodedArray))) {

                        //add lead record to log
                        include '../includes/log.php';
                        include "Spreadsheet-API.php";
                        echo "Successful";

                    }
                    else {
                        // Info was not sent to Ubiquity - send the info in an email to be manually entered
                        $emailsubject = "Submission from Oncore Contact - General enquiry - Consumer - Ubiquity down";
                        $emailmessage = "Name: ".$firstname." ".$lastname."\n\n"."Email: ".$email."\n\n"."Phone: ".$phone."\n\n"."Contact Type Category: ".$thecategory."\n\n"."Opted out setting: False\n\n"."Country: New Zealand";
                        mail($emailtoaddress,$emailsubject,$emailmessage,"From: ".$emailfromaddress."\r\n"."Content-type: text/plain; charset=utf-8\r\n");	// If any headers come via form input ensure this is sanitised
                        echo "Successful";
                    }
                }


            }else if($step == "step1" || $step == "step2"){ //not a lead, send form data to Ubiquity
                $date_of_expiry = time() + 300;
                if($step == "step1"){
                    setcookie("handbookemail", "$email", $date_of_expiry, "/");
                }else{
                    setcookie("handbookfirstname", "$firstname", $date_of_expiry, "/");
                    setcookie("handbooklastname", "$lastname", $date_of_expiry, "/");
                    setcookie("handbookphone", "$phone", $date_of_expiry, "/");
                    setcookie("handbookregion", "$region", $date_of_expiry, "/");
                    setcookie("handbooksubscribe", "$subscribe", $date_of_expiry, "/");
                }
                $url = "https://api.ubiquity.co.nz/forms/xs2W7_UVa06LZQjW2g5ofQ/submit?apiToken=vaxIncJDcdcyEaK6KaIUV8uAtJOKR5uCB2HJhWtd4LGbeh7KORxzeqQNjPIaOREIrsK7he-3zjY8zoG4OJwIQk7ORyCuHgQA4BwqSK2V-2IH3mwvH0rMzrqQscjMLW5rOXUQXgksMjs";

                $jsonData = "{
          \"data\": [
            {
              \"fieldID\": \"QBQ3cHHXOUGGwwjW2g5orw\",
              \"value\": \"$firstname\"
            },
            {
              \"fieldID\": \"0C7XMzncTkKbpAjW2g5orw\",
              \"value\": \"$lastname\"
            },
            {
              \"fieldID\": \"ezgCnBp_bEu3qAjW2g5orw\",
              \"value\": \"$email\"
            },
            {
              \"fieldID\": \"K2KwjcpVv0-M1AjW2g5orw\",
              \"value\": \"$phone\"
            },
            {
              \"fieldID\": \"w6Y-Hij5hUWyJAjW2g5orw\",
              \"value\": \"$region\"
            },
            {
              \"fieldID\": \"qEM5PUgXKEik_AjW2g5orw\",
              \"value\": \"$country\"
            },
            {
              \"fieldID\": \"oUfJ-LVJHECKKAjW2g5orw\",
              \"value\": \"$enquiry\"
            },
            {
              \"fieldID\": \"MiwTvUrFBEWXKgjW2g5orw\",
              \"value\": \"$privacy\"
            },
            {
              \"fieldID\": \"wA2DNPkDkEK1dQjW2hBilQ\",
              \"value\": \"$subscribe\"
            },
            {
              \"fieldID\": \"o9rQu25YsUy1dgjW2g5orw\",
              \"value\": \"$formpage\"
            },
            {
              \"fieldID\": \"b502naOmjE-weQjW2g5orw\",
              \"value\": \"$medium\"
            },
            {
              \"fieldID\": \"iyzH5yq-3UGQUwjW2g5orw\",
              \"value\": \"$source\"
            },
            {
              \"fieldID\": \"br40UBL2pkafgAjW2g5orw\",
              \"value\": \"$campaign\"
            }
          ],
          \"source\": \"0003 Oncore Contact - Renovate Handbook Download\"
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

                //echo $response;

                if (in_array("FailedValidation", $decodedArray)) {
                    echo "Your form submission was Invalid. Please go back and try again.";
                }
                elseif ((in_array("UpdatedRow", $decodedArray)) || (in_array("AppendedRow", $decodedArray))) {

                    echo "Successful";
                }
                else {
                    // Info was not sent to Ubiquity - send the info in an email to be manually entered
                    $emailsubject = "Submission from Renovate Handbook Download form - Ubiquity down";
                    $emailmessage = "First name: ".$firstname."\n\n"."Last name: ".$lastname."\n\n"."Email: ".$email."\n\n"."Phone: ".$phone."\n\n"."Country: ".$country."\n\n"."Region: ".$region."\n\n"."Read and accepted Privacy Policy : ".$privacy."\n\n"."Enquiry: ".$enquiry."\n\n"."Spam field contents: ".$honeypot."\n\n"."Campaign: ".$campaign;
                    mail($emailtoaddress,$emailsubject,$emailmessage,"From: ".$emailfromaddress."\r\n"."Content-type: text/plain; charset=utf-8\r\n");	// If any headers come via form input ensure this is sanitised
                    echo "Successful";
                }

            }

        }else{echo "Unsuccessful";}

    }

}

?>
