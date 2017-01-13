<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Commentaires</title>
    <link href="modules/blog/view/style.css" rel="stylesheet"/>
</head>

<body>
<div id="corps_page">
    <?php
    include 'modules/blog/view/header.php';
    include 'modules/blog/view/billet.php';
    if($errmsg != 1) {
        ?>
        <section>

            <h1>Commentaires: </h1>
            <?php
            if (!$nbCommentaires)
            {
                echo '<div class="commentaire"><p>Pas encore de commentaires...</p></div>';
            }


            foreach ($commentaires as $commentaire) {
                ?>
                <div class="commentaire">
                    <div class="avatar"><?= $commentaire['gravatar'] ?></div>
                    <h2><?= $commentaire['pseudo'] ?><span class="sous_titre"> dit:</span></h2>
                    <p>
                <span class="date_publication">
                    <em>le <?= $commentaire['date'] ?></em>
                </span>
                    </p>
                    <p>
                        <?= $commentaire['contenu'] ?>
                    </p>

                </div>

                <?php
            } ?>

        </section>

        <?php
        if ($nbPages > 1)
        {
             pageSelector($nbPages, $_COOKIE['url']);
        }
        ?>
        <section>
            <h1>Ajouter un commentaire: </h1>
            <?php
            if($errmsg == 3)
            {
            ?>
            <p>
                Votre commentaire n'a pas été envoyé car il était vide.
            <form method="post">
                <input type="submit" name="ok" value="Fermer" />
            </form>


            </p>


            <?php } ?>
            <form id="new_com" method="post"
                  action="../../../?section=commentaires&billet=<?= $billet['id'] ?>">
                <label for="pseudo">Pseudo: </label><input type="text" name="pseudo" id="pseudo"/><br/>
                <label for="email">Email: </label><input type="email" name="email" id="email"/><br/>
                <label for="contenu">Votre commentaire: *</label><textarea name="contenu" id="contenu"></textarea><br/>
                <input type="submit" name="envoyer" id="envoyer" value="Envoyer"/>
            </form>
        </section>

        <?php

    }
    include 'modules/blog/view/footer.php'; ?>
</div>
</body>
</html>

