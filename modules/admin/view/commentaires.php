<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Administration de Miniblog</title>
    <link href="modules/admin/view/style.css" rel="stylesheet"/>
</head>

<body>
<div id="corps_page">
    <?php
    include('modules/blog/view/header.php');


    if($_GET['menu'] != 'paramCommentaire')
    {
        if (!isset($_GET['action'])) {
            foreach ($commentaires as $commentaire) {
                ?>
                <h3>
                    Auteur: <?= $commentaire['pseudo'] ?>
                    Date de publication: <?= $commentaire['date'] ?><br />
                </h3>
                <p>
                <?= $commentaire['contenu'] ?>

                <?php
                if($_GET['menu'] === 'supprimerCommentaire') {
                    ?>
                    <form method="post"
                    action="?section=admin&menu=supprimerCommentaire&action=delete&commentaire=<?= $commentaire['id'] ?>">
                <?php }

                elseif($_GET['menu'] === 'validerCommentaire')
                { ?>
                    <form method="post"
                    action="?section=admin&menu=validerCommentaire&commentaire=<?= $commentaire['id'] ?>">
                <?php } ?>
                <input type="submit" name="supprimer" value="Supprimer"/>
                </form>

                <?php
                if($_GET['menu'] === 'validerCommentaire')
                {
                    ?>
                    <form method="post" action="?section=admin&menu=validerCommentaire&commentaire=<?= $commentaire['id'] ?>">
                        <input type="submit" name="valider" value="Valider" />
                    </form>
                    <?php
                } ?>
                </p>
                <br />
                <?php
            }
        }
    }
    elseif($_GET['menu'] === 'paramCommentaire')
    { ?>
        <form method="post" action="?section=admin&menu=paramCommentaire&action=changeParam">
            <label for="validation">Activer validation des commentaires par administrateur</label><input type="checkbox" name="validation" /><br />
            <input type="submit" name="modifier" value="Valider" />
        </form>
    <?php }
    include('modules/blog/view/footer.php'); ?>
</div>
</body>
</html>
