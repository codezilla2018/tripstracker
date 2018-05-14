<?php
require_once 'Facebook\FacebookResponse.php';
require_once 'Facebook\FacebookRequest.php';
require_once 'Facebook\FacebookSession.php';
require_once 'Facebook\FacebookRedirectLoginHelper.php';
require_once 'Facebook\GraphObject.php';
require_once 'Facebook\GraphUser.php';
require_once 'Facebook\GraphLocation.php';
require_once 'Facebook\GraphSessionInfo.php';
require_once 'Facebook\FacebookSDKException.php';
require_once 'Facebook\FacebookRequestException.php';
require_once 'Facebook\Entities\AccessToken.php';
require_once 'Facebook\HttpClients\FacebookHttpable.php';
require_once 'Facebook\HttpClients\FacebookStream.php';
require_once 'Facebook\HttpClients\FacebookStreamHttpClient.php';
require_once 'Facebook\FacebookAuthorizationException.php';
use Facebook\FacebookResponse;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;   
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphLocation;
use Facebook\GraphSessionInfo;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookStream;
use Facebook\HttpClients\FacebookStreamHttpClient;
session_start();
$helper = new FacebookRedirectLoginHelper('http://localhost/floginproj/fbhome.php','172688646739485','a86bd66ad18cc60a356b58c3eef0e09d');
FacebookSession::setDefaultApplication( '172688646739485','a86bd66ad18cc60a356b58c3eef0e09d' );
//check if a session already exists
if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
// create new session from the stored access_token
$session = new FacebookSession( $_SESSION['fb_token'] );
// validate the access_token and ensure its validity
try {
if ( !$session->validate() ) {
$session = null;
}
} catch ( Exception $e ) {
// catch any exceptions
$session = null;
}
}
// if no session is found
if ( !isset( $session ) || $session === null )
{
try
{
$session = $helper->getSessionFromRedirect();}
catch(FacebookRequestException $ex)
{
// When Facebook returns an error
print_r( $ex );// or echo any appropriate message
}
catch( Exception $ex )
{
// When validation fails or other local issues
print_r( $ex );// or echo any appropriate message
}
}
// if it were a new session or the session got created as a result of "if no session found" either way
// set the tokens to bring about session management in terms of remembering and validating the token
if(isset($session))
{ 
// storing or remembering the session
$_SESSION['fb_token'] = $session->getToken();
// create a session using the stored token or the new one we generated at login
 $request= (new FacebookRequest($session, 'GET', '/me' ));
    $response=$request->execute();
    $object = $response->getGraphObject();
    $graph_user = $response->getGraphObject(GraphUser::className());
    // getting the profile picture
    $request = new FacebookRequest(
      $session,
      'GET',
      '/me/picture',
      array (
      'redirect' => false,
      'height' => '150',
      'type' => 'normal',
      'width' => '150',
      )
    );
    $response = $request->execute();
    $graph_user_pic = $response->getGraphObject(GraphUser::className());
    echo "<table><tr><td>";
    echo '<br /><img src="'.$graph_user_pic->getProperty('url').'"/></td><td>';
    echo '<br />First Name: '.$graph_user->getFirstName();
    echo '<br />Last Name: '.$graph_user->getLastName();
    echo '<br />Gender: '.$graph_user->getProperty('gender');
    echo '<br />Profile Link: '.$graph_user->getLink();
    echo '<br />Email ID: '.$graph_user->getProperty('email').'</td></table>';
    echo '<br /><a href="' . $helper->getLogoutUrl( $session, 'http://localhost/floginproj/index.php' ) . '">Logout</a>';
}
else {
// show login url
echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '">Login</a>';
}
?>