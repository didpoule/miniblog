<section>
    <?php
    if($errmsg != 1)
    {
        if (!isset($_GET['section']))
        {
            foreach ($billets as $billet)
            {
            ?>
                <div class="news">
                    <h2><?= $billet['titre']; ?></h2>
                    <p>
                        <span class="date_publication">
                            Publié le <?= $billet['date'] ?> par <?= $billet['auteur'] ?>
                        </span>
                    </p>
                    <p>
                        <span class="contenu_billet">
                            <?= $billet['contenu'] ?><br/>
                                <em><a href="?section=commentaires&billet=<?= $billet['id'] ?>">Commentaires</a></em>
                        </span>
                    </p>
                </div>
            <?php
            }
        }
        elseif ($_GET['section'] == 'commentaires')
        { ?>
            <div class="news">
                <h2><?= $billet['titre'] ?></h2>
                <p>
                    <span class="date_publication">
                        Publié le <?= $billet['date'] ?> par <?= $billet['auteur'] ?>
                    </span>
                </p>
                <p>
                    <span class="contenu_billet">
                        <?= $billet['contenu'] ?><br/>
                    </span>
                </p>
            </div>
        <?php
        }
    }
    else
    {
        if($errmsg == 1) echo '<h1>Le billet demandé n\'existe pas<h1>';
    }
    ?>

</section>
