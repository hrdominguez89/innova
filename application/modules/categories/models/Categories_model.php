<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model {
    
    public function __construct()
	{
        parent::__construct();
        $this->load->database();
    }

    public function setCategory($data_category){
        $this->db->trans_begin();

		$this->db->insert('categorias', $data_category);

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

    public function updateCategory($data_category,$category_id){
        $this->db->trans_begin();

        $this->db->where('id',$category_id);
        $this->db->update('categorias',$data_category);

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
    
    public function getCategories($limit,$start){
        $this->db->limit($start,$limit);
        $this->db->order_by('descripcion asc');
        return $this->db->get('categorias')->result();
    }
    
    public function getTotalCategories(){
        return $this->db->get('categorias')->result();
    }

    public function getCategoryById($category_id){
        $this->db->where('id',$category_id);
        return $this->db->get('categorias')->row();
    }

    public function getCategoryByDescription($description){
        $this->db->where('descripcion',$description);
        return $this->db->get('categorias')->row();
    }
    
}