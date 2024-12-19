<?php

class Exchange extends DatabaseObject
{
    protected static $table_name = "exchange";
    protected static $db_columns = ['id', 'year', 'user_id', 'match_id'];

    public $id;
    public $year;
    public $user_id;
    public $match_id;

    public function __construct($args = [])
    {
        $this->year = $args['year'] ?? date('Y');
        $this->user_id = $args['user_id'] ?? '';
        $this->match_id = $args['match_id'] ?? '';
    }

    /**
     * New Exchange.
     * Pull in everyone from the family into one array and randomly assign them
     */
    public static function find_by_year($year)
    {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE year=" . h($year);
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return ($obj_array);
        } else {
            return false;
        }


        // $families = ['Wille', 'Jorgenson', 'CC', 'Olson', 'Peterson'];
        // $arr = ['Ben', 'Xandra', 'Katie', 'Danny', 'Chad', 'Choocie', 'Vic', 'Jessica'];
        // $res = [];
        // // var_dump($family, $exchange);
        // (shuffle($arr));

        // for ($i=0;$i<count($arr);$i++) {
        //     $res[$arr[$i]] = $arr[$i+1];
        // }
        // $res[$arr[count($arr)-1]] = $arr[0];
        // print_r($res);
    }

    public static function find_all_years()
    {
        $sql = "SELECT DISTINCT year FROM " . static::$table_name . " ";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            $result = ($obj_array);
        } else {
            return false;
        }

        $years = [];
        foreach ($result as $r) {
            $years[] = $r->year;
        }
        return $years;
    }

    public static function resetAssignments($year)
    {

        $stmt = self::$database->prepare("DELETE FROM exchange WHERE year = ?");
        $stmt->bind_param("i", self::$database->escape_string($year));
        $result = $stmt->execute();
        return $result;

    }

    public function get_name($id)
    {
        $user = User::find_by_id($id);
        return $user->full_name();
    }
}
