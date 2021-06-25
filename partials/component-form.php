<?php

/**
 * Partial for the single transform page
 * 
 * @package Emertech WordPress theme
 */

?>


<div class="mb-3">
    <label for="name" class="form-label">Nome</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Nome Completo" required>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
</div>
<div class="mb-3">
    <label for="message" class="form-label">Mensagem</label>
    <textarea class="form-control" name="message" id="message" rows="3" placeholder="Deixe aqui a sua mensagem" required></textarea>
</div>
<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" name="privacy" id="privacy">
    <label class="form-check-label" for="privacy" required>Eu aceito a <a href="">Política de Privacidade</a></label>
</div>

<button type="submit" class="btn btn-primary">Enviar</button>