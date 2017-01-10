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
    include 'modules/blog/view/billet.php'; ?>
    <section>
        <h1>Commentaires: </h1>
        <?php
        // Todo: Afficher gravatar
        if ($nbCommentaires == 0) {
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

    <?php if ($nbPages > 1) { ?>

        <nav class="page_select">
            <p><span>Pages: </span>
                <?php
                for ($i = 0; $i < $nbPages; $i++) {
                    echo '<ul><a href ="?section=commentaires&billet=' . $billet['id'] . '&pageCom=' . $i . '">' . $i . '</a>/</ul>';
                }
                ?></p>
        </nav>
    <?php } ?>
    <section>
        <h1>Ajouter un commentaire: </h1>
        <form id="new_com" method="post" action="../../../index.php?section=commentaires&billet=<?= $billet['id'] ?>">
            <label for="pseudo">Pseudo: </label><input type="text" name="pseudo" id="pseudo"/><br/>
            <label for="email">Email: </label><input type="email" name="email" id="email"/><br />
            <label for="contenu">Votre commentaire: *</label><textarea name="contenu" id="contenu"></textarea><br />
            <input type="submit" name="envoyer" id="envoyer" value="Envoyer"/>
        </form>
    </section>
    <?php include 'modules/blog/view/footer.php'; ?>

</div>
</body>
</html>

