<?php
//ユーザー名、パスワード、データベース名、サーバー
$user = "root";
$pass="";
$database="php_jugyo";
$server="127.0.0.1:3308";

//DSN文字列の生成
$dsn = "mysql:host={$server};dbname={$database};cherset=utf8";

//mysqlデータベースへ接続
try{
    //PDoのインスタンスを作成し、ＤＢへ接続
$pdo = new PDO($dsn,$user,$pass);
//プリペアードステートメントのエミュレーションを無効化
$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
//例外がスローされる設定にする
$pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
echo "";

}catch(Exception $e){
echo "接続エラー";
echo $e->getMessage();
exit();
}
