<?php
//　バリデーション
// ==============================

class Validation {
    // エラーメッセージ
    public static $errors = array();

    // 空チェック
    public static function validationEmpty($input) {
        if(empty($input)) {
            self::$errors[] = "入力してください";
            // var_dump(self::$errors);
            return false;
        }
    }

    // 数値チェック
    public static function validationInt($input) {
        if(!is_numeric($input)) {
            self::$errors[] = "半角数字で入力してください";
            // var_dump(self::$errors);
            return false;
        }
    }

    // 最大文字数チェック
    public static function validationMax($input ,$max) {
        if(mb_strlen($input) > $max) {
            self::$errors[] = "${max}文字以内で入力してください";
            // var_dump(self::$errors);
        }
    }

    // 文字列チェック
    public static function validationString($input) {
        if((!preg_match("/^[a-zA-Z]+$/", $input))) {
            self::$errors[] = "文字列で入力してください";
            // var_dump(self::$errors);
        }
    }

    // エラー出力
    public static function showErrors() {
        if(self::$errors) {
            echo "エラー一覧: " . PHP_EOL;
            foreach(self::$errors as $error) {
                echo $error . PHP_EOL;
            }
        } else {
            echo "エラークリア" . PHP_EOL;
        }
    }
}

class ValidationMoney {
    public static function errorCheck($input) {
        Validation::validationEmpty($input);
        Validation::validationInt($input);
        if(Validation::$errors) {
            Validation::showErrors();
            return false;
        }
    }
}

class ValidationName {

}

// Validation::validationEmpty("");
// Validation::validationInt("あああ");
// Validation::validationMax("ああああああ",5);
// Validation::validationString("0");

Validation::showErrors();