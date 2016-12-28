<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Mon blog</title>
    <link href="include/style.css" rel="stylesheet"/>
</head>

<body>
<h1>Mon super blog !</h1>
<?php if($page == 0) { echo '<h2> .Derniers billets du blog :</h2>'; } ?>

<?php
foreach ($billets as $billet) {
    ?>
    <div class="news">
        <h3>
            <?php echo $billet['titre']; ?>
            <em>le <?php echo $billet['date_creation_fr']; ?></em>
        </h3>
        <p>
            <?php echo ($billet['contenu']); ?><br />
            <em><a href="?section=commentaires&billet=<?= $billet['id'] ?>">Commentaires</a></em>
        </p>
    </div>
    <?php
}
?>
<div class = "page_select">
    <nav>
        <p>Pages: <?php
            for($i = 0; $i < $nbPages; $i++) {
                echo '<ul><a href ="?page=' . $i . '">' . $i . '</a></ul>';
            }
            ?></p>
    </nav>
</div>
</body>
</html>