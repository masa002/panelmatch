<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <title>パネルマッチ</title>
        <style type="text/css">
            .button_wrapper {
                text-align:center;
            }
        </style>
    </head>
    <body>
        <?php
            require "db_connect.php";
            require "head.php";

            if (session_status() == PHP_SESSION_NONE) {
                // セッションは有効で、開始していないとき
                session_start();
            }
            if (isset($_SESSION["name"]) === false) 

            // 名前表示
            echo $_SESSION["name"]."<br>";
            echo "<h2 class='tt'>ベストスコア</h2><br>";

            $sql = "SELECT * FROM pm WHERE name = :name";

            // プリペアドステートメントを作成する
            $stm = $pdo->prepare($sql);
            // プレースホルダに値をバインドさせる
            $stm->bindValue(':name', $_SESSION["name"], PDO::PARAM_STR);
            // SQLを実行する
            $stm->execute();

            $result = $stm->fetch(PDO::FETCH_ASSOC);
            echo "<strong class='lf'>1.".$result["score1"]."ポイント</strong></p>";
            echo "<strong class='lf'>2.".$result["score2"]."ポイント</strong></p>";
            echo "<strong class='lf'>3.".$result["score3"]."ポイント</strong></p>";
            echo "<p><strong class='lf'>4.".$result["score4"]."ポイント</strong></p>";
            echo "<p><strong class='lf'>5.".$result["score5"]."ポイント</strong></p>";
        ?>