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
            $api_key = $settings['crypto_apis_key'];

            // 示例：调用 Crypto APIs 进行交易检测
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.cryptoapis.io/v1/bc/$currency/testnet/address/$address/transactions");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "X-API-Key: $api_key"
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            $transactions = json_decode($response, true);
            $payment_received = false;

            foreach ($transactions['payload'] as $transaction) {
                if ($transaction['status'] === 'confirmed') {
                    $payment_received = true;
                    break;
                }
            }

            if ($payment_received) {
                echo "<p>支付地址: " . htmlspecialchars($address) . "</p>";
                echo "<p>购买成功，您的账号是: " . htmlspecialchars($account) . "</p>";
            } else {
                echo "<p>付款未确认，请稍后再试。</p>";
            }
        }
        ?>
    </div>
</body>
</html>
