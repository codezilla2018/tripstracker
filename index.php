<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php'; // download official fb sdk for php @ https://github.com/facebook/php-graph-sdk
$fb = new Facebook\Facebook([
  'app_id' => '172688646739485',
  'app_secret' => 'a86bd66ad18cc60a356b58c3eef0e09d',
  'default_graph_version' => 'v2.12',
  ]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['user_birthday', 'user_location']; // optional
	
try {
	if (isset($_SESSION['localhost_app_token'])) {
		$accessToken = $_SESSION['localhost_app_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
 }
if (isset($accessToken)) {
	if (isset($_SESSION['localhost_app_token'])) {
		$fb->setDefaultAccessToken($_SESSION['localhost_app_token']);
	} else {
		// getting short-lived access token
		$_SESSION['localhost_app_token'] = (string) $accessToken;
	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['localhost_app_token']);
		$_SESSION['localhost_app_token'] = (string) $longLivedAccessToken;
		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['localhost_app_token']);
	}
	// redirect the user back to the same page if it has "code" GET variable
	if (isset($_GET['code'])) {
		header('Location: ./');
	}
	// getting basic info about user
	try {
		$profile_request = $fb->get('/me?fields=name,first_name,last_name,birthday,location');
		$profile = $profile_request->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: ./");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	
	// printing $profile array on the screen which holds the basic info about user
	echo $profile['first_name'];
	echo $profile['birthday']->format('d-m-Y');
	//echo $profile['website'];
	echo $profile['location']['name'];
  	// Now you can redirect to another page and use the access token from $_SESSION['localhost_app_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl('https://facebooktrips.cf', $permissions);
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}