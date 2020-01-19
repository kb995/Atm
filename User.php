<?php
class User {
    public $id;
    public $password;
    public $name;
    public $balance;

    // public function __construct($id, $password, $name, $balance) {
    //     $this->id = $id;
    //     $this->password = $password;
    //     $this->name = $name;
    //     $this->balance = $balance;
    // }

    public function getUserId($input_id) {
        $fp = fopen('test.csv', 'r');
        while (($line = fgetcsv($fp)) !== false) {
            if($line[0] === $input_id) {
                return $line[0];
            }
        }
        fclose($fp);
    }
    public function getUserPass($input_id) {
        $fp = fopen('test.csv', 'r');
        while (($line = fgetcsv($fp)) !== false) {
            if($line[1] === $input_id) {
                return $line[1];
            }
        }
        fclose($fp);
    }

    // public function getUserById($id) {
    //     $fp = fopen('test.csv', 'r');
    //     while (($line = fgetcsv($fp)) !== false) {
    //         if($line[$id] === $id) {
    //             $this->user_info = fgetcsv($fp);
    //             echo $this->user_info;
    //             return $this->user_info;
    //         }
    //     }
    //     fclose($fp);
    // }

    public function setUserInfo($id) {
        $fp = fopen('test.csv', 'r');
        while (($line = fgetcsv($fp)) !== false) {
            if($line[0] == $id) {
                $this->id = $list[0];
                $this->password = $list[1];
                $this->name = $list[2];
                $this->balance = $list[3];
            }
        }
        fclose($fp);
    }
}


