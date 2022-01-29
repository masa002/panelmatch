<?php
    if (session_status() == PHP_SESSION_NONE) {
        // セッションは有効で、開始していないとき
        session_start();
    }   
   if( isset($_POST['logout']) ) {
       unset($_SESSION['name']);
   }
?>
<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UFT-8">
        <title>パネルマッチ</title>
        <style>
            .h_body { 
                margin: 0;
                font-family: "ヒラギノ角ゴシック体 W3";
            }
            .header {
                display: flex;
                justify-content: space-between;
                margin: 0 auto;
                font-size: 1.3rem;
                background-color: #ffd958;
                padding-left: 20%;
                padding-right: 15%;
            }
            .header a {
                text-decoration: none;
                color: black;
            }
            .header a:hover { text-decoration: underline; }
            .h_top { display: flex; transition: 0.3s; }
            .h_top:hover { transform: scale(1.2,1.2); }
            .h_logout { display: flex; }
            .h_img1 {
                width: 30px;
                height: 30px;
                margin-top: 20px;
                margin-right: 5px;
            }
            .h_in { display: flex; }
            .h_login a {
                display:flex;
                margin-right: 30px;
            }
            .h_img2 {
                width: 28px;
                height: 28px;
                margin-top: 23px;
                margin-right: 5px;
            }
            .h_logou {
                font-size: 1.3rem;
                margin-left: 30px;
                transition: 0.3s;
            }
            .h_logou:hover { transform: scale(1.2,1.2); }
            .h_login { transition: 0.3s; }
            .h_login:hover { transform: scale(1.2,1.2); }
            .h_signin { transition: 0.3s; }
            .h_signin:hover { transform: scale(1.2,1.2); }
            button{
                background-color: transparent;
                border: none;
                cursor: pointer;
                outline: none;
                padding: 0;
                appearance: none;
            }
        </style>
    </head>
    <body class="h_body">
	<header class="header">       
	    <a href="title.php" class="h_topa">   <!-- 今だけaタグの中身 head.php➝修正title.php -->
            <div class="h_top">
                <img src="images/home.png" class="h_img1" alt="家の画像" >
                <p>トップ</p>
            </div>
        </a>
        <?php   //右側の表示
        //ログインしている状態かどうか、している
        if( isset($_SESSION['name']) ) {      //SESSIONに名前があるか   //今だけaタグの中身 head.php➝修正title.php ↓
            echo "<div class='h_logout'>
                    <p>".$_SESSION['name']."さん</p>
                    <form action='title.php' method='POST'>
                        <a><button type='submit' name='logout'><p class='h_logou'>ログアウト</p></button></a>
                    </form>
                </div>"; //ログアウト
        
        //ログインしていないとき
        } else {  
            echo "<div class='h_in'>
                    <div class='h_login'>
                        <a href='login.php'><img src='images/loginicon.svg' class='h_img2' alt='アイコン'>
                        <p>ログイン</p></a>
                    </div>" ;                     //ログイン
            echo   "<div class='h_signin'><p><a href='signin.php'>アカウント作成</a></p></div>
                 </div>";                         //アカウント作成
        }
        ?>
	</header>
    </body>
</html>

