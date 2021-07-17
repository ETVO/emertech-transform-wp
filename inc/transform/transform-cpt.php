<?php

/**
 * Setup Transformations Custom Post Type
 * 
 * @package Emertech Transform Plugin
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom Post Type for Emertech Transformations
 */
class Emertech_Transform_CPT
{

    protected $slug;

    /**
     * Construct class
     * 
     * @since 1.0
     */
    public function __construct(string $slug = 'transform')
    {
        $this->set_slug($slug);

        $this->register_cpt_transform();
    }

    /**
     * Register custom post type
     *
     * @since 1.0
     */
    public function register_cpt_transform()
    {

        $slug = $this->get_slug();
        $args = $this->get_args();

        register_post_type($slug, $args);

        
        $this->register_tipo_for_cpt();
        $this->register_opcional_for_cpt();
        $this->register_caracteristica_for_cpt();

        new Emertech_Transform_Term_Meta();
    }

    /**
     * Register taxonomy for custom post type
     *
     * @return void
     */
    public function register_tipo_for_cpt()
    {
        $taxonomy_slug = 'tipo';
        $post_type = $this->get_slug();

        $labels = array(
            'name'                          => __('Tipos'),
            'singular_name'                 => __('Tipo'),
            'search_items'                  => __('Pesquisar tipos'),
            'popular_items'                 => __('Tipos populares'),
            'all_items'                     => __('Todos os tipos'),
            'parent_items'                  => __('Tipos superiores'),
            'parent_item_colon'             => __('Tipos superiores:'),
            'edit_item'                     => __('Editar tipo'),
            'view_item'                     => __('Ver tipo'),
            'update_item'                   => __('Actualizar tipo'),
            'add_new_item'                  => __('Adicionar novo tipo'),
            'new_item_name'                 => __('Novo tipo'),
            'separate_items_with_commas'    => __('Separar tipos com vírgulas'),
            'add_or_remove_items'           => __('Adicionar ou remover tipo'),
            'choose_from_most_used'         => __('Escolher dos tipos mais usados'),
            'not_found'                     => __('Nenhum tipo encontrado'),
            'no_terms'                      => __('Sem tipo'),
            'filter_by_item'                => __('Filtrar por tipo'),
            'back_to_items'                 => __('Voltar aos tipos'),
        );

        register_taxonomy(
            $taxonomy_slug,
            $post_type,
            array(
                'labels'                => $labels,
                'description'           => __('Tipos de Veículos transformados'),
                'public'                => true,
                'hierarchical'          => true,
                'show_in_rest'          => true,
                'show_admin_column'     => true,
                // 'meta_box_cb'           => [$this, ''],
                'rewrite'               => array('slug' => $taxonomy_slug, 'with_front' => false),
                'sort'                  => true
            )
        );
    }

    public function register_opcional_for_cpt()
    {
        $post_type = $this->get_slug();

        /**
         * taxonomy_slug
         * The same value is used in a filter at the end of the function 
         * (must be changed in both places if necessary)
         */ 
        $taxonomy_slug = 'opcional'; 

        $labels = array(
            'name'                          => __('Opcionais'),
            'singular_name'                 => __('Opcional'),
            'search_items'                  => __('Pesquisar opcionais'),
            'popular_items'                 => __('Opcionais populares'),
            'all_items'                     => __('Todos os opcionais'),
            'parent_items'                  => __('Opcionais superiores'),
            'parent_item_colon'             => __('Opcionais superiores:'),
            'edit_item'                     => __('Editar opcional'),
            'view_item'                     => __('Ver opcional'),
            'update_item'                   => __('Actualizar opcional'),
            'add_new_item'                  => __('Adicionar novo opcional'),
            'new_item_name'                 => __('Novo opcional'),
            'separate_items_with_commas'    => __('Separar opcionais com vírgulas'),
            'add_or_remove_items'           => __('Adicionar ou remover opcional'),
            'choose_from_most_used'         => __('Escolher dos opcionais mais usados'),
            'not_found'                     => __('Nenhum opcional encontrado'),
            'no_terms'                      => __('Sem opcionais'),
            'filter_by_item'                => __('Filtrar por opcional'),
            'back_to_items'                 => __('Voltar aos opcionais'),
        );

        register_taxonomy(
            $taxonomy_slug,
            $post_type,
            array(
                'labels'                => $labels,
                'description'           => __('Opcionais das transformações'),
                'public'                => true,
                'hierarchical'          => true,
                'show_in_rest'          => true,
                'show_admin_column'     => true,
                // 'meta_box_cb'           => [$this, ''],
                'rewrite'               => array('slug' => $taxonomy_slug, 'with_front' => false),
                'sort'                  => false
            )
        );
    }

    public function register_caracteristica_for_cpt()
    {
        $post_type = $this->get_slug();

        /**
         * taxonomy_slug
         * The same value is used in a filter at the end of the function 
         * (must be changed in both places if necessary)
         */ 
        $taxonomy_slug = 'caracter'; 

        $labels = array(
            'name'                          => __('Características'),
            'singular_name'                 => __('Característica'),
            'search_items'                  => __('Pesquisar características'),
            'popular_items'                 => __('Características populares'),
            'all_items'                     => __('Todas as características'),
            'parent_items'                  => __('Características superiores'),
            'parent_item_colon'             => __('Características superiores:'),
            'edit_item'                     => __('Editar característica'),
            'view_item'                     => __('Ver característica'),
            'update_item'                   => __('Actualizar característica'),
            'add_new_item'                  => __('Adicionar nova característica'),
            'new_item_name'                 => __('Nova característica'),
            'separate_items_with_commas'    => __('Separar características com vírgulas'),
            'add_or_remove_items'           => __('Adicionar ou remover característica'),
            'choose_from_most_used'         => __('Escolher das características mais usadas'),
            'not_found'                     => __('Nenhum característica encontrada'),
            'no_terms'                      => __('Sem características'),
            'filter_by_item'                => __('Filtrar por característica'),
            'back_to_items'                 => __('Voltar às características'),
        );

        register_taxonomy(
            $taxonomy_slug,
            $post_type,
            array(
                'labels'                => $labels,
                'description'           => __('Características das transformações'),
                'public'                => true,
                'hierarchical'          => true,
                'show_in_rest'          => true,
                'show_admin_column'     => true,
                // 'meta_box_cb'           => [$this, ''],
                'rewrite'               => array('slug' => $taxonomy_slug, 'with_front' => false),
                'sort'                  => true
            )
        );
    }

    /**
     * Register all custom meta fields of 
     * the custom post type *transform*
     *
     * @param WP_Post $post
     * @since 1.0
     */
    public function register_meta_box_transform()
    {
        new Emertech_Transform_Meta($this);   
    }

    /**
     * Set slug of custom post type *transform*
     *
     * @param string $slug
     * @since 1.0
     */
    protected function set_slug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug of custom post type *transform*
     *
     * @return string
     * @since 1.0
     */
    public function get_slug(): string
    {
        return $this->slug;
    }

    /**
     * Get custom post type *transform* array of arguments
     *
     * @return array
     * @since 1.0
     */
    public function get_args(): array
    {
        $slug = $this->get_slug();

        $labels = array(
            'name'                      => __('Transformações'),
            'singular_name'             => __('Transformação'),
            'menu_name'                 => __('Transformações'),
            'name_admin_bar'            => __('Transformação'),
            'add_new'                   => __('Adicionar Nova'),
            'add_new_item'              => __('Adicionar nova transformação'),
            'new_item'                  => __('Nova transformação'),
            'edit_item'                 => __('Editar transformação'),
            'view_item'                 => __('Ver transformação'),
            'view_items'                => __('Ver transformações'),
            'all_items'                 => __('Todas as transformações'),
            'search_items'              => __('Pesquisar transformações'),
            'parent_items'              => __('Transformações superiores'),
            'parent_item_colon'         => __('Transformações superiores:'),
            'not_found'                 => __('Nenhuma transformação encontrada'),
            'not_found_in_trash'        => __('Nenhuma transformação encontrada na lixeira'),
            'featured_image'            => __('Imagem em destaque'),
            'set_featured_image'        => __('Definir imagem em destaque'),
            'remove_featured_image'     => __('Remover imagem em destaque'),
            'use_featured_image'        => __('Usar como imagem em destaque'),
            'archives'                  => __('Catálogo de transformações'),
            'insert_into_item'          => __('Inserir em transformação'),
            'uploaded_to_this_item'     => __('Carregado nesta transformação'),
            'filter_items_list'         => __('Filtrar transformações'),
            'items_list_navigation'     => __('Navegação por transformações'),
            'items_list'                => __('Lista de transformações'),
            'items_published'           => __('Transformação publicada'),
            'items_published_protectedly' => __('Transformação publicada em privado'),
            'item_reverted_to_draft'    => __('Transformação revertida a rascunho'),
            'item_updated'              => __('Transformação actualizada'),
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
            'label'                 => __('Transformações'),
            'labels'                => $labels,
            'description'           => __('Transformações de veículos realizadas pela Emertech'),
            'public'                => true,
            'show_in_rest'          => true,
            'hierarchical'          => false,
            'menu_position'         => 31,
            'menu_icon'             => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f0f6fc99" class="bi bi-hammer" viewBox="0 0 16 16"><path d="M9.972 2.508a.5.5 0 0 0-.16-.556l-.178-.129a5.009 5.009 0 0 0-2.076-.783C6.215.862 4.504 1.229 2.84 3.133H1.786a.5.5 0 0 0-.354.147L.146 4.567a.5.5 0 0 0 0 .706l2.571 2.579a.5.5 0 0 0 .708 0l1.286-1.29a.5.5 0 0 0 .146-.353V5.57l8.387 8.873A.5.5 0 0 0 14 14.5l1.5-1.5a.5.5 0 0 0 .017-.689l-9.129-8.63c.747-.456 1.772-.839 3.112-.839a.5.5 0 0 0 .472-.334z"/></svg>'),
            'capability_type'       => 'page',
            'supports'              => $supports,
            // 'register_meta_box_cb'  => [$this, "register_meta_box_transform"],
            // 'taxonomies'            => array('category'),
            'has_archive'           => true,
            'rewrite'               => array('slug' => $slug, 'with_front' => false),
        );

        return $args;
    }
}

require_once 'transform-meta.php';
require_once 'transform-term-meta.php';
new Emertech_Transform_CPT();
