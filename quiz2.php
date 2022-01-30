<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <style type="text/css">
            .button_wrapper {
                margin-top: 30px;
                text-align: center;
            }
        </style>
        <title>パネルマッチ</title>
    </head>
    <body>
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                // セッションは有効で、開始していないとき
                session_start();
            }

            require "head.php";

            echo "<h2 class='tt'>黒く塗りつぶされていた場所を思い出して押してみよう！</h2>";

            $level = $_SESSION["level"];
            $max = $level ** 2;
            $panels = array_fill(0, $max, "white");
            $cnt1 = $cnt2 = 1;

            echo "<form action='quiz3.php' method='POST'><table border=1 height=1000 width=100%><tr>";
            foreach($panels as $panel){
                if ($cnt1 % ($level + 1) === 0) {
                    echo "</tr><tr>";
                    $cnt1 = 1;
                }
                echo "<td class='cell ".$cnt2."' data-num=".$cnt2." style='background-color:white; width=".(100 / $level)."%'><input type='checkbox' name='check[]' value=".$cnt2." style='display:none;'></td>";
                $cnt1 ++;
                $cnt2 ++;
            }
            echo "</table>";
            echo "<div class='button_wrapper'><input type='submit' id='submit' value='終わり' class='start-btn'></div>";
            echo "</form>";
        ?>
        <script>
            let cell = document.getElementsByClassName('cell');
            let submit = document.getElementById('submit');
            //console.log(cell);
            for(let i = 0; cell.length > i; i++) {
                //console.log(i);
                cell[i].addEventListener('click', function(){
                    //console.log(this.dataset.num);
                    if (this.style.backgroundColor == "black") {
                        this.style.backgroundColor = 'white';
                        cell[i].getElementsByTagName('input')[0].checked = false;
                    }
                    else if (this.style.backgroundColor == "white") {
                        this.style.backgroundColor = 'black';
                        cell[i].getElementsByTagName('input')[0].checked = true;
                    }
                });
            }
            submit.addEventListener('click', function(){
                for(let i = 0; cell.length > i; i++) {
                    console.log(cell[i].style.backgroundColor);
                }
            });
            //}
        </script>
    </body>