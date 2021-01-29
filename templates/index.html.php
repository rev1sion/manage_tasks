<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.11/dist/css/uikit.min.css"/>

</head>
<body>

<div id="alert_div">
    <?php if (!empty($_SESSION['message'])) { ?>
    <div class="uk-alert uk-text-center uk-padding-small">
        <a class="uk-alert-close" uk-close></a>
        <?php foreach ($_SESSION['message'] as $value) {
            echo "<p>{$value}</p>";
        }
        unset($_SESSION['message']);
        } ?>
    </div>
</div>

<section class="uk-section">
    <div class="uk-container">

        <?= $content ?>

    </div>
</section>

<!-- UIkit JS -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.6.11/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.6.11/dist/js/uikit-icons.min.js"></script>
<script src="/assets/js/custom.js"></script>
</body>
</html>