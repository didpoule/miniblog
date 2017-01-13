<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Administration de Miniblog</title>
    <link href="modules/admin/view/style.css" rel="stylesheet"/>
</head>

<body>
<div id="corps_page">
    <?php include('modules/blog/view/header.php'); ?>
    <section id="menu_admin">
        <a href="?section=admin&menu=paramAdmin">Modifier paramètres de connexion</a>
        <nav class="menu_billets">
            <h1>Gestion des billet: </h1>
            <ul>
                <li><a href="?section=admin&menu=nouveauBillet">Ecrire un nouveau billet</a></li>
                <li><a href="?section=admin&menu=modifierBillet">Modifier/supprimer un billet existant</a></li>
            </ul>
        </nav>
        <nav class="menu_commentaires">
            <h1>Gestion des commentaires: </h1>
            <ul>
                <li><a href="?section=admin&menu=paramCommentaire">Activer/Désactiver validation automatique</a></li>
                <li><a href="?section=admin&menu=validerCommentaire">Valider des commentaires</a></li>
                <li><a href="?section=admin&menu=supprimerCommentaire">Supprimer des commentaires</a></li>
            </ul>
        </nav>
    </section>

    <?php include('modules/blog/view/footer.php'); ?>
</div>

</body>
</html>
