<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Profile_model');
        $this->load->library(array('my_form_validation'));
        $this->form_validation->run($this);
    }

    public function index()
    {

        if (!$this->session->userdata('user_data')) {
            redirect(base_url() . 'auth/login');
        }

        $data['data_perfil'] = $this->Profile_model->getPerfilData($this->session->userdata('user_data')->id, $this->session->userdata('user_data')->rol_id);
        //CARGO LAS VISTAS Y SUS DATOS SEGUN EL ROL
        switch ($this->session->userdata('user_data')->rol_id) {
            case ROL_STARTUP:
                $data['categorias'] = $this->Profile_model->getCategorias();
                $data['categorias_seleccionadas'] = $this->Profile_model->getCategoriasSeleccionadas($this->session->userdata('user_data')->id);
                $data['sections_view'] = 'profile_startup_view';
                break;
            case ROL_EMPRESA:
                $data['sections_view'] = 'profile_empresa_view';
                break;
            case ROL_ADMIN_ORGANIZACION:
            case ROL_ADMIN_PLATAFORMA:
                $data['sections_view'] = 'profile_admins_view';
                break;
        }

        $data['files_js'] = array('profile.js', 'perfil/images.js');
        $data['title'] = 'Perfil';
        $data['subtitle'] = 'Editar perfil';



        //SEGUN EL ROL, HAGO VALIDACIONES DEL POST.

        if ($this->input->post()) {
            if ($this->session->userdata('user_data')->rol_id == ROL_ADMIN_ORGANIZACION || $this->session->userdata('user_data')->rol_id == ROL_ADMIN_PLATAFORMA) {
                $this->rulesPerfilAdmin($data['data_perfil']);
            } else {
                $this->rulesPerfil($data['data_perfil']);
            }
            if ($this->form_validation->run() != FALSE) {
                switch ($this->session->userdata('user_data')->rol_id) {
                    case ROL_STARTUP:
                        $data_startup['titular'] = $this->input->post('titular');
                        $data_startup['razon_social'] = $this->input->post('razon_social');
                        $data_startup['cuit'] = $this->input->post('cuit');
                        $data_startup['email_startup'] = $this->input->post('email_startup');
                        $data_startup['telefono_startup'] = $this->input->post('telefono_startup');
                        $data_startup['pais'] = $this->input->post('pais');
                        $data_startup['provincia'] = $this->input->post('provincia');
                        $data_startup['localidad'] = $this->input->post('localidad');
                        $data_startup['direccion'] = $this->input->post('direccion');
                        $data_startup['url_web'] = $this->input->post('url_web');
                        $data_startup['url_youtube'] = $this->input->post('url_youtube');
                        $data_startup['url_instagram'] = $this->input->post('url_instagram');
                        $data_startup['url_facebook'] = $this->input->post('url_facebook');
                        $data_startup['url_twitter'] = $this->input->post('url_twitter');
                        $data_startup['rubro'] = $this->input->post('rubro');
                        $data_startup['descripcion'] = $this->input->post('descripcion');
                        $data_startup['antecedentes'] = $this->input->post('descripcion');
                        $data_startup['exporta'] = $this->input->post('exporta');

                        for ($i = 0; $i < count($this->input->post('categories')); $i++) {
                            $data_categorias_seleccionadas[$i]['startup_id']     = $this->session->userdata('user_data')->id;
                            $data_categorias_seleccionadas[$i]['categoria_id'] = $this->input->post('categories')[$i];
                            $data_categorias_seleccionadas[$i]['descripcion'] = $this->input->post('category_description[' . $this->input->post('categories')[$i] . ']');
                        }

                        //Guardo datos del usuario
                        $data_usuario['logo'] = true;
                        $data_usuario['nombre'] = $this->input->post('nombre');
                        $data_usuario['apellido'] = $this->input->post('apellido');
                        $data_usuario['email'] = $this->input->post('email');
                        $data_usuario['telefono'] = $this->input->post('telefono');
                        $data_usuario['perfil_completo'] = true;
                        $data_usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());

                        if ($this->Profile_model->updatePerfilStartup($data_startup, $data_usuario, $data_categorias_seleccionadas, $this->session->userdata('user_data')->id)) {
                            $this->session->userdata('user_data')->perfil_completo = 1;
                            if ($this->input->post('profile_img')) {
                                $data_img = explode(',', $this->input->post('profile_img'));
                                $data_img_decoded = base64_decode($data_img[1]);
                                $fichero = './uploads/imagenes_de_usuarios/' . $this->session->userdata('user_data')->id . '.png';
                                file_put_contents($fichero, $data_img_decoded);
                                $this->session->userdata('user_data')->logo = true;
                            }
                            if ($data['data_perfil']->email != $this->input->post('email')) {
                                $this->session->userdata('user_data')->email = $this->input->post('email');
                            }
                            $message = '{
                                "title":"Perfil cargado con éxito",
                                "text": "Se modificó el perfil correctamente.",
                                "type": "success",
                                "buttonsStyling": true,
                                "timer":5000,
                                "confirmButtonClass": "btn btn-success"
                            }';
                            $this->session->set_flashdata('message', $message);
                            redirect(base_url() . 'home');
                        }
                        break;
                    case ROL_EMPRESA:
                        //Guardo datos de empresa
                        $data_empresa['titular'] = $this->input->post('titular');
                        $data_empresa['razon_social'] = $this->input->post('razon_social');
                        $data_empresa['cuit'] = $this->input->post('cuit');
                        $data_empresa['email_empresa'] = $this->input->post('email_empresa');
                        $data_empresa['telefono_empresa'] = $this->input->post('telefono_empresa');
                        $data_empresa['pais'] = $this->input->post('pais');
                        $data_empresa['provincia'] = $this->input->post('provincia');
                        $data_empresa['localidad'] = $this->input->post('localidad');
                        $data_empresa['direccion'] = $this->input->post('direccion');
                        $data_empresa['url_web'] = $this->input->post('url_web');
                        $data_empresa['url_youtube'] = $this->input->post('url_youtube');
                        $data_empresa['url_instagram'] = $this->input->post('url_instagram');
                        $data_empresa['url_facebook'] = $this->input->post('url_facebook');
                        $data_empresa['url_twitter'] = $this->input->post('url_twitter');
                        $data_empresa['rubro'] = $this->input->post('rubro');
                        $data_empresa['descripcion'] = $this->input->post('descripcion');
                        $data_empresa['exporta'] = $this->input->post('exporta');


                        //Guardo datos del usuario
                        $data_usuario['logo'] = true;
                        $data_usuario['nombre'] = $this->input->post('nombre');
                        $data_usuario['apellido'] = $this->input->post('apellido');
                        $data_usuario['email'] = $this->input->post('email');
                        $data_usuario['telefono'] = $this->input->post('telefono');
                        $data_usuario['perfil_completo'] = true;
                        $data_usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());

                        if ($this->Profile_model->updatePerfilEmpresa($data_empresa, $data_usuario, $this->session->userdata('user_data')->id)) {
                            $this->session->userdata('user_data')->perfil_completo = 1;
                            if ($this->input->post('profile_img')) {
                                $data_img = explode(',', $this->input->post('profile_img'));
                                $data_img_decoded = base64_decode($data_img[1]);
                                $fichero = './uploads/imagenes_de_usuarios/' . $this->session->userdata('user_data')->id . '.png';
                                file_put_contents($fichero, $data_img_decoded);
                                $this->session->userdata('user_data')->logo = true;
                            }
                            if ($data['data_perfil']->email != $this->input->post('email')) {
                                $this->session->userdata('user_data')->email = $this->input->post('email');
                            }
                            $message = '{
                                "title":"Perfil cargado con éxito",
                                "text": "Se modificó el perfil correctamente.",
                                "type": "success",
                                "buttonsStyling": true,
                                "timer":5000,
                                "confirmButtonClass": "btn btn-success"
                            }';
                            $this->session->set_flashdata('message', $message);
                            redirect(base_url() . 'home');
                        }
                        break;
                    case ROL_ADMIN_ORGANIZACION:
                    case ROL_ADMIN_PLATAFORMA:
                        //Guardo datos del usuario
                        $data_usuario['logo'] = true;
                        $data_usuario['nombre'] = $this->input->post('nombre');
                        $data_usuario['apellido'] = $this->input->post('apellido');
                        $data_usuario['email'] = $this->input->post('email');
                        $data_usuario['perfil_completo'] = true;
                        $data_usuario['fecha_modifico'] = date('Y-m-d H:i:s', time());

                        $this->Profile_model->updatePerfilAdmin($data_usuario, $this->session->userdata('user_data')->id);

                        $this->session->userdata('user_data')->perfil_completo = 1;
                        if ($this->input->post('profile_img')) {
                            $data_img = explode(',', $this->input->post('profile_img'));
                            $data_img_decoded = base64_decode($data_img[1]);
                            $fichero = './uploads/imagenes_de_usuarios/' . $this->session->userdata('user_data')->id . '.png';
                            file_put_contents($fichero, $data_img_decoded);
                            $this->session->userdata('user_data')->logo = true;
                        }
                        if ($data['data_perfil']->email != $this->input->post('email')) {
                            $this->session->userdata('user_data')->email = $this->input->post('email');
                        }
                        $message = '{
                                "title":"Perfil cargado con éxito",
                                "text": "Se modificó el perfil correctamente.",
                                "type": "success",
                                "buttonsStyling": true,
                                "timer":5000,
                                "confirmButtonClass": "btn btn-success"
                            }';
                        $this->session->set_flashdata('message', $message);
                        redirect(base_url() . 'home');
                        break;
                }
            }
        }


        $this->load->view('layout_back_view', $data);
        // $data['categories_selected'] = $this->Profile_model->getCategoriesSelected($this->session->userdata('user_data')->id);

        // switch ($this->session->userdata('user_data')->rol_id){
        //     case ROL_STARTUP:
        //         // $data['profile_startup'] = $this->Profile_model->getStartupProfile($this->session->userdata('user_data')->id);
        //         if($this->input->post()){
        //             $this->rulesStartupProfile($data['profile_startup']);
        //             if($this->form_validation->run() != FALSE){

        //                 $data_empresa['titular'] = $this->input->post('titular');
        //                 $data_empresa['name'] = $this->input->post('razon_social');
        //                 $data_empresa['image'] = $this->session->userdata('user_data')->id.'.png';
        //                 $data_empresa['cuit'] = $this->input->post('cuit');
        //                 $data_empresa['company_email'] = $this->input->post('company_email');
        //                 $data_empresa['company_phone'] = $this->input->post('company_phone');
        //                 $data_empresa['country'] = $this->input->post('country');
        //                 $data_empresa['state'] = $this->input->post('state');
        //                 $data_empresa['city'] = $this->input->post('city');
        //                 $data_empresa['address'] = $this->input->post('address');
        //                 $data_empresa['company_url'] = $this->input->post('company_url');
        //                 $data_empresa['youtube_url'] = $this->input->post('youtube_url');
        //                 $data_empresa['instagram_url'] = $this->input->post('instagram_url');
        //                 $data_empresa['facebook_url'] = $this->input->post('facebook_url');
        //                 $data_empresa['twitter_url'] = $this->input->post('twitter_url');
        //                 $data_empresa['rubro'] = $this->input->post('rubro');
        //                 $data_empresa['description'] = $this->input->post('description');
        //                 $data_empresa['company_references'] = $this->input->post('company_references');
        //                 $data_empresa['export'] = $this->input->post('export');

        //                 for($i=0; $i < count($this->input->post('categories'));$i++){
        //                     $data_categories_selected[$i]['category_id'] = $this->input->post('categories')[$i];
        //                     // $data_categories_selected[$i]['description_selected'] = $this->input->post('category_description['.$this->input->post('categories')[$i].']');
        //                     $data_categories_selected[$i]['user_id']     = $this->session->userdata('user_data')->id;
        //                     $data_categories_selected[$i]['rol_id']      = $this->session->userdata('user_data')->rol_id;
        //                 }

        //                 $data_usuario['name'] = $this->input->post('contact_name');
        //                 $data_usuario['lastname'] = $this->input->post('lastname');
        //                 $data_usuario['email'] = $this->input->post('contact_email');
        //                 $data_usuario['phone'] = $this->input->post('contact_phone');
        //                 $data_usuario['complete_perfil'] = 1;

        //                 if($this->Profile_model->updateStartupProfile($data_empresa,$data_usuario,$data_categories_selected,$this->session->userdata('user_data')->id)){
        //                     $this->session->userdata('user_data')->complete_perfil = 1;
        //                     if($this->input->post('profile_img')){
        //                         $data_img = explode(',',$this->input->post('profile_img'));
        //                         $data_img_decoded = base64_decode($data_img[1]);
        //                         $fichero = './images_startups/'.$this->session->userdata('user_data')->id.'.png';
        //                         file_put_contents($fichero,$data_img_decoded);
        //                     }
        //                     if($data['profile_startup']->email != $this->input->post('contact_email')){
        //                         $this->session->userdata('user_data')->email = $this->input->post('contact_email');
        //                     }
        //                     $message ='{
        //                         "title":"Perfil cargado con éxito",
        //                         "text": "Se modificó el perfil correctamente.",
        //                         "type": "success",
        //                         "buttonsStyling": true,
        //                         "timer":5000,
        //                         "confirmButtonClass": "btn btn-success"
        //                     }';
        //                     $this->session->set_flashdata('message',$message);
        //                     redirect(base_url().'home');
        //                 }
        //             }
        //         }

        //         $data['sections_view'] ="profile_startup_view";
        //         break;

        //                 
        // }
    }

    function rulesPerfil($data_perfil)
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules(
            'titular',
            'Titular',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'razon_social',
            'Razón social',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        // if (!$data_perfil->logo) {
        //     $this->form_validation->set_rules(
        //         'profile_img',
        //         'Logo de la empresa',
        //         'required',
        //         array(
        //             'required'  => 'El campo {field} es obligatorio',
        //         )
        //     );
        // }
        $this->form_validation->set_rules(
            'cuit',
            'CUIT',
            'numeric|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'email_empresa',
            'E-mail',
            'valid_email',
            array(
                'valid_email' => 'El campo {field} no es un e-mail válido',
            )
        );
        $this->form_validation->set_rules(
            'telefono_empresa',
            'Teléfono',
            'trim'
        );
        $this->form_validation->set_rules(
            'pais',
            'País',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'provincia',
            'Provincia/Estado',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'localidad',
            'Localidad/Ciudad',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'direccion',
            'Dirección',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'url_web',
            'URL Web',
            'valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );
        $this->form_validation->set_rules(
            'url_youtube',
            'URL YouTube',
            'valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );
        $this->form_validation->set_rules(
            'url_instagram',
            'URL Instagram',
            'valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );
        $this->form_validation->set_rules(
            'url_facebook',
            'URL Facebook',
            'valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );
        $this->form_validation->set_rules(
            'url_twitter',
            'URL Twitter',
            'valid_url',
            array(
                'valid_url' => 'El campo {field} debe ser una url valida, por ejemplo http://www.example.com',
            )
        );

        $this->form_validation->set_rules(
            'rubro',
            'Rubro',
            'trim',
        );
        $this->form_validation->set_rules(
            'descripcion',
            'Descripción',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'exporta',
            'Exporta',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'nombre',
            'Nombre',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'apellido',
            'Apellido',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'valid_email|required|callback_validar_email[' . $data_perfil->email . ']',
            array(
                'valid_email' => 'El campo {field} no es un e-mail válido',
                'required'  => 'El campo {field} es obligatorio',
                'validar_email' => 'El E-Mail indicado ya se encuentra en uso.'
            )
        );
        $this->form_validation->set_rules(
            'telefono',
            'Teléfono',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        if ($this->session->userdata('user_data')->rol_id == ROL_STARTUP) {
            $this->form_validation->set_rules(
                'antecedentes',
                'Antecedentes',
                'trim',
            );
            $this->form_validation->set_rules(
                'categories[]',
                'Servicios/Productos que ofrece',
                'integer|required',
                array(
                    'required'  => 'Debe seleccionar al menos un servicio/producto',
                )
            );
            foreach ($this->input->post('category_description') as $key => $value) {
                $this->form_validation->set_rules(
                    'category_description[' . $key . ']',
                    'Descripción',
                    'trim'
                );
            }
        }
    }
    function rulesPerfilAdmin($data_perfil)
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        // if (!$data_perfil->logo) {
        //     $this->form_validation->set_rules(
        //         'profile_img',
        //         'Logo de la empresa',
        //         'required',
        //         array(
        //             'required'  => 'El campo {field} es obligatorio',
        //         )
        //     );
        // }
        $this->form_validation->set_rules(
            'nombre',
            'Nombre',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'apellido',
            'Apellido',
            'trim|required',
            array(
                'required'  => 'El campo {field} es obligatorio',
            )
        );
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'valid_email|required|callback_validar_email[' . $data_perfil->email . ']',
            array(
                'valid_email' => 'El campo {field} no es un e-mail válido',
                'required'  => 'El campo {field} es obligatorio',
                'validar_email' => 'El E-Mail indicado ya se encuentra en uso.'
            )
        );
    }

    public function validar_email($email, $current_email = FALSE)
    {
        if ($current_email && $current_email == $email) {
            return TRUE;
        }
        if ($this->Profile_model->getEmails($email)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
