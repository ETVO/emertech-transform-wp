<?php

/**
 * Create Taxonomy Meta Custom Fields
 * 
 * @package Emertech Transform Plugin
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Setup Meta Box for Emertech Transformations
 */
class Emertech_Transform_Term_Meta
{

    /**
     * Hook into the appropriate actions when the class is constructed.
     * 
     * @since 2.0
     */
    public function __construct()
    {
        add_action('init', [$this, 'register_opcional_meta']);
        add_action('init', [$this, 'register_caracter_meta']);

        add_action('opcional_add_form_fields', [$this, 'add_form_field_term_image']);
        add_action('opcional_edit_form_fields', [$this, 'edit_form_field_term_image']);

        add_action('caracter_add_form_fields', [$this, 'add_form_field_term_image']);
        add_action('caracter_edit_form_fields', [$this, 'edit_form_field_term_image']);

        add_action('edit_opcional', [$this, 'save_term_image']);
        add_action('create_opcional', [$this, 'save_term_image']);

        add_action('edit_caracter', [$this, 'save_term_image']);
        add_action('create_caracter', [$this, 'save_term_image']);
    }

    public static function register_opcional_meta()
    {
        register_meta('opcional', 'term_image', 'sanitize_term_image');
    }

    public static function register_caracter_meta()
    {
        register_meta('caracter', 'term_image', 'sanitize_term_image');
    }

    public static function sanitize_term_image($value)
    {
        return $value;
    }

    public static function add_form_field_term_image()
    {

        wp_nonce_field('emertech_term_meta_nonce', 'emertech_term_meta_nonce');
?>
        <div class="form-field term-image-wrap">
            <label for="term-image">
                <?php _e('Imagem'); ?>
            </label>
            <div class="emertech-image-preview">
            </div>
            <div class="button-container">
                <button type="button" class="emertech-image-upload button action">
                    <?php _e('Selecionar Imagem') ?>
                </button>
                <button type="button" href="#" class="emertech-image-remove button danger" style="display: none;">
                    <?php _e('Remover Imagem') ?>
                </button>
            </div>
            <input type="hidden" name="term_image" id="term-image" class="emertech-image-input">
        </div>
        <?php
    }

    public static function edit_form_field_term_image($term)
    {

        $image_id  = get_term_image($term->term_id);

        wp_nonce_field('emertech_term_meta_nonce', 'emertech_term_meta_nonce');

        if ($image = wp_get_attachment_image_src($image_id)) {
            print_r($image);
        ?>
            <tr class="form-field term-image-wrap">
                <th scope="row">
                    <label for="term-image">
                        <?php _e('Imagem'); ?>
                    </label>
                </th>
                <td>
                    <div class="emertech-image-preview">
                        <img src="<?php echo $image[0]; ?>" alt="">
                    </div>
                    <div class="button-container">
                        <button type="button" class="emertech-image-upload button action">
                            <?php _e('Selecionar Imagem') ?>
                        </button>
                        <button type="button" href="#" class="emertech-image-remove button danger">
                            <?php _e('Remover Imagem') ?>
                        </button>
                    </div>
                    <input type="hidden" name="term_image" id="term-image" class="emertech-image-input" value="<?php echo $image_id; ?>">
                </td>
            </tr>
        <?php

        } else {
        ?>
            <tr class="form-field term-image-wrap">
                <th scope="row">
                    <label for="term-image">
                        <?php _e('Imagem'); ?>
                    </label>
                </th>
                <td>
                    <div class="emertech-image-preview">
                    </div>
                    <div class="button-container">
                        <button type="button" class="emertech-image-upload button action">
                            <?php _e('Selecionar Imagem') ?>
                        </button>
                        <button type="button" href="#" class="emertech-image-remove button is-destructive" style="display: none;">
                            <?php _e('Remover Imagem') ?>
                        </button>
                    </div>
                    <input type="hidden" name="term_image" id="term-image" class="emertech-image-input">
                </td>
            </tr>
<?php
        }
    }

    public function save_term_image($term_id)
    {
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set
        if (!isset($_POST['emertech_term_meta_nonce'])) {
            return $term_id;
        }

        $nonce = $_POST['emertech_term_meta_nonce'];

        // Verify that the nonce is valid
        if (!wp_verify_nonce($nonce, 'emertech_term_meta_nonce')) {
            return $term_id;
        }

        $old_value  = get_term_image($term_id);

        $new_value = isset($_POST['term_image'])
            ? $this->sanitize_term_image($_POST['term_image'])
            : '';

        // If the new value is empty (and the old value is not), delete it
        if ($old_value && '' === $new_value)
            delete_term_meta($term_id, 'term_image');

        // If the new value is different than the old value, update it
        else if ($old_value !== $new_value)
            update_term_meta($term_id, 'term_image', $new_value);
    }
}


if (!function_exists('get_term_image')) {
    function get_term_image($term_id)
    {
        $value = get_term_meta($term_id, 'term_image', true);
        $value = Emertech_Transform_Term_Meta::sanitize_term_image($value);
        return $value;
    }
}
