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

        add_action('opcional_add_form_fields', [$this, 'add_form_field_term_meta']);
        add_action('opcional_edit_form_fields', [$this, 'edit_form_field_term_meta']);

        add_action('caracter_add_form_fields', [$this, 'add_form_field_term_meta']);
        add_action('caracter_edit_form_fields', [$this, 'edit_form_field_term_meta']);

        add_action('edit_opcional', [$this, 'save_term_meta']);
        add_action('create_opcional', [$this, 'save_term_meta']);

        add_action('edit_caracter', [$this, 'save_term_meta']);
        add_action('create_caracter', [$this, 'save_term_meta']);
    }

    public static function register_opcional_meta()
    {
        register_meta('opcional', 'term_image', 'sanitize_term_image');
        register_meta('opcional', 'term_order', 'sanitize_term_order');
    }

    public static function register_caracter_meta()
    {
        register_meta('caracter', 'term_image', 'sanitize_term_image');
        register_meta('opcional', 'term_order', 'sanitize_term_order');
    }

    public static function sanitize_term_image($value)
    {
        return $value;
    }

    public static function add_form_field_term_image()
    {
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

    /** ------ ORDER ------ */

    public static function sanitize_term_order($value)
    {
        return $value;
    }

    public static function add_form_field_term_order()
    {
        ?>
        <div class="form-field term-order-wrap">
            <label for="term-order">
                <?php _e('Ordem'); ?>
            </label>
            <input type="number" value="0" name="term_order" id="term-order" class="emertech-order-input">
        </div>
    <?php
    }

    public static function edit_form_field_term_order($term)
    {

        $order  = get_term_order($term->term_id);

        ?>
            <tr class="form-field term-order-wrap">
                <th scope="row">
                    <label for="term-order">
                        <?php _e('Ordem'); ?>
                    </label>
                </th>
                <td>
                    <input type="number" name="term_order" id="term-order" 
                    class="emertech-order-input" value="<?php echo $order; ?>">
                </td>
            </tr>
        <?php
    }

    public function save_term_order($term_id)
    {
        $old_value  = get_term_order($term_id);

        $new_value = isset($_POST['term_order'])
            ? $this->sanitize_term_order($_POST['term_order'])
            : '';

        // If the new value is empty (and the old value is not), delete it
        if ($old_value && '' === $new_value)
            delete_term_meta($term_id, 'term_order');

        // If the new value is different than the old value, update it
        else if ($old_value !== $new_value)
            update_term_meta($term_id, 'term_order', $new_value);
    }

    /** ------ ADD, EDIT & SAVE META ------ */

    public function add_form_field_term_meta()
    {
        wp_nonce_field('emertech_term_meta_nonce', 'emertech_term_meta_nonce');

        $this->add_form_field_term_image();
        $this->add_form_field_term_order();
    }

    public function edit_form_field_term_meta($term)
    {
        wp_nonce_field('emertech_term_meta_nonce', 'emertech_term_meta_nonce');

        $this->edit_form_field_term_image($term);
        $this->edit_form_field_term_order($term);
    }

    public function save_term_meta($term_id)
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

        $this->save_term_image($term_id);
        $this->save_term_order($term_id);
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

if (!function_exists('get_term_order')) {
    function get_term_order($term_id)
    {
        $value = get_term_meta($term_id, 'term_order', true);
        $value = Emertech_Transform_Term_Meta::sanitize_term_order($value);
        return $value;
    }
}
