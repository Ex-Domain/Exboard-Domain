<?php
include 'translate.php';

$domains = json_decode(file_get_contents('data/domains.json'), true);
$settings = json_decode(file_get_contents('data/settings.json'), true);
$selectedLang = isset($_GET['lang']) ? $_GET['lang'] : 'ZH';

function t($text) {
    global $selectedLang;
    return translate($text, $selectedLang);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo t('域名售卖'); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><?php echo t('域名售卖'); ?></a>
        <div class="ml-auto">
            <select id="language-select" onchange="changeLanguage(this.value)">
                <option value="ZH" <?php echo $selectedLang == 'ZH' ? 'selected' : ''; ?>>中文</option>
                <option value="EN" <?php echo $selectedLang == 'EN' ? 'selected' : ''; ?>>English</option>
                <!-- Add other language options -->
            </select>
        </div>
    </nav>
    <div class="container">
        <h1><?php echo t('域名列表'); ?></h1>
        <div class="list-group">
            <?php foreach ($domains as $domain): ?>
                <a href="buy.php?domain=<?php echo urlencode($domain['domain']); ?>&lang=<?php echo $selectedLang; ?>" class="list-group-item list-group-item-action">
                    <?php echo htmlspecialchars($domain['domain']); ?>
                    - <?php echo t('价格'); ?>: <?php echo htmlspecialchars($domain['price']); ?> USDT
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        function changeLanguage(lang) {
            window.location.href = '?lang=' + lang;
        }
    </script>
    <footer>
        <p><?php echo t('Powered by DeepLX API'); ?></p>
    </footer>
</body>
</html>
