<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Commentaires</title>
    <link href="include/style.css" rel="stylesheet"/>
</head>

<body>
    <div class="billet">
        <article>
            <h3>
                <?php echo $billet['titre']; ?>
                <em>le <?php echo $billet['date_creation_fr']; ?></em>
            </h3>

            <p>
                <?php echo $billet['contenu']; ?>
            </p>
        </article>
    </div>
    <section id="Commentaires">
        <h3>Commentaires: </h3>
        <?php
        if ($nbCommentaires == 0) {
            echo '<p>Pas encore de commentaires...</p>';
        }


        foreach ($commentaires as $commentaire) {
        ?>
        <div class="commentaire">
            <h4>
                <?php echo $commentaire['pseudo']; ?>
                <em>le <?php echo $commentaire['date_creation_fr']; ?></em>
            </h4>

            <p>
                <?php echo $commentaire['contenu']; ?>
                <br/>
            </p>
        </div>

        <?php
        }
    if ($nbPages > 1) { ?>

            <nav class = "page_select">
                <p><span>Pages: </span>
                <?php
                    for ($i = 0; $i < $nbPages; $i++) {
                        echo '<ul><a href ="?section=commentaires&billet=' . $billet['id'] . '&pageCom=' . $i . '">' . $i . '</a>/</ul>';
                    }
                ?></p>
        </nav>
    <?php } ?>
            <h3>Ajouter un commentaire: </h3>
            <form id="new_com" method="post" action="../../../blog.php?section=commentaires&billet=<?= $billet['id'] ?>">
                <input type="text" name="pseudo" id="pseudo" placeholder="Entrez votre pseudo"/><br/>
                <textarea name="contenu" id="contenu" placeholder="Ecrivez votre commenataire"></textarea><br/>
                <input type="submit" name="envoyer" id="envoyer"/>
            </form>

        </section>


</body>
</html>

