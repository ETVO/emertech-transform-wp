<?php
/**
 * Partial for the archive transform page
 * 
 * @package Emertech WordPress theme
 */


$view_more_label = get_theme_mod( 'emertech_transform_strings_view_more' );
if($view_more_label == '') $view_more_label = __('Ver Mais');

?>


<div class="catalog">
    <div class="transforms-wrap">
        <div class="transforms">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4">
                <?php
                    while (have_posts()) :
                        the_post();
                        
                        $post = get_post();
                        
                        $permalink = esc_url(get_the_permalink());
                        
                        $image_url = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
                        $image_alt = get_the_post_thumbnail_caption();
                        
                        $category = get_the_category();
                        if ($use_transform)
                        $category = get_the_terms($post->ID, 'tipo');
                        
                        $title = get_the_title();
                        $excerpt = get_the_excerpt();
                        ?>
                        <div class="col p-2">
                            
                            <div class="card position-relative clink" href="<?php echo $permalink; ?>">

                                <?php if ($image_url != ''){ ?>
                                    <div class="image">
                                        <img src="<?php echo $image_url; ?>" class="card-img-top" 
                                        alt="<?php echo $image_alt; ?>">
                                    </div>
                                <?php } else { ?>
                                    <div class="image-placeholder"></div>
                                <?php } ?>

                                    <div class="card-body">
                                        <a class="title d-block" href="<?php echo $permalink; ?>">
                                            <h5 class="d-inline-block card-title">
                                                <?php echo $title; ?>
                                            </h5>
                                        </a>
                                        <a class="eb-link" href="<?php echo $permalink; ?>">
                                            <?php echo $view_more_label; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <?php
                    endwhile;
                    ?>
                </div>
        </div>
    </div>

    <?php
        get_template_part("partials/component/pagination");
    ?>
</div>