<?php
// Charge la feuille de style du thème parent.
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
    wp_enqueue_style('slickCSS', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');
    wp_enqueue_style('slicktheme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css');
    wp_enqueue_script('slickJS', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), '1.8.1', true);
    wp_enqueue_script('mainJS', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '1.0', true);
    wp_enqueue_style('wp-block-library');
});

// Fonction pour ajouter la section et le champ personnalisé dans le Customizer
function luka_register( $wp_customize ) {
    // Ajoute une nouvelle section dans le Customizer
    $wp_customize->add_section( 'custom_homepage_section', array(
        'title'    => __( 'Contenu personnalisé de la page d\'accueil', 'luka' ),
        'priority' => 30,
    ));

    // Ajoute un champ pour le contenu personnalisé
    $wp_customize->add_setting( 'homepage_custom_content', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control( 'homepage_custom_content_control', array(
        'label'    => __( 'Contenu personnalisé', 'luka' ),
        'section'  => 'custom_homepage_section',
        'settings' => 'homepage_custom_content',
        'type'     => 'textarea',
    ));
}
add_action( 'customize_register', 'luka_register' );

function mytheme_setup() {
    add_theme_support( 'wp-block-styles' );
}
add_action( 'after_setup_theme', 'mytheme_setup' );

function deliver_mail() {
    if ( isset( $_POST['cf-submitted'] ) ) {
        $name    = sanitize_text_field( $_POST["cf-name"] );
        $email   = sanitize_email( $_POST["cf-email"] );
        $message = esc_textarea( $_POST["cf-message"] );
        $to      = get_option( 'lukacourmont0506@gmail.com' );

        $headers = "From: $name <$email>" . "\r\n";

        if ( wp_mail( $to, "Message du site web", $message, $headers ) ) {
            echo '<div>';
            echo '<p>Votre message a été envoyé avec succès.</p>';
            echo '</div>';
        } else {
            echo 'Une erreur est survenue.';
        }
    }
}

add_action( 'wp', 'deliver_mail' );


function mytheme_count_post_views() {
    global $post;
    if(get_post_type($post->ID) == 'chambre') {
        $count_key = 'post_views_count';
        $count = get_post_meta($post->ID, $count_key, true);
        if($count==''){
            delete_post_meta($post->ID, $count_key);
            add_post_meta($post->ID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($post->ID, $count_key, $count);
        }
    }

}
add_action('wp_head', 'mytheme_count_post_views');

// Ajouter une colonne de vues dans le tableau de bord pour les posts de type "chambre"
function mytheme_add_views_column($defaults) {
    $defaults['post_views'] = 'Vues';
    return $defaults;
}
add_filter('manage_chambre_posts_columns', 'mytheme_add_views_column');

function mytheme_display_views($column_name, $post_id) {
    if($column_name === 'post_views'){
        echo (int)get_post_meta($post_id, 'post_views_count', true);
    }
}
add_action('manage_chambre_posts_custom_column', 'mytheme_display_views', 10, 2);