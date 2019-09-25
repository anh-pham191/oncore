<?php
include 'sync-spreadsheetFW.php';
/** @var ListEntry */
date_default_timezone_set('Pacific/Auckland');

$listFeed->insert([
    "createddate" => date("Y-m-d H:i:s"),
    "firstname" => $firstname,
    "lastname" => $lastname,
    "email" => $email,
    'phone' => $phone,
    'privacypolicy' => $privacy,
    'optoutofnewslettter' => $subscribe,
    'wheretoopen' =>  $wheretoopen,
    'howsoontoopen' => $howsoon,
    'utmsource' => $source,
    'utmcampaign' => $campaign,
    'utmmedium' => $medium,
    'landingpageurl' => $formpage,
    'gclid' => $gclid,
]);
?>
