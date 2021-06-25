<?php
/**
 * Partial for the form component
 * 
 * @package Emertech WordPress theme
 */

$name_label = __('Nome');
$name_placeholder = __('Nome Completo');

$email_label = __('Email');
$email_placeholder = __('email@example.com');

$message_label = __('Mensagem');
$message_placeholder = __('Deixe aqui a sua mensagem');

$checkbox_label = __('Eu aceito a Política de Privacidade');

?>

<div class="mb-3">
    <label for="name" class="form-label"><?php echo $name_label; ?></label>
    <input type="text" class="form-control" name="name" id="name" 
    placeholder="<?php echo $name_placeholder; ?>" required>
</div>
<div class="mb-3">
    <label for="email" class="form-label"><?php echo $email_label; ?></label>
    <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email_placeholder; ?>" required>
</div>
<div class="mb-3">
    <label for="message" class="form-label"><?php echo $message_label; ?></label>
    <textarea class="form-control" name="message" id="message" rows="3" placeholder="<?php echo $message_placeholder; ?>" required></textarea>
</div>
<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" name="privacy" id="privacy">
    <label class="form-check-label" for="privacy" required><?php echo $checkbox_label; ?></label>
</div>

<button type="submit" class="btn btn-primary"><?php echo __('Solicitar') ?></button>