<?php
session_start();
?>
<html>
    <head>
    <meta charset="UFT-8">
        <title>ログイン</title>
        <link rel="stylesheet" href="style.css">
        <style>
            /* header 部分 */
            .h_body { 
                margin: 0;
                font-family: "ヒラギノ角ゴシック体 W3";
            }
            .header {
                display: flex;
                justify-content: space-between;
                margin: 0 auto;
                font-size: 1.5rem;
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
                margin-top: 25px;
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
                margin-top: 28px;
                margin-right: 5px;
            }
            .h_logou { margin-left: 30px; transition: 0.3s; }
            .h_logou:hover { transform: scale(1.2,1.2); }
            .h_login { transition: 0.3s; }
            .h_login:hover { transform: scale(1.2,1.2); }
            .h_signin { transition: 0.3s; }
            .h_signin:hover { transform: scale(1.2,1.2); }

            /* login画面部分 */
            .login {
                margin-top: 5vw;
                margin-left: 35vw;
            }
            .login p {
                font-size: 1.3vw;
            }
            .logsub { margin-left: 4vw;
                display       : inline-block;
                border-radius : 25%;         /* 角丸       */
                font-size     : 18pt;        /* 文字サイズ */
                text-align    : center;      /* 文字位置   */
                cursor        : pointer;     /* カーソル   */
                padding       : 24px 100px;  /* 余白       */
                background    : rgba(255, 166, 77, 0.82);   /* 背景色     */
                color         : #ffffff;   /* 文字色     */
                line-height   : 1em;       /* 1行の高さ  */
                transition    : .3s;         /* なめらか変化 */
                 box-shadow    : 4px 4px 3px #666666;  /* 影の設定 */
            }
            .logsub:hover {
                box-shadow    : none;        /* カーソル時の影消去 */
            }
            .h4 {
                margin-top: 5vh;
                text-align: center;
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
            echo "<div class='h_logout'><p>".$_SESSION['name']."さん</p><p class='h_logou'><a href='title.php'>ログアウト</a></p></div>";
            unset($_SESSION['name']);
        //ログインしていないとき
        } else {  
            echo "<div class='h_in'>
                    <div class='h_login'>
                        <a href='login.php'><img src='images/loginicon.svg' class='h_img2' alt='アイコン'>
                        <p>ログイン</p></a>
                    </div>";
            echo   "<div class='h_signin'><p><a href='signin.php'>アカウント作成</a></p></div>
                 </div>";
        }
        ?>
	</header>
    <div class="login">
        <h2>ログイン</h2>
        <form action="return.php" method="POST" >

        <label><p>ユーザー名<?php if(isset($_SESSION["errnamelog"])){echo '<a style="color:#ff0000;font-size: 12px;">　　　　　　'.$_SESSION["errnamelog"].'</a>';}?></p>
        <input type="text" name="namelog" style="width: 30vw" required></label><br><br>


        <label><p>パスワード<?php if(isset($_SESSION["errpasslog"])){echo '<a style="color:#ff0000";font-size: 12px;>　　　　　　'.$_SESSION["errpasslog"].'</a>';}?></p>
        <input type="password" name="passlog" placeholder="半角英数のみ8文字以上" style="width: 30vw" required></label><br><br>

        <input type="submit" value="ログイン" class="logsub">

        </form>
    </div>
    <br><br><h4 class="h4">パスワードを忘れても弊社は責任を負いかねます</h4>
</html>

<script>
window.onload = function(){
    document.getElementById("logout").onsubmit=function(){
    <?php  
    unset($_SESSION['errnamelog']);
    unset($_SESSION['errpasslog']);
    //logoutが押されたらsessionを破棄
    ?>
    }
}

window.onload = function(){
document.getElementById("mainForm").onsubmit = function(){
<?php
if(isset($_SESSION["errname"])){
unset($_SESSION["errname"]);
} 
if(isset($_SESSION["errpass"])){
unset($_SESSION["errpass"]);
} 
//submitが押されたらsessionを破棄
?>
}
}

</script>