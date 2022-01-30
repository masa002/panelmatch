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
unset($_SESSION["errname"]);
unset($_SESSION["errpass"]);
unset($_SESSION["errnamelog"]);
unset($_SESSION["errpasslog"]);


// $result2 -> select name from pm
if(isset($_POST["name"])) {
    if( $result2!=null ) {
        foreach($result2 as $dust){
            if($dust["name"] === $_POST["name"]) {
                $_SESSION["errname"]="もう使われている名前だよ？";
                header("location:signin.php");
            } else {
                $name = htmlspecialchars($_POST["name"],ENT_QUOTES,"UTF-8");
                $nerr = 0;
            }
        }
    } else {
        $name = htmlspecialchars($_POST['name'],ENT_QUOTES,"UTF-8" );
        $nerr = 0;
    }
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
    //$_SESSION["name"] = $name;
    $_SESSION["signin"] = 1;
    header("location:signin.php");
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
            $_SESSION["errnamelog"]='';
             header("location:login.php");
        }
    }
    if(isset($_SESSION['errnamelog']) ) {
        echo 20;
        header("location:login.php");
    }
}
if(isset($_POST["passlog"])) {
    $_POST["passlog"] = htmlspecialchars($_POST["passlog"],ENT_QUOTES,"UTF-8");
    if(preg_match('/\w{8,}/u',$_POST["passlog"]) == 1) {
        $_POST["passlog"] = hash("sha256",$_POST["passlog"]);
            if( hash_equals( $result4["pass"],$_POST["passlog"])==1 ) {
                $_SESSION["name"] = $setname;
                 header("location:title.php");
            }else{
                $_SESSION["errpasslog"]="パスワードが違います";
                header("location:login.php");}
            
    } else{$_SESSION["errpasslog"]="アルファベットと数字だけで8文字以上書いてね？"; header("location:login.php");} //英数字８以上でなければやり直し
}
?>