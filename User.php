<?php
class User {
    const LIST_ID = 0;
    const LIST_PASS = 1;
    const LIST_NAME = 2;
    const LIST_BALANCE = 3;
    const LIST_PATH = "./user_list.csv";

    private $id;
    private $password;
    private $name;
    private $balance;

    // ユーザー情報セット
    public function setUser($input_id) {
        $fp = fopen(self::LIST_PATH, 'r');
        while(($line = fgetcsv($fp))) {
            if($line[self::LIST_ID] === $input_id) {
                $this->id = $line[self::LIST_ID];
                $this->password = $line[self::LIST_PASS];
                $this->name = $line[self::LIST_NAME];
                $this->balance = $line[self::LIST_BALANCE];
            }
        }
        fclose($fp);
    }
    // IDが存在するか確認
    public function searchUserId($input_id) {
        $fp = fopen(self::LIST_PATH, 'r');
        while (($line = fgetcsv($fp))) {
            if($line[self::LIST_ID] === $input_id) {
                $this->id = $line[self::LIST_ID];
            }
        }
        fclose($fp);
    }
    // パスワード照会
    public function checkPass($input_pass) {
        if($this->password != $input_pass) {
            echo "パスワードが違います。" . PHP_EOL;
            return false;
        }
    }

    // アクセサメソッド
    // ゲッター
    public function getUserId() {
        return $this->id;
    }
    public function getUserPass() {
        return $this->password;
    }
    public function getName() {
        return $this->name;
    }
    public function getUserBalance() {
        return $this->balance;
    }
    // セッター
    public function setUserBalance($input) {
        $this->balance;
    }

    public function withdrawBalance($input) {
        $this->balance -= $input;
        return $this->balance;
    }
    public function depositBalance($input) {
        $this->balance += $input;
        return $this->balance;
    }
}


