<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * send_email Helper
 *
 * @package		Pipi
 * @subpackage	Helper
 * @category	Helper
 * @author		Héctor Ricardo Domínguez
 * @link		https://developers.google.com/recaptcha/docs
 */

// ------------------------------------------------------------------------

if ( ! function_exists('get_partner_helper'))
{
	/**
	 * send_email_helper
	 *
	 * Configura y envia email.
	 *
     * 
	 */

    function get_partner_helper(){
        
        $CI =& get_instance();
        $CI->load->model('Partners_model');

        $partners =  $CI->Partners_model->getTotalPartnersByStatusUserId(USR_ENABLED);

        return $partners;

        // $CI->config->load('custom_config');

        // $email_config = $CI->config->item('email_config');
    }
}

// ------------------------------------------------------------------------

