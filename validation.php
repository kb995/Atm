<?php
//　バリデーション
// ==============================

class Validation {
    // エラーメッセージ
    public $errors = [];

    // 空チェック
    public function validationEmpty($input) {
        if(empty($input) && $input != 0) {
            $this->errors[] = "入力してください";
            return false;
        }
    }

    // 数値チェック
    public function validationInt($input) {
        if(!is_numeric($input)) {
            $this->errors[] = "半角数字で入力してください";
            return false;
        }
    }

    // 固定値チェック
    public function validationLength($input, $length) {
        if(mb_strlen($input) !== $length) {
            $this->errors[] = "${length}文字で入力してください";
        }
    }

    // 引き出し限度額チェック
    public function validationWithdraw($input ,$max, $min) {
        if($input > $max) {
            $this->errors[] = "引き出し上限額を超えています。¥ ${max} 以内で入力してください";
        }elseif($input < $min) {
            $this->errors[] = "¥ ${min} 以上で入力してください";
        }
    }

    // 残高超えチェック
    public function validationOver($input) {
        if(Atm::$balance < $input) {
            $this->errors[] = "お引き出し金額が残高を超えています";
        }
    }

    // 文字列チェック
    public function validationString($input) {
        if((!preg_match("/^[a-zA-Z]+$/", $input))) {
            $this->errors[] = "文字列で入力してください";
        }
    }

    // エラー出力
    public function showErrors() {
        if($this->errors) {
            echo "エラー一覧: " . PHP_EOL;
            foreach($this->errors as $error) {
                echo $error . PHP_EOL;
            }
        }
    }
}


// 引き出し時チェッククラス
class validationWithdraw extends Validation {
    public function check($input) {
        $this->errors = [];
        $this->validationEmpty($input);
        $this->validationInt($input);
        $this->validationWithdraw($input, 100000, 1000);
        $this->validationOver($input);
        
        if($this->errors) {
            $this->showErrors();
            return false;
        }
    }
}

// 預け入れ時チェッククラス
class ValidationDeposit extends Validation {
    public function check($input) {
        $this->errors = [];
        $this->validationEmpty($input);
        $this->validationInt($input);
        if($this->errors) {
            $this->showErrors();
            return false;
        }
    }
}

// 操作選択チェッククラス
class ValidationOperation extends Validation {
    public function check($input) {
        $this->errors = array();
        $this->validationEmpty($input);
        $this->validationInt($input);
        $this->validationLength($input, 1);

        if($this->errors) {
            $this->showErrors();
            return false;
        }
    }
}

// パスワードチェッククラス
class ValidationPassword extends Validation {
    public function check($input) {
        $this->errors = [];
        $this->validationEmpty($input);
        $this->validationInt($input);
        $this->validationLength($input, 4);
        if($this->errors) {
            $this->showErrors();
            return false;
        }
    }
}

// idチェッククラス
class ValidationID extends Validation {
    public function check($input) {
        $this->errors = [];
        $this->validationEmpty($input);
        $this->validationInt($input);
        $this->validationLength($input, 4);
        if($this->errors) {
            $this->showErrors();
            return false;
        }
    }
}
