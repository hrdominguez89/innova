<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cambiarpassword extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('Cambiarpassword_model');
    }

    public function index()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules(
                'password',
                'Contraseña nueva',
                'trim|required|max_length[72]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,72}$/]',
                array(
                    'required' => 'El campo {field} es obligatorio.',
                    'max_length' => 'El campo {field}, debe tener un máximo de {param} caracteres',
                    'regex_match' => 'La contraseña debe ser alfanumérica, mayor a 6 caracteres y debe contener al menos 1 caracter en mayúscula y al menos 1 caracter en minúscula.'
                )
            );

            $this->form_validation->set_rules(
                're_password',
                'Confirmar contraseña',
                'trim|required|matches[password]',
                array(
                    'required' => 'El campo {field} es obligatorio.',
                    'matches'  => 'Las contraseñas no coinciden.'
                )
            );
            if ($this->form_validation->run() != FALSE) {
                $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                $this->Cambiarpassword_model->updateUser($user_data, $this->session->userdata('user_data')->id);
                $mensaje = array(
                    'title'=> "Contraseña cambiada con éxito",
                    'type'=> "success",
                    'buttonsStyling'=> true,
                    'timer'=> 5000,
                    'confirmButtonClass'=> "btn btn-success",
                );
                $this->session->set_flashdata('mensaje', $mensaje);
                redirect(base_url().'cambiarpassword');
            }
        }
        $data['title'] = 'Cambiar contraseña';
        $data['sections_view'] = 'cambiar_password_view';
        $this->load->view('layout_back_view', $data);
    }
}
