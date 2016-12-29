<section>
    <?php
    if(!isset($_GET['section'])) {
        foreach ($billets as $billet) {
            ?>
            <div class="news">
                <h2><?php echo $billet['titre']; ?></h2>
                <p>
                        <span class="date_publication">
                            Publié le <?php echo $billet['date_creation_fr']; ?>
                        </span>
                </p>
                <p>
                        <span class="contenu_billet">
                            <?php echo($billet['contenu']); ?><br/>
                                <em><a href="?section=commentaires&billet=<?= $billet['id'] ?>">Commentaires</a></em>
                        </span>
                </p>
            </div>
            <?php
        }
    }

    elseif($_GET['section'] == 'commentaires')
    { ?>
        <div class="news">
            <h2><?php echo $billet['titre']; ?></h2>
            <p>
            <span class="date_publication">
                Publié le <?php echo $billet['date_creation_fr']; ?>
            </span>
            </p>
            <p>
            <span class="contenu_billet">
                <?php echo($billet['contenu']); ?><br/>
            </span>
            </p>
        </div>

        <?php
    }
    ?>

</section>
