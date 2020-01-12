<?php
//　バリデーション
// ==============================

class Validation {
    // エラーメッセージ
    public static $errors = array();

    // 空チェック
    public static function validationEmpty($input) {
        if(empty($input) && $input != 0) {
            self::$errors[] = "入力してください";
            return false;
        }
    }

    // 数値チェック
    public static function validationInt($input) {
        if(!is_numeric($input)) {
            self::$errors[] = "半角数字で入力してください";
            // return false;
        }
    }

    // 固定値チェック
    public static function validationLength($input, $length) {
        if(mb_strlen($input) !== $length) {
            self::$errors[] = "${length}文字で入力してください";
        }
    }

    // 引き出し限度額チェック
    public static function validationWithdraw($input ,$max, $min) {
        if($input > $max) {
            self::$errors[] = "引き出し上限額を超えています。¥ ${max} 以内で入力してください";
        }elseif($input < $min) {
            self::$errors[] = "¥ ${min} 以上で入力してください";
        }
    }

    // 残高超えチェック
    public static function validationOver($input) {
        if(Atm::$balance < $input) {
            self::$errors[] = "お引き出し金額が残高を超えています";
        }
    }

    // 文字列チェック
    public static function validationString($input) {
        if((!preg_match("/^[a-zA-Z]+$/", $input))) {
            self::$errors[] = "文字列で入力してください";
        }
    }

    // エラー出力
    public static function showErrors() {
        if(self::$errors) {
            echo "エラー一覧: " . PHP_EOL;
            foreach(self::$errors as $error) {
                echo $error . PHP_EOL;
            }
        }
    }
}

// 引き出し時チェッククラス
class ValidationWithdraw {
    public static function check($input) {
        Validation::$errors = array();
        Validation::validationEmpty($input);
        Validation::validationInt($input);
        Validation::validationWithdraw($input, 100000, 1000);
        Validation::validationOver($input);
        
        if(Validation::$errors) {
            Validation::showErrors();
            return false;
        }
    }
}

// 預け入れ時チェッククラス
class ValidationDeposit {
    public static function check($input) {
        Validation::$errors = array();
        Validation::validationEmpty($input);
        Validation::validationInt($input);
        if(Validation::$errors) {
            Validation::showErrors();
            return false;
        }
    }
}

// 操作選択チェッククラス
class ValidationOperation {
    public static function check($input) {
        Validation::$errors = array();
        Validation::validationEmpty($input);
        Validation::validationInt($input);
        Validation::validationLength($input, 1);

        if(Validation::$errors) {
            Validation::showErrors();
            return false;
        }
    }
}

// Validation::validationEmpty("");
// Validation::validationInt("あああ");
// Validation::validationMax("ああああああ",5);
// Validation::validationString("0");

Validation::showErrors();