<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_domain = [
        'domain' => $_POST['domain'],
        'account' => $_POST['account'],
        'password' => $_POST['password'],
        'price' => (float) $_POST['price'],
        'currency' => 'USDT'
    ];
    $domains = json_decode(file_get_contents('../data/domains.json'), true);
    $domains[] = $new_domain;
    file_put_contents('../data/domains.json', json_encode($domains));
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加域名</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>添加域名</h1>
        <form method="POST">
            <div class="form-group">
                <label for="domain">域名:</label>
                <input type="text" class="form-control" id="domain" name="domain" required>
            </div>
            <div class="form-group">
                <label for="account">所属账号:</label>
                <input type="text" class="form-control" id="account" name="account" required>
            </div>
            <div class="form-group">
                <label for="password">账号密码:</label>
                <input type="text" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="price">价格 (USDT):</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">添加</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">返回</a>
    </div>
</body>
</html>
