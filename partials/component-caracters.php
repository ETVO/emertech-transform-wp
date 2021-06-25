<?php
/**
 * Partial for the characteristics component
 * 
 * @package Emertech WordPress theme
 */


$taxonomy = "caracter";
$caracters = get_the_terms( get_the_ID(), $taxonomy ) ?? [];

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

                        $caracter_id = 'caracter_' . $caracter_slug;
                        $caracter_collapse_id = 'caracter_' . $caracter_slug . 'Collapse';

                        $fields_name = 'caracter';

                        $view_mode_title = __("Mais informações");

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
                                            <span class="bi bi-question"></span>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <?php if($caracter_desc != ''): ?>
                                    <div class="collapse" id="<?php echo $caracter_collapse_id; ?>">
                                        <div class="p-2">
                                            <!-- <h6 class="mb-0">
                                                <?php echo $caracter_name; ?>
                                            </h6> -->
                                            <p>
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