<?php
require_once 'vendor/autoload.php';
require_once(__DIR__ . '/constants.php');

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

$configuration = new SdkConfiguration(array(
  "domain"                => AUTH0_DOMAIN,
  "clientId"              => AUTH0_ID,
  "clientSecret"          => AUTH0_SECRET,
  "cookieSecret"          => AUTH0_COOKIE_SECRET,
  "redirectUri"           => AUTH0_REDIRECT_URI,
  'scope'                 => ['openid profile'],
  'persist_id_token'      => true,
  'persist_access_token'  => true,
  'persist_refresh_token' => true,
));

$auth0 = new Auth0($configuration);

// Check if the user is logged in already
$session = $auth0->getCredentials();

/**
 * Allows for private routes. This function will redirect the client if they do not have an active session (if they are not logged in).
 * 
 * @param Object $session the current initialized Auth0 session object
 * @param Object $auth0 the current initialized Auth0 object
 */
function is_authorized($session, $auth0)
{

  if ($session === null) {
    // We redirect the user to the Auth0 login page
    $auth0->clear();

    header('Location: ' . $auth0->login());
    exit;
  }
}
