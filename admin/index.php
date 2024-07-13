<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include('config.php');

// 调用更新价格的函数
updatePrices();

$domains = json_decode(file_get_contents('../data/domains.json'), true);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理员后台</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">后台管理</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="settings.php">设置</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">登出</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>域名管理</h1>
        <a href="add_domain.php" class="btn btn-primary mb-3">添加域名</a>
        <div class="list-group">
            <?php foreach ($domains as $domain): ?>
                <a href="update_domain.php?domain=<?php echo urlencode($domain['domain']); ?>" class="list-group-item list-group-item-action">
                    <?php echo htmlspecialchars($domain['domain']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
