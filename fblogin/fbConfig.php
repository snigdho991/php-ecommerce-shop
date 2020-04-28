<?php
    if(!session_id()){
        session_start();
    }

    // Include the autoloader provided in the SDK
    require_once __DIR__ . '/vendor/autoload.php';

    // Include required libraries
    use Facebook\Facebook;
    use Facebook\Exceptions\FacebookResponseException;
    use Facebook\Exceptions\FacebookSDKException;

    /*
     * Configuration and setup Facebook SDK
     */
    $appId         = '435147893687851'; //Facebook App ID
    $appSecret     = 'e601f2e04b4b9a2c62ee6919dcae3fc0'; //Facebook App Secret
    $redirectURL   = 'http://localhost/shop/alternative.php'; //Callback URL
    $fbPermissions = array('email');  //Optional permissions

    $fb = new Facebook(array(
        'app_id' => $appId,
        'app_secret' => $appSecret,
        'default_graph_version' => 'v2.10',
    ));

    // Get redirect login helper
    $helper = $fb->getRedirectLoginHelper();

    // Try to get access token
    try {
        if(isset($_SESSION['facebook_access_token'])){
            $accessToken = $_SESSION['facebook_access_token'];
        }else{
              $accessToken = $helper->getAccessToken();
        }
    } catch(FacebookResponseException $e) {
         echo 'Graph returned an error: ' . $e->getMessage();
          exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
    }

?>