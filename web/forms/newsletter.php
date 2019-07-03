<?php
// Ubiquity form: 0002 Zones Newsletter - Footer - Subscribe to newsletter
include '../includes/email.php';
if (isset($_POST['firstname'])) {
    $firstname = trim(addslashes($_POST['firstname']));
} else {
    $firstname = '';
}
if (isset($_POST['lastname'])) {
    $lastname = trim(addslashes($_POST['lastname']));
} else {
    $lastname = '';
}
if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
}

if (isset($_POST['tel'])) {
    $phone = trim($_POST['tel']);
} else {
    $phone = '';
}

if (isset($_COOKIE['fromsource'])) {
    if ($_COOKIE['fromsource'] == "google") {
        $source = "Google AdWords";
    } else if ($_COOKIE['fromsource'] == "bing") {
        $source = "Bing";
    } else if ($_COOKIE['fromsource'] == "facebook") {
        $source = "Facebook";
    } else if ($_COOKIE['fromsource'] == "LinkedIn") {
        $source = "LinkedIn";
    } else if ($_COOKIE['fromsource'] == "Social Media Post") {
        $source = "Social Media";
    } else if ($_COOKIE['fromsource'] == "Mailout") {
        $source = "Mailout";
    } else if ($_COOKIE['fromsource'] == "Social Media Post") {
        $source = "Social Media";
    } else if ($_COOKIE['fromsource'] == "Harmoney") {
        $source = "Harmoney";
    } else if ($_COOKIE['fromsource'] == "referral") {
        $source = "Referral";
    } else if ($_COOKIE['fromsource'] == "Local Print Media") {
        $source = "Local Print Media";
    } else if ($_COOKIE['fromsource'] == "banner") {
        $source = "Banner";
    } else if ($_COOKIE['fromsource'] == "local digital") {
        $source = "Local Digital Campaign";
    } else if ($_COOKIE['fromsource'] == "instagram") {
        $source = "Instagram";
    } else if ($_COOKIE['fromsource'] == "twitter") {
        $source = "Twitter";
    } else if ($_COOKIE['fromsource'] == "pinterest") {
        $source = "Pinterest";
    } else if ($_COOKIE['fromsource'] == "renovate") {
        $source = "Renovate Website";
    } else if ($_COOKIE['fromsource'] == "promotions") {
        $source = "Competitions";
    } else if ($_COOKIE['fromsource'] == "Friend") {
        $source = "Friend Referral";
    } else if ($_COOKIE['fromsource'] == "Customer") {
        $source = "Customer Referral";
    } else if ($_COOKIE['fromsource'] == "Repeat") {
        $source = "Customer repeat work";
    } else if ($_COOKIE['fromsource'] == "Trade") {
        $source = "Trade Referral";
    } else if ($_COOKIE['fromsource'] == "Designer") {
        $source = "Designer Referral";
    } else if ($_COOKIE['fromsource'] == "Distributor") {
        $source = "Distributor Referral";
    } else if ($_COOKIE['fromsource'] == "site sign") {
        $source = "Site Sign";
    } else if ($_COOKIE['fromsource'] == "tv") {
        $source = "TV";
    } else if ($_COOKIE['fromsource'] == "radio") {
        $source = "Radio";
    } else if ($_COOKIE['fromsource'] == "vehicle") {
        $source = "Branded Vehicle";
    } else if ($_COOKIE['fromsource'] == "event") {
        $source = "Local Event";
    } else if ($_COOKIE['fromsource'] == "network") {
        $source = "Network";
    } else if ($_COOKIE['fromsource'] == "outdoor") {
        $source = "Outdoor";
    } else if ($_COOKIE['fromsource'] == "sponsorship") {
        $source = "Sponsorship";
    } else if ($_COOKIE['fromsource'] == "leaflet") {
        $source = "Letter Box Drop";
    } else if ($_COOKIE['fromsource'] == "merchandise") {
        $source = "Branded merchandise";
    } else if ($_COOKIE['fromsource'] == "walk in") {
        $source = "Local Office";
    } else if ($_COOKIE['fromsource'] == "permanent expo") {
        $source = "Permanent Exhibition Centre";
    } else if ($_COOKIE['fromsource'] == "home show") {
        $source = "Home Show";
    } else if ($_COOKIE['fromsource'] == "seminar") {
        $source = "Seminars";
    } else if ($_COOKIE['fromsource'] == "directory") {
        $source = "Directory";
    } else if ($_COOKIE['fromsource'] == "cinema") {
        $source = "Cinema";
    } else if ($_COOKIE['fromsource'] == "other") {
        $source = "Other";
    } else if ($_COOKIE['fromsource'] == "Re-engagement") {
        $source = "Re-engagement";
    } else {
        $source = "Oncore Consumer Website";
    }
} else {
    $source = "Oncore Consumer Website";
};


if (isset($_POST['frompage'])) {
    $frompage = trim($_POST['frompage']);
} else {
    $frompage = '';
}

$formpage = $frompage;
$identifier = "0002 Oncore Newsletter - Footer - Subscribe to newsletter";
$subscribe = "False";
if (empty($firstname) || $firstname == "") { //not a lead
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
    if (!preg_match('/\d+/', $firstname)) {
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
        } else {
            // Info was not sent to Ubiquity - send the info in an email to be manually entered
            $emailsubject = "Submission from 0002 Oncore Newsletter - Footer - Subscribe to newsletter - Ubiquity down";
            $emailmessage = "First name: " . $firstname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: New Zealand" . "\n\n" . "Opted out setting: " . $subscribe;
            mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n");    // If any headers come via form input ensure this is sanitised
            echo "Successful"; // So that user sees their info has been collected.
        }
    }
} else { //its a lead
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
      \"fieldID\": \"TktuHUCoN0m9PAjWvZIKAA\",
      \"value\": \"$source\"
    },
    {
      \"fieldID\": \"RjD1DyFr7kibPgjWvZIQTA\",
      \"value\": \"$medium\"
    },
    {
      \"fieldID\": \"5-_-f7C3pU-QDQjWvZIUtg\",
      \"value\": \"$campaign\"
    },
	{
      \"fieldID\": \"8jNW_rnfyEGCTQjWvZD00w\",
      \"value\": \"$subscribe\"
    },
    {
      \"fieldID\": \"1m4CmWmHv0qerwjWvZFcHg\",
      \"value\": \"True\"
    },
    {
        \"fieldID\": \"OdiYtGs2VUyf9gjWvZIsdg\",
        \"value\": \"$frompage\"
    }
  ],
  \"source\": \"0002 Oncore Newsletter - Footer - Subscribe to newsletter\"
}";

// perform the curl transaction
    if (!preg_match('/\d+/', $firstname)) {
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
            include "Spreadsheet-API.php";
        } else {
            // Info was not sent to Ubiquity - send the info in an email to be manually entered
            $emailsubject = "Submission from 0002 Oncore Newsletter - Footer - Subscribe to newsletter - Ubiquity down";
            $emailmessage = "First name: " . $firstname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: New Zealand" . "\n\n" . "Opted out setting: " . $subscribe;
            mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n");    // If any headers come via form input ensure this is sanitised
            echo "Successful"; // So that user sees their info has been collected.
        }
    }
}
?>