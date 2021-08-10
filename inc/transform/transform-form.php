<?php 

/**
 * Setup Form Options and Fields for Transformations
 * 
 * @package Emertech Transform Plugin
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Form Options for Emertech Transformations
 */
class Emertech_Transform_Form {

    /**
     * Get form fields
     *
     * @return array
     */
    public static function get_fields():array {

        $name_field = array(
            'name' => 'name',
            'type' => 'text',
            'label' => __('Nome'),
            'class' => '',
            'placeholder' => __('Nome Completo'),
            'required' => true,
            'attr' => ''
        );
        
        $email_field = array(
            'name' => 'email',
            'type' => 'email',
            'label' => __('Email'),
            'class' => '',
            'placeholder' => __('email@example.com'),
            'required' => true,
            'attr' => ''
        );
        
        $company_field = array(
            'name' => 'company',
            'type' => 'text',
            'label' => __('Empresa ou Instituição'),
            'class' => '',
            'placeholder' => __('Empresa ou Instituição'),
            'required' => true,
            'attr' => ''
        );
        
        $message_field = array(
            'name' => 'message',
            'type' => 'textarea',
            'label' => __('Mensagem'),
            'class' => '',
            'placeholder' => __('Deixe aqui sua mensagem'),
            'required' => false,
            'attr' => ''
        );
        
        $fields = array(
            $name_field,
            $email_field,
            $company_field,
            $message_field
        );

        return $fields;
    }

    /**
     * Render form for front-end
     * ATTENTION: By using this function, the HTML will be directly outputed
     *
     * @param boolean $with_submit_btn Whether or not to render the submit button
     * @return void
     */
    public static function render_form(bool $with_submit_btn = false, bool $show_required = true) {
        $fields = Emertech_Transform_Form::get_fields();
        
        foreach($fields as $field) {

            $is_textarea = $field['type'] == 'textarea';

            if($field):
            ?> 
            <div class="mb-3">

                <label for="<?php echo $field['name']; ?>" class="form-label" <?php if($field['required']) echo 'title="' . __('Campo obrigatório') . '"'; ?>>
                    <?php echo $field['label']; ?><?php if($show_required && $field['required']) echo '<span class="text-primary">*</span>'; ?>
                </label>

                <?php if($is_textarea) { ?>
                    <textarea 
                    rows="3"
                <?php } else { ?>
                    <input 
                    type="<?php echo $field['type'] ?>" 
                <?php } ?>
                    class="form-control <?php echo $field['class'] ?>" 
                    name="<?php echo $field['name'] ?>" 
                    id="<?php echo $field['name'] ?>" 
                    placeholder="<?php echo $field['placeholder'] ?>" 
                    <?php if($field['required']) echo "required"; ?>
                    <?php echo $field['attr']; ?>><?php if($is_textarea) { ?></textarea><?php } ?>
            
            </div>
            <?php
            endif;
        }

        if($with_submit_btn) {
            $submit_text = get_theme_mod('emertech_transform_form_submit', __('Solicitar'));
            ?>
                <button type="submit" name="submitTransformForm" class="btn btn-primary"><?php echo $submit_text; ?></button>
            <?php
        }
    }

}

?>