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
$result2 = $stm2->fetchAll(PDO::FETCH_ASSOC);

if( $result2!=null ) {
    foreach($result2 as $data) {
        if(isset($_POST["name"])) {
            if($data["name"] === $_POST["name"]) {
                $_SESSION["errname"]=1;
                header("location:signin.php");
            } else {
                $_POST["name"] = htmlspecialchars($_POST["name"],ENT_QUOTES,"UTF-8");
                $name = $_POST["name"];
                $_SESSION['name'] = $_POST['name'];
            }
        }
    }
} else {
    $_POST["name"] = htmlspecialchars($_POST["name"],ENT_QUOTES,"UTF-8");
    $name = $_POST["name"];
    $_SESSION['name'] = $_POST['name'];
}

if(isset($_POST["pass"])){
    $_POST["pass"] = htmlspecialchars($_POST["pass"],ENT_QUOTES,"UTF-8");
    if(preg_match('/\w{8,}/u',$_POST["pass"]) == 1) {
        $pass = hash("sha256",$_POST["pass"]);
    } else {
        $_SESSION["errpass"]=1;
        header("location:signin.php");
    }
}

if(isset($name)==1 && isset($pass)==1 ) {
    $stm = $pdo->prepare($sql);//プリペアードステートメントを作成
    $stm->bindValue(":name",$name,PDO::PARAM_STR); 
    $stm->bindValue(":pass",$pass,PDO::PARAM_STR); 
    $stm->execute();        //sqlの実行
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
$sql4 = "select pass from pm　where name = :namelog";
$stm4 = $pdo->prepare($sql4);
$stm4->execute();        
$result4 = $stm4->fetchAll(PDO::FETCH_ASSOC);

//登録されたname,passと$_POST["namelog"],$_POST["passlog]が同じならログイン
$sql5 = "select pass from pm where name = :namelog";


if(isset($_POST["namelog"])){
    foreach($result3 as $data3) {
        if($data3["name"] === $_POST["namelog"]) {
            echo 'データベースにありました';
            $setname = htmlspecialchars($_POST["namelog"],ENT_QUOTES,"UTF-8");
            unset($_SESSION['errnamelog']);
            $stm5 = $pdo->prepare($sql5);
            $stm5->bindValue(":namelog",$_SESSION["name"],PDO::PARAM_STR);
            $stm4->bindValue(":namelog",$_SESSION["name"],PDO::PARAM_STR);
            $stm5->execute();
            $result5 = $stm5->fetch(PDO::FETCH_ASSOC);
            var_dump($result5);
            break;
        } else{
            $_SESSION["errnamelog"]=1;
        }
    }
    if(isset($_SESSION['errnamelog']) ) {
        echo 20;
        header("location:login.php");
    }
}

if(isset($_POST["passlog"])) {
    echo 'post';
    $_POST["passlog"] = htmlspecialchars($_POST["passlog"],ENT_QUOTES,"UTF-8");
    if(preg_match('/\w{8,}/u',$_POST["passlog"]) == 1) {
        echo 'preg_match';
        $_POST["passlog"] = hash("sha256",$_POST["passlog"]);
        foreach($result4 as $data4){
            echo 'foreach';
            $op =hash_equals( $data4["pass"],$_POST["passlog"]);
            echo $op;
            if( hash_equals( $data4["pass"],$_POST["passlog"])==1 ) {
                if($result5["pass"] == $_POST["passlog"]){
                    header("location:head.php");
                }
            }else{
                $_SESSION["errpasslog"]="パスワードが違います";
                    header("location:login.php");
            }
        }
    } else{$_SESSION["errnamelog"]=1; header("location:login.php");} //英数字８以上でなければやり直し
}
echo $home;
if($home <= 0) {
    header("location:head.php");//ホームへ//今だけ<a head.php>修正➝title.php
}

?>