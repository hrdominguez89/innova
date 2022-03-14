<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    private $custom_config;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    // public function getStartupDataById($startup_id){
    //     $this->db->select('*');
    //     $this->db->from('startups as s');
    //     $this->db->where('usuario_id',$startup_id);
    //     $this->db->join('usuarios as u','u.id = s.usuario_id');
    //     return $this->db->get()->row();
    // }

    // public function getEmpresaDataById($empresa_id){
    //     $this->db->select('*');
    //     $this->db->from('empresas as e');
    //     $this->db->where('usuario_id',$empresa_id);
    //     $this->db->join('usuarios as u','u.id = e.usuario_id');
    //     return $this->db->get()->row();
    // }

    public function getPerfilData($usuario_id, $rol_id)
    {
        $this->db->select('*');
        $this->db->from('usuarios as u');
        if ($rol_id == ROL_STARTUP) {
            $this->db->join('startups as st', 'u.id = st.usuario_id','left');
        } else if ($rol_id == ROL_EMPRESA) {
            $this->db->join('empresas as em', 'u.id = em.usuario_id','left');
        } else if ($rol_id == ROL_PARTNER) {
            $this->db->join('partners as pa', 'u.id = pa.usuario_id','left');
        } else if ($rol_id == ROL_VALIDADOR){

        }
        $this->db->where('u.id', $usuario_id);
        return $this->db->get()->row();
    }

    public function getTiposDePartners(){
        $this->db->select('*');
        $this->db->from('tipos_de_partners');
        $this->db->order_by('id ASC');
        return $this->db->get()->result();
    }

    public function getCategorias()
    {
        $this->db->select('*');
        $this->db->where('activo', true);
        $this->db->order_by('descripcion ASC');
        return $this->db->get('categorias')->result();
    }

    public function getCategoriasSeleccionadas($usuario_id)
    {
        $this->db->select('*');
        $this->db->from('vi_categorias_startups');
        $this->db->order_by('descripcion ASC');
        $this->db->where('usuario_id', $usuario_id);
        $this->db->where('activo', true);
        return $this->db->get()->result();
    }

    public function updatePerfilStartup($data_startup, $data_usuario, $data_categories_selected, $user_id)
    {
        $this->db->trans_begin();
        
        $this->db->where('id', $user_id);
        $this->db->update('usuarios', $data_usuario);

        if($this->db->select('id')->from('startups')->where('usuario_id',$user_id)->get()->row()){
            $this->db->where('usuario_id', $user_id);
            $this->db->update('startups', $data_startup);
        }else{
            $this->db->insert('startups', $data_startup);
        }


        $this->eliminarCategorias($user_id);
        foreach ($data_categories_selected as $data_category_selected) {
            $this->db->insert('categorias_startups', $data_category_selected);
        }
        // Condicional del Rollback 
        if ($this->db->trans_status() === FALSE) {

            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return TRUE;
        } //If Rollback
    }

    public function updatePerfilEmpresa($data_empresa, $data_usuario, $usuario_id)
    {
        $this->db->trans_begin();

        $this->db->where('usuario_id', $usuario_id);
        $this->db->update('empresas', $data_empresa);

        $this->db->where('id', $usuario_id);
        $this->db->update('usuarios', $data_usuario);

        // Condicional del Rollback 
        if ($this->db->trans_status() === FALSE) {

            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return TRUE;
        } //If Rollback
    }

    public function updatePerfilPartner($data_partner, $data_usuario, $usuario_id)
    {
        $this->db->trans_begin();

        $this->db->where('usuario_id', $usuario_id);
        $this->db->update('partners', $data_partner);

        $this->db->where('id', $usuario_id);
        $this->db->update('usuarios', $data_usuario);

        // Condicional del Rollback 
        if ($this->db->trans_status() === FALSE) {

            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return TRUE;
        } //If Rollback
    }

    public function eliminarCategorias($user_id)
    {
        $this->db->where('startup_id', $user_id);
        $this->db->delete('categorias_startups');
    }

    public function getEmails($email)
    {
        $this->db->select('*');
        $this->db->where('email', $email);
        return $this->db->get('usuarios')->row();
    }

    public function updatePerfilAdmin($dataPerfil, $usuario_id)
    {
        $this->db->trans_begin();


        $this->db->where('id', $usuario_id);
        $this->db->update('usuarios', $dataPerfil);

        // Condicional del Rollback 
        if ($this->db->trans_status() === FALSE) {

            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return TRUE;
        } //If Rollback
    }
}
