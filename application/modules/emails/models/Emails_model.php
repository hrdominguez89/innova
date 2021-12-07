<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emails_model extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->load->database();
    }

    public function encolarCorreo($email_data){
        $this->db->trans_begin();

        $this->db->insert('emails', $email_data);
        $insert_id = $this->db->insert_id();
        // Condicional del Rollback 
        if ($this->db->trans_status() === FALSE) {
            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return $insert_id;
        } //If Rollback
    }

    public function getCorreoById($correo_id){
        return $this->db->select('*')->where('id',$correo_id)->get('emails')->row();
    }

    public function getCorreosNuevosYPendientes(){

    }

    public function updateEmail($email_data,$email_id){
        $this->db->trans_begin();

        $this->db->where('id',$email_id);
        $this->db->update('emails', $email_data);
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

?>