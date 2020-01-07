<?php
class Atm {
    //　メッセージ定数宣言
    // ==============================
    private const HELLO_MESSAGE = "いらっしゃいませ " . PHP_EOL . "カードを挿入( ※ IDを入力 )してください" . PHP_EOL;
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
    public $user;
    public static $balance = 10000;

    public function __construct($user) {
        $this->user = $user;
        $this->userAuth();
    }

    //　ATM操作メソッド
    // ==============================
    // ユーザー認証
    public function userAuth() {
        echo self::HELLO_MESSAGE . PHP_EOL;
    }

    // ATM操作選択
    public function atmOperation() {
        echo self::SELECT_TRANSACTION_MESSAGE . PHP_EOL;
        $select = trim(fgets(STDIN));
        echo PHP_EOL;

        switch($select) {
            case 1: // 引き出し処理
                $input = $this->withdrawMoney();
                break;

            case 2: // 入金処理
                $input = $this->depositMoney();
                echo $input . "円が入金されました。明細書をお取りください" . PHP_EOL;
                echo PHP_EOL;
                break;

            case 3: // 残高確認
                echo $this->showBalance();
                echo PHP_EOL;
                break;

            case 0: // 終了
            echo "操作が中断されました" . PHP_EOL;
            exit;
        }
    }

    public function withdrawMoney() {
        echo "お引き出し金額を入力してください" . PHP_EOL;
        $withdraw = trim(fgets(STDIN));
        $error_flg = ValidationMoney::errorCheck($withdraw);
        // if($error_flg) {
        //     return;
        // }
        if(self::$balance < $withdraw) {
            echo "お引き出し金額が残高を超えています" . PHP_EOL;
            return;
        }
        self::$balance -= $withdraw;
        echo "¥" . $withdraw . "が引き出されました" . PHP_EOL . "カードと明細書をお取りください" . PHP_EOL;
        // echo "残高";
        // print_r(self::$balance);
        echo PHP_EOL;
    }

    public function depositMoney() {
        echo "預け入れ金額を入力してください" . PHP_EOL;
        $deposit = trim(fgets(STDIN));
        self::$balance += $deposit;
        echo "¥" . $deposit . "が入金されました" . PHP_EOL . "カードと明細書をお取りください" . PHP_EOL;
        // echo "残高";
        // print_r(self::$balance);
    }

    public function showBalance() {
        return "残高は". self::$balance ."円です";
    }

}
