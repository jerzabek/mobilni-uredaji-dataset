<?php

// Database access configuration
define('DB_NAME', 'fer_2122_or_mobilni_uredaji');
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

try {
  $db = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
  // set the PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit();
}

$sql = $db->query('SELECT * FROM phone');
$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

// ---------------------------------- JSON ----------------------------------
// Iterate over all phones and fill out necessary attributes
foreach ($rows as $index => $row) {
  // Join brand
  $sql = $db->prepare('SELECT * FROM company WHERE id = ?');
  $sql->execute(array($row['brand']));
  $brand = $sql->fetch(PDO::FETCH_ASSOC);

  if ($brand !== false) {
    $row['brand'] = $brand['name'];
  } else {
    throw new Error("Could not find brand");
  }

  // Join processor
  $sql = $db->prepare('SELECT * FROM processor WHERE id = ?');
  $sql->execute(array($row['processor']));
  $processor = $sql->fetch(PDO::FETCH_ASSOC);
  unset($processor['id']);

  if ($processor !== false) {
    $sql = $db->prepare('SELECT * FROM company WHERE id = ?');
    $sql->execute(array($processor['brand']));
    $processor_brand = $sql->fetch(PDO::FETCH_ASSOC);

    if ($processor !== false) {
      $processor['brand'] = $processor_brand['name'];
      $row['processor']   = $processor;
    } else {
      throw new Error("Could not find processor brand");
    }
  } else {
    throw new Error("Could not find processor");
  }

  // Join charging port
  $sql = $db->prepare('SELECT * FROM charging_port WHERE id = ?');
  $sql->execute(array($row['charging_port']));
  $charging_port = $sql->fetch(PDO::FETCH_ASSOC);

  if ($charging_port !== false) {
    $row['charging_port'] = $charging_port['name'];
  } else {
    throw new Error("Could not find charging_port");
  }

  $row['headphone_jack']    = $row['headphone_jack'] ? true : false;
  $row['microsd']           = $row['microsd'] ? true : false;
  $row['wireless_charging'] = $row['wireless_charging'] ? true : false;

  // Camera data
  $sql = $db->prepare('SELECT camera.description, camera.horizontal_resolution, camera.vertical_resolution, camera.resolution, camera.apature, camera_position.position FROM phone_camera LEFT JOIN camera ON phone_camera.camera_id = camera.id LEFT JOIN phone ON phone_camera.phone_id = phone.id LEFT JOIN camera_position ON camera.position = camera_position.id WHERE phone_id = ?');
  $sql->execute(array($row['id']));
  $phone_cameras = $sql->fetchAll(PDO::FETCH_ASSOC);

  $row['cameras'] = $phone_cameras;

  unset($row['id']);
  $rows[$index] = $row;
}

file_put_contents(DB_NAME . ".json", json_encode($rows));
// ---------------------------------- END JSON ----------------------------------

// ---------------------------------- CSV ----------------------------------
$csv_data = array();

foreach ($rows as $row) {
  // Flatten processor array
  $row['processor']['processor_name']   = $row['processor']['name'];
  $row['processor']['processor_brand']  = $row['processor']['brand'];

  unset($row['processor']['name']);
  unset($row['processor']['brand']);

  $row = array_merge($row, $row['processor']);

  unset($row['processor']);

  // For each camera we will have a separate entry in the CSV
  if (count($row['cameras']) > 0) {
    foreach ($row['cameras'] as $camera) {
      $csv_data[] = $row;

      $last = count($csv_data) - 1;

      unset($csv_data[$last]['cameras']);

      // Rename these attributes to prevent overwriting
      $camera['camera_horizontal_resolution'] = $camera['horizontal_resolution'];
      $camera['camera_vertical_resolution']   = $camera['vertical_resolution'];

      unset($camera['horizontal_resolution']);
      unset($camera['vertical_resolution']);

      $csv_data[$last] = array_merge($csv_data[$last], $camera);

      unset($csv_data[$last]['processor']);
    }
  } else {
    unset($row['cameras']);

    for ($i = 0; $i < 5; $i++) {
      // 6 Is the number of camera attributes. This is so that phones without a camera don't have missing columns
      $row[] = '';
    }

    $csv_data[] = $row;
  }
}

// Add column titels
array_unshift($csv_data, array_keys($csv_data[0]));

$fp = fopen(DB_NAME . '.csv', 'w');

if ($fp !== false) {
  foreach ($csv_data as $fields) {
    fputcsv($fp, $fields);
  }

  fclose($fp);
}
// ---------------------------------- END CSV ----------------------------------
