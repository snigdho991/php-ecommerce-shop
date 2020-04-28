<?php include 'inc/header.php'; ?>
<?php
    $login = Session::get("cmrLogin");
    if($login == true){
        header("Location:404.php");
    }
?>
<?php
    // Include FB config file && User class
    require_once '/fblogin/fbConfig.php';
    require_once '/fblogin/User.class.php';

    if(isset($accessToken)){
        if(isset($_SESSION['facebook_access_token'])){
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }else{
            // Put short-lived access token in session
            $_SESSION['facebook_access_token'] = (string) $accessToken;
            
              // OAuth 2.0 client handler helps to manage access tokens
            $oAuth2Client = $fb->getOAuth2Client();
            
            // Exchanges a short-lived access token for a long-lived one
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
            $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
            
            // Set default access token to be used in script
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
        
        // Redirect the user back to the same page if url has "code" parameter in query string
        if(isset($_GET['code'])){
            header('Location: ./');
        }
        
        // Getting user facebook profile info
        try {
            $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,gender,locale,cover,picture,link');
            $fbUserProfile = $profileRequest->getGraphNode()->asArray();
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // Redirect user back to app login page
            header("Location: ./");
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
        // Initialize User class
        $user = new User();
        
        // Insert or update user data to the database
        $fbUserData = array(
            'oauth_provider'=> 'facebook',
            'oauth_uid'     => $fbUserProfile['id'],
            'first_name'    => $fbUserProfile['first_name'],
            'last_name'     => $fbUserProfile['last_name'],
            'email'         => $fbUserProfile['email'],
            'picture'       => $fbUserProfile['picture']['url']
        );
        $userData = $user->checkUser($fbUserData);
        
        // Put user data into session
        $_SESSION['userData'] = $userData;
        
        // Get logout url
        $logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'logout.php');
        
        // Render facebook profile data
        if(!empty($userData)){
            $output  = '<div class="content_top">
                            <div class="heading">
                                <h3>Facebook ID Details</h3>
                            </div>
                                <div class="clear"></div>
                        </div>';
            $output .= '<div style="position: relative;">';
            $output .= '<img style="position: absolute; top: 10px;left: 40%;height: 150px;width: 170px;" src="'.$userData['picture'].'"/>';
            $output .= '</div>';
            $output .= '<br/><p class="notice">Facebook ID : '.$userData['oauth_uid'].'</p>';
            $output .= '<br/><p class="notice">Name : '.$userData['first_name'].' '.$userData['last_name'].'</p>';
            $output .= '<br/><p class="notice">Email : '.$userData['email'].'</p>';
            $output .= '<p class="notice"><br/><br/>Logged in with : Facebook</p><br/>';


            $query = "SELECT tbl_customer.*, users.email
                      FROM tbl_customer
                      INNER JOIN users
                      ON tbl_customer.oauth_uid = users.oauth_uid
                      ORDER BY tbl_customer.id ASC";
            $result = $db->select($query);
            if($result) {
                while($value = $result->fetch_assoc()){
                if($value['email'] == $fbUserProfile['email']){
                    $output .= '<h2 style="color:red">You are already registered with this e-mail address. </h2><br/><div class="search"><div style="padding-left: 318; padding-top: 20;"><a style="color:#fff;" href="login.php"><button class="grey" name="submit">Go To Login Page</button></a></div></div>             
                        <div class="clear"></div>';
                } } } else {
                    $output .= '<h2 style="color:green">Click <span class="design"><a style="color:#fff;" href="fbprofile.php?proid='.$userData['oauth_uid'].'">here</a></span> to continue the registration process.</h2><br/><div class="search"><div style="padding-left: 318; padding-top: 20;"><a style="color:#fff;" href="login.php"><button class="grey" name="submit">Go Back</button></a></div></div>             
                        <div class="clear"></div>';
                } 
            
        } else {
            $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
        }
        
    } else {
        // Get login url
        $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
        
        // Render facebook login button
        $output = '<a href="'.htmlspecialchars($loginURL).'"><img src="fblogin/images/fblogin-btn.png"></a>';
    }
?>

<style type="text/css">
    p.term{
        float:left;
        font-size:12px;
        padding:15px 0 0 15px;
    }

    p.term a,p.notice a{
    text-decoration:underline;
    color:#7C2DC5;
    }
    p.terms a:hover,p.notice a:hover{
        text-decoration:none;
    }
    p.notice{
        font-size:17px;
        color:#666;
        padding:5px;
        line-height:10px;
    }
    .design{
        color: #fff;
        background: #602d8d url("../images/large-button-overlay.png") repeat scroll 0 0;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        color: #fff;
        font-family: Arial,"Helvetica Neue","Helvetica",Tahoma,Verdana,sans-serif;
        font-size: 0.8em;
        padding: 5px 15px;
        text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.25);
        cursor: pointer;
        outline: none;
    }
</style>

    <div class="main">
    <div class="content">
        <div class="section group">
            <body>
                <!-- Display login button / Facebook profile information -->
                <div>
                    <?php echo $output; ?>
                </div>
            </body>
        </div>
            
    <div class="clear"></div>
    </div>
    </div>

<?php include 'inc/footer.php'; ?>

