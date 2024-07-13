<?php
$domains = json_decode(file_get_contents('data/domains.json'), true);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>域名售卖</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">域名售卖</a>
    </nav>
    <div class="container">
        <h1>域名列表</h1>
        <div class="list-group">
            <?php foreach ($domains as $domain): ?>
                <a href="buy.php?domain=<?php echo urlencode($domain['domain']); ?>" class="list-group-item list-group-item-action">
                    <?php echo htmlspecialchars($domain['domain']); ?>
                    - 价格: <?php echo htmlspecialchars($domain['price']); ?> USDT
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>