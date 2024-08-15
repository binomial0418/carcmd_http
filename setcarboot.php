<?php
$serve = 'mysql:host=db的IP:3306;dbname=db的名字;charset=utf8';
$username = 'db的帳號';
$password = 'db的密碼';

// PDO連線資料庫若錯誤則會丟擲一個PDOException異常
try {
    $PDO = new PDO($serve, $username, $password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // 設置錯誤模式為拋出異常
    
    $updateQuery = "INSERT INTO `caract` (`ser_no`, `act`, `tsc`, `rtt`) ".
                   "VALUES (NULL, 'boot', '3', current_timestamp())"; 
    $stmt = $PDO->prepare($updateQuery);
    $stmt->execute();
    // 检查是否插入成功
    if ($stmt->rowCount() > 0) {
        echo "add ok";
    } else {
        echo "add error";
    }
} catch (PDOException $error) {
    echo 'connect failed: ' . $error->getMessage();
}
?>
