<?php
include 'sync-spreadsheet.php';
/** @var ListEntry */
date_default_timezone_set('Pacific/Auckland');
$listFeed->insert([
    "createddate" => date("Y-m-d H:i:s"),
    "firstname" => $firstname,
    "lastname" => $lastname,
    "email" => $email,
    'phone' => $phone,
    'preferredtime' => $preftime,
    'message' => $enquiry,
    'privacypolicy' => $privacy,
    'optoutofnewslettter' => $subscribe,
    'wheretolandscape' =>  $wheretoopen,
    'howsoontolandscape' => $howsoon,
    'utmsource' => $source,
    'utmcampaign' => $campaign,
    'utmmedium' => $medium,
    'utmcontent' => "",
    'utmkeyword' => "",
    'landingpageurl' => $formpage,
    'formidentifier' => $identifier,
]);
?>
