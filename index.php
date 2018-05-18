<?php
session_start();
//--facebook login--
set_include_path(get_include_path() . PATH_SEPARATOR . 'facebook-php-sdk\src');
require_once ('Facebook/FacebookResponse.php');
require_once ('Facebook/FacebookSession.php');
require_once ('Facebook/FacebookSignedRequestFromInputHelper.php');
require_once ('Facebook/FacebookRedirectLoginHelper.php');
require_once ('Facebook/FacebookRequest.php');
require_once ('Facebook/FacebookSDKException.php');
require_once ('Facebook/FacebookRequestException.php');
require_once ('Facebook/FacebookAuthorizationException.php');
require_once ('Facebook/GraphObject.php');
use Facebook\FacebookResponse;
use Facebook\FacebookSession;
use Facebook\FacebookSignedRequestFromInputHelper;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
$helper = new FacebookRedirectLoginHelper('http://localhost/tripstracker/fbhome.php', '172688646739485','a86bd66ad18cc60a356b58c3eef0e09d');
$loginUrl = $helper->getLoginUrl();
echo '<br /><a href="' . $helper->getLoginUrl() . '">Login with Facebook</a>';
?>