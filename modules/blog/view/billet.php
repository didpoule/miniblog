<section>
    <?php
        if (!isset($_GET['section']))
        {
            if($billets)
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
                        </span>
                            <em><a href="?section=commentaires&billet=<?= $billet['id'] ?>">Lire la suite et commentaires</a></em>
                        </p>
                    </div>
                    <?php
                }
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
    ?>

</section>
