<?php
require_once(__DIR__ . '/constants.php');
require_once(__DIR__ . '/database.php');

$db = new Database();

$rows = $db->get('SELECT * FROM phone');

// ---------------------------------- JSON ----------------------------------
// Iterate over all phones and fill out necessary attributes
foreach ($rows as $index => $row) {
  // Join brand
  $brand = $db->getPrepared('SELECT * FROM company WHERE id = ?', array($row['brand']), false);

  if (empty($brand)) {
    throw new Error('Brand not found');
  }

  $row['brand'] = $brand['name'];

  // Join processor
  $processor = $db->getPrepared('SELECT * FROM processor WHERE id = ?', array($row['processor']), false);

  if (empty($processor)) {
    throw new Error('Processor not found');
  }

  unset($processor['id']); // We do not wish to include internal database IDs in the generated dataset

  $processor_brand = $db->getPrepared('SELECT * FROM company WHERE id = ?', array($processor['brand']), false);

  if (empty($processor_brand)) {
    throw new Error('Processor brand not found');
  }

  $processor['brand'] = $processor_brand['name'];
  $row['processor']   = $processor;

  // Join charging port
  $charging_port = $db->getPrepared('SELECT * FROM charging_port WHERE id = ?', array($row['charging_port']), false);

  if (empty($charging_port)) {
    throw new Error('Charging port not found');
  }

  $row['charging_port'] = $charging_port['name'];

  // We ensure boolean type
  $row['headphone_jack']    = $row['headphone_jack'] ? true : false;
  $row['microsd']           = $row['microsd'] ? true : false;
  $row['wireless_charging'] = $row['wireless_charging'] ? true : false;

  // Camera data
  $phone_cameras = $db->getPrepared(
    'SELECT camera.description, camera.horizontal_resolution, camera.vertical_resolution, camera.resolution, camera.apature, camera_position.position 
    FROM phone_camera 
    LEFT JOIN camera ON phone_camera.camera_id = camera.id 
    LEFT JOIN phone ON phone_camera.phone_id = phone.id 
    LEFT JOIN camera_position ON camera.position = camera_position.id 
    WHERE phone_id = ?',
    array($row['id'])
  );

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

    for ($i = 0; $i < 6; $i++) {
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
