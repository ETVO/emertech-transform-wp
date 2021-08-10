<?php
/**
 * Function helpers 
 * 
 * @package Emertech Transform Plugin
 */

 
if ( ! function_exists( 'get_transform_template_part' ) ) {
    /**
     * Get plugin template part
     *
     * @param string $path Path of template part file (**WITHOUT** file extension)
     * @since 1.0
     */
	function get_transform_template_part(string $path) {
        if($path == '') return; 
        try {

            $file_name = EMERTECH_TRANSFORM_DIR . $path . '.php';

            if(! file_exists($file_name)) 
                throw new Exception("No such file or directory in ($file_name)");
            
            include $file_name;
            
        } catch (Exception $e) {
            echo "<script>";
            echo "console.error(\"Plugin template part ($path) was not found.\");";
            echo "</script>";
        }
    }
}


if ( ! function_exists( 'get_term_top_parent' ) ) {
    /**
     * Get term top most parent
     *
     * @param WP_Term $path Term of which the parent will be get
     * @param string $taxonomy Taxonomy of term
     * @since 1.0
     */
	function get_term_top_parent(WP_Term $term, string $taxonomy = '') {
        $parent_id = $term->parent;
    
        // If parent ID is 0, then the term given is already 
        // the top most parent
        if($parent_id == 0) 
            return false;

        // Keep getting the parent of the parent until the top most 
        // parent is found
        while($parent_id != 0) {
            $parent = get_term( $parent_id, $taxonomy );
            $parent_id = $parent->parent;
        }
        
        // Return found parent
        return $parent;
    }
}


if ( ! function_exists( 'transform_strip_term' ) ) {
    /**
     * Strip term of unused properties
     *
     * @param WP_Term $term Term to be used as a basis
     * @return array
     * @since 1.0
     */
    function transform_strip_term(WP_Term $term):array {
        return array(
            "slug" => $term->slug,
            "name" => $term->name,
            "description" => $term->description,
        );
    }
}

if( ! function_exists( 'get_transform_term_image_height' ) ) {

    /**
     * Get theme mod for max height of Transform term image
     *
     * @param boolean $with_unit
     * @return string
     */
    function get_transform_term_image_height(bool $with_unit = true): string {
        $image_max_height = &get_theme_mod('emertech_transform_term_image_height');
        
        if($with_unit) {
            if($image_max_height == null || $image_max_height <= 0) 
                $image_max_height = 'unset';
            else 
                $image_max_height .= 'px';
        }
        
        return $image_max_height;
    }
}

if( ! function_exists( 'get_transform_term_icon' ) ) {

    /**
     * Get theme mod for icon of Transform term
     *
     * @return string
     */
    function get_transform_term_icon(): string {
        $icon = &get_theme_mod('emertech_transform_term_icon');
        
        if($icon == '') {
            $icon = 'question';
        }
        
        return $icon;
    }
}

if( ! function_exists( 'get_transform_term_title' ) ) {

    /**
     * Get theme mod for hover title of Transform term
     *
     * @return string
     */
    function get_transform_term_title(): string {
        $title = &get_theme_mod('emertech_transform_term_title');
        
        if($title == '') {
            $title = __("Mais informações");
        }
        
        return $title;
    }
}

if( ! function_exists( 'get_transform_optionals' ) ) {

    /**
     * Get all singular transform available optionals raw
     *
     * @return array Optionals as returned by the get_the_terms() default
     */
    function get_transform_optionals(): array {
        $taxonomy = "opcional";
        $optionals = get_the_terms( get_the_ID(), $taxonomy );
        
        return $optionals;
    }
}

if( ! function_exists( 'get_transform_grouped_optionals' ) ) {

    /**
     * Return provided optionals grouped by parents and sorted by menu_order.
     * **Structure:**
     *  - **$parents** _as_ **$parent**
     *  - **$grouped_optionals[$parent->slug]** _as_ **$optional**
     *
     * @param array $optionals Optionals array to group
     * @return array parents, grouped_optionals
     */
    function transform_group_optionals($optionals): array {
        $taxonomy = "opcional";
        
        if(!$optionals) return array();
        
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

        return array(
            'parents' => $parents, 
            'grouped_optionals' => $grouped_optionals
        );
    }
}

if( ! function_exists( 'get_transform_grouped_optionals' ) ) {

    /**
     * Return all single transform available optionals grouped by parents and sorted by menu_order.
     * **Structure:**
     *  - **$parents** _as_ **$parent**
     *  - **$grouped_optionals[$parent->slug]** _as_ **$optional**
     *
     * @return array $parents, grouped_optionals
     */
    function get_transform_grouped_optionals(): array {
        $optionals = get_transform_optionals();

        return transform_group_optionals($optionals);
    }
}


