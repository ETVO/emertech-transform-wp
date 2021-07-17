<?php
/**
 * Partial for the optionals component
 * 
 * @package Emertech WordPress theme
 */


$taxonomy = "opcional";
$optionals = get_the_terms( get_the_ID(), $taxonomy );

// Get theme mods
$image_max_height = get_transform_term_image_height();
$icon = get_transform_term_icon();
$view_mode_title = get_transform_term_title();

$parents = array();
$grouped_optionals = array();

if($optionals):

foreach($optionals as $optional) {

    if($parent = get_term_top_parent($optional, $taxonomy)){
        // Deprecated: was used to make term into an array to save space (now it's unnecessary and inefficient)
        // $parent = transform_strip_term($parent);
        // $optional = transform_strip_term($optional);
        
        $parent_slug = $parent->slug;

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

usort($parents, function($t1, $t2) {
    $a = get_term_order($t1->term_id);
    $b = get_term_order($t2->term_id);

    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
});

foreach($parents as $parent):
    
    $parent_name = $parent->name;
    $parent_desc = $parent->description;
    $parent_slug = $parent->slug;
    if($parent_slug == '') return; 

    $parent_optionals = $grouped_optionals[$parent_slug];

    ?> 
        <div class="transform-meta-group optionals-group">

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
                <div class="list-group">
                    <?php
                        foreach($parent_optionals as $optional):
                            $optional_name = $optional->name;
                            $optional_desc = $optional->description;
                            $optional_slug = $optional->slug;
                            $term_id = $optional->term_id;
                            $term_image = wp_get_attachment_image_src(get_term_image($term_id));
                            
                            $optional_id = $optional_slug;
                            $optional_collapse_id = $optional_slug . 'Collapse';

                            $fields_name = 'optionals';

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
                                                <span class="bi bi-<?php echo $icon; ?>"></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <?php if($optional_desc != ''): ?>
                                        <div class="collapse" id="<?php echo $optional_collapse_id; ?>">
                                            <div class="p-2">
                                                <?php if(!empty($term_image)): ?>
                                                    <img src="<?php echo $term_image[0]; ?>" alt="" class="pb-2" 
                                                    style="max-height: <?php echo $image_max_height; ?>">
                                                <?php endif; ?>
                                                <p class="mb-0">
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

endif; // If not empty
?>