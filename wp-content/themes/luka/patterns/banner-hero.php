<?php
/**
 * Title: Hero
 * Slug: twentytwentyfour/banner-hero
 * Categories: banner, call-to-action, featured
 * Viewport width: 1400
 */
?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"layout":{"type":"constrained","contentSize":"","wideSize":""}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
	<!-- wp:group {"style":{"spacing":{"blockGap":"0px"}},"layout":{"type":"constrained","contentSize":"565px"}} -->
	<div class="wp-block-group">

		<!-- wp:heading {"textAlign":"center","fontSize":"x-large","level":1} -->
		<h1 class="wp-block-heading has-text-align-center has-x-large-font-size"><?php echo apply_filters( 'the_content', get_theme_mod( 'homepage_custom_content' ) ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:spacer {"height":"var:preset|spacing|30","style":{"layout":{}}} -->
	<div style="height:var(--wp--preset--spacing--30)" aria-hidden="true" class="wp-block-spacer">
	</div>
	<!-- /wp:spacer -->
    <div class="slider">
        <?php
        $args = array(
            'post_type' => 'chambre',
            'posts_per_page' => -1,
        );
        
        $chambres = get_posts($args);
        
        foreach ($chambres as $chambre) {
            $image_url = get_the_post_thumbnail_url($chambre->ID);
            ?>
            <div class="chambre-card">
                <img src="<?php echo $image_url; ?>" alt="<?php echo get_the_title($chambre->ID); ?>">
                <h2><?php echo get_the_title($chambre->ID); ?></h2>
                <p><?php echo get_the_excerpt($chambre->ID); ?></p>
                <a href="<?php echo get_permalink($chambre->ID); ?>">Voir plus</a>
            </div>

            <?php
        }
        ?>
    </div>

    <div class="chambres-container" style="text-align: center;">
        <a href="index.php/archives/chambres" class="archive-link">Voir toutes les chambres</a>
    </div>
    
</div>
<!-- /wp:group -->
