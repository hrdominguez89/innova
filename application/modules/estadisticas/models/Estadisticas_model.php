<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas_model extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->load->database();
    }

    public function getUltimasCincoNotificaciones($usuario_id){
        $this->db->select('*');
        $this->db->where('para_usuario_id',$usuario_id);
        $this->db->order_by('fecha_alta', 'ASC');
        return $this->db->get('notificaciones')->result();
    }

    public function getNotificacionesMaximas(){
        $this->db->select('notificaciones_maximas');
        return $this->db->get('configuraciones')->row();
    }
}

?>