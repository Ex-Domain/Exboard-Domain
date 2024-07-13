<?php
function updatePrices() {
    $settings = json_decode(file_get_contents('../data/settings.json'), true);
    $api_key = $settings['crypto_apis_key'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.cryptoapis.io/v1/exchange-rates");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "X-API-Key: $api_key"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $exchange_rates = json_decode($response, true);
    $domains = json_decode(file_get_contents('../data/domains.json'), true);

    foreach ($domains as &$domain) {
        $price_in_usdt = $domain['price'];
        $currency = $domain['currency'];
        if (isset($exchange_rates['data'][$currency])) {
            $domain['price'] = $price_in_usdt / $exchange_rates['data'][$currency]['rate'];
        }
    }

    file_put_contents('../data/domains.json', json_encode($domains));
}
?>
