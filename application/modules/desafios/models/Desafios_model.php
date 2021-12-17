<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Desafios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getCategorias()
    {
        $this->db->select('*');
        $this->db->where('activo', true);
        $this->db->order_by('descripcion', 'ASC');
        return $this->db->get('categorias')->result();
    }

    public function getDesafiosByUserId($user_id, $estado_desafio)
    {
        $this->db->select('*');
        $this->db->where('usuario_empresa_id', $user_id);
        if ($estado_desafio == 'vigentes') {
            $this->db->where('estado_id', DESAF_VIGENTE);
        } else if ($estado_desafio == 'finalizados') {
            $this->db->where('estado_id', DESAF_FINALIZADO);
        }
        return $this->db->get('desafios')->result();
    }

    public function insertarDesafio($desafio_data, $categorias_data)
    {
        $this->db->trans_begin();

        $this->db->insert('desafios', $desafio_data);
        $desafio_id = $this->db->insert_id();

        $categoria['desafio_id'] = $desafio_id;
        $categoria['validado'] = FALSE;
        foreach ($categorias_data as $categoria_data) {
            $categoria['categoria_id'] = $categoria_data;
            $this->db->insert('categorias_desafios', $categoria);
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

    public function getDesafioByDesafioId($usuario_id, $desafio_id)
    {
        return $this->db->select('
            *,
            (
                SELECT
                    GROUP_CONCAT(c.id SEPARATOR \',\')
                    FROM categorias_desafios as cd
                    INNER JOIN categorias as c ON c.id = cd.categoria_id
                    WHERE d.id = cd.desafio_id
            ) as id_de_categorias
            ')
            ->from('desafios as d')
            ->where('d.id', $desafio_id)
            ->where('d.usuario_empresa_id', $usuario_id)
            ->get()
            ->row();
    }

    public function eliminarCategoriaByDesafioId($desafio_id)
    {
        $this->db->trans_begin();

        $this->db->where('desafio_id', $desafio_id);
        $this->db->delete('categorias_desafios');
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

    public function editarDesafio($data_desafio, $desafio_id, $categorias_data)
    {
        $this->db->trans_begin();

        $this->db->where('id', $desafio_id);
        $this->db->update('desafios', $data_desafio);

        $categoria['desafio_id'] = $desafio_id;
        $categoria['validado'] = FALSE;
        foreach ($categorias_data as $categoria_data) {
            $categoria['categoria_id'] = $categoria_data;
            $this->db->insert('categorias_desafios', $categoria);
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

    public function getDesafiosVigentesPorCategorias($array_categorias, $start = false, $limit = false)
    {
        if ($limit !== false && $start !== false) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->select('vd.*')
            ->from('vi_desafios vd')
            ->join('categorias_desafios as cd', 'cd.desafio_id = vd.desafio_id')
            ->where('vd.fecha_fin_de_postulacion >=', date('Y-m-d', time()))
            ->where_in('cd.categoria_id', $array_categorias)
            ->order_by('vd.desafio_id')
            ->group_by('vd.desafio_id')
            ->get()->result();
        return $query;
    }

    public function getDesafiosPorCategorias($array_categorias, $start = false, $limit = false)
    {
        if ($limit !== false && $start !== false) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->select('vd.*')
            ->from('vi_desafios vd')
            ->join('categorias_desafios as cd', 'cd.desafio_id = vd.desafio_id')
            ->where_in('cd.categoria_id', $array_categorias)
            ->group_by('vd.desafio_id')
            ->get()->result();
        return $query;
    }

    public function getStartupsByStatusUserId($limit, $start, $status_user_id)
    {
        $this->db->limit($limit, $start);
        $this->db->select('*,u.id as user_id,u.name as user_name,s.id as startup_id,s.name as startup_name');
        $this->db->from('users as u');
        $this->db->join('startups as s', 'u.id = s.user_id');
        $this->db->where('u.rol_id', ROL_STARTUP);
        $this->db->where('u.status_user_id', $status_user_id);
        $this->db->order_by('u.date_created', 'ASC');
        return $this->db->get()->result();
    }

    public function getCategoriasStartups($usuario_id)
    {
        $this->db->select('categoria_id');
        $this->db->from('categorias_startups');
        $this->db->where('startup_id', $usuario_id);
        return $this->db->get()->result();
    }

    public function getCantidadDePostulacionesByEmpresa($usuario_id,$empresa_id){
        return $this->db->select('p.id')
        ->from('postulaciones p')
        ->join('desafios d','d.id = p.desafio_id','left')
        ->group_start()
        ->where('p.estado_postulacion', POST_PENDIENTE)
        ->or_where('p.estado_postulacion', POST_VALIDADO)
        ->group_end()
        ->where('p.startup_id', $usuario_id)
        ->where('d.usuario_empresa_id',$empresa_id)
        ->group_start()
        ->where('d.estado_id',DESAF_VIGENTE)
        ->or_where('d.estado_id',DESAF_FINALIZADO)
        ->group_end()
        ->get()->result();
    }
    
    public function getCantidadDePostulaciones($usuario_id)
    {
        return $this->db->select('id')
            ->from('postulaciones')
            ->group_start()
            ->where('estado_postulacion', POST_PENDIENTE)
            ->or_where('estado_postulacion', POST_VALIDADO)
            ->group_end()
            ->where('startup_id', $usuario_id)
            ->get()->result();
    }

    public function getCantidadMaximaDePostulaciones()
    {
        return $this->db->select('postulaciones_maximas')
            ->from('configuraciones')
            ->get()
            ->row();
    }
    public function getDataEmpresa($usuario_id)
    {
        $this->db->select('*');
        $this->db->from('empresas');
        $this->db->where('usuario_id', $usuario_id);
        return $this->db->get()->row();
    }

    public function getDataStartup($usuario_id)
    {
        $this->db->select('*');
        $this->db->from('startups');
        $this->db->where('usuario_id', $usuario_id);
        return $this->db->get()->row();
    }

    public function insertPostulacion($postulacion)
    {
        $this->db->trans_begin();

        $this->db->insert('postulaciones', $postulacion);

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

    public function getTodosLosDesafios()
    {
        $this->db->select('vd.*,SUM(CASE WHEN p.startup_id IS NULL THEN 0 ELSE 1 END) AS cantidad_de_startups_postuladas');
        $this->db->from('vi_desafios as vd');
        $this->db->join('postulaciones as p', 'p.desafio_id = vd.desafio_id', 'left');
        $this->db->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion', 'left');
        $this->db->group_by('vd.desafio_id');
        return $this->db->get()->result();
    }

    public function getDesafioById($desafio_id)
    {
        $this->db->select('vd.*,u.email as email_contacto');
        $this->db->where('vd.desafio_id', $desafio_id);
        $this->db->from('vi_desafios as vd');
        $this->db->join('usuarios as u','u.id = vd.id_empresa');
        return $this->db->get()->row();
    }

    public function getPostuladosByDesafioId($desafio_id)
    {
        $this->db->select('*,ep.estado as estado_postulacion_descripcion');
        $this->db->from('postulaciones as p');
        $this->db->where('p.desafio_id', $desafio_id);
        $this->db->join('vi_startups_info as vsi', 'vsi.usuario_id = p.startup_id', 'left');
        $this->db->join('vi_desafios as vd', 'vd.desafio_id = p.desafio_id', 'left');
        $this->db->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion');
        return $this->db->get()->result();
    }
}
