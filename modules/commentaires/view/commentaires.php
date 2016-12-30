<section>
    <h1>Commentaires: </h1>
    <?php
    // Todo: Afficher gravatar
    if ($nbCommentaires == 0) {
        echo '<p>Pas encore de commentaires...</p>';
    }


    foreach ($commentaires as $commentaire) {
        ?>
        <div class="commentaire">
            <h2><?php echo $commentaire['pseudo']; ?><span class="sous_titre"> dit:</span> </h2>


            <p>
                <span class="date_publication">
                    <em>le <?php echo $commentaire['date_creation_fr']; ?></em>
                </span>
            </p>
            <p>
                <?php echo $commentaire['contenu']; ?>
            </p>

        </div>

        <?php
    } ?>

</section>
