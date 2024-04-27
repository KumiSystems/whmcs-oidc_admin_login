<?php

/*
 * This file is part of a project developed by Kumi Systems e.U.
 *
 * Copyright (c) 2023 Kumi Systems e.U.
 *
 * This software is released under the MIT License.
 * See the LICENSE file in the project root for more information.
 */

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once 'vendor/autoload.php';
require_once "../../../init.php";

use Jumbojett\OpenIDConnectClient;
use WHMCS\Database\Capsule;

// Check if the module is activated
$moduleActivated = Capsule::table('tbladdonmodules')
    ->where('module', '=', 'oidc_admin_login')
    ->count() > 0;

if (!$moduleActivated) {
    // Handle the error case where the module is not activated
    error_log("OIDC SSO login failed: Module not activated");
    die("OIDC SSO login failed: Module not activated");
}

// Fetch the module configuration
$moduleConfig = Capsule::table('tbladdonmodules')
    ->where('module', '=', 'oidc_admin_login')
    ->get();

$oidcProviderUrl = $moduleConfig->where('setting', '=', 'oidcProviderUrl')->first()->value;
$clientID = $moduleConfig->where('setting', '=', 'clientId')->first()->value;
$clientSecret = $moduleConfig->where('setting', '=', 'clientSecret')->first()->value;
$oidcScopes = $moduleConfig->where('setting', '=', 'oidcScopes')->first()->value;
$oidcClaim = $moduleConfig->where('setting', '=', 'oidcClaim')->first()->value;

$oidcScopes = explode(',', $oidcScopes);

// Initialize the OIDC client
$oidc = new OpenIDConnectClient($oidcProviderUrl, $clientID, $clientSecret);
$oidc->addScope($oidcScopes);

try {
    // Authenticate the user with the OIDC provider
    $oidc->authenticate();

    // Fetch the user's details
    $userInfo = $oidc->requestUserInfo();

    // Get the value of the claim to use as the WHMCS username
    if (isset($userInfo->$oidcClaim)) {
        $username = $userInfo->$oidcClaim;

        // Initialize WHMCS authentication class
        $auth = new WHMCS\Auth();

        // Attempt to find and authenticate the user by username
        if ($auth->getInfobyUsername($username)) {
            // Set session variables for the logged-in user
            $auth->setSessionVars();

            $redirectUri = '/admin/';
            // TODO: Preserve the original redirect URL
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
