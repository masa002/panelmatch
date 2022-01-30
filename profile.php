<?php
    if (session_status() == PHP_SESSION_NONE) {
        // セッションは有効で、開始していないとき
        session_start();
    }
    if (isset($_SESSION["name"]) === false) 

    // 名前表示
    echo $_SESSION["name"]."<br>";
    echo "ベストスコア";

    $sql = "SELECT score FROM pm WHERE name = :name";

    // プリペアドステートメントを作成する
    $stm = $pdo->prepare($sql);
    // プレースホルダに値をバインドさせる
    $stm->bindValue(':name', $_SESSION["name"], PDO::PARAM_STR);
    // SQLを実行する
    $stm->execute();

    $result = $stm->fetch(PDO::FETCH_ASSOC);
    echo $result;
?>