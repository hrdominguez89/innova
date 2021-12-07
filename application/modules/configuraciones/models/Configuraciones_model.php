<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuraciones_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMensajesDeLaPlataforma()
    {
        $this->db->select('*');
        return $this->db->get('mensajes_de_la_plataforma')->result();
    }

    public function getConfiguracionesDeLaPlataforma()
    {
        $this->db->select('*');
        return $this->db->get('configuraciones')->row();
    }

    public function getTiposDeEnvio()
    {
        $this->db->select('*');
        return $this->db->get('tipos_de_envio')->result();
    }

    public function getNotificadores(){
        return $this->db->select('*')->get('notificadores')->result();
    }

    public function updateConfigPlataforma($data_configuraciones_plataforma){
        $this->db->trans_begin();

        $this->db->update('configuraciones',$data_configuraciones_plataforma);

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

    public function updateConfigMensajes($data_configuraciones_mensajes,$mensaje_id){
        $this->db->trans_begin();

        $this->db->where('id',$mensaje_id);
        $this->db->update('mensajes_de_la_plataforma',$data_configuraciones_mensajes);

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
