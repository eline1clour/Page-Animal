<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="src/view/site.css" />
    <title><?php echo $this->title ?></title>
</head>
<body>
    <?php if ($this->feedback !== ''): ?>
        <div class='feedback'><?php echo $this->feedback ?></div>
    <?php endif ?>
    <nav>
        <ul>
            <?php foreach ($this->menu as $item): ?>
                <li><a href="<?= $item['url'] ?>"><?= $item['texte'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <h1><?php echo $this->title ?></h1>
    <p><?php echo $this->content ?></p>
</body>
</html>