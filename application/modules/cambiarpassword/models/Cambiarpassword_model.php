<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cambiarpassword_model extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->load->database();
    }

    public function updateUser($data_user,$usuario_id){
        $this->db->trans_begin();
        
        $this->db->where('id',$usuario_id);
        $this->db->update('usuarios',$data_user);

        // Condicional del Rollback 
		if ($this->db->trans_status() === FALSE){      
			//Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();  
            return FALSE;    
		}else{      
			//Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();   
            return TRUE;
		}//If Rollback
    }
}

?>