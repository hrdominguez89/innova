<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Google Re-Captcha Helper
 *
 * @package		Pipi
 * @subpackage	Helper
 * @category	Helper
 * @author		Héctor Ricardo Domínguez
 * @link		https://developers.google.com/recaptcha/docs
 */

// ------------------------------------------------------------------------

if ( ! function_exists('valid_captcha'))
{
	/**
	 * valid_captcha_helper
	 *
	 * Verifica que el captcha sea valido.
	 *
	 * @param	string recaptcha response
	 * @return	boolean	Devuelve true si pasa el captcha
	 */

    function valid_captcha_helper($captcha){
        $CI =& get_instance();
        $CI->load->library('email');
        $CI->config->load('custom_config');

        $data_captcha_google = $CI->config->item('data_captcha_google');

        $recaptcha_response = $captcha;
        $recaptcha = file_get_contents($data_captcha_google->url . '?secret=' . $data_captcha_google->secretKey . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);
        if (!$recaptcha->success) {
            return false;
        }else{
            return true;
        }
    }
}

// ------------------------------------------------------------------------

