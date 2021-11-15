<?php

/**
 * Database interaction class, used to handle querying the database.
 */
class Database
{
  private $db;

  function __construct()
  {
    try {
      $this->db = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
      // set the PDO error mode to exception
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Removes quotations from numbers in output JSON
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      exit();
    }
  }

  /**
   * Executes the given query on the database and returns the result.
   * 
   * @param String $query The SQL query to be executed
   * @param Boolean $multiple Whether to return multiple results or a single row. Default: true
   * @return Array Data returned by given query
   */
  function get($query, $multiple = true)
  {
    $sql    = $this->db->query($query);

    if ($multiple) {
      $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
      $result = $sql->fetch(PDO::FETCH_ASSOC);
    }

    if ($result === false) {
      throw new Error("MySQL Error");
    }

    return $result;
  }

  /**
   * Executes the given query on the database while also passing the given parameters.
   * 
   * @param String $query The SQL query to be executed
   * @param Array $parameters Parameters to be passed to the query, the parameters are escaped
   * @param Boolean $multiple Whether to return multiple results or a single row. Default: true
   * @return Array Data returned by given query
   */
  function getPrepared($query, $parameters, $multiple = true)
  {
    $sql = $this->db->prepare($query);
    $sql->execute($parameters);

    if ($multiple) {
      $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
      $result = $sql->fetch(PDO::FETCH_ASSOC);
    }

    if ($multiple && $result === false) {
      // only fetchAll returns false on error; fetch returns false on no rows
      throw new Error("MySQL Error");
    }

    return $result;
  }

  /**
   * We handle error responses in this function.
   * 
   * @param int $status The status code returned to the client
   * @param String $msg The error message outputed in JSON format
   */
  function handle_error($status, $msg = "Unknown error occurred")
  {
    echo json_encode(array(
      "status"  => false,
      "message" => $msg
    ));

    http_response_code($status);
    exit();
  }
}
