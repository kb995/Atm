<?php
class User {
    // public $id = "";
    // public $password = "";
    // public $name = "";
    // public $balance = "";

    // public function __construct($id, $password, $name, $balance) {
    //     $this->id = $id;
    //     $this->password = $password;
    //     $this->name = $name;
    //     $this->balance = $balance;
    // }
    public $user_list = [
        1 => [
            "id" => 0001,
            "password" => 1111,
            "name" => "Kubosima",
            "balance" => 10000,
        ],
        2 => [
            "id" => 0002,
            "password" => 2222,
            "name" => "Tanaka",
            "balance" => 20000,
        ],
        1 => [
            "id" => 0003,
            "password" => 3333,
            "name" => "Suzuki",
            "balance" => 30000,
        ],
    ];

    public function getUserById ($id) {
        if(!is_set(self::$user_list[$id])) {
            return false;
        }
        return self::$user_list[$id];
    }
}