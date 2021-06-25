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
 * Setup Meta Box for Emertech Transformations
 */
class Emertech_Transform_Meta {
 
    /**
     * Hook into the appropriate actions when the class is constructed.
     * 
     * @since 1.0
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post',      array( $this, 'save'         ) );
    }
 
    /**
     * Adds the meta box container.
     * 
     * @since 1.0
     */
    public function add_meta_box( $post_type ) {
        // Limit meta box to certain post types.
        $post_types = array( 'post', 'page' );
        
        $box_label = __('Opcionais para esta transformação');
        if ( $post_type == 'transform' ) {
            add_meta_box(
                'emertech_transform_optionals',
                $box_label,
                array( $this, 'render_meta_box_content' ),
                $post_type,
                'advanced',
                'high'
            );
        }
    }
 
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     * @since 1.0
     */
    public function render_meta_box_content( WP_Post $post ) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'emertech_transform_nonce', 'emertech_transform_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta( $post->ID, 'et_transform_optionals', true );
        
        // Display the form, using the current value.
        ?>
        <label for="et_transform_optionals" style="display: block;">
            <?php _e( 'Opcionais'); ?>
        </label>
        <input type="text" id="et_transform_optionals" name="et_transform_optionals" value="<?php echo esc_attr( $value ); ?>" size="25" />
        <?php
    }
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     * @since 1.0
     */
    public function save( int $post_id ) {
    
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */
    
        // Check if our nonce is set.
        if ( ! isset( $_POST['emertech_transform_nonce'] ) ) {
            return $post_id;
        }
    
        $nonce = $_POST['emertech_transform_nonce'];
    
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'emertech_transform_nonce' ) ) {
            return $post_id;
        }
    
        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
    
        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'transform' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }
    
        /* OK, now it's safe for us to save the data. */

        if( isset( $_POST['et_transform_optionals'] ) ) {
            // Sanitize the user input.
            $value = sanitize_text_field( $_POST['et_transform_optionals'] );
        
            // Update the meta field.
            update_post_meta( $post_id, 'et_transform_optionals', $value );
        }
    
    }
}