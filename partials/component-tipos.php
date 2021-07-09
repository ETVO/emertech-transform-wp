<?php
/**
 * Partial for the categories component
 * 
 * @package Emertech WordPress theme
 */

$tipos = get_terms(array('taxonomy' => 'tipo'));

$set_term_slug = '';
if(isset($_GET['tipo'])) {
    $set_term_slug = $_GET['tipo'];
}

$show_reset_btn = true;
$reset_btn_label = __("Limpar");

$select_label = get_theme_mod( 'emertech_transform_strings_filter' );
if($select_label == '') $select_label = __('Filtrar por tipo');

?>

<span class="tipo d-flex align-items-center">
    <select class="form-select d-inline-block text-dark text-uppercase" id="filterTipo" style="cursor: pointer">
        <option value="" selected><?php echo $select_label; ?></option>
    <?php 
        foreach($tipos as $tipo):
    ?>
        <option value="<?php echo $tipo->slug ?>" <?php if($tipo->slug == $set_term_slug) echo 'selected'; ?>><?php echo $tipo->name; ?></option>
    <?php 
        endforeach; 
    ?>
    </select>
        <?php
        // Add reset button for the user to clear category selection
        if($show_reset_btn && count($tipos) > 0 && $set_term_slug != ""):
    ?>
        <a class="tipo-reset me-3 order-first d-none d-md-block" href="?" title="<?php echo $reset_btn_label; ?>" aria-label="<?php echo $reset_btn_label; ?>">
            <span class="bi bi-arrow-counterclockwise"></span>
        </a>
    <?php endif; ?>
    
</span>

<script>
    var select = document.getElementById('filterTipo');

    select.onchange = (e) => {
        var value = select.value;
        window.location.href = "?tipo=" + value;
    };

</script>