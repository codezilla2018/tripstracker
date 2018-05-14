<?php
session_start();
//--facebook login--
set_include_path(get_include_path() . PATH_SEPARATOR . 'facebook-php-sdk\src');
require_once __DIR__.'Facebook\FacebookResponse.php';
require_once __DIR__.'Facebook\FacebookSession.php';
require_once __DIR__.'Facebook\FacebookSignedRequestFromInputHelper.php';
require_once __DIR__.'Facebook\FacebookRedirectLoginHelper.php';
require_once __DIR__.'Facebook\FacebookRequest.php';
require_once __DIR__.'Facebook\FacebookSDKException.php';
require_once __DIR__.'Facebook\FacebookRequestException.php';
require_once __DIR__.'Facebook\FacebookAuthorizationException.php';
require_once __DIR__.'Facebook\GraphObject.php';
use Facebook\FacebookResponse;
use Facebook\FacebookSession;
use Facebook\FacebookSignedRequestFromInputHelper;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
$helper = new FacebookRedirectLoginHelper('http://localhost/tripstracker/fbhome.php', 'your App ID','your App Secret');
$loginUrl = $helper->getLoginUrl();
echo '<br /><a href="' . $helper->getLoginUrl() . '">Login with Facebook</a>';
?>