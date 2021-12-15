<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/database.php');

$db = new Database();

// We set the Content-Type header indicating we are returning json data
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  $db->handle_error(403, 'Forbidden');
}

if (empty($_GET['list'])) {
  $db->handle_error(400, 'Missing list parameter');
}

switch ($_GET['list']) {
  case 'charging_port':
    try {
      $ports = $db->get('SELECT id, name FROM charging_port;');
    } catch (Exception $err) {
      $db->handle_error(500, "Could not list charging ports");
    }

    echo json_encode(array(
      "status"  => true,
      "data"    => $ports
    ));

    exit();
  case 'brand':
    try {
      $brands = $db->get('SELECT id, name FROM company;');
    } catch (Exception $err) {
      $db->handle_error(500, "Could not list brands");
    }

    echo json_encode(array(
      "status"  => true,
      "data"    => $brands
    ));

    exit();
}

$db->handle_error(400, 'Invalid list parameter');
