<?php 

/**
 * Functions to send Transformations requests by email
 * 
 * @package Emertech Transform Plugin
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Email requests for Emertech Transformations
 */
class Emertech_Email_Request {

    public $to;
    public $subject;
    public $message;
    public $headers;
    public $params;
    
    /**
     * Just to instantiate the class
     * 
     * @since 3.0
     */
    public function __construct() {
        
    }

    /**
     * Add headers to enable HTML formatting
     *
     * @since 3.0
     */
    public function use_html() {
        $this->headers[] = 'MIME-Version: 1.0';
        $this->headers[] = 'Content-type: text/html; charset=utf-8';
    }

    /**
     * Send email
     *
     * @param boolean $use_html Whether or not to use 
     * @return void
     */
    public function send_mail(bool $use_html = false) {
        $to = $this->to;
        $subject = $this->subject;
        $message = $this->message;
        $headers = $this->headers;
        $params = $this->params;
        
        if($headers)
            $headers = implode("\r\n", $headers);
        
        if($params)
            $params = implode("\r\n", $params);
        
        mail(
            $to, 
            $subject, 
            $message, 
            $headers, 
            $params
        );
    }

}