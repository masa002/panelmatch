<?php
session_start();
require "db_connect.php";
$sql = "INSERT INTO pm(name,pass) VALUES(:name,:pass)";
//あああ
//アカウント登録signin
//被った名前を探す
$sql2 = "select name from pm";
$stm2 = $pdo->prepare($sql2);
$stm2->execute();        
$result2 = $stm2->fetch(PDO::FETCH_ASSOC);
$nerr=1;
$perr=1;
if( $result2!=null ) {
    if(isset($_POST["name"])) {
        if($result2["name"] === $_POST["name"]) {
            $_SESSION["errname"]="もう使われている名前だよ？";
            header("location:signin.php");
        } else {
            $name = htmlspecialchars($_POST["name"],ENT_QUOTES,"UTF-8");
            $nerr = 0;
             
        }
    }else{$_SESSION["errname"]="名前を書いてください";header("location:signin.php");}
} else {/*多分エラーの元
    $_POST["name"] = htmlspecialchars($_POST["name"],ENT_QUOTES,"UTF-8");
    $name = $_POST["name"];*/
}

if(isset($_POST["pass"])){
    $_POST["pass"] = htmlspecialchars($_POST["pass"],ENT_QUOTES,"UTF-8");
    if(preg_match('/\w{8,}/u',$_POST["pass"]) == 1) {
        $pass = hash("sha256",$_POST["pass"]);
        $perr = 0;
    } else {
        $_SESSION["errpass"]="アルファベットと数字だけで8文字以上書いてね？";
        header("location:signin.php");
    }
}

if($perr != 1 && $nerr != 1 ) {
    $stm = $pdo->prepare($sql);//プリペアードステートメントを作成
    $stm->bindValue(":name",$name,PDO::PARAM_STR); 
    $stm->bindValue(":pass",$pass,PDO::PARAM_STR); 
    $stm->execute();        //sqlの実行
    $_SESSION["name"];
    echo "アカウント登録が完了しました！！"."<br>";
    echo '<label>'.'<a href="head.php">'.'トップ画面へ'.'</a>'.'</label>'; //今だけ<a head.php>修正➝title.php
}








//ここから下はlogin.phpの処理
$home=2;//0になったらログイン成功
//被った名前を探す
$sql3 = "select name from pm";
$stm3 = $pdo->prepare($sql3);
$stm3->execute();        
$result3 = $stm3->fetchAll(PDO::FETCH_ASSOC);
//一致するpassを探す
$sql4 = "select pass from pm where name = :namelog";
$stm4 = $pdo->prepare($sql4);


//登録されたname,passと$_POST["namelog"],$_POST["passlog]が同じならログイン



if(isset($_POST["namelog"])){
    foreach($result3 as $data3) {
        if($data3["name"] === $_POST["namelog"]) {
            $setname = htmlspecialchars($_POST["namelog"],ENT_QUOTES,"UTF-8");
            unset($_SESSION['errnamelog']);
            $stm4->bindValue(":namelog",$setname,PDO::PARAM_STR);
            $stm4->execute();        
            $result4 = $stm4->fetch(PDO::FETCH_ASSOC);
            break;
        } else{
            $_SESSION["errnamelog"]='名前が存在しません';
             header("location:login.php");

        }
    }
    if(isset($_SESSION['errnamelog']) ) {
        echo 20;
        header("location:login.php");
    }
}else{$_SESSION['errnamelog'] = "名前を書いてください";header("location:login.php");}

if(isset($_POST["passlog"])) {
    echo 'post';
    $_POST["passlog"] = htmlspecialchars($_POST["passlog"],ENT_QUOTES,"UTF-8");
    if(preg_match('/\w{8,}/u',$_POST["passlog"]) == 1) {
        echo 'preg_match';
        $_POST["passlog"] = hash("sha256",$_POST["passlog"]);
        foreach($result4 as $data4){
            if( hash_equals( $data4["pass"],$_POST["passlog"])==1 ) {
                $_SESSION["name"] = $setname;
                 header("location:head.php");
            }
        }
        if(hash_equals( $data4["pass"],$_POST["passlog"]) != 1){ 
            $_SESSION["errpasslog"]="パスワードが違います";
            header("location:login.php");
        }
    } else{$_SESSION["errnamelog"]="アルファベットと数字だけで8文字以上書いてね？"; header("location:login.php");} //英数字８以上でなければやり直し
}
echo $home;
if($home <= 0) {
    header("location:title.php");//ホームへ//今だけ<a head.php>修正➝title.php
}

?>
