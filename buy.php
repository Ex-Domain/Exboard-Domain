<?php
$domain_name = $_GET['domain'];
$domains = json_decode(file_get_contents('data/domains.json'), true);
$settings = json_decode(file_get_contents('data/settings.json'), true);

$domain = null;
foreach ($domains as $d) {
    if ($d['domain'] === $domain_name) {
        $domain = $d;
        break;
    }
}

if ($domain === null) {
    die('域名不存在');
}

// 获取不同货币的支付地址
$currency_address = [
    'USDT' => $settings['usdt_address'],
    'ETH' => $settings['eth_address'],
    'BTC' => $settings['btc_address'],
    'USDC' => $settings['usdc_address'],
    'BCH' => $settings['bch_address'],
    'DOGE' => $settings['doge_address'],
];

$exchange_rates = json_decode(file_get_contents('https://api.exchangerate-api.com/v4/latest/USDT'), true);
$price_in_usdt = $domain['price'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>购买 <?php echo htmlspecialchars($domain_name); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">域名售卖</a>
    </nav>
    <div class="container">
        <h1>购买 <?php echo htmlspecialchars($domain_name); ?></h1>
        <p>价格: <?php echo htmlspecialchars($price_in_usdt); ?> USDT</p>
        <form method="POST">
            <div class="form-group">
                <label for="account">请输入您的账号:</label>
                <input type="text" class="form-control" id="account" name="account" required>
            </div>
            <div class="form-group">
                <label for="currency">选择支付货币:</label>
                <select class="form-control" id="currency" name="currency">
                    <?php foreach ($currency_address as $currency => $address): ?>
                        <option value="<?php echo htmlspecialchars($currency); ?>"><?php echo htmlspecialchars($currency); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">提交</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $account = $_POST['account'];
            $currency = $_POST['currency'];
            $address = $currency_address[$currency];

            // 调用第三方API检测转账情况，并处理购买逻辑
            // 示例：假设成功付款
            echo "<p>支付地址: " . htmlspecialchars($address) . "</p>";
            echo "<p>购买成功，您的账号是: " . htmlspecialchars($account) . "</p>";
        }
        ?>
    </div>
</body>
</html>