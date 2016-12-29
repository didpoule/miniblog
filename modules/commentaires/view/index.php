<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Commentaires</title>
    <link href="include/style.css" rel="stylesheet"/>
</head>

<body>
    <div id="corps_page">
        <?php
        include 'modules/blog/view/header.php';
        include 'modules/blog/view/billet.php';
        include 'commentaires.php';
        ?>

        <?php if ($nbPages > 1) { ?>

        <nav class = "page_select">
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
            <form id="new_com" method="post" action="../../../blog.php?section=commentaires&billet=<?= $billet['id'] ?>">
                <input type="text" name="pseudo" id="pseudo" placeholder="Entrez votre pseudo"/><br/>
                <textarea name="contenu" id="contenu" placeholder="Ecrivez votre commenataire"></textarea><br/>
                <input type="submit" name="envoyer" id="envoyer"/>
            </form>
        </section>


    </div>
</body>
</html>

