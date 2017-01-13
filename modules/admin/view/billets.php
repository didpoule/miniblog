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
    if (!isset($_GET['action'])) {
        foreach ($billets as $billet) {
            ?>
            <div class="news">
                <a href="?section=admin&menu=modifierBillet&action=afficher&billet=<?= $billet['id']?>">
                    <h2>ID: [<?= $billet['id'] ?>] <?= $billet['titre']; ?></h2>
                </a>
                <p>
                        <span class="date_publication">
                            Publié le <?= $billet['date'] ?> par <?= $billet['auteur'] ?>
                        </span>
                </p>
            </div>
            <?php
        }
    } elseif ($_GET['action'] == 'afficher') { ?>
        <section id="nouveau_billet" >
            <form method="post" action="">
                <input type="hidden" name="id_billet" value="<?= $billet['id'] ?>"/>
                <input type="hidden" name="token" value="<?= $token ?>" />
                <label for="titre">Titre: </label><input type="text" name="titre" id="titre" value="<?= $billet['titre'] ?>"/>
                <label for="contenu">Contenu: </label><textarea name="contenu" id="contenu"><?= $billet['contenu']?></textarea><br />
                <input type="submit" name="modifier" id="modifier" value="modifier"/><br />
                <input type="submit" name="supprimer" id ="supprimer" value="supprimer "/>
            </form>
        </section>

    <?php }

    include('modules/blog/view/footer.php'); ?>
</div>
</body>
</html>
