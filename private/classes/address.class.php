<?php

class Address extends DatabaseObject
{
    protected static $table_name = "address";
    protected static $db_columns = ['id', 'street', 'city', 'state', 'zip'];

    protected static $meta_table_name = "address_meta";
    protected static $meta_db_columns = ['meta_id', 'address_id', 'user_id'];

    public $id;
    public $street;
    public $city;
    public $state;
    public $zip;
    protected $meta_id;
    protected $address_id;
    public $user_id;

    public function __construct($args=[])
    {
        $this->street = $args['street'] ?? '';
        $this->city = $args['city'] ?? '';
        $this->state = $args['state'] ?? '';
        $this->zip = $args['zip'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
        $this->address_id = $args['address_id'] ?? '';
    }

    public static function find_by_user($user_id)
    {
        $sql = "SELECT * FROM " . static::$meta_table_name . " ";
        $sql .= "WHERE user_id=" . self::$database->escape_string($user_id) . "";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            $result = array_shift($obj_array);
        } else {
            return false;
        }

        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE id='" . $result->address_id . "'";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return false;
        }
    }

    public static function find_users_by_id($address_id)
    {
        $sql = "SELECT user_id FROM " . static::$meta_table_name . " ";
        $sql .= "WHERE address_id=" . self::$database->escape_string($address_id) . "";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return $obj_array;
        } else {
            return false;
        }
    }

    public static function find_meta_by_user($user_id)
    {
        $sql = "SELECT * FROM " . static::$meta_table_name . " ";
        $sql .= "WHERE user_id=" . self::$database->escape_string($user_id) . "";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return false;
        }
    }

    protected function validate()
    {
        $this->errors = [];
        // var_dump($this->address_id);
        // die;
    if ($this->address_id === "0") {
        $this->errors[] = "Choose a real address";
    }
        return $this->errors;
    }

    public function address_id()
    {
        return $this->address_id;
    }

    public function save_address()
    {
        // A new record will not have ID set yet
        if (isset($this->meta_id)) {
            return $this->update_address();
        } else {
            return $this->create_address();
        }
    }

    public function create_address()
    {
        $this->validate();
        if (!empty($this->errors)) {
            return false;
        }

        $attributes = $this->sanitized_attributes_address();
        $sql = "INSERT INTO " . static::$meta_table_name . " (";
        $sql .= join(', ', array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";        
        $result = self::$database->query($sql);
        if ($result) {
            $this->meta_id = self::$database->insert_id;
        }

        return $result;
        // return $sql;
    }

    public function update_address()
    {
        
        $this->validate();
        if (!empty($this->errors)) {
            return false;
        }

        $attributes = $this->sanitized_attributes_address();
        $attribute_pairs = [];
        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$meta_table_name . " SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE meta_id='" . self::$database->escape_string($this->meta_id) . "' ";
        $sql .= "LIMIT 1";
        $result = self::$database->query($sql);
        return $result;
    }

    public function attributes_address()
    {
        $attributes = [];
        foreach (static::$meta_db_columns as $column) {
            if ($column == 'meta_id') {
                continue;
            }
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    public function sanitized_attributes_address()
    {
        $sanitized = [];
        foreach ($this->attributes_address() as $key => $value) {
            if ($value == null) {
                continue;
            }
            $sanitized[$key] = self::$database->escape_string($value);
        }
        return $sanitized;
    }
}
