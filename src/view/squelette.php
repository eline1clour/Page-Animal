<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $this->title ?></title>
</head>
<body>
    <?php if ($this->feedback): ?>
        <p><?php echo $this->feedback ?></p>
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
  