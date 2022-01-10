<?php
require_once(__DIR__ . '/auth0.php');

is_authorized($session, $auth0);

// Already authenticated - we immediately redirect to profile page
header("Location: " . APP_PROFILE_PAGE);
exit;
