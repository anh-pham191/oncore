<?php
include '../pipedrive/api.php';
$api = new API();

$data['email'] = $email;

//    -> $data['email'] = $email
//$personID = json_decode($api->find_contact_email($data), true)['data'][0]['id'];
$persons = json_decode($api->find_contact_email($data), true)['data'];

foreach ($persons as $key => $person) {
    $personIDs[] = $person['id'];

}

//$dealID = $api->find_deal_name($data, $personID);

foreach ($personIDs as $personID) {
    $all_related_deals = json_decode($api->find_deals_from_person_id($personID),true)['data'];

    if(!empty($all_related_deals)){
        foreach($all_related_deals as $deal) {
            
                $deal_id =  $deal["id"];
                $pipeline_id = $deal['pipeline_id'];
                break;
            
        }
    }

}
if(!isset($deal_id)){
    echo "NoDeal";
    exit;
}



?>

