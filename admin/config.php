<?php
function updatePrices() {
    $settings = json_decode(file_get_contents('../data/settings.json'), true);
    $api_key = $settings['api_key'];

    // 使用示例API URL，实际使用时请替换为你所使用的API
    $api_url = 'https://api.exchangerate-api.com/v4/latest/USDT';
    $exchange_rates = json_decode(file_get_contents($api_url), true);

    $domains = json_decode(file_get_contents('../data/domains.json'), true);
    foreach ($domains as &$domain) {
        $price_in_usdt = $domain['price'];
        $currency = $domain['currency'];
        if (isset($exchange_rates['rates'][$currency])) {
            $domain['price'] = $price_in_usdt / $exchange_rates['rates'][$currency];
        }
    }
    file_put_contents('../data/domains.json', json_encode($domains));
}
?>
