<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    if ($password == "3119") {
        // 密码正确，触发 HTTP 请求
        $url = "http://url/setcarboot.php";
        $response = file_get_contents($url);

        // 检查响应内容是否为 'add ok'
        if (trim($response) === "add ok") {
            $currentTime = new DateTime();  // 获取当前时间
            $currentTime->modify('+3 minutes');  // 加三分钟
            $formattedTime = $currentTime->format('H:i:s');  // 格式化时间为 HH:MM:SS

            $_SESSION['message'] = "<div class='ok-box'>設定成功，將於三分鐘內啟動。<br>(預計時間：$formattedTime)</div>";
        } else {
            $_SESSION['message'] = "<div class='error-box'>失敗(Response: $response)</div>";
        }

        // 重定向到同一页面，避免重复提交
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        $_SESSION['message'] = "<div class='error-box'>密碼錯誤</div>";
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>啟動汽車</title>
    <style>
        body {
            font-size: 32px; /* 字体大小调整为原来的两倍 */
        }

        h2 {
            font-size: 48px; /* 标题字体大小调整为两倍 */
        }

        label {
            font-size: 32px; /* 标签字体大小调整为两倍 */
        }

        input[type="password"] {
            font-size: 32px; /* 输入框字体大小调整为两倍 */
            width: 50%; /* 增加输入框宽度 */
            padding: 10px; /* 增加内边距，使输入框更大 */
            margin: 10px 0; /* 增加上下间距 */
        }

        input[type="submit"] {
            font-size: 32px; /* 按钮字体大小调整为两倍 */
            padding: 10px 20px; /* 增加按钮内边距 */
        }

        p {
            font-size: 32px; /* 提示信息字体大小调整为两倍 */
        }

        .error-box {
            border: 3px solid red; /* 红色边框 */
            padding: 10px; /* 内边距 */
            font-size: 32px; /* 字体大小 */
            color: red; /* 字体颜色 */
            width: 70%; 
        }
        .ok-box {
            border: 3px solid blue; /*边框 */
            padding: 10px; /* 内边距 */
            font-size: 32px; /* 字体大小 */
            color: blue; /* 字体颜色 */
            width: 70%; 
        }
    </style>
</head>
<body>

<h2>啟動汽車</h2>

<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);  // 清除消息
}
?>

<form method="POST" action="">
    <label for="password">Enter Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="啟動">
</form>

</body>
</html>

</body>
</html>
