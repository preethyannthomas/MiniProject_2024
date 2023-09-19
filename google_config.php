<?php

//start session on web page
include('connection.php');

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('95908132454-43ct561tga2rk82a6bku1e1llekgfemv.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('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');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?>

