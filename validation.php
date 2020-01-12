<?php
//　バリデーション
// ==============================

class Validation {
    // エラーメッセージ
    public static $errors = array();

    // 空チェック
    public function validationEmpty($input) {
        if(empty($input) && $input != 0) {
            self::$errors[] = "入力してください";
            return false;
        }
    }

    // 数値チェック
    public function validationInt($input) {
        if(!is_numeric($input)) {
            self::$errors[] = "半角数字で入力してください";
            // return false;
        }
    }

    // 固定値チェック
    public function validationLength($input, $length) {
        if(mb_strlen($input) !== $length) {
            self::$errors[] = "${length}文字で入力してください";
        }
    }

    // 引き出し限度額チェック
    public function validationWithdraw($input ,$max, $min) {
        if($input > $max) {
            self::$errors[] = "引き出し上限額を超えています。¥ ${max} 以内で入力してください";
        }elseif($input < $min) {
            self::$errors[] = "¥ ${min} 以上で入力してください";
        }
    }

    // 残高超えチェック
    public function validationOver($input) {
        if(Atm::$balance < $input) {
            self::$errors[] = "お引き出し金額が残高を超えています";
        }
    }

    // 文字列チェック
    public function validationString($input) {
        if((!preg_match("/^[a-zA-Z]+$/", $input))) {
            self::$errors[] = "文字列で入力してください";
        }
    }

    // エラー出力
    public function showErrors() {
        if(self::$errors) {
            echo "エラー一覧: " . PHP_EOL;
            foreach(self::$errors as $error) {
                echo $error . PHP_EOL;
            }
        }
    }
}

// 引き出し時チェッククラス
// class ValidationWithdraw {
//     public static function check($input) {
//         Validation::$errors = array();
//         Validation::validationEmpty($input);
//         Validation::validationInt($input);
//         Validation::validationWithdraw($input, 100000, 1000);
//         Validation::validationOver($input);
        
//         if(Validation::$errors) {
//             Validation::showErrors();
//             return false;
//         }
//     }
// }

// 引き出し時チェッククラス
class ValidationWithdraw extends Validation {
    public function check($input) {
        $this->$errors = [];
        $this->validationEmpty($input);
        $this->validationInt($input);
        $this->validationWithdraw($input, 100000, 1000);
        $this->validationOver($input);
        if(Validation::$errors) {
            $this->showErrors();
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
class ValidationOperation extends Validation {
    public static function check($input) {
        $thid->errors = [];
        $thid->validationEmpty($input);
        $thid->validationInt($input);
        $thid->validationLength($input, 1);

        if($thid->$errors) {
            $thid->showErrors();
            return false;
        }
    }
}

// Validation::validationEmpty("");
// Validation::validationInt("あああ");
// Validation::validationMax("ああああああ",5);
// Validation::validationString("0");

Validation::showErrors();