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
            if (session_status() == PHP_SESSION_NONE) {
                // セッションは有効で、開始していないとき
                session_start();
            }

            require "head.php";

            $score = 0;
            $cnt1 = $cnt2 = 0;

            $panels = $_SESSION["question"];
            if (isset($_POST["check"]) === false)$checks=[]; else $checks = $_POST["check"];
            $black_panel = $_SESSION["max_panel"] + 1;
            $white_panel = count($panels) - $black_panel;
            $a_panels = array_fill(0, count($panels), "white");
            foreach($checks as $check) {
                if($panels[$check - 1] === "black") {$score += 1000; $cnt1+=1;}
                if($panels[$check - 1] === "white") {$score -= 500; $cnt2 += 1;}
            }


            echo "<h2 class='tt'>".$cnt1."個正解で、".$cnt2."個不正解です。得点は".$score."ポイントです。</h2>";
            echo "<div class='form-top'><form action='quiz1.php' method='POST'><input type='submit' value='もう一度プレイ' class='start-btn'></form></div>";

            $sql = "INSERT INTO pm(score) VALUES(:score) WHERE name = :name";

            // プリペアドステートメントを作成する
            $stm = $pdo->prepare($sql);
            // プレースホルダに値をバインドさせる
            $stm->bindValue(':name', $_SESSION["name"], PDO::PARAM_STR);
            $stm->bindValue(':score', $_SESSION["score"], PDO::PARAM_STR);
            // SQLを実行する
            $stm->execute();
        
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            echo $result["score"];
        ?>