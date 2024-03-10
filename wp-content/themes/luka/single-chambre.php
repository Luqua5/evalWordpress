<head>
    <?php echo wp_head(); ?>
</head>

<?php echo do_blocks('<!-- wp:template-part {"slug":"header","area":"header","tagName":"header"} /-->'); ?>

<?php


$chambre = get_fields();


$typelit = get_the_terms(get_the_ID(), 'type_lit');
$gammetarif = get_the_terms(get_the_ID(), 'gamme_tarif');


if (have_posts()) {
    while (have_posts()) {
        the_post();
        $image_url = get_the_post_thumbnail_url();
        ?>
        <article class="single" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <img src="<?php echo $image_url; ?>" alt="<?php echo get_the_title(); ?>">
            <h2><?php the_title(); ?></h2>
            <div style="display: flex; justify-content: space-evenly; width:100%;">
                <p>Prix indicatif : <?php echo $chambre['prix_indicatif'] ?? ''; ?>€</p>
                <p>Nombre de couchage : <?php echo $chambre['nombre_couchage'] ?? ''; ?></p>
            </div>
            <div style="display: flex; justify-content: space-evenly; width:100%;">
                <p>Gamme de tarif : <?php echo $gammetarif[0]->name ?? ''; ?></p>
                <p>Type de lit : <?php echo $typelit[0]->name ?? ''; ?></p>
            </div>
            <p><?php the_content(); ?></p>
        </article>
        <?php
    }
}

//display post with same gamme_tarif
$gamme_tarif = $gammetarif[0]->name;
$args = array(
    'post_type' => 'chambre',
    'tax_query' => array(
        array(
            'taxonomy' => 'gamme_tarif',
            'field' => 'name',
            'terms' => $gamme_tarif
        )
    )
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()) {
    ?>
    <h2>Chambres de la même gamme tarifaire</h2>
    <div class="slider">
        <?php
        while($the_query->have_posts()) {
            $the_query->the_post();
            $image_url = get_the_post_thumbnail_url();
            ?>
            <div class="chambre-card">
                <img src="<?php echo $image_url; ?>" alt="<?php echo get_the_title(); ?>">
                <h2><?php the_title(); ?></h2>
                <p><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>">Voir plus</a>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

?>
<?php echo wp_footer(); ?>
<?php echo do_blocks('<!-- wp:template-part {"slug":"footer","area":"footer","tagName":"footer"} /-->'); ?>


</body>