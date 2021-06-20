<?php
/**
 * Setup Transformations Custom Post Type
 * 
 * @package Emertech Transform Plugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Post Type for Emertech Transformations
 */
class Emertech_Transform_CPT {

    private string $slug;

    /**
     * Construct class
     * 
     * @since 1.0
     */
    public function __construct() {
        
        $this->register_cpt_transform();
    }

    /**
     * Register custom post type *transform*
     *
     * @since 1.0
     */
    public function register_cpt_transform() {
        $slug = 'transform';
        $this->set_slug($slug);
        
        $args = $this->get_args();
        
        register_post_type($slug, $args);
    }

    /**
     * Callback to register all custom meta fields of 
     * the custom post type *transform*
     *
     * @since 1.0
     */
    public function register_meta_box_transform() {
        echo "test";
    }

    /**
     * Set slug of custom post type *transform*
     *
     * @param string $slug
     * @since 1.0
     */
    private function set_slug(string $slug) {
        $this->slug = $slug;
    }

    /**
     * Get slug of custom post type *transform*
     *
     * @return string
     * @since 1.0
     */
    public function get_slug():string {
        return $this->slug;
    }

    /**
     * Get custom post type *transform* array of arguments
     *
     * @return array
     * @since 1.0
     */
    private function get_args():array {
        $slug = $this->get_slug();

        $labels = array(
            'name'                      => __( 'Transformações' ),
            'singular_name'             => __( 'Transformação' ),
            'menu_name'                 => __( 'Transformações' ),
            'name_admin_bar'            => __( 'Transformação' ),
            'add_new'                   => __( 'Adicionar Nova' ),
            'add_new_item'              => __( 'Adicionar Nova Transformação' ),
            'new_item'                  => __( 'Nova Transformação' ),
            'edit_item'                 => __( 'Editar Transformação' ),
            'view_item'                 => __( 'Ver Transformação' ),
            'all_items'                 => __( 'Todas as Transformações' ),
            'search_items'              => __( 'Pesquisar Transformações' ),
            'parent_item_colon'         => __( 'Transformações mãe:' ),
            'not_found'                 => __( 'Nenhuma transformação encontrada' ),
            'not_found_in_trash'        => __( 'Nenhuma transformação encontrada na lixeira' ),
            'featured_image'            => __( 'Imagem em destaque' ),
            'set_featured_image'        => __( 'Definir imagem em destaque' ),
            'remove_featured_image'     => __( 'Remover imagem em destaque' ),
            'use_featured_image'        => __( 'Usar como imagem em destaque' ),
            'archives'                  => __( 'Catálogo de Transformações' ),
            'insert_into_item'          => __( 'Inserir em Transformação' ),
            'uploaded_to_this_item'     => __( 'Carregado nesta Transformação' ),
            'filter_items_list'         => __( 'Filtrar Transformações' ),
            'items_list_navigation'     => __( 'Navegação por Transformações' ),
            'items_list'                => __( 'Lista de Transformações' ),
            'items_published'           => __( 'Transformação publicada' ),
            'items_published_privately' => __( 'Transformação publicada em privado' ),
            'item_reverted_to_draft'    => __( 'Transformação revertida a rascunho' ),
            'item_updated'              => __( 'Transformação actualizada' ),
        );

        $supports = array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'custom-fields',
            'revisions',
            'page-attributes'
        );

        $args = array(
            'label'                 => __( 'Transformações' ),
            'labels'                => $labels,
            'description'           => __( 'Transformações de veículos realizadas pela Emertech' ),
            'public'                => true,
            'show_in_admin_bar'     => true,
            'hierarchical'          => false,
            'menu_position'         => null,
            'menu_icon'             => 'dashicons-video-alt',  # a little space to trick it into using bootstrap-icons
            'capability_type'       => array($slug),
            'supports'              => $supports,
            // 'register_meta_box_cb'  => [$this, "register_meta_box_transform"],
            'taxonomies'            => array('category'),
            'has_archive'           => true,
            'rewrite'               => array('slug' => $slug, 'with_front' => false),
        );

        return $args;
    }
}

new Emertech_Transform_CPT();