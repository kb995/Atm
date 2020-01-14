<?php
class Atm {
    //　メッセージ定数宣言
    // ==============================
    private const HELLO_MESSAGE = "いらっしゃいませ " . PHP_EOL . "カードを挿入( ※ IDを入力 )してください";
    private const PASSWORD_MESSAGE = "4桁の暗証番号を入力してください" . PHP_EOL;
    private const SELECT_TRANSACTION_MESSAGE = <<<EOD
    ご希望のお取引を選択してください
    【 1 】 => お引出し
    【 2 】 => お預入れ
    【 3 】 => 残高照会
    【 0 】 => 終了
    EOD;
    private const SELECT_RETRY_MESSAGE =<<<EOD
    続けてお取り引きしますか?
    【 1 】 => はい
    【 2 】 => いいえ
    EOD;
    private const EXIT_MESSAGE = "ご利用ありがとうございました。お取り忘れにご注意ください。" . PHP_EOL;

    //　ATMプロパティ / コンストラクタ
    // ==============================
    public static $user;
    // public static $user_id;
    // public static $user_pass;
    // public static $balance = 10000;


    private const MENU_TYPE_WITHDRAW = 1;
    private const MENU_TYPE_DEPOSIT = 2;
    private const MENU_TYPE_BALANCE = 3;
    private const MENU_TYPE_EXIT = 0;

    public function __construct() {
        // self::$user_id = 1111;
        // self::$user_pass = 2222;
        self::userAuth();
    }
    //　ATM操作メソッド
    // ==============================
    // ユーザー認証
    public function userAuth() {
        echo self::HELLO_MESSAGE . PHP_EOL;
        $input_id = self::input('id');
        // var_dump($input_id);
        // var_dump(self::$input_id);
        // id あるかチェック
        if($input_id != self::$user_id) {
            echo "idが存在しません" . PHP_EOL;
            return self::userAuth();
        }

        echo self::PASSWORD_MESSAGE;
        $input_pass = self::input('password');
        // id パスワード一致チェック
        if($input_pass != self::$user_pass) {
            echo "パスワードが違います" . PHP_EOL;
            return self::userAuth();
        }
    }

    // ATM操作選択
    public function atmOperation() {
        echo self::SELECT_TRANSACTION_MESSAGE . PHP_EOL;
        $select = self::input('operation');

        switch($select) {
            case self::MENU_TYPE_WITHDRAW: // 引き出し処理
                $this->withdrawMoney();
                break;

            case self::MENU_TYPE_DEPOSIT: // 入金処理
                $this->depositMoney();
                break;

            case self::MENU_TYPE_BALANCE: // 残高確認
                $this->showBalance();
                break;

            case self::MENU_TYPE_EXIT: // 終了
                $this->end();
                break;
        }
    }

    // 引き出しメソッド
    public function withdrawMoney() {
        echo "お引き出し金額を入力してください" . PHP_EOL;
        $withdraw = self::input('withdraw');
        self::$balance -= $withdraw;
        echo "¥" . $withdraw . "が引き出されました" . PHP_EOL . "カードと明細書をお取りください" . PHP_EOL;
        echo PHP_EOL;
    }

    // 預け入れメソッド
    public function depositMoney() {
        echo "預け入れ金額を入力してください" . PHP_EOL;
        $deposit = self::input('deposit');
        self::$balance += $deposit;
        echo "¥" . $deposit . "が入金されました" . PHP_EOL . "カードと明細書をお取りください" . PHP_EOL;
        echo PHP_EOL;
    }

    // 残高確認メソッド
    public function showBalance() {
        echo "残高は". self::$balance ."円です" . PHP_EOL;
    }

    // 操作終了メソッド
    public function end() {
        echo "操作が中断されました" . PHP_EOL;
        exit;
    }

    // 標準入力メソッド
    public function input($type) {
        $input = trim(fgets(STDIN));
        switch($type) {
        case 'id':
            $validation = new ValidationID();
            $error_flg = $validation->check($input);
        break;
        case 'password':
            $validation = new ValidationPassword();
            $error_flg = $validation->check($input);
        break;
        case 'operation':
            $validation = new ValidationOperation();
            $error_flg = $validation->check($input);
            break;
        case 'withdraw':
            $validation = new ValidationWithdraw();
            $error_flg = $validation->check($input);
            break;
        case 'deposit':
            $validation = new ValidationDeposit();
            $error_flg = $validation->check($input);
            break;
        }
        if($error_flg === false) {
            return self::input($type);
        }
        return $input;
    }
}
