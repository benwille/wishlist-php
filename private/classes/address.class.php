<?php

class Address extends DatabaseObject
{
    protected static $table_name = "address";
    protected static $db_columns = ['id', 'street', 'city', 'state', 'zip'];

    protected static $meta_table_name = "address_meta";
    protected static $meta_db_columns = ['id', 'address_id', 'user_id'];

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
}
