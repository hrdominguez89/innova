<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('my_form_validation'));
        if ($this->form_validation->run($this));

        $this->load->model('Registro/Registro_model');
        $this->load->model('Usuarios_model');
        $this->load->model('mensajes/Mensajes_model');
        $this->load->helper(array('send_email_helper'));
    }

    public function index()
    {
        $data['title'] = 'Usuarios';
        $data['files_js'] = array('usuarios/usuarios.js');
        $data['sections_view'] = 'usuarios_abm_view';
        $this->load->view('layout_back_view', $data);
    }

    public function cargarUsuarios()
    {
        $data['usuarios'] = $this->Usuarios_model->getUsuariosAdmin();
        echo json_encode(array(
            'status_code' => 200,
            'data' => $data['usuarios']
        ));
    }

    public function crearUsuario()
    {
        $this->crearUsuarioRules();
        if ($this->form_validation->run() != FALSE) {
            $password = $this->generarPassword();
            $usuario['nombre'] = $this->input->post('nombre');
            $usuario['apellido'] = $this->input->post('apellido');
            $usuario['email'] = $this->input->post('email');
            $usuario['rol_id'] = $this->input->post('rol_id');
            $usuario['estado_id'] = USR_ENABLED;
            $usuario['usuario_alta_id'] = $this->session->userdata('user_data')->id;
            $usuario['password'] = password_hash($password, PASSWORD_BCRYPT);
            $usuario['fecha_alta'] = date('Y-m-d H:i:s', time());
            $this->Usuarios_model->insertarUsuario($usuario);



            $buscar_y_reemplazar = array(
                array('buscar' => '{{EMAIL_USUARIO}}', 'reemplazar' => $usuario['email']),
                array('buscar' => '{{PASSWORD_USUARIO}}', 'reemplazar' => $password),
                array('buscar' => '{{NOMBRE_USUARIO}}', 'reemplazar' => $usuario['nombre']),
                array('buscar' => '{{APELLIDO_USUARIO}}', 'reemplazar' => $usuario['apellido']),
            );

            if ($usuario['rol_id'] == ROL_VALIDADOR) {
                $mensaje_de_plataforma = $this->Mensajes_model->getMensaje('mensaje_alta_usuario_validador');
            } else {
                $mensaje_de_plataforma = $this->Mensajes_model->getMensaje('mensaje_alta_usuario_admin_plataforma');
            }

            $email_id = $this->crearEmail($mensaje_de_plataforma, $usuario['email'], $buscar_y_reemplazar);

            modules::run('cli/enviarcorreosencolados', $email_id);



            echo json_encode(array(
                'status_code' => 200,
                'cargado' => true,
                'msg' => 'Usuario creado con éxito',
            ));
        } else {
            echo json_encode(array(
                'status_code' => 200,
                'cargado' => false,
                'msg' => validation_errors(),
            ));
        }
    }

    public function crearUsuarioRules()
    {
        $this->form_validation->set_rules(
            'nombre',
            'Nombre',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'apellido',
            'Apellido',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'trim|required|max_length[255]|callback_check_email',
            array(
                'required' => 'El campo {field} es obligatorio.',
                'check_email' => 'El {field} ya se encuentra registrado.',
            )
        );
        $this->form_validation->set_rules(
            'rol_id',
            'Rol',
            'integer|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
    }

    public function check_email($email)
    {
        $data_email = $this->Registro_model->getEmail($email);
        if ($data_email && $data_email->id != $this->input->post('usuario_id')) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function generarPassword()
    {
        $letras = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $cantidad_de_letras = count($letras) - 1;
        $password = '';
        for ($j = 0; $j < 4; $j++) {
            for ($i = 0; $i < 2; $i++) {
                if (rand(0, 1)) {
                    $password .= $letras[rand(0, $cantidad_de_letras)];
                } else {
                    $password .= strtoupper($letras[rand(0, $cantidad_de_letras)]);
                }
            }
            $password .= rand(0, 9);
        }
        return $password;
    }

    public function activarUsuario()
    {
        $usuario_id = $this->input->post('usuario_id');
        if ($this->input->post('activar') == 'true') {
            $usuario['estado_id'] = USR_ENABLED;
        } else {
            $usuario['estado_id'] = USR_DISABLED;
        }
        $usuario['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
        $usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());
        $this->Usuarios_model->updateUsuario($usuario, $usuario_id);
        echo json_encode(array(
            'status_code' => 200,
        ));
    }

    public function editarUsuario()
    {
        $this->rulesEditarUsuario();
        if ($this->form_validation->run() != FALSE) {
            $usario_id = $this->input->post('usuario_id');
            $usuario['nombre'] = $this->input->post('nombre');
            $usuario['apellido'] = $this->input->post('apellido');
            $usuario['email'] = $this->input->post('email');
            $usuario['rol_id'] = $this->input->post('rol_id');
            $usuario['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());
            if ($this->input->post('reset_password')) {
                $password = $this->generarPassword();
                $usuario['password'] = password_hash($password, PASSWORD_BCRYPT);
                $usuario['reiniciar_password_fecha'] = date('Y-m-d H:i:s', time());
                $usuario['cambiar_password'] = TRUE;
            }
            $this->Usuarios_model->updateUsuario($usuario, $usario_id);

            if ($this->input->post('reset_password')) {
                $buscar_y_reemplazar = array(
                    array('buscar' => '{{EMAIL_USUARIO}}', 'reemplazar' => $usuario['email']),
                    array('buscar' => '{{PASSWORD_USUARIO}}', 'reemplazar' => $password),
                    array('buscar' => '{{NOMBRE_USUARIO}}', 'reemplazar' => $usuario['nombre']),
                    array('buscar' => '{{APELLIDO_USUARIO}}', 'reemplazar' => $usuario['apellido']),
                );

                $mensaje_de_plataforma = $this->Mensajes_model->getMensaje('mensaje_reinicio_clave_usuario_admin');

                $email_id = $this->crearEmail($mensaje_de_plataforma, $usuario['email'], $buscar_y_reemplazar);

                modules::run('cli/enviarcorreosencolados', $email_id);
            }

            echo json_encode(array(
                'status_code' => 200,
                'editado' => true,
                'msg' => 'Usuario editado con éxito',
            ));
        } else {
            echo json_encode(array(
                'status_code' => 200,
                'editado' => false,
                'msg' => validation_errors(),
            ));
        }
    }

    public function rulesEditarUsuario()
    {
        $this->form_validation->set_rules(
            'usuario_id',
            'ID de Usuario',
            'integer|required',
            array(
                'required' => 'Error al editar usuario, por favor indique el id de usuario a modificar'
            )
        );
        $this->form_validation->set_rules(
            'nombre',
            'Nombre',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'apellido',
            'Apellido',
            'trim|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'trim|required|max_length[255]|callback_check_email',
            array(
                'required' => 'El campo {field} es obligatorio.',
                'check_email' => 'El {field} ya se encuentra registrado.',
            )
        );
        $this->form_validation->set_rules(
            'rol_id',
            'Rol',
            'integer|required',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
    }

    public function getDataUSuario()
    {
        $usuario_id = $this->input->post('usuario_id');
        $data = $this->Usuarios_model->getUsuarioById($usuario_id);
        echo json_encode(array(
            'status_code' => 200,
            'data' => $data,
        ));
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
        $email_para = $data_usuario_para;
        $email_mensaje = $mensaje;
        $email_asunto =  $asunto;

        encolar_email($email_de, $nombre_de, $email_para, $email_mensaje, $email_asunto);
    }
}
