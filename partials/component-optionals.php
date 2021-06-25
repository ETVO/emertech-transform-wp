<?php
/**
 * Partial for the single transform page
 * 
 * @package Emertech WordPress theme
 */

$taxonomy = "opcional";

$optionals = get_the_terms( get_the_ID(), $taxonomy );


function strip_opcional($term) {
    return array(
        "slug" => $term->slug,
        "name" => $term->name,
        "description" => $term->description,
    );
}

$parents = array();
$grouped_optionals = array();

foreach($optionals as $optional) {

    if($parent = get_term_top_parent($optional, $taxonomy)){
        $parent = strip_opcional($parent);
        $optional = strip_opcional($optional);
        
        
        $parent_slug = $parent['slug'];

        if(!isset($parents[$parent_slug])) {
            $parents[$parent_slug] = array();
        }

        $parents[$parent_slug] = $parent;
    }
    else {
        $parent_slug = '';
    }

    $grouped_optionals[$parent_slug][] = $optional;
}

foreach($parents as $parent):

    $parent_name = $parent['name'];
    $parent_desc = $parent['description'];
    $parent_slug = $parent['slug'];
    if($parent_slug == '') return; 

    $parent_optionals = $grouped_optionals[$parent_slug];

    ?> 
        <div class="optionals-group">

            <?php if($parent_name != ''): ?>
                <div class="title">
                    <h5 class="text-uppercase fw-light">
                        <?php echo $parent_name; ?>
                    </h5>
                </div>
            <?php endif; ?>
            
            <?php if($parent_desc != ''): ?>
                <div class="description">
                    <p>
                        <?php echo $parent_desc; ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if(count($parent_optionals) > 0): ?>
                <div class="list-group mb-4">
                    <?php
                        foreach($parent_optionals as $optional):
                            $optional_name = $optional['name'];
                            $optional_desc = $optional['description'];
                            $optional_slug = $optional['slug'];

                            $optional_id = $optional_slug;
                            $optional_collapse_id = $optional_slug . 'Collapse';

                            $fields_name = 'optionals';

                            $view_mode_title = __("Mais informações");

                            ?>
                                <label class="list-group-item bg-secondary text-light" style="cursor: pointer;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" 
                                            id="<?php echo $optional_slug; ?>" 
                                            value="<?php echo $optional_slug; ?>"
                                            name="<?php echo $fields_name; ?>[]">
                                            
                                            <span>
                                                <?php echo $optional_name; ?>
                                            </span>
                                        </div>
                                            
                                        <?php if($optional_desc != ''): ?>
                                            <a class="btn btn-primary border-0 rounded-pill py-0 px-1" 
                                            href="#<?php echo $optional_collapse_id; ?>"
                                            title="<?php echo $view_mode_title; ?>"
                                            data-bs-toggle="collapse" 
                                            role="button" 
                                            aria-expanded="false" 
                                            aria-controls="<?php echo $optional_collapse_id; ?>">
                                                <span class="bi bi-question"></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <?php if($optional_desc != ''): ?>
                                        <div class="collapse" id="<?php echo $optional_collapse_id; ?>">
                                            <div class="p-2">
                                                <h6 class="mb-0">
                                                    <?php echo $optional_name; ?>
                                                </h6>
                                                <p>
                                                    <?php echo $optional_desc; ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </label>
                            <?php

                        endforeach;
                    ?>
                </div>
            <?php endif; ?>
        </div>
    <?php

endforeach;
?>