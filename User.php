<?php
class User {
    public $id = "";
    public $password = "";
    public $name = "";
    public $balance = "";

    public function __construct($id, $password, $name, $balance) {
        $this->id = $id;
        $this->password = $password;
        $this->name = $name;
        $this->balance = $balance;
    }
}
