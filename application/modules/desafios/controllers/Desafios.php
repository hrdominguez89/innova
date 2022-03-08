<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Desafios extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Desafios_model');
        $this->load->library(array('my_form_validation'));
        $this->form_validation->run($this);

        $this->load->library('pagination');


        //config paginacion
        $this->limit_default = 10;
        $this->page = $this->input->get('page') ? $this->input->get('page') : 0;
        $this->limit = $this->input->get('limit') ? $this->input->get('limit') : $this->limit_default;
        $this->start = $this->page >= 1 ? ($this->page - 1) * $this->limit : 0;
        $this->config_pagination = array(
            'per_page'             => $this->limit,
            'use_page_numbers'     => TRUE,
            'page_query_string'    => TRUE,
            'query_string_segment' => 'page',
            'reuse_query_string'   => TRUE,
            'full_tag_open'        => '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">',
            'full_tag_close'       => '</ul></nav>',
            'first_link'           => 'Primero',
            'first_tag_open'       => '<li class="page-item">',
            'first_tag_close'      => '</li>',
            'last_link'            => 'Último',
            'last_tag_open'        => '<li class="page-item">',
            'last_tag_close'       => '</li>',
            'next_tag_open'        => '<li class="page-item">',
            'next_tag_close'       => '</li>',
            'prev_tag_open'        => '<li class="page-item">',
            'prev_tag_close'       => '</li>',
            'num_tag_open'         => '<li class="page-item">',
            'num_tag_close'        => '</li>',
            'cur_tag_open'         => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close'        => '</span></li>',
            'attributes'           => array(
                'class' => 'page-link'
            ),
        );
    }

    public function index()
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }
        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_STARTUP:
                $categorias = $this->Desafios_model->getCategoriasStartups($this->session->userdata('user_data')->id);
                $array_categorias = [];
                $data['files_js'] = array('desafios/desafio_postularme.js');
                foreach ($categorias as $categoria) {
                    $array_categorias[] = $categoria->categoria_id;
                }

                $this->config_pagination['base_url'] = base_url() . 'desafios';
                $this->config_pagination['total_rows'] = count($this->Desafios_model->getDesafiosVigentesPorCategorias($array_categorias));
                $this->pagination->initialize($this->config_pagination);

                // foreach ($categorias as $categoria) {
                //     $array_categorias[] = $categoria->categoria_id;
                // }
                $data['desafios'] = $this->Desafios_model->getDesafiosVigentesPorCategorias($array_categorias, $this->start, $this->limit);
                $this->load->model('postulados/Postulados_model');
                $postulaciones = $this->Postulados_model->getPostulacionesByStartupId($this->session->userdata('user_data')->id);
                foreach ($postulaciones as $postulacion) {
                    $data['postulaciones'][$postulacion->desafio_id] = $postulacion;
                }
                $data['sections_view'] = 'desafios_cartelera_view';
                break;
            case ROL_EMPRESA:
                $data['categorias'] = $this->Desafios_model->getCategorias();
                $data['sections_view'] = 'desafios_abm_view';
                $data['files_js'] = array('desafios/carga_desafios.js');
                break;
            case ROL_PARTNER:
                $this->config_pagination['base_url'] = base_url() . 'desafios';
                $this->config_pagination['total_rows'] = count($this->Desafios_model->getDesafiosVigentes());
                $this->pagination->initialize($this->config_pagination);
                $data['desafios'] = $this->Desafios_model->getDesafiosVigentes($this->start, $this->limit);
                $data['files_js'] =  array('partners/desafios_partner.js');
                $data['sections_view'] = 'desafios_cartelera_partner_view';
                break;

            case ROL_ADMIN_ORGANIZACION:
            case ROL_ADMIN_PLATAFORMA:
                $data['categorias'] = $this->Desafios_model->getCategorias();
                $data['desafios'] = $this->Desafios_model->getTodosLosDesafios();
                $data['sections_view'] = 'desafios_admin_list_view';
                $data['files_js'] = array('desafios/desafios_abm_admin_plataforma.js');
                break;
        }
        $data['title'] = 'Desafíos';
        $this->load->view('layout_back_view', $data);
    }

    public function postularse()
    {
        if ($this->validarAcceso()) {
            $this->load->model('postulados/Postulados_model');
            $desafio_id = $this->input->post('desafio_id');
            $desafios_ya_postulados = $this->Postulados_model->getPostulacionesByDesafioId($desafio_id, $this->session->userdata('user_data')->id);
            if ($desafios_ya_postulados) {
                echo json_encode(array(
                    "status_code" => 200,
                    "postulado" => false,
                    "title" => 'Postulación vigente',
                    "mensaje" => 'Ya se encuentra postulado a este desafío.'
                ));
            } else {
                $desafio_data = $this->Desafios_model->getDesafioById($desafio_id);

                //TRAIGO CANTIDAD DE DESAFIOS POSTULADOS POR EMPRESA Y SI EL DESAFIO ESTA VIGENTE O FINALIZADO.
                $cantidad_de_desafios = count($this->Desafios_model->getCantidadDePostulacionesByEmpresa($this->session->userdata('user_data')->id, $desafio_data->id_empresa));
                $configuracion = $this->Desafios_model->getCantidadMaximaDePostulaciones();
                if ($cantidad_de_desafios < $configuracion->postulaciones_maximas) {
                    $postulacion['desafio_id'] = $desafio_id;
                    $postulacion['startup_id'] = $this->session->userdata('user_data')->id;
                    $postulacion['fecha_postulacion'] = date('Y-m-d H:i:s', time());
                    $postulacion['estado_postulacion'] = POST_PENDIENTE;

                    $this->Desafios_model->insertPostulacion($postulacion);

                    $this->load->helper(array('send_email_helper'));
                    $this->load->model('mensajes/Mensajes_model');

                    $data_startup = $this->Desafios_model->getDataStartup($this->session->userdata('user_data')->id);


                    $buscar_y_reemplazar = array(
                        array('buscar' => '{{NOMBRE_RAZON_SOCIAL_STARTUP}}', 'reemplazar' => $data_startup->razon_social),
                        array('buscar' => '{{DESAFIO_NOMBRE}}', 'reemplazar' => $desafio_data->nombre_del_desafio),
                        array('buscar' => '{{NOMBRE_RAZON_SOCIAL_EMPRESA}}', 'reemplazar' => $desafio_data->nombre_empresa),
                    );
                    $mensaje_de_plataforma_a_administradores = $this->Mensajes_model->getMensaje('mensaje_nuevo_postulado_a_administradores');

                    //creo notificacion para administradores
                    $this->crearNotificacion($mensaje_de_plataforma_a_administradores, FALSE, $this->session->userdata('user_data'), $buscar_y_reemplazar);


                    $mensaje_de_plataforma_a_empresa = $this->Mensajes_model->getMensaje('mensaje_nuevo_postulado_a_empresas');

                    switch ($mensaje_de_plataforma_a_empresa->tipo_de_envio_id) {
                        case ENVIO_NOTIFICACION:
                            $mensaje_de_notificacion = $this->Mensajes_model->getMensaje('mensaje_nueva_notificacion');
                            $this->crearNotificacion($mensaje_de_plataforma_a_empresa, $desafio_data, $this->session->userdata('user_data'), $buscar_y_reemplazar);
                            $this->crearEmail($mensaje_de_notificacion, $desafio_data, $buscar_y_reemplazar);
                            break;
                        case ENVIO_EMAIL:
                            $this->crearEmail($mensaje_de_plataforma_a_empresa, $desafio_data, $buscar_y_reemplazar);
                            break;
                        case ENVIO_NOTIF_EMAIL:
                            $this->crearNotificacion($mensaje_de_plataforma_a_empresa, $desafio_data, $this->session->userdata('user_data'), $buscar_y_reemplazar);
                            $this->crearEmail($mensaje_de_plataforma_a_empresa, $desafio_data, $buscar_y_reemplazar);
                            break;
                    }

                    echo json_encode(array(
                        "status_code" => 200,
                        "postulado" => true,
                        "mensaje" => 'Se postuló al desafío correctamente'
                    ));
                } else {
                    echo json_encode(array(
                        "status_code" => 200,
                        "postulado" => false,
                        "title" => 'Limite alcanzado.',
                        "mensaje" => 'Alcanzo el limite maximo de postulaciones (Max. ' . $configuracion->postulaciones_maximas . ').'
                    ));
                }
            }
        }
    }

    public function insertar()
    {
        if ($this->validarAcceso()) {
            $this->rulesInsertar();
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array(
                    'status_code' => 422,
                    'msg' => validation_errors(),
                ));
            } else {
                $this->load->model('mensajes/Mensajes_model');

                $desafio['fecha_inicio_de_postulacion'] = $this->input->post('inicio_del_desafio');
                $desafio['fecha_fin_de_postulacion'] = $this->input->post('fin_del_desafio');
                $desafio['nombre_del_desafio'] = $this->input->post('nombre_del_desafio');
                $desafio['descripcion_del_desafio'] = $this->input->post('descripcion_del_desafio');
                $desafio['requisitos_del_desafio'] = $this->input->post('requisitos_del_desafio');
                $desafio['estado_id'] = DESAF_VIGENTE;

                //SI SOY ADMIN PLATAFORMA PUEDO CREAR DESAFIOS PARA LAS EMPRESAS.{{NO DESARROLLADO}}
                if ($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA) {
                    $desafio['usuario_empresa_id'] = $this->input->post('usuario_empresa_id');
                } else {
                    $desafio['usuario_empresa_id'] = $this->session->userdata('user_data')->id;
                }

                $desafio['usuario_id_alta'] = $this->session->userdata('user_data')->id;
                $desafio['fecha_alta'] = date('Y-m-d H:i:s', time());

                $categorias = $this->input->post('categorias');

                if ($this->Desafios_model->insertarDesafio($desafio, $categorias)) {
                    $this->load->helper(array('send_email_helper'));

                    $data_empresa = $this->Desafios_model->getDataEmpresa($this->session->userdata('user_data')->id);

                    $buscar_y_reemplazar = array(
                        array('buscar' => '{{NOMBRE_CONTACTO}}', 'reemplazar' => $this->session->userdata('user_data')->nombre),
                        array('buscar' => '{{APELLIDO_CONTACTO}}', 'reemplazar' => $this->session->userdata('user_data')->apellido),
                        array('buscar' => '{{NOMBRE_RAZON_SOCIAL}}', 'reemplazar' => $data_empresa->razon_social),
                        array('buscar' => '{{NOMBRE_DESAFIO}}', 'reemplazar' => $desafio['nombre_del_desafio']),
                        array('buscar' => '{{FECHA_INICIO_POSTULACION}}', 'reemplazar' => date('d-m-Y', strtotime($desafio['fecha_inicio_de_postulacion']))),
                        array('buscar' => '{{FECHA_DE_FINALIZACION}}', 'reemplazar' => date('d-m-Y', strtotime($desafio['fecha_fin_de_postulacion'])))
                    );
                    $mensaje_de_plataforma = $this->Mensajes_model->getMensaje('mensaje_nuevo_desafio');

                    $this->crearNotificacion($mensaje_de_plataforma, FALSE, $this->session->userdata('user_data'), $buscar_y_reemplazar);


                    echo json_encode(array(
                        'status_code' => 200,
                    ));
                }
            }
        }
    }

    public function rulesInsertar()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules(
            'inicio_del_desafio',
            'Inicio del desafío',
            'required|callback_verificar_fecha_inicio',
            array(
                'required' => 'El campo {field} es obligatorio.',
            )
        );
        $this->form_validation->set_rules(
            'fin_del_desafio',
            'Fin del desafío',
            'required|callback_verificar_fecha_fin_postulacion[' . $this->input->post('inicio_del_desafio') . ']',
            array(
                'required' => 'El campo {field} es obligatorio.',
            )
        );
        $this->form_validation->set_rules(
            'nombre_del_desafio',
            'Nombre del desafio',
            'trim|required|max_length[1000]',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'descripcion_del_desafio',
            'Descripcion',
            'trim|required|max_length[5000]',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'requisitos_del_desafio',
            'Requisitos del desafío',
            'trim|max_length[5000]',
        );
        $this->form_validation->set_rules(
            'categorias[]',
            'categorías',
            'integer|required',
            array(
                'required' => 'Debe elegir al menos una categoría'
            )
        );
    }

    public function getDesafiosByUserId()
    {
        if ($this->validarAcceso()) {
            $user_id = $this->session->userdata('user_data')->id;
            $estado_desafio = $this->input->post('estadoDesafio');
            echo json_encode($this->Desafios_model->getDesafiosByUserId($user_id, $estado_desafio));
        }
    }

    public function getDesafioByDesafioId()
    {
        if ($this->validarAcceso()) {
            if ($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA) {
                $user_id = FALSE;
            } else {
                $user_id = $this->session->userdata('user_data')->id;
            }
            $desafio_id = $this->input->post('desafio_id');
            $desafio = $this->Desafios_model->getDesafioByDesafioId($desafio_id, $user_id);
            echo json_encode(
                array(
                    'status_code'   => 200,
                    'data'          => $desafio
                )
            );
        }
    }

    public function validarAcceso() //valida los acceso a traves de ajax.
    {
        if (!$this->session->userdata('user_data')) {
            echo json_encode(array(
                'status_code'   => 403,
                'msg'           => 'Sin acceso',
            ));
        } else if (!$this->input->post()) {
            echo json_encode(array(
                'status_code'   => 400,
                'msg'           => 'Error de petición',
            ));
        } else {
            return true;
        }
        return false;
    }

    public function editar()
    {
        if ($this->validarAcceso()) {
            $desafio_id = $this->input->post('editar_desafio_id');
            $desafio_data = $this->Desafios_model->getDesafioById($desafio_id);
            //SI SOY ADMIN PLATAFORMA PUEDO CREAR DESAFIOS PARA LAS EMPRESAS. {{NO DESARROLLADO}}
            if ($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA) {
                $this->rulesEditarDesafio($desafio_data, true);
            } else {
                $this->rulesEditarDesafio($desafio_data);
            }
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array(
                    'status_code' => 422,
                    'msg' => validation_errors(),
                ));
            } else {
                $desafio['fecha_inicio_de_postulacion'] = $this->input->post('inicio_del_desafio');
                $desafio['fecha_fin_de_postulacion'] = $this->input->post('fin_del_desafio');
                $desafio['nombre_del_desafio'] = $this->input->post('nombre_del_desafio');
                $desafio['descripcion_del_desafio'] = $this->input->post('descripcion_del_desafio');
                $desafio['requisitos_del_desafio'] = $this->input->post('requisitos_del_desafio');

                $date = date('Y-m-d', time());
                if ($desafio['fecha_fin_de_postulacion'] >= $date) {
                    $desafio['estado_id'] = DESAF_VIGENTE;
                }

                $desafio['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
                $desafio['fecha_modifico'] = date('Y-m-d H:i:s', time());

                $categorias = $this->input->post('categorias');
                $this->Desafios_model->eliminarCategoriaByDesafioId($desafio_id);
                if ($this->Desafios_model->editarDesafio($desafio, $desafio_id, $categorias)) {
                    echo json_encode(array(
                        'status_code' => 200,
                    ));
                }
            }
        }
    }

    public function ver($desafio_id)
    {
        if ($this->session->userdata('user_data')->rol_id != ROL_STARTUP) {
            redirect(base_url() . 'home');
        }
        $data['files_js'] = array('desafios/desafio_postularme.js');
        $data['desafio'] = $this->Desafios_model->getDesafioById($desafio_id);
        $this->load->model('postulados/Postulados_model');
        $postulaciones = $this->Postulados_model->getPostulacionesByStartupId($this->session->userdata('user_data')->id);
        foreach ($postulaciones as $postulacion) {
            $data['postulaciones'][$postulacion->desafio_id] = $postulacion;
        }
        $data['sections_view'] = 'ficha_desafio_view_startup';
        $data['title'] = 'Desafíos';
        $this->load->view('layout_back_view', $data);
    }

    public function verDesafio($desafio_id)
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }
        if (!($this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA || $this->session->userdata('user_data')->rol_id == ROL_ADMIN_ORGANIZACION)) {
            redirect(base_url() . 'home');
        }
        $data['desafio'] = $this->Desafios_model->getDesafioById($desafio_id);
        $data['postulados'] = $this->Desafios_model->getPostuladosByDesafioId($desafio_id);
        if (!$data['desafio']) {
            redirect(base_url() . 'desafios');
        }
        $data['files_js'] = array('activar_tabla_comun.js');
        $data['sections_view'] = 'ficha_desafio_view_admin';
        $data['title'] = 'Ver desafío';
        $this->load->view('layout_back_view', $data);
    }

    public function crearNotificacion($data_mensaje, $data_usuario_para, $data_de_usuario, $buscar_y_reemplazar)
    {
        if (!$data_usuario_para) {
            $data_usuario_para_id = 0;
            $data_usuario_rol_id = ROL_ADMIN_ORGANIZACION;
        } else {
            $data_usuario_para_id = @$data_usuario_para->id_empresa ? $data_usuario_para->id_empresa : @$data_usuario_para->usuario_id;
            $data_usuario_rol_id = @$data_usuario_para->rol_id ? $data_usuario_para->rol_id : ROL_EMPRESA;
        }

        $de_usuario_id = $data_de_usuario->id;
        $de_rol_id = $data_de_usuario->rol_id;

        crear_notificacion($de_usuario_id, $de_rol_id, $data_mensaje, $data_usuario_para_id, $data_usuario_rol_id, $buscar_y_reemplazar);
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

    public function verificar_fecha_fin_postulacion($fecha_fin, $fechas_parametros) //fecha de fin de postulación debe ser mayor a fecha de inicio
    {
        $fecha_inicio = explode(',', $fechas_parametros)[0];

        $fecha_fin_bd = explode(',', $fechas_parametros)[1] ? explode(',', $fechas_parametros)[1] : false;

        if ($fecha_inicio >= $fecha_fin) {
            $this->form_validation->set_message('verificar_fecha_fin_postulacion', 'El campo {field} debe ser mayor a la fecha de Inicio del desafío');
            return false;
        } else {
            if ($fecha_fin_bd) { //si existe fecha bd comparo que es mas lejano la fecha existente en bd o el dia actual.
                $date = date('Y-m-d', time());
                $fecha_de_bd = false;
                if ($fecha_fin_bd < $date) {
                    $date = $fecha_fin_bd;
                    $fecha_de_bd = true;
                }
                if ($fecha_fin < $date) { //si fecha nueva es menor a FECHA DE BD O DIA ACTUAL devuelvo falso
                    if ($fecha_de_bd) {
                        $this->form_validation->set_message('verificar_fecha_fin_postulacion', 'El campo {field} debe ser mayor o igual a la fecha de Fin de postulación que ya se encontraba registrada.');
                    } else {
                        $this->form_validation->set_message('verificar_fecha_fin_postulacion', 'El campo {field} debe ser mayor a la fecha de hoy.');
                    }
                    return false;
                }
            }
            return true;
        }
    }

    public function verificar_fecha_inicio($fecha_inicio, $fecha_inicio_bd = false)
    { //fecha de inicio de postulación debe ser mayor o igual a la fecha actual
        $date = date('Y-m-d', time());
        $fecha_de_bd = false;
        if ($fecha_inicio_bd) { //si es editar, existe fecha_inicio_bd, comparo cual es mas antigua, si fecha_inicio_bd es mas vieja reemplazo date
            if ($fecha_inicio_bd < $date) {
                $date = $fecha_inicio_bd;
                $fecha_de_bd = true;
            }
        }
        if ($fecha_inicio < $date) {
            if ($fecha_de_bd) {
                $this->form_validation->set_message('verificar_fecha_inicio', 'El campo {field} debe ser mayor o igual a la fecha de Inicio de postulación que ya se encontraba registrada.');
            } else {
                $this->form_validation->set_message('verificar_fecha_inicio', 'El campo {field} debe ser mayor a la fecha de hoy.');
            }
            return false;
        } else {
            return true;
        }
    }

    public function rulesEditarDesafio($desafio_data, $is_admin = false)
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($is_admin) { //SI SOY ADMIN VALIDO ESTO.
            $this->form_validation->set_rules( //no verifico fecha de inicio
                'inicio_del_desafio',
                'Inicio del desafío',
                'required',
                array(
                    'required' => 'El campo {field} es obligatorio.',
                )
            );
            $this->form_validation->set_rules( //solo verifico que fecha de fin de postulacion sea mayor a fecha de inicio
                'fin_del_desafio',
                'Fin del desafío',
                'required|callback_verificar_fecha_fin_postulacion[' . $this->input->post('inicio_del_desafio') . ']',
                array(
                    'required' => 'El campo {field} es obligatorio.',
                )
            ); //FIN $IS_ADMIN
        } else { //si no soy admin hago estas validaciones
            $this->form_validation->set_rules(
                'inicio_del_desafio',
                'Inicio del desafío',
                'required|callback_verificar_fecha_inicio[' . $desafio_data->fecha_inicio_de_postulacion . ']',
                array(
                    'required' => 'El campo {field} es obligatorio.',
                )
            );
            $this->form_validation->set_rules(
                'fin_del_desafio',
                'Fin del desafío',
                'required|callback_verificar_fecha_fin_postulacion[' . $this->input->post('inicio_del_desafio') . ',' . $desafio_data->fecha_fin_de_postulacion . ']',
                array(
                    'required' => 'El campo {field} es obligatorio.',
                )
            );
        }

        $this->form_validation->set_rules(
            'nombre_del_desafio',
            'Nombre del desafio',
            'trim|required|max_length[1000]',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'descripcion_del_desafio',
            'Descripcion',
            'trim|required|max_length[5000]',
            array(
                'required' => 'El campo {field} es obligatorio.'
            )
        );
        $this->form_validation->set_rules(
            'requisitos_del_desafio',
            'Requisitos del desafío',
            'trim|max_length[5000]',
        );
        $this->form_validation->set_rules(
            'categorias[]',
            'categorías',
            'integer|required',
            array(
                'required' => 'Debe elegir al menos una categoría'
            )
        );
    }

    public function eliminar()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($this->session->userdata('user_data')->rol_id != ROL_ADMIN_PLATAFORMA) {
            $data = array(
                'status'    => false,
                'msg'       => 'No tiene permisos para realizar esta modificación'
            );
        } else {
            $desafio_id = $this->input->post('desafio_id');
            $data_desafio['estado_id'] = DESAF_ELIMINADO;
            $data_desafio['usuario_id_modifico'] = $this->session->userdata('user_data')->id;
            $data_desafio['fecha_modifico'] = date('Y-m-d H:i:s', time());
            if ($this->Desafios_model->actualizarDesafio($data_desafio, $desafio_id)) {
                $data = array(
                    'status'    => true,
                );
            } else {
                $data = array(
                    'status'    => false,
                    'msg'       => 'No fue posible modificar el desafío.'
                );
            }
        }
        echo json_encode($data);
    }

    public function compartirDesafio()
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }

        if (!$this->input->is_ajax_request() && $this->session->userdata('user_data')->rol_id != ROL_PARTNER) {
            redirect(base_url() . 'home');
        }
        
        $desafio_compartido = $this->Desafios_model->getDesafioCompartido($this->input->post('desafio_id'),$this->input->post('startup_id'),$this->session->userdata('user_data')->id);

        if($desafio_compartido){
            $data = array(
                'status' => false,
                'msg' =>'Este desafío ya fue compartido.',
            );
        }else{
            $data_compartir['desafio_id'] = $this->input->post('desafio_id');
            $data_compartir['empresa_id'] = $this->input->post('empresa_id');
            $data_compartir['startup_id'] = $this->input->post('startup_id');
            $data_compartir['partner_id'] = $this->session->userdata('user_data')->id;
            $data_compartir['fecha'] = date('Y-m-d H:i:s', time());
            if ($this->Desafios_model->compartirDesafio($data_compartir)) {
    
                $this->load->model('startups/Startups_model');
                $this->load->model('empresas/Empresas_model');
                $this->load->model('partners/Partners_model');
                $this->load->model('mensajes/Mensajes_model');
                $this->load->helper(array('send_email_helper'));
    
                $startup_data = $this->Startups_model->getStartupById($this->input->post('startup_id'));
                $empresa_data = $this->Empresas_model->getEmpresaById($this->input->post('empresa_id'));
                $partner_data = $this->Partners_model->getPartnerById($this->session->userdata('user_data')->id);
                $desafio_data = $this->Desafios_model->getDesafioById($this->input->post('desafio_id'));
    
    
                $enlace_desafio = '<a href="' . base_url() . 'desafios/ver/' . $desafio_data->desafio_id . '">Ver desafío</a>';
    
                $buscar_y_reemplazar = array(
                    array('buscar' => '{{RAZON_SOCIAL_STARTUP}}', 'reemplazar' => $startup_data->razon_social),
                    array('buscar' => '{{RAZON_SOCIAL_EMPRESA}}', 'reemplazar' => $empresa_data->razon_social),
                    array('buscar' => '{{RAZON_SOCIAL_PARTNER}}', 'reemplazar' => $partner_data->razon_social),
                    array('buscar' => '{{DESAFIO_TITULO}}', 'reemplazar' => $desafio_data->nombre_del_desafio),
                    array('buscar' => '{{ENLACE_DESAFIO}}', 'reemplazar' => $enlace_desafio)
                );
    
                $mensaje_de_plataforma = $this->Mensajes_model->getMensaje('mensaje_compartir_desafio');
    
                switch ($mensaje_de_plataforma->tipo_de_envio_id) {
                    case ENVIO_NOTIFICACION:
                        $mensaje_de_notificacion = $this->Mensajes_model->getMensaje('mensaje_nueva_notificacion');
                        $this->crearNotificacion($mensaje_de_plataforma, $startup_data, $this->session->userdata('user_data'), $buscar_y_reemplazar);
                        $this->crearEmail($mensaje_de_notificacion, $startup_data, $buscar_y_reemplazar);
                        break;
                    case ENVIO_EMAIL:
                        $this->crearEmail($mensaje_de_plataforma, $startup_data, $buscar_y_reemplazar);
                        break;
                    case ENVIO_NOTIF_EMAIL:
                        $this->crearNotificacion($mensaje_de_plataforma, $startup_data, $this->session->userdata('user_data'), $buscar_y_reemplazar);
                        $this->crearEmail($mensaje_de_plataforma, $startup_data, $buscar_y_reemplazar);
                        break;
                }
    
                $data = array(
                    'status' => true,
                );
            } else {
                $data = array(
                    'status' => false,
                    'msg' =>'No fue posible compartir este desafío, por favor aguarde unos instantes e intente nuevamente.',
                );
            }
        }
        echo json_encode($data);
    }
    
    public function getDesafiosCompatiblesPorStartupId(){
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }

        if (!$this->input->is_ajax_request() && $this->session->userdata('user_data')->rol_id != ROL_PARTNER) {
            redirect(base_url() . 'home');
        }

        $startup_id = $this->input->post('startup_id');
        $partner_id = $this->session->userdata('user_data')->id;
        $this->load->model('startups/Startups_model');
        $categorias_startup = $this->Startups_model->getCategoriasDeLaStartup($startup_id);
        $array_categorias_startup = [];
        foreach ($categorias_startup as $categoria) {
            $array_categorias_startup[] = $categoria->categoria_id;
        }
        $desafiosCompatibles = $this->Desafios_model->getDesafiosCompatiblesPorStartupId($array_categorias_startup, $partner_id, $startup_id);
        $data = array(
            'status' => true,
            'data' => $desafiosCompatibles
        );
        echo json_encode($data);
    }

    public function getDesafioById()
    {
        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }

        if (!$this->input->is_ajax_request() && $this->session->userdata('user_data')->rol_id != ROL_PARTNER) {
            redirect(base_url() . 'home');
        }

        $desafio_id = $this->input->post('desafio_id');
        $startup_id = $this->input->post('startup_id');
        $partner_id = $this->session->userdata('user_data')->id;
        $desafio_data = $this->Desafios_model->getDesafioByIdForPartner($startup_id, $partner_id, $desafio_id);
        $data = array(
            'status' => true,
            'data' => $desafio_data
        );
        echo json_encode($data);
    }
}
