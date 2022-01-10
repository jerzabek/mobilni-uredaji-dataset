<?php
include 'auth0.php';

$auth0->clear();
header("Location: " . $auth0->logout(BASE_URL));
exit;