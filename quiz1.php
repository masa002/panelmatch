<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <title>パネルマッチ</title>
        <script>
            var to_timeup = 1000;
            var max = 1000;
            var intervalid;
            var start_flag = false;

            function count_start(){
                if(start_flag===false){                          
                    intervalid = setInterval(count_down,10);  
                    start_flag = true;
               }
            }

            function count_down(){
                var timer = document.getElementById("time");  
                if(to_timeup===0){
                    window.location.href="quiz2.php";
                    count_stop();
                } else {
                    to_timeup--;
                    padding();
                }
            }

            function padding(){
                var timer=document.getElementById("time");   
                var sec = 0;
                var msec = 0;
                sec = Math.floor(to_timeup/100);
                msec = (to_timeup%100);
                sec = ("0"+sec).slice(-2);
                msec = ("0"+msec).slice(-2);
                timer.innerHTML = "残り"+sec +"."+ msec+"秒です。";
            }


            window.onload = function(){
                count_start()
                padding();
                var startbutton=document.getElementById("start");
                startbutton.addEventListener("click",count_start,false);
            }           
        </script>
    </head>
    <body>
        <?php require "head.php"; ?>
        <h2 class="tt" id="time"></h2>
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                // セッションは有効で、開始していないとき
                session_start();
            }

            $level = $_SESSION["level"];
            $max = $level ** 2;
            $_SESSION["max_panel"] = ceil($max / 4);

            $panels = array_fill(0, $max, "white");
            $panels[rand(0, $max - 1)] = "black";

            while(array_count_values($panels)["black"] <= $_SESSION["max_panel"]){
            $panels[rand(0, $max - 1)] = "black";
            }
            $_SESSION["question"] = $panels;

            //height=1000 -> height=600に変更
            echo "<table border=1 height=600 width=100%><tr>";

            $cnt = 1;
            foreach($panels as $panel){
                if ($cnt % ($level + 1) === 0) {
                    echo "</tr><tr>";
                    $cnt = 1;
                }
                echo "<td bgcolor=".$panel." width=".(100 / $level)."%></td>";
                $cnt ++;
            }
            echo "</table>";
        ?>
    </body>
</html>