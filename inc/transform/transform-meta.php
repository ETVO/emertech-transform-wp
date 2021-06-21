<?php
/**
 * Create Transformations Meta Custom Fields
 * 
 * @package Emertech Transform Plugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta fields for Emertech Transformations
 */
class Emertech_Transform_Meta {

    protected Emertech_Transform_CPT $cpt;

    /**
     * Construct class
     * 
     * @since 1.0
     */
    public function __construct(Emertech_Transform_CPT $cpt = null) {
        if($cpt == null) $cpt = new Emertech_Transform_CPT();
        $this->cpt = $cpt;
        
        $this->register_meta_boxes();
    }

    /**
     * Register all of the meta boxes
     *
     * @since 1.0
     */
    public function register_meta_boxes() {
        $post_type = $this->cpt->get_slug();
        $prefix = "emertech_$post_type";

        add_meta_box(
            $prefix . '_gallery',
            __('Galeria de Fotos'),
            [$this, 'render_meta_gallery'],
            $post_type,
            'normal',
            'default'
        );
        add_action('save_post', [$this, 'save_meta_gallery'], 10, 2);
    }

    /**
     * Render meta box for Gallery
     *
     * @param WP_Post $post
     * @since 1.0
     */
    public function render_meta_gallery(WP_Post $post) {
        
        // Add nonce for security and authentication.
        wp_nonce_field( 'custom_nonce_action', 'transform_gallery_nonce' );
    }

    /**
     * Save meta box for Gallery
     *
     * @param WP_Post $post
     * @param integer $post_id
     * @since 1.0
     */
    public function save_meta_gallery(WP_Post $post, int $post_id) {
        $safe = 'a';
        // Check if the meta box can be saved safely
        if(! $safe = $this->is_save_safe('transform_gallery_nonce', $post_id))
            return;

        echo $safe;
 
        // Sanitize the user input.
        $mydata = sanitize_text_field( $_POST['myplugin_new_field'] );
 
        // Update the meta field.
        update_post_meta( $post_id, '_my_meta_value_key', $mydata );
    }


    public function is_save_safe($custom_nonce_name, $post_id) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST[$custom_nonce_name] ) ? $_POST[$custom_nonce_name] : '';
        $nonce_action = 'custom_nonce_action';

        $safe = true;

        // Check if nonce is valid.
        $safe &= wp_verify_nonce( $nonce_name, $nonce_action );
        $safe &= current_user_can( 'edit_post', $post_id );
        $safe &= ! wp_is_post_autosave( $post_id );
        $safe &= ! wp_is_post_revision( $post_id );
        
        return $safe;
    }

}