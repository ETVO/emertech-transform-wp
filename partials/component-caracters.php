<?php
/**
 * Partial for the characteristics component
 * 
 * @package Emertech WordPress theme
 */


$taxonomy = "caracter";
$caracters = get_the_terms( get_the_ID(), $taxonomy ) ?? [];

// Get theme mods
$image_max_height = get_transform_term_image_height();
$icon = get_transform_term_icon();
$view_mode_title = get_transform_term_title();

if($caracters):
    $caracters_title = __('Características de Série');
    
    ?>
        <div class="transform-meta-group caracters-group">
            <?php if($caracters_title != ''): ?>
                <div class="title">
                    <h5 class="text-uppercase fw-light">
                        <?php echo $caracters_title; ?>
                    </h5>
                </div>
            <?php endif; ?>
            
            <div class="list-group mb-4">
                <?php
                    foreach($caracters as $caracter):
                        $caracter_name = $caracter->name;
                        $caracter_desc = $caracter->description;
                        $caracter_slug = $caracter->slug;
                        $term_id = $caracter->term_id;
                        $term_image = wp_get_attachment_image_src(get_term_image($term_id));

                        $caracter_id = 'caracter_' . $caracter_slug;
                        $caracter_collapse_id = 'caracter_' . $caracter_slug . 'Collapse';

                        $fields_name = 'caracter';

                        ?>
                            <div class="list-group-item bg-secondary text-light" style="cursor: pointer;" 
                            href="#<?php echo $caracter_collapse_id; ?>"
                            data-bs-toggle="collapse" 
                            role="button" 
                            aria-expanded="false" 
                            aria-controls="<?php echo $caracter_collapse_id; ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>
                                        <?php echo $caracter_name; ?>
                                    </span>
                                        
                                    <?php if($caracter_desc != ''): ?>
                                        <a class="btn btn-primary border-0 rounded-pill py-0 px-1" 
                                        title="<?php echo $view_mode_title; ?>"
                                        href="#<?php echo $caracter_collapse_id; ?>"
                                        data-bs-toggle="collapse" 
                                        role="button" 
                                        aria-expanded="false" 
                                        aria-controls="<?php echo $caracter_collapse_id; ?>">
                                                <span class="bi bi-<?php echo $icon; ?>"></span>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <?php if($caracter_desc != ''): ?>
                                    <div class="collapse" id="<?php echo $caracter_collapse_id; ?>">
                                        <div class="p-2">
                                            <?php if(!empty($term_image)): ?>
                                                <img src="<?php echo $term_image[0]; ?>" alt="" class="pb-2" 
                                                style="max-height: <?php echo $image_max_height; ?>">
                                            <?php endif; ?>
                                            <p class="mb-0">
                                                <?php echo $caracter_desc; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php

                    endforeach;
                ?>
            </div>
        </div>  
    <?php
endif;