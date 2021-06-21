<?php
/**
 * Setup Transformations Custom Post Type
 * 
 * @package Emertech Transform Plugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup Custom Post Type for Emertech Transformations
 */
class Emertech_Transform_Setup {

    protected Emertech_Transform_CPT $cpt;

    /**
     * Construct class
     * 
     * @since 1.0
     */
    public function __construct(Emertech_Transform_CPT $cpt = null) {
        if($cpt == null) $cpt = new Emertech_Transform_CPT();
        $this->cpt = $cpt;
    }
}

include 'transform-cpt.php';
new Emertech_Transform_Setup();