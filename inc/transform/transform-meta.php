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
        
        // Register all of the meta data
        // $this->register_meta_boxes();

        // Enqueue JS files with rendering for the meta boxes
        // add_action('admin_enqueue_scripts', [$this, 'enqueue_boxes_js'] );
    }

    /**
     * Register all of the meta boxes
     *
     * @since 1.0
     */
    public function register_meta_boxes() {
        $post_type = $this->cpt->get_slug();
        $prefix = "_$post_type";
        
        register_post_meta( 
            $post_type, 
            $prefix . '_gallery', 
            array(
                'description'   => __('Galeria de fotos da transformação'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => [$this, 'sanitize_array_value'] // Type is string, but we use it as an array 
            ) 
        );
    }

    /**
     * Sanitize string to use as array
     *
     * @param string $meta_value
     * @param string $meta_key
     * @param string $meta_type
     * 
     * @since 1.0
     */
    public function sanitize_array_value(string $meta_value, string $meta_key, string $meta_type) {
        return serialize( json_decode( $meta_value ) );
    }
    
    /**
     * Enqueue boxes rendering scripts (that use JSX)
     *
     * @since 1.0
     */
    public function enqueue_boxes_js() {

        $dir = EMERTECH_TRANSFORM_JS_URL;

        wp_enqueue_script(
            'emertech-transform-boxes-scripts',
            $dir . 'boxes.js',
            [ 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ],
            null,
            true
        );
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