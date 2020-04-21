<?php
include '../pipedrive/api.php';
$api = new API();
if (isset($firstname) && $firstname != "") {
    if (isset($lastname) && $lastname != "") {
        $contact['name'] = $firstname . " " . $lastname;
    } else {
        $contact['name'] = $firstname;
    }
}
if (isset($email) && $email != "") {
    $contact['email'] = $email;
}
$persons = json_decode($api->find_contact_email($contact), true)['data']; // finding Person based on email address
foreach ($persons as $key => $person) {
    $personIDs[] = $person['id']; //more than one person possibly?

}
foreach ($personIDs as $personID) {
    $all_related_deals = json_decode($api->find_deals_from_person_id($personID),true)['data']; // find all deals based on each person ID
    if(!empty($all_related_deals)){
        foreach($all_related_deals as $deal) { //only deals on Australian Webinar pipeline
            if( $deal['pipeline_id'] == 43) { // 42: NZ 43: AU 44:UK 45:US
                $deal_id =  $deal["id"];
                $pipeline_id = $deal['pipeline_id'];
                break;
            }
        }
    }
}
if(isset($deal_id) && isset($pipeline_id) && $pipeline_id == "43") {
    // update?
} else {
    //normal



    if (isset($phone) && $phone != "") {
        $contact['phone'] = $phone;
    }
    if (isset($country) && $country != "") {
        $contact['c05324ca675eec21d1cbb85c31dfd22b3a9d141a'] = $country;
        if ($country == "Australia") {
            $deal['pipeline_id'] = "43"; // 1 - Refresh NZ; 3 - Zones NZ; 4 - Refresh Oz; 5 - Refresh UK; 6 - Refresh US; 7 - Refresh Other;
            $deal['stage_id']= "328"; // going to Lead In stage
    //        $deal['user_id']="1760272"; //AU leads owner - Mark
    //        $contact['owner_id']="1760272";
            $deal['user_id']="1623105"; //NZ leads owner - Chris
            $contact['owner_id']="1623105";

        } elseif ($country == "New Zealand") {
            $deal['pipeline_id'] = "1"; // 1 - Refresh NZ; 3 - Zones NZ; 4 - Refresh Oz; 5 - Refresh UK; 6 - Refresh US; 7 - Refresh Other;
            $deal['user_id']="1929160"; //NZ leads owner - Lal
            $contact['owner_id']="1929160";
        } elseif ($country == "United Kingdom") {
            $deal['pipeline_id'] = "5"; // 1 - Refresh NZ; 3 - Zones NZ; 4 - Refresh Oz; 5 - Refresh UK; 6 - Refresh US; 7 - Refresh Other;
    //        $deal['user_id']="1752102"; //UK leads owner - Tom
            $deal['user_id']="9838774"; //UK leads owner - Vincent
            $contact['owner_id']="9838774";

        } elseif ($country == "United States") {
            $deal['pipeline_id'] = "28"; // 1 - Refresh NZ; 3 - Zones NZ; 4 - Refresh Oz; 5 - Refresh UK; 28 - Refresh US; 6 - Refresh Other;
            $deal['user_id']="9203202"; //US leads owner - Paul
            $contact['owner_id']="9203202";
        } else {
            $deal['pipeline_id'] = "6"; // 1 - Refresh NZ; 3 - Zones NZ; 4 - Refresh Oz; 5 - Refresh UK; 28 - Refresh US; 6 - Refresh Other;
        }
    }else{
        $contact['c05324ca675eec21d1cbb85c31dfd22b3a9d141a'] = "Australia"; //Country
        $deal['pipeline_id'] = "4"; // 1 - Refresh NZ; 3 - Zones NZ; 4 - Refresh Oz; 5 - Refresh UK; 6 - Refresh US; 7 - Refresh Other;
        $deal['user_id']="1760272"; //AU leads owner - Mark
        $contact['owner_id']="1760272";
    }
    $deal['title'] = $contact['name'] . " Deal";
    $deal['03197a58402293106dd45764ea9d3b6d45c936d5'] = "Refresh Franchise ".$country." Website"; //Lead source */
    if (isset($countryinterest) && $countryinterest != "") {
        $deal['dea8395431c0f22108796567858d8b31729069fa'] = $countryinterest; //Country interested in
    }
    if (isset($enquiry) && $enquiry != "") {
        $deal['46a3299d657baba2a9de0731eb7ae060c7f901d9'] = $enquiry; //Enquiry
    }
    if (isset($source) && $source != "") {
        $deal['cce125edda19d5f999a8643db3bb4cae1139c736'] = $source; //Referral source
    }
    if (isset($campaign) && $campaign != "") {
        $deal['2c3321c249fc2d645b2ff6b8d8cb4220a84fc5a8'] = $campaign; //Referral campaign
    }
    if (isset($cityinterest) && $cityinterest != "") {
        $deal['e7b57b754f31bb28f953244fb7a88f3c8149eb22'] = $cityinterest; //City interested in
    }
     if($formpage=="Master Franchise"){
        $deal['dea8395431c0f22108796567858d8b31729069fa'] = $country;
        $deal['685a0f82690ad447fd1d72a67b0eb2329cd26cac'] = $region;
        $deal['278fe37fda87dab73c818dc71d115cefc834f663'] = $state;
        if ($country == "Australia") {
            $deal['pipeline_id'] = "30";
        } elseif ($country == "New Zealand") {
            $deal['pipeline_id'] = "32";
        } elseif ($country == "United Kingdom") {
            $deal['pipeline_id'] = "31";
        } elseif ($country == "United States") {
            $deal['pipeline_id'] = "27";
        }

    }

    //use name to search contact
    $find_contact_name = $api->find_contact_name($contact);
    $name_check_result = json_decode($find_contact_name, true);

    //use email to search contact
    $find_contact_email = $api->find_contact_email($contact);
    $email_check_result = json_decode($find_contact_email, true);


    if ($name_check_result['success'] == 1 && $name_check_result['data'] != null && $email_check_result['success'] == 1 && $email_check_result['data'] != null ) {
    //If Pipedrive returns two "info existed" responses for both of name and email, and the two info ID is the same, create new deal under this person contact; If not, creatie a new person contact and a new deal under this contact.

        foreach($email_check_result['data'] as $email_array) {
          foreach($name_check_result['data'] as $name_array) {
              if($email_array['id'] == $name_array['id']){
                  $deal['person_id'] = $email_array['id'];
              }
          }
        }
        if( $deal['person_id'] !=""){
        $create_deal = $api->create_deal($deal);
        }else{
         //no person contact is found, create a new one.
        $create_contact = $api->create_contact($contact);
        $contact_create_result = json_decode($create_contact, true);

        //if created successfully, continue to create a new deal under the contact person's name.
        if ($contact_create_result['success'] == "true" && $contact_create_result['data'] != null) {
            $deal['person_id'] = $contact_create_result['data']['id'];
            $create_deal = $api->create_deal($deal);
        }
        }

     // check if the contact exists in pipedrive person list. if yes, update information. if no, creat new person contact. if there is no lastname, new record should be created
        // $contact_id = $name_check_result['data'][0]['id'];
        // $update_contact = $api->update_contact($contact_id, $contact);
        // $contact_update_result = json_decode($update_contact, true);

    //if this person contact record is updated successfully, check if there is any deal record which is associated with this person contact
        // if ($contact_update_result['success'] == "true" && $contact_update_result['data'] != null) {

        //     $find_deal_name = $api->find_deal_name($contact, $contact_update_result['data']['id']);
        //     $find_deal_result = json_decode($find_deal_name, true);
        //     //if there is a deal record found, then update it
        //     if ($find_deal_result['success'] == "true" && $find_deal_result['data'] != null) {
        //         $find_deal_id = $api->find_deal_id($find_deal_result['data'][0]['id']);
        //         $find_dealdetail_result = json_decode($find_deal_id, true);

        //         if ($find_dealdetail_result['success'] == "true" && $find_dealdetail_result['data']['pipeline_id'] == $deal['pipeline_id'] && $find_dealdetail_result['data']['status'] == "open" && (time() - strtotime($find_dealdetail_result['data']['update_time'])) / (60 * 60 * 24) < 2.5) {
        //             $update_deal = $api->update_deal($find_deal_result['data'][0]['id'], $deal);
        //         } else {
        //             $deal['person_id'] = $contact_update_result['data']['id'];
        //             $create_deal = $api->create_deal($deal);
        //         }
        //     } else {
        //         //if no deal record is found, create a new one
        //         $deal['person_id'] = $contact_update_result['data']['id'];
        //         $create_deal = $api->create_deal($deal);
        //     }
        // }
    } else {
        //no person contact is found, create a new one.
        $create_contact = $api->create_contact($contact);
        $contact_create_result = json_decode($create_contact, true);

        //if created successfully, continue to create a new deal under the contact person's name.
        if ($contact_create_result['success'] == "true" && $contact_create_result['data'] != null) {
            $deal['person_id'] = $contact_create_result['data']['id'];
            $create_deal = $api->create_deal($deal);
        }
    }
}

?>