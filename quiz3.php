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

            require "db_connect.php";
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

            if (isset($_SESSION["name"]) !== false){
                $sql1 = "SELECT score1, score2, score3, score4, score5 FROM pm WHERE name = :name";

                // プリペアドステートメントを作成する
                $stm1 = $pdo->prepare($sql1);
                // プレースホルダに値をバインドさせる
                $stm1->bindValue(':name', $_SESSION["name"], PDO::PARAM_STR);
                // SQLを実行する
                $stm1->execute();
            
                $result = $stm1->fetchALL(PDO::FETCH_ASSOC);
                foreach ($result as $data){
                    $score_array = array($data["score1"], $data["score2"], $data["score3"], $data["score4"], $data["score5"], $score);
                    rsort($score_array);
                }
                
                list($score1, $score2, $score3, $score4, $score5, $del) = $score_array;

                $sql2 = "UPDATE pm SET score1 = :score1, score2 = :score2, score3 = :score3, score4 = :score4, score5 = :score5 WHERE name = :name";

                // プリペアドステートメントを作成する
                $stm2 = $pdo->prepare($sql2);
                // プレースホルダに値をバインドさせる
                $stm2->bindValue(':name', $_SESSION["name"], PDO::PARAM_STR);
                $stm2->bindValue(':score1', $score1, PDO::PARAM_INT);
                $stm2->bindValue(':score2', $score2, PDO::PARAM_INT);
                $stm2->bindValue(':score3', $score3, PDO::PARAM_INT);
                $stm2->bindValue(':score4', $score4, PDO::PARAM_INT);
                $stm2->bindValue(':score5', $score5, PDO::PARAM_INT);
                // SQLを実行する
                $stm2->execute();
            }
        ?>