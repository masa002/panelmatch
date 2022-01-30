<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <title>パネルマッチ</title>
        <style type="text/css">
            .be {
                margin: 0;
                font-size: 30px;
                text-align: center;
            }
            .lf1 {
                margin-top: 0;
                text-align: center;
                font-size: 40px;
                
            }
            .lf { 
                text-align: center;
                font-size: 25px;
                
            }
            .p_img {
                width:30px;
                height:30px;
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
            echo "<h2 class='tt'>マイスコア</h2><br>";

            $sql = "SELECT * FROM pm WHERE name = :name";

            // プリペアドステートメントを作成する
            $stm = $pdo->prepare($sql);
            // プレースホルダに値をバインドさせる
            $stm->bindValue(':name', $_SESSION["name"], PDO::PARAM_STR);
            // SQLを実行する
            $stm->execute();

            $result = $stm->fetch(PDO::FETCH_ASSOC);
            echo "<div class='ll'>";
            echo "<p class='be'>BEST SCORE!!</P>";
            echo "<p class='lf1'><img src='images/kin.png' class='p_img'>1.".$result["score1"]."ポイント</p>";
            echo "<p class='lf'><img src='images/gin.png' class='p_img'>2.".$result["score2"]."ポイント</p>";
            echo "<p class='lf'><img src='images/dou.png' class='p_img'>3.".$result["score3"]."ポイント</p>";
            echo "<p class='lf'>4.".$result["score4"]."ポイント</p>";
            echo "<p class='lf'>5.".$result["score5"]."ポイント</p>";
            echo "</div>";
        ?>