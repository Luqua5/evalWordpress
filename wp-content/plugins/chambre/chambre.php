<?php
require_once(ABSPATH . 'wp-content/plugins/acf-codifier/vendor/autoload.php');

use Geniem\ACF\Group;
use Geniem\ACF\RuleGroup;
use Geniem\ACF\Field\Text;
use Geniem\ACF\Field\Number;

/*
Plugin Name: Chambre
Plugin URI: https://chambre.com/
Description: Gestion des chambres
Version: 1.0
Author: Luka
Author URI: https://luka.com/
License: GPLv2 or later
Text Domain: chambre
*/

class Chambre
{
    public function __construct()
    {
        add_action('init', [$this, 'create_post_type']);
        add_action('init', [$this, 'acf_codifier_field_group']);
        add_action('init', [$this, 'add_taxonomy']);
        add_action('pre_get_posts', [$this, 'pre_get_posts']);
    }

    public function create_post_type()
    {
        register_post_type('chambre', [
            'labels' => [
                'name' => 'Chambres',
                'singular_name' => 'Chambre',
                'add_new' => 'Ajouter',
                'add_new_item' => 'Ajouter une chambre',
                'edit_item' => 'Modifier la chambre',
                'new_item' => 'Nouvelle chambre',
                'view_item' => 'Voir la chambre',
                'search_items' => 'Rechercher parmi les chambres',
                'not_found' => 'Pas de chambre trouvé',
                'not_found_in_trash' => 'Pas de chambre dans la corbeille'
            ],
            'public' => true,
            'hierarchical' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'comments', 'excerpt', 'custom-fields'],
            'menu_position' => 5,
            'menu_icon' => 'dashicons-admin-home',
            'rewrite' => [
                'slug' => 'chambres'
            ]
        ]);
    }

    public function acf_codifier_field_group()
    {
        $field_group = new Group('groupe_champ');
        $field_group->set_title('Chambre');
        $field_group->set_key('chambre');

        $field1 = new Number('nombre_couchage');
        $field1->set_label('Nombre de couchage');
        $field1->set_required();

        //prix indicatif
        $field2 = new Number('prix_indicatif');
        $field2->set_label('Prix indicatif');
        $field2->set_required();



        $field_group->add_field($field1);
        $field_group->add_field($field2);

        $rule_group = new RuleGroup();
        $rule_group->add_rule( 'post_type', '==', 'chambre' );
        $field_group->add_rule_group( $rule_group );

        $field_group->register();
    }


    public function add_taxonomy()
    {
        register_taxonomy('type_lit', 'chambre', [
            'labels' => [
                'name' => 'Type de lit',
                'singular_name' => 'Type de lit',
                'search_items' => 'Rechercher parmi les types de lit',
                'all_items' => 'Tous les types de lit',
                'edit_item' => 'Editer le type de lit',
                'update_item' => 'Mettre à jour le type de lit',
                'add_new_item' => 'Ajouter un nouveau type de lit',
                'new_item_name' => 'Nouveau type de lit',
                'menu_name' => 'Type de lit'
            ],
            'hierarchical' => true,
            'show_admin_column' => true
        ]);

        register_taxonomy('gamme_tarif', 'chambre', [
            'labels' => [
                'name' => 'Gamme de tarif',
                'singular_name' => 'Gamme de tarif',
                'search_items' => 'Rechercher parmi les gammes de tarif',
                'all_items' => 'Toutes les gammes de tarif',
                'edit_item' => 'Editer la gamme de tarif',
                'update_item' => 'Mettre à jour la gamme de tarif',
                'add_new_item' => 'Ajouter une nouvelle gamme de tarif',
                'new_item_name' => 'Nouvelle gamme de tarif',
                'menu_name' => 'Gamme de tarif'
            ],
            'hierarchical' => true,
            'show_admin_column' => true
        ]);
    }

    public static function displayFilter()
    {
        require_once(ABSPATH . 'wp-content/plugins/chambre/templates/filter.php');
    }

    public function pre_get_posts($query)
    {
        if (is_admin() || !$query->is_main_query()) {
            return;
        }

        if ($query->is_post_type_archive('chambre')) {
            // Récupérez les valeurs du formulaire
            $prix_max = $_POST['prix'] ?? 999999;
            $couchage_min = $_POST['couchage'] ?? 0;


            $query->set('meta_query', [
                'relation' => 'AND',
                [
                    'key' => 'prix_indicatif',
                    'value' => $prix_max,
                    'compare' => '<=',
                    'type' => 'NUMERIC'
                ],
                [
                    'key' => 'nombre_couchage',
                    'value' => $couchage_min,
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                ]
            ]);

        }

    }
}

new Chambre();