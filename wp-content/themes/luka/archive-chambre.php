<head>
    <?php echo wp_head(); ?>
</head>

<body>

    <?php

    echo do_blocks('<!-- wp:template-part {"slug":"header","area":"header","tagName":"header"} /-->');
    ?>

    <?php


Chambre::displayFilter();

?>
<div class="listArticle">
<?php
if (have_posts()) {
    while (have_posts()) {
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php
            the_post();
            $image_url = get_the_post_thumbnail_url();
            echo '<img src="' . $image_url . '" alt="' . get_the_title() . '">';
            the_title();
            the_excerpt();
            echo '<a href="' . get_permalink() . '">Voir plus</a>';
            ?>
        </article>
        <?php
    }
} else {
    echo 'No posts found.';
}
?>
</div>
<?php

wp_reset_postdata();


?>


<?php echo do_blocks('<!-- wp:template-part {"slug":"footer","area":"footer","tagName":"footer"} /-->'); ?>


</body>