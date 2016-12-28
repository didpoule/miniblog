<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Commentaires</title>
    <link href="include/style.css" rel="stylesheet"/>
</head>

<body>
<article class="news">
    <h3>
        <?php echo $billet['titre']; ?>
        <em>le <?php echo $billet['date_creation_fr']; ?></em>
    </h3>

    <p>
        <?php echo $billet['contenu']; ?>
    </p>
</article>
<?php
foreach ($commentaires as $commentaire) {
    ?>
    <div class="commentaire">
        <h3>
            <?php echo $commentaire['pseudo']; ?>
            <em>le <?php echo $commentaire['date_creation_fr']; ?></em>
        </h3>

        <p>
            <?php echo $commentaire['contenu']; ?>
            <br/>
        </p>
    </div>

    <?php
}

?>
<div class = "page_select">
    <nav>
        <p>Pages: <?php
        for($i = 0; $i < $nbPages; $i++) {
            echo '<ul><a href ="?section=commentaires&billet=' . $billet['id'] . '&pageCom=' . $i . '">' . $i . '</a></ul>';
        }
            ?></p>
    </nav>
</div>
    <h3>Ajouter un commentaire</h3>
    <form id="new_com" method="post" action="../../../blog.php?section=commentaires&billet=<?= $billet['id']?>">
        <input type="text" name="pseudo" id="pseudo" placeholder="Entrez votre pseudo" /><br />
        <textarea name="contenu" id="contenu" placeholder="Ecrivez votre commenataire"></textarea><br />
        <input type="submit" name="envoyer" id="envoyer" />
    </form>
</body>
</html>

