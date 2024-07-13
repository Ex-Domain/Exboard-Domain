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
    <title><?php echo t('添加域名'); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1><?php echo t('添加域名'); ?></h1>
        <form method="post" action="save_domain.php">
            <div class="form-group">
                <label for="domain"><?php echo t('域名'); ?></label>
                <input type="text" class="form-control" id="domain" name="domain">
            </div>
            <div class="form-group">
                <label for="price"><?php echo t('价格'); ?></label>
                <input type="text" class="form-control" id="price" name="price">
            </div>
            <button type="submit" class="btn btn-primary"><?php echo t('保存'); ?></button>
        </form>
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
