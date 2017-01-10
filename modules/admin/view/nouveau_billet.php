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
    <section id="nouveau_billet">
        <h1>Ecrire un nouveau billet</h1>
        <form action="?section=admin&menu=nouveauBillet" method="post">
            <label for="titre">Entrez un titre: </label><input type="text" name="titre" id="titre"><br/>
            <label for="contenu">Ecrivez votre billet: </label><textarea name="contenu"
                                                                         id="contenu"></textarea><br/>
            <input type="submit" name="envoyer" id="envoyer" value="Envoyer"/>
        </form>
    </section>
    <?php include('modules/blog/view/footer.php'); ?>
</div>
</body>
</html>