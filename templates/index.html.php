<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.11/dist/css/uikit.min.css"/>

</head>
<body>

<section class="uk-section">
    <div class="uk-container">

        <?= $content ?>

    </div>
</section>

<!-- UIkit JS -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.6.11/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.6.11/dist/js/uikit-icons.min.js"></script>
</body>
</html>