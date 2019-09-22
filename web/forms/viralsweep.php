<?PHP
$request_body = file_get_contents("php://input");
$data = json_decode($request_body, true);
include '../includes/emails.php';
$firstname = $data['20944_1568340301'];
$email = $data['email'];

$phone = $data["phone"];
$address = $data['address'];
$city = $data['city'];
$location = $address . ", " . $city;
$country = $data['country'];
$frompage = $data['entry_source']; //full site URL
$formpage = $frompage;
//$query_str = parse_url($frompage, PHP_URL_QUERY);
//parse_str($query_str, $query_params);
preg_match("/&?utm_source=([^&]+)/", $frompage, $matchSource);
$source = urldecode($matchSource[1]);
if ($source == "google") {
    $source = "Google AdWords";
} else if ($source == "bing") {
    $source = "Bing";
} else if ($source == "facebook") {
    $source = "Facebook";
} else if ($source == "LinkedIn") {
    $source = "LinkedIn";
} else if ($source == "Social Media Post") {
    $source = "Social Media";
} else if ($source == "Mailout") {
    $source = "Mailout";
} else if ($source == "Social Media Post") {
    $source = "Social Media";
} else if ($source == "Harmoney") {
    $source = "Harmoney";
} else if ($source == "referral") {
    $source = "Referral";
} else if ($source == "Local Print Media") {
    $source = "Local Print Media";
} else if ($source == "banner") {
    $source = "Banner";
} else if ($source == "local digital") {
    $source = "Local Digital Campaign";
} else if ($source == "instagram") {
    $source = "Instagram";
} else if ($source == "twitter") {
    $source = "Twitter";
} else if ($source == "pinterest") {
    $source = "Pinterest";
} else if ($source == "renovate") {
    $source = "Renovate Website";
} else if ($source == "promotions") {
    $source = "Competitions";
} else if ($source == "Friend") {
    $source = "Friend Referral";
} else if ($source == "Customer") {
    $source = "Customer Referral";
} else if ($source == "Repeat") {
    $source = "Customer repeat work";
} else if ($source == "Trade") {
    $source = "Trade Referral";
} else if ($source == "Designer") {
    $source = "Designer Referral";
} else if ($source == "Distributor") {
    $source = "Distributor Referral";
} else if ($source == "site sign") {
    $source = "Site Sign";
} else if ($source == "tv") {
    $source = "TV";
} else if ($source == "radio") {
    $source = "Radio";
} else if ($source == "vehicle") {
    $source = "Branded Vehicle";
} else if ($source == "event") {
    $source = "Local Event";
} else if ($source == "network") {
    $source = "Network";
} else if ($source == "outdoor") {
    $source = "Outdoor";
} else if ($source == "sponsorship") {
    $source = "Sponsorship";
} else if ($source == "leaflet") {
    $source = "Letter Box Drop";
} else if ($source == "merchandise") {
    $source = "Branded merchandise";
} else if ($source == "walk in") {
    $source = "Local Office";
} else if ($source == "permanent expo") {
    $source = "Permanent Exhibition Centre";
} else if ($source == "home show") {
    $source = "Home Show";
} else if ($source == "seminar") {
    $source = "Seminars";
} else if ($source == "directory") {
    $source = "Directory";
} else if ($source == "cinema") {
    $source = "Cinema";
} else if ($source == "other") {
    $source = "Other";
} else if ($source == "Re-engagement") {
    $source = "Re-engagement";
} else {
    $source = "Competitions";
}

if (empty($source)) {
    $source = "Competitions";
}
$privacy = "TRUE";
preg_match("/&?utm_campaign=([^&]+)/", $frompage, $matchCam);
$campaign = urldecode($matchCam[1]);
if (empty($campaign)) {
    $campaign = "Not set";
}
preg_match("/&?utm_medium=([^&]+)/", $frompage, $matchMed);
$medium = urldecode($matchMed[1]);
if (empty($medium)) {
    $medium = "Not set";
}

//if (isset($data['85489_1552604368'])){
//    $platform = explode(';', $data['85489_1552604368']);
//    $campaign = "win this ford";
//}
if ($data['newsletter_subscribe'] == "yes") {
    $subscribe = 'False'; // not opted out // send to 0002 Oncore Newsletter - Footer - Subscribe to newsletter
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
        \"value\": \"$country\"
      }, 
       {
        \"fieldID\": \"8jNW_rnfyEGCTQjWvZD00w\",
        \"value\": \"$subscribe\"
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
        \"fieldID\": \"OdiYtGs2VUyf9gjWvZIsdg\",
        \"value\": \"$frompage\"
      }
    ],
    \"source\": \"ViralSweep Competition\"
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
    $decodedArray = json_decode($response, true);
    if (in_array("FailedValidation", $decodedArray)) {
        $emailsubject = "Submission from ViralSweep Competiton - Ubiquity down";
        $emailmessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $lastname . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Enquiry Page Made On: " . $formpage . "\n\n" . "Lead Source: Competitions";
        mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n");

    }
}
if (isset($data['20761_1552604544'])) {
    $enquiry = $data['20761_1552604544'];
}

if ($data['44779_1566167646'] == "Yes" || !empty($data['20761_1552604544'])) {
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
         \"fieldID\": \"JN7dg42xtUuI8gjXCpVHvA\",
         \"value\": \"$location\"
        },
        {
          \"fieldID\": \"x9oxG3B8XkWeTwjWTvBXsg\",
          \"value\": \"$country\"
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
          \"fieldID\": \"znq2Qp_sQ0SlTwjWTwUmrg\",
          \"value\": \"$campaign\"
        },
        {
          \"fieldID\": \"fRAJ4A8sY0CqQwjWTv4m_Q\",
          \"value\": \"$medium\"
        },
        {
          \"fieldID\": \"YP7yRZqzekWW7wjXPai3kQ\",
          \"value\": \"$subscribe\"
        },
        {
            \"fieldID\": \"kVxA-ShxDUqmBgjWTwUSGA\",
            \"value\": \"$frompage\"
        }
      ],
      \"source\": \"ViralSweep Competition\"
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
    $decodedArray = json_decode($response, true);
    $identifier = "ViralSweep Competition - Handyman for a day";
    include 'Spreadsheet-API.php';

    if (in_array("FailedValidation", $decodedArray)) {
        $emailsubject = "Submission from ViralSweep Competiton - Ubiquity down";
        $emailmessage = "First name: " . $firstname . "\n\n" . "Last name: " . $lastname . "\n\n" . "Email: " . $email . "\n\n" . "Phone: " . $phone . "\n\n" . "Country: " . $country . "\n\n" . "Enquiry Page Made On: " . $frompage . "\n\n" . "Lead Source: " . $source;
        mail($emailtoaddress, $emailsubject, $emailmessage, "From: " . $emailfromaddress . "\r\n" . "Content-type: text/plain; charset=utf-8\r\n");

    }

}


?>