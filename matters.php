<?php

require_once('functions.php');
//header('Location :'.'https://eu.app.clio.com/api/v4/contacts.json');

$URL = "https://eu.app.clio.com/api/v4/matters.json";
$result = send_request($URL,'GET');
?>
