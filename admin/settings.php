<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$settings = json_decode(file_get_contents('../data/settings.json'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'eth_address' => $_POST['eth_address'],
        'btc_address' => $_POST['btc_address'],
        'usdc_address' => $_POST['usdc_address'],
        'usdt_address' => $_POST['usdt_address'],
        'bch_address' => $_POST['bch_address'],
        'doge_address' => $_POST['doge_address'],
        'admin_password' => $settings['admin_password'],
        'api_key' => $settings['api_key']
    ];

    if (!empty($_POST['admin_password'])) {
        $settings['admin_password'] = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);
    }

    file_put_contents('../data/settings.json', json_encode($settings));
    $message = "设置已更新";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>设置</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>设置</h1>
        <?php if (isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>
        <form method="POST">
            <div class="form-group">
                <label for="eth_address">ETH 地址:</label>
                <input type="text" class="form-control" id="eth_address" name="eth_address" value="<?php echo htmlspecialchars($settings['eth_address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="btc_address">BTC 地址:</label>
                <input type="text" class="form-control" id="btc_address" name="btc_address" value="<?php echo htmlspecialchars($settings['btc_address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="usdc_address">USDC 地址:</label>
                <input type="text" class="form-control" id="usdc_address" name="usdc_address" value="<?php echo htmlspecialchars($settings['usdc_address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="usdt_address">USDT 地址:</label>
                <input type="text" class="form-control" id="usdt_address" name="usdt_address" value="<?php echo htmlspecialchars($settings['usdt_address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="bch_address">BCH 地址:</label>
                <input type="text" class="form-control" id="bch_address" name="bch_address" value="<?php echo htmlspecialchars($settings['bch_address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="doge_address">DOGE 地址:</label>
                <input type="text" class="form-control" id="doge_address" name="doge_address" value="<?php echo htmlspecialchars($settings['doge_address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="admin_password">新管理员密码:</label>
                <input type="password" class="form-control" id="admin_password" name="admin_password">
            </div>
            <button type="submit" class="btn btn-primary">更新设置</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">返回</a>
    </div>
</body>
</html>
