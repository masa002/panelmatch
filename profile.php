<?php
    if (session_status() == PHP_SESSION_NONE) {
        // セッションは有効で、開始していないとき
        session_start();
    }
    // 名前表示
    echo $_SESSION["name"]."<br>";
    echo "ベストスコア";

    $sql = "SELECT * FROM pm WHERE name = :name";

    // プリペアドステートメントを作成する
    $stm = $pdo->prepare($sql);
    // プレースホルダに値をバインドさせる
    $stm->bindValue(':', $_SESSION["name"], PDO::PARAM_STR);
    // SQLを実行する
    $stm->execute();
?>