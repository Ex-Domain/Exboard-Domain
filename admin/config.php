<?php
include '../translate.php';

$settings = json_decode(file_get_contents('../data/settings.json'), true);
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
    <title><?php echo t('配置'); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1><?php echo t('配置'); ?></h1>
        <p><?php echo t('这是配置页面的内容。'); ?></p>
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

