<?php
function updatePrices() {
    $settings = json_decode(file_get_contents('../data/settings.json'), true);
    $api_key = $settings['api_key'];

    // 使用示例API URL，实际使用时请替换为你所使用的API
    $api_url = 'https://api.cryptoapis.io/v1/exchange-rates';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'X-API-Key: ' . $api_key
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    $exchange_rates = json_decode($response, true);

    $domains = json_decode(file_get_contents('../data/domains.json'), true);
    foreach ($domains as &$domain) {
        $price_in_usdt = $domain['price'];
        $currency = $domain['currency'];
        if (isset($exchange_rates['data']['rates'][$currency])) {
            $domain['price'] = $price_in_usdt / $exchange_rates['data']['rates'][$currency];
        }
    }
    file_put_contents('../data/domains.json', json_encode($domains));
}

function checkTransactionStatus($txid, $currency) {
    $settings = json_decode(file_get_contents('../data/settings.json'), true);
    $api_key = $settings['api_key'];
    $api_url = "https://api.cryptoapis.io/v1/{$currency}/txs/{$txid}";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'X-API-Key: ' . $api_key
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
?>
