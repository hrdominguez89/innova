<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

class Cli extends MX_Controller
{

    //correr en cosola el siguiente comando
    //php index.php _NOMBRE_DEL_CONTROLADOR_ _NOMBRE_DEL_METODO_ _PARAMETRO_SI_ES_QUE_NECESITA_ y asi sucesivamente

    //EJEMPLO con parametros
    //php index.php cli enviarCorreosEncolados PARAMETRO1 PARAMETRO2 PARAM3 PARAM4...

    //EJEMPLO sin parametros
    //php index.php cli enviarCorreosEncolados

    //PARA LLAMAR A ESTE CONTROLADOR DESDE OTRO CONTROLADOR UTILIZAR LA FUNCION EXEC()
    //exec('COMANDO DE CONSOLA');

    //EJEMPLO
    //exec('php index.php Cli enviarCorreosEncolados ' . $email_id);



    public function __construct()
    {
        parent::__construct();
        // if(!is_cli()){
        //     redirect(base_url().'home');
        // }
        $this->load->helper(array('send_email_helper'));
        $this->load->model('Cli_model');
    }

    public function enviarCorreosEncolados($correo_id = false)
    {
        if ($correo_id) {
            $correo_a_enviar = $this->Cli_model->getEmailById($correo_id);
            if ($correo_a_enviar) {
                $this->prepararYEnviar($correo_a_enviar);
            }
        } else {
            $correos_a_enviar = $this->Cli_model->getEmailsNuevosYPendientes();
            if ($correos_a_enviar) {
                foreach ($correos_a_enviar as $correo_a_enviar) {
                    $this->prepararYEnviar($correo_a_enviar);
                }
            }
        }
    }

    public function prepararYEnviar($correo_a_enviar)
    {
        $email_para = $correo_a_enviar->email_para;
        $email_asunto = $correo_a_enviar->email_asunto;
        $email_mensaje = $correo_a_enviar->email_mensaje;
        $email_de = $correo_a_enviar->email_de;
        $nombre_de = $correo_a_enviar->nombre_de;

        $intentos_de_envio = $correo_a_enviar->intentos_de_envio;

        $resultado = send_email_helper($email_para, $email_asunto, $email_mensaje, $email_de, $nombre_de);
        $email_id = $correo_a_enviar->id;
        $email_enviado['intentos_de_envio'] = $intentos_de_envio + 1;
        $email_enviado['fecha_enviado'] = date('Y-m-d H:i:s', time());
        if ($resultado !== TRUE) {
            $email_enviado['email_estado_id'] = EMAIL_PENDIENTE;
            $email_enviado['errores_de_envio'] = $resultado;
        } else {
            $email_enviado['email_estado_id'] = EMAIL_ENVIADO;
            //$email_enviado['errores_de_envio'] = NULL;
        }
        $this->Cli_model->updateEmail($email_enviado, $email_id);
    }

    public function finalizarDesafios()
    {
        $this->load->model('mensajes/Mensajes_model');
        $this->load->helper(array('send_email_helper'));

        $date = date('Y-m-d', time());
        $desafios_vencidos = $this->Cli_model->getDesafiosvencidos($date);
        $mensaje_de_plataforma =  $this->Mensajes_model->getMensaje('mensaje_fin_etapa_postulacion');
        $desafio_data['estado_id'] = DESAF_FINALIZADO;
        $this->Cli_model->finalizarDesafios($desafio_data, $date);
        switch ($mensaje_de_plataforma->tipo_de_envio_id) {
            case ENVIO_NOTIFICACION:
                $mensaje_de_notificacion = $this->Mensajes_model->getMensaje('mensaje_nueva_notificacion');
                foreach ($desafios_vencidos as $desafio_vencido) {
                    $buscar_y_reemplazar = array(
                        array('buscar' => '{{DESAFIO_NOMBRE}}', 'reemplazar' => $desafio_vencido->nombre_del_desafio),
                        array('buscar' => '{{NOMBRE_RAZON_SOCIAL_EMPRESA}}','reemplazar' => $desafio_vencido->nombre_empresa),
                        array('buscar' => '{{NOMBRE_CONTACTO_EMPRESA}}','reemplazar' => $desafio_vencido->nombre_contacto),
                        array('buscar' => '{{APELLIDO_CONTACTO_EMPRESA}}','reemplazar' => $desafio_vencido->apellido_contacto),
                    );
                    $this->crearNotificacion($mensaje_de_plataforma, $desafio_vencido, $buscar_y_reemplazar);
                    $this->crearEmail($mensaje_de_notificacion, $desafio_vencido, $buscar_y_reemplazar);
                }
                break;
            case ENVIO_EMAIL:
                foreach ($desafios_vencidos as $desafio_vencido) {
                    $buscar_y_reemplazar = array(
                        array('buscar' => '{{DESAFIO_NOMBRE}}', 'reemplazar' => $desafio_vencido->nombre_del_desafio),
                        array('buscar' => '{{NOMBRE_RAZON_SOCIAL_EMPRESA}}','reemplazar' => $desafio_vencido->nombre_empresa),
                        array('buscar' => '{{NOMBRE_CONTACTO_EMPRESA}}','reemplazar' => $desafio_vencido->nombre_contacto),
                        array('buscar' => '{{APELLIDO_CONTACTO_EMPRESA}}','reemplazar' => $desafio_vencido->apellido_contacto),
                    );
                    $this->crearEmail($mensaje_de_plataforma, $desafio_vencido, $buscar_y_reemplazar);
                }
                break;
            case ENVIO_NOTIF_EMAIL:
                foreach ($desafios_vencidos as $desafio_vencido) {
                    $buscar_y_reemplazar = array(
                        array('buscar' => '{{DESAFIO_NOMBRE}}', 'reemplazar' => $desafio_vencido->nombre_del_desafio),
                        array('buscar' => '{{NOMBRE_RAZON_SOCIAL_EMPRESA}}','reemplazar' => $desafio_vencido->nombre_empresa),
                        array('buscar' => '{{NOMBRE_CONTACTO_EMPRESA}}','reemplazar' => $desafio_vencido->nombre_contacto),
                        array('buscar' => '{{APELLIDO_CONTACTO_EMPRESA}}','reemplazar' => $desafio_vencido->apellido_contacto),
                    );
                    $this->crearNotificacion($mensaje_de_plataforma, $desafio_vencido, $buscar_y_reemplazar);
                    $this->crearEmail($mensaje_de_plataforma, $desafio_vencido, $buscar_y_reemplazar);
                }
                break;
        }
        
    }

    public function crearNotificacion($data_mensaje, $data_usuario_para, $buscar_y_reemplazar)
    {
        $de_usuario_id = 0;
        $de_rol_id = 0;

        crear_notificacion($de_usuario_id, $de_rol_id, $data_mensaje, $data_usuario_para->id_empresa, ROL_EMPRESA, $buscar_y_reemplazar);
    }

    public function crearEmail($data_mensaje, $data_usuario_para, $buscar_y_reemplazar)
    {

        $mensaje = $data_mensaje->texto_mensaje;
        $asunto = $data_mensaje->asunto_mensaje;

        if ($buscar_y_reemplazar) {
            for ($i = 0; $i < count($buscar_y_reemplazar); $i++) {
                $mensaje = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $mensaje);
                $asunto = str_replace($buscar_y_reemplazar[$i]['buscar'], $buscar_y_reemplazar[$i]['reemplazar'], $asunto);
            }
        }

        $email_de = $data_mensaje->notificador_correo;
        $nombre_de = $data_mensaje->notificador_nombre;
        $email_para = $data_usuario_para->email_contacto;
        $email_mensaje = $mensaje;
        $email_asunto =  $asunto;

        encolar_email($email_de, $nombre_de, $email_para, $email_mensaje, $email_asunto);
    }
}
