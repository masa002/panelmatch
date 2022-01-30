<?php
    //初期値の設定
    if (session_status() == PHP_SESSION_NONE) {
        // セッションは有効で、開始していないとき
        session_start();
    }

    require "head.php";

    // test

    if (isset($_SESSION["level"]) === false) $_SESSION["level"] = 2;
    //難易度のカウントアップの処理
    if(isset($_POST['pull']) !== false){
        $_SESSION['level'] = $_SESSION['level'] - 1;
        if($_SESSION['level'] < 2){
            $_SESSION['level'] = 10;
        }
    }
    //難易度のカウントダウンの処理
    if(isset($_POST['add']) !== false){
        $_SESSION['level'] = $_SESSION['level'] + 1;
        if($_SESSION['level'] > 10){
            $_SESSION['level'] = 2;
        }
    }
    //＋か－のボタンを押すとUndefined indexのエラーが出る
?>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1 class="title">★パネルマッチ★</h1>
    <!--oo.phpを次のページに変える-->
    <div class="form-top">
        <form action="quiz1.php" method="POST">    
            <input type="submit" value="始める" class="start-btn">
        </form>
    </div>
    <h2 class="tt">難易度設定</h2><br>
    <form action="title.php" id="form2" method="POST">
        <div class="form-top">
            <button type="submit" name="pull" class="button">－</button>
            <span class="tt"><?php echo "　".$_SESSION['level']."　";?></span>
            <button type="submit" name="add" class="button">＋</button>
        </div>
    </form>
    <h2 class="tt">説明</h2>
        <p class="tt">
            このクイズアプリは、10秒間で黒く塗られたパネルの場所を覚えて、どこが黒く塗りつぶされたか思い出してその場所を押して最後にどれくらい覚えていたかを
            採点するクイズゲームです。最高得点目指してみんな頑張ろう！
        </p>
        <!--ランキングタイトル-->
        <h2 class="tt">ランキング</h2>

<?php   if(isset($_SESSION["name"])){

}
?>
  </body>
</html>