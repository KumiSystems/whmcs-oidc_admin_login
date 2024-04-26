<?php

require_once 'vendor/autoload.php';
require_once "../../../init.php";

require_once "config.php";

use Jumbojett\OpenIDConnectClient;

// Initialize the OIDC client
$oidc = new OpenIDConnectClient($oidcProviderUrl, $clientID, $clientSecret);
$oidc->addScope(['openid', 'email', 'profile']);

try {
    // Authenticate the user with the OIDC provider
    $oidc->authenticate();

    // Fetch the user's details
    $userInfo = $oidc->requestUserInfo();

    // The 'preferred_username' claim will be used as the WHMCS username
    if (isset($userInfo->preferred_username)) {
        $username = $userInfo->preferred_username;

        // Initialize WHMCS authentication class
        $auth = new WHMCS\Auth();

        // Attempt to find and authenticate the user by username
        if ($auth->getInfobyUsername($username)) {
            // Set session variables for the logged-in user
            $auth->setSessionVars();

            $redirectUri = '/admin/';
            header('Location: ' . $redirectUri);
            exit;
        } else {
            // Handle the error case where the username doesn't exist in WHMCS
            error_log("OIDC SSO login failed: Username not found in WHMCS");
            // TODO: Redirect to a failure page
            die("OIDC SSO login failed: Username not found in WHMCS");
        }
    } else {
        // Handle missing username claim
        error_log("OIDC SSO login failed: Username claim not found in user info");
        exit;
    }
} catch (Exception $e) {
    // Handle errors, such as authentication failures
    error_log("OIDC SSO login error: " . $e->getMessage());
    die("OIDC SSO login error: " . $e->getMessage());
}
