<?php

class Wishlist extends DatabaseObject 
{
    protected static $table_name = "list";
    protected static $db_columns = ['id', 'item_name', 'description', 'link', 'user_id', 'year_added', 'purchased'];

    public $id;
    public $item_name;
    public $description;
    public $link;
    public $user_id;
    public $year_added;
    protected $purchased;

    public function __construct($args=[])
    {
        $this->item_name = $args['item_name'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->link = $args['link'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
        $this->year_added = $args['year_added'] ?? '';
        $this->purchased = $args['purchased'] ?? 0;
    }

    public static function find_by_user($user_id)
    {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE user_id='" . self::$database->escape_string($user_id) . "'";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return $obj_array;
        } else {
            return false;
        }
    }
}

?>