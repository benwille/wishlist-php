<?php

class User extends DatabaseObject
{
    protected static $table_name = "users";
    protected static $db_columns = ['id', 'first_name', 'last_name', 'family', 'email', 'username', 'hashed_password', 'type', 'is_admin'];

    public $id;
    public $first_name;
    public $last_name;
    public $family;
    public $email;
    public $username;
    protected $hashed_password;
    public $password;
    public $confirm_password;
    protected $password_required = true;
    protected $type;
    protected $is_admin = false;

    public function __construct($args=[])
    {
        $this->first_name = $args['first_name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->username = $args['username'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->confirm_password = $args['confirm_password'] ?? '';
        $this->is_admin = $args['is_admin'] ?? 0;
    }

    public function full_name()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function concat_name()
    {
        return $this->first_name . $this->last_name;
    }

    protected function set_hashed_password()
    {
        $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function verify_password($password)
    {
        return password_verify($password, $this->hashed_password);
    }

    public function create()
    {
        $this->set_hashed_password();
        return parent::create();
    }

    protected function update()
    {
        if ($this->password != '') {
            $this->set_hashed_password();
        } else {
            $this->password_required = false;
        }

        return parent::update();
    }

    protected function validate()
    {
        $this->errors = [];

        if (is_blank($this->first_name)) {
            $this->errors[] = "First name cannot be blank.";
        } elseif (!has_length($this->first_name, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "First name must be between 2 and 255 characters.";
        }

        if (is_blank($this->last_name)) {
            $this->errors[] = "Last name cannot be blank.";
        } elseif (!has_length($this->last_name, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "Last name must be between 2 and 255 characters.";
        }

        if (is_blank($this->username)) {
            $this->errors[] = "Username cannot be blank.";
        } elseif (!has_length($this->username, array('min' => 4, 'max' => 255))) {
            $this->errors[] = "Username must be between 4 and 255 characters.";
        } elseif (!has_unique_username($this->username, $this->id ?? 0)) {
            $this->errors[] = "Username already exists. Try another.";
        }

        if ($this->password_required) {
            if (is_blank($this->password)) {
                $this->errors[] = "Password cannot be blank.";
            }
            // TODO: fix this validation
            // elseif (!has_length($this->password, array('min' => 12))) {
            //   $this->errors[] = "Password must contain 12 or more characters";
            // } elseif (!preg_match('/[A-Z]/', $this->password)) {
            //   $this->errors[] = "Password must contain at least 1 uppercase letter";
            // } elseif (!preg_match('/[a-z]/', $this->password)) {
            //   $this->errors[] = "Password must contain at least 1 lowercase letter";
            // } elseif (!preg_match('/[0-9]/', $this->password)) {
            //   $this->errors[] = "Password must contain at least 1 number";
            // } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
            //   $this->errors[] = "Password must contain at least 1 symbol";
            // }

            if (is_blank($this->confirm_password)) {
                $this->errors[] = "Confirm password cannot be blank.";
            } elseif ($this->password !== $this->confirm_password) {
                $this->errors[] = "Password and confirm password must match.";
            }
        }

        return $this->errors;
    }

    public static function find_by_username($username)
    {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return false;
        }
    }

    public static function get_people($users)
    {

        $people = [];
        foreach ($users as $user) {
            $people[] = $user->id;
        }
        shuffle($people);
        return $people;

    }

    public static function isValidAssignment($assigner, $assignee, $conn, $currentYear)
    {

        $stmt = $conn->prepare("SELECT * FROM no_pair WHERE (person1 = ? AND person2 = ?) OR (person1 = ? AND person2 = ?)");
        $stmt->bind_param("ssss", $assigner, $assignee, $assignee, $assigner);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return false;
        }


        $stmt = $conn->prepare("
            SELECT * FROM exchange 
            WHERE user_id = ? AND match_id = ?
            AND year >= ?
        ");
        $thresholdYear = $currentYear - 2;
        $stmt->bind_param("ssi", $assigner, $assignee, $thresholdYear);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows === 0;

    }

    public function type()
    {
        if ($this->type > 0) {
            return self::TYPE[ $this->type ];
        } else {
            return 'Unknown';
        }
    }

    public function is_admin()
    {
        if ($this->is_admin == 1) {
            return true;
        } else {
            return false;
        }
    }
}
