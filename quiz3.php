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
            $panels = $_SESSION["question"];
            if (isset($_POST["check"]) === false)$checks=[]; else $checks = $_POST["check"];
            $black_panel = $_SESSION["max_panel"] + 1;
            $white_panel = count($panels) - $black_panel;
            $a_panels = array_fill(0, count($panels), "white");
            foreach($checks as $check) {
                if($panels[$check - 1] === "black") $score += 1000;
                if($panels[$check - 1] === "white") $score -= 500;
            }


            echo "<h2 class='tt'>得点は".$score."ポイントです。</h2>";
        ?>