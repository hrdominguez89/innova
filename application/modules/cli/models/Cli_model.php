<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cli_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getEmailsNuevosYPendientes()
    {
        $this->db->select('*');
        $this->db->where('email_estado_id', EMAIL_NUEVO);
        $this->db->or_where('email_estado_id', EMAIL_PENDIENTE);
        return $this->db->get('emails')->result();
    }

    public function getEmailById($email_id)
    {
        $this->db->select('*');
        $this->db->where('id', $email_id);
        return $this->db->get('emails')->row();
    }

    public function updateEmail($email_data, $email_id)
    {

        $this->db->trans_begin();

        $this->db->where('id', $email_id);
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

    public function getDesafiosVencidos($date)
    {
        $this->db->select('vd.*,u.email as email_contacto, u.nombre as nombre_contacto, u.apellido as apellido_contacto');
        $this->db->from('vi_desafios as vd');
        $this->db->where('fecha_fin_de_postulacion <', $date)
            ->group_start()
            ->where('desafio_estado_id', DESAF_NUEVO)
            ->or_where('desafio_estado_id', DESAF_VIGENTE)
            ->group_end();
        $this->db->join('usuarios as u','u.id = vd.id_empresa');
        return $this->db->get()->result();
    }

    public function finalizarDesafios($desafio_data,$date){
        $this->db->where('fecha_fin_de_postulacion <', $date)
        ->group_start()
        ->where('estado_id', DESAF_NUEVO)
        ->or_where('estado_id', DESAF_VIGENTE)
        ->group_end();
        $this->db->update('desafios',$desafio_data);
    }
}
