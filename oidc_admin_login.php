<?php

function oidc_admin_login_config()
{
    // Plugin details displayed by WHMCS
    return [
        'name' => 'OIDC Admin Login',
        'description' => 'This module provides an OpenID Connect based single sign-on (SSO) solution for WHMCS admin users.',
        'version' => '0.1',
        'author' => 'Kumi Systems e.U.',
        'fields' => [
            // Configuration fields for the module
            // Displayed in WHMCS admin area under Addon Modules and used to store OIDC provider details
            'oidcProviderUrl' => [
                'FriendlyName' => 'OIDC Provider URL',
                'Type' => 'text',
                'Size' => '25',
                'Default' => '',
                'Description' => 'Enter the URL of your OIDC provider.',
            ],
            'clientId' => [
                'FriendlyName' => 'Client ID',
                'Type' => 'text',
                'Size' => '25',
                'Default' => '',
                'Description' => 'Enter the client ID provided by your OIDC provider.',
            ],
            'clientSecret' => [
                'FriendlyName' => 'Client Secret',
                'Type' => 'password',
                'Size' => '25',
                'Default' => '',
                'Description' => 'Enter the client secret provided by your OIDC provider.',
            ],
            'oidcClaim' => [
                'FriendlyName' => 'OIDC Claim',
                'Type' => 'text',
                'Size' => '25',
                'Default' => 'preferred_username',
                'Description' => 'Enter the OIDC claim to use as the WHMCS username.',
            ],
            'oidcScopes' => [
                'FriendlyName' => 'OIDC Scopes',
                'Type' => 'text',
                'Size' => '25',
                'Default' => 'openid,email,profile',
                'Description' => 'Enter the OIDC scopes to request from the provider, separated by commas.',
            ],
        ],
    ];
}

function oidc_admin_login_activate()
{
    // Code to execute when the module is activated
    return ['status' => 'success', 'description' => 'OIDC Admin Login activated successfully'];
}

function oidc_admin_login_deactivate()
{
    // Code to execute when the module is deactivated
    return ['status' => 'success', 'description' => 'OIDC Admin Login deactivated successfully'];
}
