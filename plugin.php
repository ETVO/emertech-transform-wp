<?php
/**
 * Plugin Name: Emertech Transformations
 * Description: Transformações da Emertech
 * Author: Estevão Rolim
 * Author URI: https://www.linkedin.com/in/estevaoprolim/
 * Version: 1.0
 * 
 * @package Emertech Transform Plugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Core constants 
define("EMERTECH_TRANSFORM_DIR", plugin_dir_path(__DIR__));
define("EMERTECH_TRANSFORM_URL", plugins_url("emertech-transform/"));
define("EMERTECH_TRANSFORM_CLASS_NAME", "Emertech_Transform_Plugin");

/**
 * Emertech transformations plugin class
 */
final class Emertech_Transform_Plugin {

    /**
     * Add actions, filters and call functions
     * 
     * @since 1.0
     */
    public function __construct() {

        $this->plugin_constants();

        // Initialize blocks PHP
        add_action('init', array(EMERTECH_TRANSFORM_CLASS_NAME, 'plugin_setup'));

        // Enqueue scripts on init        
        add_action('wp_enqueue_scripts', array(EMERTECH_TRANSFORM_CLASS_NAME, 'plugin_css'));
        add_action('wp_enqueue_scripts', array(EMERTECH_TRANSFORM_CLASS_NAME, 'plugin_js'));
    }

    /**
     * Define plugin core constants
     *
     * @since 1.0
     */
    public function plugin_constants() {

    } 

    /**
     * Setup plugin files
     *
     * @since 1.0
     */
    public function plugin_setup() {

    }

    /**
     * Enqueue plugin CSS
     *
     * @since 1.0
     */
    public function plugin_css() {

    }

    /**
     * Enqueue plugin JS
     *
     * @since 1.0
     */
    public function plugin_js() {

    }
}