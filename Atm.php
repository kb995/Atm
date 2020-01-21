<?php
echo "問題69: " . PHP_EOL;

require('./User.php');
require('./validation.php');


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
    private const EXIT_MESSAGE = "ご利用ありがとうございまた。お忘れ物にご注意下さい。" . PHP_EOL;

    //　ATMプロパティ / コンストラクタ
    // ==============================
    public $operation_user; // Userクラスのインスタンスが入る

    // メニュー選択定数
    private const MENU_TYPE_WITHDRAW = 1;
    private const MENU_TYPE_DEPOSIT = 2;
    private const MENU_TYPE_BALANCE = 3;
    private const MENU_TYPE_EXIT = 0;

    public function __construct() {
        $this->operation_user = new User();
        $this->userAuth();
    }
    //　ATM操作メソッド
    // ==============================
    // ユーザー認証
    public function userAuth() {
        // id存在チェック
        echo self::HELLO_MESSAGE . PHP_EOL;
        echo "id : 0001" . PHP_EOL;
        $input_id = $this->input('id');
        $this->operation_user->searchUserId(str_pad($input_id, 4, 0, STR_PAD_LEFT));
        // 入力したidがcsvデータに存在するか確認,あれば操作ユーザーにセット
        if($this->operation_user->getUserId() != $input_id) {
            echo "idが存在しません" . PHP_EOL;
            return $this->userAuth();
        }else{
            echo "【id認証完了】" . PHP_EOL;
            // idの存在があるので操作ユーザー情報をセットする
            $this->operation_user->setUser($input_id);
        }
        // パスワード一致チェック
        echo self::PASSWORD_MESSAGE;
        echo "pass : 1111" . PHP_EOL;
        $input_pass = $this->input('password');
        // 操作ユーザーのpassと入力値を照会
        if($this->operation_user->checkPass($input_pass) === false) {
            return $this->userAuth();
        }
        echo "【パス認証完了】" . PHP_EOL;
    }
    // ATM操作選択メソッド
    public function atmOperation() {
        echo self::SELECT_TRANSACTION_MESSAGE . PHP_EOL;
        $select = $this->input('operation');

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
        $withdraw = $this->input('withdraw');
        if($withdraw > $this->operation_user->getUserBalance()) {
            echo "お引き出し金額が残高を超えています。もう一度入力して下さい。" . PHP_EOL;
            $this->withdrawMoney();
        }
        $this->operation_user->withdrawBalance($withdraw);
        echo "¥" . $withdraw . "が引き出されました" . PHP_EOL . "カードと明細書をお取りください" . PHP_EOL;
        echo "ユーザー残高 | ¥ ";
        echo $this->operation_user->getUserBalance() . PHP_EOL;
        echo PHP_EOL;
    }
    // 預け入れメソッド
    public function depositMoney() {
        echo "預け入れ金額を入力してください" . PHP_EOL;
        $deposit = $this->input('deposit');
        $this->operation_user->depositBalance($deposit);
        echo "¥" . $deposit . "が入金されました" . PHP_EOL . "カードと明細書をお取りください" . PHP_EOL;
        echo "ユーザー残高 | ¥ ";
        echo $this->operation_user->getUserBalance() . PHP_EOL;
        echo PHP_EOL;
    }
    // 残高確認メソッド
    public function showBalance() {
        echo "残高は". $this->operation_user->getUserBalance() ."円です" . PHP_EOL;
        $this->RetryOperation();
    }
    // 操作終了メソッド
    public function end() {
        echo "操作が中断されました" . PHP_EOL;
        exit;
    }
    // 続けて取引メソッド
    public function RetryOperation() {
        echo self::SELECT_RETRY_MESSAGE . PHP_EOL;
        $select = $this->input('operation');
        if($select == 1) {
            return $this->atmOperation();
        }elseif($select == 2){
            $this->end();
        }else{
            echo "もう一度入力して下さい" . PHP_EOL;
            return $this->RetryOperation();
        }
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
            return $this->input($type);
        }
        return $input;
    }
}

// ATM操作実行
$atm = new Atm();
$atm->atmOperation();