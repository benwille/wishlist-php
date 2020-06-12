<?php

class DatabaseObject {

  static protected $database;
  static protected $table_name = "";
  static protected $columns = [];
  public $errors = [];

  static public function set_database($database) {
    self::$database = $database;
  }

  static public function find_by_sql($sql) {
    $result = self::$database->query($sql);
    if(!$result) {
      exit("Database query failed.");
    }

    // results into objects
    $object_array = [];
    while($record = $result->fetch_assoc()) {
      $object_array[] = static::instantiate($record);
    }

    $result->free();

    return $object_array;
  }

  static public function find_all() {
    $sql = "SELECT * FROM " . static::$table_name;
    return static::find_by_sql($sql);
  }

  static public function count_all() {
    $sql = "SELECT COUNT(*) FROM " . static::$table_name;
    $result_set = self::$database->query($sql);
    if (!$result_set) {
      return 0;
    } else {
      $row = $result_set->fetch_array();
      return array_shift($row);
    }
  }

  static public function find_by_id($id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($id) . "'";
    $obj_array = static::find_by_sql($sql);
    if (!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  static protected function instantiate($record) {
    $object = new static;
    // Could manually assign values to properties
    // but automatically assignment is easier and re-usable
    foreach($record as $property => $value) {
      if(property_exists($object, $property)) {
        $object->$property = $value;
      }
    }
    return $object;
  }

  protected function validate() {
    $this->errors = [];

    // Add custom validations

    return $this->errors;
  }

  public function create() {
    $this->validate();
    if (!empty($this->errors)) {
      return false;
    }

    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    $result = self::$database->query($sql);
    if ($result) {
      $this->id = self::$database->insert_id;
    }

    return $result;
    // return $sql;
  }

  protected function update() {
    $this->validate();
    if (!empty($this->errors)) {
      return false;
    }

    $attributes = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach ($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }

    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }

  public function clear($question, $answer) {

    $attributes = $this->sanitized_attributes();
    // return $attributes;
    $attribute_pairs = [];
    foreach ($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }
    // return $attribute_pairs;
    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE " . $question . "='" . $answer . "' ";
    $result = self::$database->query($sql);
    return $result;
  }

  public function save() {
    // A new record will not have ID set yet
    if (isset($this->id)) {
      return $this->update();
    } else {
      return $this->create();
    }
  }

  public function merge_attributes($args) {
    foreach($args as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }

  // Properties which have database columns, excluding ID
  public function attributes() {
    $attributes = [];
    foreach(static::$db_columns as $column) {
      if($column == 'id') { continue;  }
      $attributes[$column] = $this->$column;
    }
    return $attributes;
  }

  public function sanitized_attributes() {
    $sanitized = [];
    foreach($this->attributes() as $key => $value) {
      if($value == NULL) { continue; }
      $sanitized[$key] = self::$database->escape_string($value);
    }
    return $sanitized;
  }

  public function delete() {
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;

    //After deleting, the instance of the record will exist even though the database record does not.
    //This can be useful as in:
    // echo $user->first_name . " was deleted.";
  }

  public function move($table) {
    $this->validate();
    if (!empty($this->errors)) {
      return false;
    }

    $sql = "INSERT INTO " . self::$database->escape_string($table) . " ";
    $sql .= "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $move = self::$database->query($sql);

    if (isset($move)) {
      $this->delete();
    }
  }

  public function copy($table) {
    $this->validate();
    if (!empty($this->errors)) {
      return false;
    }

    $sql = "INSERT INTO " . self::$database->escape_string($table) . " ";
    $sql .= "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $move = self::$database->query($sql);

    if (isset($move)) {
      return true;
    }
  }

}

 ?>
