<?php
require_once(__DIR__ . '/auth0.php');

if ($auth0->getExchangeParameters()) {
  // If they're present, we should perform the code exchange.
  $auth0->exchange();
}

// Check if the user is logged in already
$session = $auth0->getCredentials();

if ($session === null) {
  // User is not logged in!
  // Redirect to the Universal Login Page for authentication.
  header("Location: " . $auth0->authentication()->getLoginLink(bin2hex(random_bytes(20))));
  exit;
}

// Successfully authenticated
header("Location: " . APP_PROFILE_PAGE);
exit;
