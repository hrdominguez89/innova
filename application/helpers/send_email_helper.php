<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * send_email Helper
 *
 * @package		Pipi
 * @subpackage	Helper
 * @category	Helper
 * @author		Héctor Ricardo Domínguez
 */

// ------------------------------------------------------------------------

if (!function_exists('send_email_helper')) {
    /**
     * send_email_helper
     *
     * Configura y envia email.
     *
     * @param	string TO_EMAIL A E-Mail
     * @param	string EMAIL_SUBJECT Asunto
     * @param	string EMAIL_MESSAGE Mensaje
     * @param	string FROM_EMAIL Desde E-Mail
     * @param	string FROM_NAME Desde Nombre
     * @param	string EMAIL_CC Con copia
     * @param	string EMAIL_BCC Con copia oculta
     * @param	string EMAIL_REPLY responder a EMAIL
     * @param	string NAME_REPLY responder a NOMBRE
     * @return	boolean	Devuelve true se envio el email con éxtio
     */

    function send_email_helper($to_email, $email_subject, $email_message, $from_email = FALSE, $from_name = FALSE, $email_cc = FALSE, $email_bcc = FALSE, $email_reply = FALSE)
    {

        $CI = &get_instance();
        $CI->load->library('email');
        $CI->config->load('custom_config');

        $email_config = $CI->config->item('email_config');

        $config['protocol']      = $email_config->protocol;
        $config['smtp_host']     = $email_config->smtp_host;
        $config['smtp_port']     = $email_config->smtp_port;
        $config['smtp_user']     = $email_config->smtp_user;
        $config['smtp_pass']     = $email_config->smtp_pass;
        $config['mailtype']      = $email_config->mailtype;
        $config['charset']       = $email_config->charset;
        $config['wrapchars']     = $email_config->wrapchars;
        $config['newline']       = $email_config->newline;
        $config['crlf']          = $email_config->crlf;
        $config['wordwrap']      = $email_config->wordwrap;

        $CI->email->clear(TRUE);

        $CI->email->initialize($config);

        if (!$from_email) {
            $no_reply = $CI->config->item('no_reply');
            $CI->email->from($no_reply->from_email, $no_reply->from_name);
        } else {
            $CI->email->from($from_email, $from_name);
        }

        $CI->email->to($to_email);

        if ($email_cc) {
            $CI->email->cc($email_cc);
        }

        if ($email_bcc) {
            $CI->email->bcc($email_bcc);
        }
        if ($email_reply) {
            $CI->email->reply_to();
        }

        $body['body'] = $email_message;

        $html = $CI->load->view('email_template_view',$body,true);

        $CI->email->subject($email_subject);
        $CI->email->message($html);

        if ($CI->email->send(FALSE)) {
            return true;
        } else {
            return $CI->email->print_debugger(array('headers'));;
        }
    }
}
if (!function_exists('encolar_emails')) {


    /**
     * encolar_emails
     *
     * encolas los correos en la BD.
     *
     * @param	string email_de E-mail de quien envia el E-mail
     * @param	string nombre_de Nombre de quien envia el E-mail
     * @param	string email_para E-mail destinatario
     * @param	string email_mensaje Mensaje
     * @param	string email_asunto Asunto
     */
    function encolar_email($email_de, $nombre_de, $email_para, $email_mensaje, $email_asunto)
    {
        $CI = &get_instance();
        $CI->load->model('emails/Emails_model');

        $email['email_de'] = $email_de;
        $email['nombre_de'] = $nombre_de;
        if(ENVIRONMENT != 'production'){
            $email['email_para'] = 'red@redia.com.ar';
        }else{
            $email['email_para'] = $email_para;
        }
        $email['email_mensaje'] = $email_mensaje;
        $email['email_asunto'] = $email_asunto;
        $email['email_estado_id'] = EMAIL_NUEVO;
        $email['fecha_envio'] = date('Y-m-d H:i:s', time());
        $email['intentos_de_envio'] = 0;

        $id_email = $CI->Emails_model->encolarCorreo($email);
        return $id_email;
    }
}

if (!function_exists('crear_notificacion')) {
    /**
     * crear_notificacion
     *
     * Genera la notificacion en la bd.
     *
     * @param	string de_usuario_id E-mail de quien envia el E-mail
     * @param	string de_rol_id Nombre de quien envia el E-mail
     * @param	string mensaje_de_plataforma E-mail destinatario
     * @param	string para_usuario_id Mensaje
     * @param	string para_rol_id Asunto
     * @param	string buscar_y_reemplazar Array de 
     */
    function crear_notificacion($de_usuario_id, $de_rol_id, $mensaje_de_plataforma, $para_usuario_id, $para_rol_id,$buscar_y_reemplazar)
    {
        $CI = &get_instance();
        $CI->load->model('notificaciones/Notificaciones_model');

        $mensaje_notif = $mensaje_de_plataforma->texto_mensaje;
        $asunto_notif = $mensaje_de_plataforma->asunto_mensaje;

        for ($i = 0; $i < count($buscar_y_reemplazar); $i++) {
            $mensaje_notif = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $mensaje_notif);
            $asunto_notif = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $asunto_notif);
        }


        $notificacion['de_usuario_id']= $de_usuario_id;
        $notificacion['de_rol_id']= $de_rol_id;
        $notificacion['de_nombre']= $mensaje_de_plataforma->notificador_nombre;
        $notificacion['para_usuario_id']= $para_usuario_id;
        $notificacion['para_rol_id']= $para_rol_id;
        $notificacion['titulo_mensaje']= $asunto_notif;
        $notificacion['mensaje']= $mensaje_notif;
        $notificacion['leido']= false;
        $notificacion['fecha_alta']= date('Y-m-d H:i:s', time());

        $CI->Notificaciones_model->insertarNotificacion($notificacion);
    }
}
// ------------------------------------------------------------------------