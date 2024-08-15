<?php
$serve = 'mysql:host=db的IP:3306;dbname=db的名字;charset=utf8';
$username = 'db的帳號';
$password = 'db的IP密碼';
$query  = "SELECT act, ser_no, tsc FROM caract WHERE tsc = '3' and rtt >= NOW() - INTERVAL 6 MINUTE";

// PDO連線資料庫若錯誤則會丟擲一個PDOException異常
try {
    $PDO = new PDO($serve, $username, $password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // 設置錯誤模式為拋出異常

    $result = $PDO->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($data) {
        foreach($data as $val) {
            $act = $val['act'];
        }
        echo "<boot>" . $act . "</boot>";
    } else {
        echo "<boot>disable</boot>"; // 如果没有结果，返回默认值
    }
    // 更新tsc值為6
    $updateQuery = "UPDATE caract        ".
                   "   SET tsc = '6',    ".
                   "       rtt = now()     ".
                   " WHERE tsc = '3'     ";
    $stmt = $PDO->prepare($updateQuery);
    $stmt->bindParam(':act', $act);
    $stmt->execute();
} catch (PDOException $error) {
    echo 'connect failed: ' . $error->getMessage();
}
?>
