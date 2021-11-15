<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/database.php');

$db = new Database();

// We set the Content-Type header indicating we are returning json data
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(403);
  exit();
}

if (isset($_POST['wildcard'])) {
  $query = "SELECT JSON_ARRAYAGG(
    JSON_OBJECT(
    'cameras', 
      (SELECT JSON_ARRAYAGG(JSON_OBJECT(
        'description', description,
        'horizontal_resolution', horizontal_resolution, 
        'vertical_resolution', vertical_resolution,
        'resolution', resolution,
        'apature', apature,
        'position', camera_position.position)) AS json
      FROM camera
      RIGHT OUTER JOIN phone_camera ON (camera.id = phone_camera.camera_id)
      LEFT JOIN camera_position ON (camera.position = camera_position.id)
      GROUP BY phone_camera.phone_id
      HAVING phone_camera.phone_id = phone.id),
    'name', phone.name,
    'release_date', release_date,
    'brand', brand.name,
    'width', width,
    'height', height,
    'thickness', thickness,
    'screen_size', screen_size,
    'vertical_resolution', vertical_resolution,
    'horizontal_resolution', horizontal_resolution,
    'charging_port', charging_port.name,
    'headphone_jack', headphone_jack,
    'microsd', microsd,
    'wireless_charging', wireless_charging,
    'processor',
        (SELECT JSON_OBJECT(
          'name', processor.name,
          'cores', processor.cores,
          'clock_speed', processor.clock_speed,
          'brand', processor_brand.name)
        FROM processor
        LEFT JOIN company AS processor_brand ON (processor.brand = processor_brand.id)
        WHERE phone.processor = processor.id
        LIMIT 1)
    )
  ) as data 
  FROM phone
  LEFT JOIN charging_port ON (charging_port.id = phone.charging_port)
  LEFT JOIN company AS brand ON (brand.id = phone.brand)
  WHERE 
  phone.name LIKE ? OR
  phone.release_date LIKE ? OR
  phone.width LIKE ? OR
  phone.height LIKE ? OR
  phone.thickness LIKE ? OR
  phone.screen_size LIKE ? OR
  phone.vertical_resolution LIKE ? OR
  phone.horizontal_resolution LIKE ? OR
  charging_port.name LIKE ? OR
  brand.name LIKE ?";

  $params = array();

  // You can not repeat parameters in the PDO prepared statement. This is dirty but it works.
  for ($i = 0; $i < 10; $i++) {
    $params[] = "%" . $_POST['wildcard'] . "%";
  }

  try {
    $json = $db->getPrepared($query, $params, false);
  } catch (Exception $err) {
    $db->handle_error(500, "Could not filter data: " . $err);
  }

  if (empty($json['data'])) {
    $data = array();
  } else {
    $data = json_decode($json['data'], true);
  }

  echo json_encode(
    array(
      "status"  => true,
      "data"    => $data
    )
  );
} else if (!empty($_POST['field'])) {
  $query_start = "SELECT JSON_ARRAYAGG(
      JSON_OBJECT(
      'cameras', 
        (SELECT JSON_ARRAYAGG(JSON_OBJECT(
          'description', description,
          'horizontal_resolution', horizontal_resolution, 
          'vertical_resolution', vertical_resolution,
          'resolution', resolution,
          'apature', apature,
          'position', camera_position.position)) AS json
        FROM camera
        RIGHT OUTER JOIN phone_camera ON (camera.id = phone_camera.camera_id)
        LEFT JOIN camera_position ON (camera.position = camera_position.id)
        GROUP BY phone_camera.phone_id
        HAVING phone_camera.phone_id = phone.id),
      'name', phone.name,
      'release_date', release_date,
      'brand', brand.name,
      'width', width,
      'height', height,
      'thickness', thickness,
      'screen_size', screen_size,
      'vertical_resolution', vertical_resolution,
      'horizontal_resolution', horizontal_resolution,
      'charging_port', charging_port.name,
      'headphone_jack', headphone_jack,
      'microsd', microsd,
      'wireless_charging', wireless_charging,
      'processor',
          (SELECT JSON_OBJECT(
            'name', processor.name,
            'cores', processor.cores,
            'clock_speed', processor.clock_speed,
            'brand', processor_brand.name)
          FROM processor
          LEFT JOIN company AS processor_brand ON (processor.brand = processor_brand.id)
          WHERE phone.processor = processor.id
          LIMIT 1)
      )
    ) as data 
    FROM phone
    LEFT JOIN charging_port ON (charging_port.id = phone.charging_port)
    LEFT JOIN company AS brand ON (brand.id = phone.brand) ";

  $field = $_POST['field'];

  $query = '';

  // TODO: Add full text index on text fields, for more optimized searching
  // https://stackoverflow.com/questions/9589813/most-efficient-way-to-search-in-sql

  $parameters = array();

  switch ($field) {
    case 'name':
      $query .= "WHERE LOWER(phone.name) LIKE ?";
      $parameters[] = "%" . strtolower($_POST['value']) . "%";
      break;
    case 'release_date':
      $before = '';
      $after  = '';

      if (!empty($_POST['before'])) {
        $date = str_replace(' ', '', $_POST['before']);
        $date = new DateTime($date);
        $before = $date->format('Y-m-d');
      }

      if (!empty($_POST['after'])) {
        $date = str_replace(' ', '', $_POST['after']);
        $date = new DateTime($date);
        $after = $date->format('Y-m-d');
      }

      // Not ideal but will do the job
      if (!empty($after) && !empty($before)) {
        $query .= 'WHERE release_date BETWEEN ? AND ?';

        $parameters[] = $after;
        $parameters[] = $before;
      } else if (!empty($after)) {
        $query .= 'WHERE release_date > ?';

        $parameters[] = $after;
      } else if (!empty($before)) {
        $query .= 'WHERE release_date <= ?';

        $parameters[] = $before;
      }

      break;
    case 'width':
      // Not ideal but will do the job
      if (!empty($_POST['gt']) && !empty($_POST['lt'])) {
        $query .= 'WHERE width BETWEEN ? AND ?';

        $parameters[] = $_POST['gt'];
        $parameters[] = $_POST['lt'];
      } else if (!empty($_POST['gt'])) {
        $query .= 'WHERE width > ?';

        $parameters[] = $_POST['gt'];
      } else if (!empty($_POST['lt'])) {
        $query .= 'WHERE width <= ?';

        $parameters[] = $_POST['lt'];
      }

      break;
    case 'height':
      // Not ideal but will do the job
      if (!empty($_POST['gt']) && !empty($_POST['lt'])) {
        $query .= 'WHERE height BETWEEN ? AND ?';

        $parameters[] = $_POST['gt'];
        $parameters[] = $_POST['lt'];
      } else if (!empty($_POST['gt'])) {
        $query .= 'WHERE height > ?';

        $parameters[] = $_POST['gt'];
      } else if (!empty($_POST['lt'])) {
        $query .= 'WHERE height <= ?';

        $parameters[] = $_POST['lt'];
      }

      break;
    case 'thickness':
      // Not ideal but will do the job
      if (!empty($_POST['gt']) && !empty($_POST['lt'])) {
        $query .= 'WHERE thickness BETWEEN ? AND ?';

        $parameters[] = $_POST['gt'];
        $parameters[] = $_POST['lt'];
      } else if (!empty($_POST['gt'])) {
        $query .= 'WHERE thickness > ?';

        $parameters[] = $_POST['gt'];
      } else if (!empty($_POST['lt'])) {
        $query .= 'WHERE thickness <= ?';

        $parameters[] = $_POST['lt'];
      }

      break;
    case 'screen_size':
      // Not ideal but will do the job
      if (!empty($_POST['gt']) && !empty($_POST['lt'])) {
        $query .= 'WHERE screen_size BETWEEN ? AND ?';

        $parameters[] = $_POST['gt'];
        $parameters[] = $_POST['lt'];
      } else if (!empty($_POST['gt'])) {
        $query .= 'WHERE screen_size > ?';

        $parameters[] = $_POST['gt'];
      } else if (!empty($_POST['lt'])) {
        $query .= 'WHERE screen_size <= ?';

        $parameters[] = $_POST['lt'];
      }

      break;
    case 'vertical_resolution':
      // Not ideal but will do the job
      if (!empty($_POST['gt']) && !empty($_POST['lt'])) {
        $query .= 'WHERE vertical_resolution BETWEEN ? AND ?';

        $parameters[] = $_POST['gt'];
        $parameters[] = $_POST['lt'];
      } else if (!empty($_POST['gt'])) {
        $query .= 'WHERE vertical_resolution > ?';

        $parameters[] = $_POST['gt'];
      } else if (!empty($_POST['lt'])) {
        $query .= 'WHERE vertical_resolution <= ?';

        $parameters[] = $_POST['lt'];
      }

      break;
    case 'horizontal_resolution':
      // Not ideal but will do the job
      if (!empty($_POST['gt']) && !empty($_POST['lt'])) {
        $query .= 'WHERE horizontal_resolution BETWEEN ? AND ?';

        $parameters[] = $_POST['gt'];
        $parameters[] = $_POST['lt'];
      } else if (!empty($_POST['gt'])) {
        $query .= 'WHERE horizontal_resolution > ?';

        $parameters[] = $_POST['gt'];
      } else if (!empty($_POST['lt'])) {
        $query .= 'WHERE horizontal_resolution <= ?';

        $parameters[] = $_POST['lt'];
      }

      break;
    case 'charging_port':
      $query .= 'WHERE charging_port.id = ?';

      $parameters[] = $_POST['value'];
      break;
    case 'headphone_jack':
      $query .= 'WHERE headphone_jack = ?';

      $parameters[] = $_POST['value'];
      break;
    case 'microsd':
      $query .= 'WHERE microsd = ?';

      $parameters[] = $_POST['value'];
      break;
    case 'wireless_charging':
      $query .= 'WHERE wireless_charging = ?';

      $parameters[] = $_POST['value'];
      break;
    case 'brand':
      $query .= 'WHERE brand.id = ?';

      $parameters[] = $_POST['value'];
      break;
    case 'processor_name':
      $query .= 'WHERE LOWER(processor.name) = ?';

      $parameters[] = strtolower($_POST['value']);
      break;
    case 'processor_cores':
      $temp_query = '(SELECT cores FROM processor p WHERE p.id = phone.processor LIMIT 1)';

      // Not ideal but will do the job
      if (!empty($_POST['gt']) && !empty($_POST['lt'])) {
        $query .= "WHERE $temp_query BETWEEN ? AND ?";

        $parameters[] = $_POST['gt'];
        $parameters[] = $_POST['lt'];
      } else if (!empty($_POST['gt'])) {
        $query .= "WHERE $temp_query > ?";

        $parameters[] = $_POST['gt'];
      } else if (!empty($_POST['lt'])) {
        $query .= "WHERE $temp_query <= ?";

        $parameters[] = $_POST['lt'];
      }
      break;
    case 'processor_brand':
      $query = 'WHERE EXISTS (SELECT * FROM processor p LEFT JOIN company pb ON (p.brand = pb.id) WHERE p.id = phone.processor AND pb.id = ?) ';

      $parameters[] = $_POST['value'];
      break;
    case 'num_of_cameras':
      $temp_query = '(SELECT COUNT(*) FROM phone_camera WHERE phone_camera.phone_id = phone.id) ';

      // Not ideal but will do the job
      if (!empty($_POST['gt']) && !empty($_POST['lt'])) {
        $query .= "WHERE $temp_query BETWEEN ? AND ?";

        $parameters[] = $_POST['gt'];
        $parameters[] = $_POST['lt'];
      } else if (!empty($_POST['gt'])) {
        $query .= "WHERE $temp_query > ?";

        $parameters[] = $_POST['gt'];
      } else if (!empty($_POST['lt'])) {
        $query .= "WHERE $temp_query <= ?";

        $parameters[] = $_POST['lt'];
      }
      break;
    case 'camera_description':
      $query .= 'WHERE EXISTS (
        SELECT id FROM phone_camera pc LEFT JOIN camera c ON(pc.camera_id = c.id) WHERE pc.phone_id = phone.id AND LOWER(c.description) LIKE ?
      )';

      $parameters[] = "%" . strtolower($_POST['value']) . "%";
      break;
  }

  try {
    $json = $db->getPrepared($query_start . $query, $parameters, false);
  } catch (Exception $err) {
    $db->handle_error(500, "Could not filter data: " . $err);
  }

  if (empty($json['data'])) {
    $data = array();
  } else {
    $data = json_decode($json['data'], true);
  }

  echo json_encode(
    array(
      "status"  => true,
      "data"    => $data
    )
  );
} else {
  $db->handle_error(400, "No field supplied");
}
