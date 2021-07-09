<?php
/**
 * Archive transform (Transformação) page template
 * 
 * @package Emertech WordPress theme
 */

    get_header();

    $catalog_title = get_theme_mod( 'emertech_transform_strings_catalog_title' );
    if($catalog_title == '') $catalog_title = __('Transformações');
?>


<div id="loadingContainer">
    <div class="m-auto text-center">
        <div class="loader m-auto" id="spinner"></div>
        <!-- <h6 class="fw-light m-auto mt-2">Carregando...</h6> -->
    </div>
</div>  

<div class="search-results-wrap py-2 py-md-4 position-relative">

    <div class="container">
        <div class="m-auto px-4 px-md-0">
            <div class="heading d-flex align-items-center mb-3 flex-column flex-md-row">
                <div class="title mb-0 d-flex align-items-center">
                    <div class="title">
                        <h2><?php echo $catalog_title; ?></h2>
                    </div>
                </div>
                <div class="form mx-auto me-md-0">
                    <div class="categories">
                        <?php get_transform_template_part("partials/component-tipos"); ?>
                    </div>
                    <?php #get_search_form(); ?>
                </div>
            </div>
            <div class="results">
                <?php get_transform_template_part('partials/page-archive-transform'); ?>
            </div>
        </div>
    </div>
</div>

<?php

get_footer();