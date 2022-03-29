<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Postulados_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getDesafiosPostuladosByUserId($usuario_id, $start = false, $limit = false)
    {
        if ($limit !== false && $start !== false) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->select('vd.*,ep.id as estado_postulacion,p.id as postulacion_id')
            ->from('vi_desafios vd')
            ->join('postulaciones as p', 'p.desafio_id = vd.desafio_id')
            ->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion')
            ->where('p.startup_id', $usuario_id)
            ->where('vd.desafio_estado_id !=', DESAF_ELIMINADO)
            ->where('vd.desafio_estado_id !=', DESAF_RECHAZADO)
            ->where('vd.desafio_estado_id !=', DESAF_CERRADO)
            ->where('p.estado_postulacion !=', POST_ELIMINADO)
            ->where('p.estado_postulacion !=', POST_CANCELADO)
            ->where('p.estado_postulacion !=', POST_RECHAZADO)
            ->group_start()
            ->where('vd.estado_usuario_id', USR_ENABLED)
            ->or_where('vd.estado_usuario_id', USR_VERIFIED)
            ->group_end()
            ->group_by('vd.desafio_id')
            ->get()->result();
        return $query;
    }

    public function getDesafiosYPostuladosByEmpresaUserId($usuario_id, $start = false, $limit = false)
    {
        if ($limit !== false && $start !== false) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->select('vd.*,ep.id as estado_postulacion,SUM(CASE WHEN p.startup_id IS NULL THEN 0 ELSE 1 END) AS cantidad_de_startups_postuladas')
            ->from('vi_desafios as vd')
            ->join('postulaciones as p', 'p.desafio_id = vd.desafio_id', 'left')
            ->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion', 'left')
            ->where('vd.id_empresa', $usuario_id)
            ->where('vd.desafio_estado_id !=', DESAF_ELIMINADO)
            ->where('vd.desafio_estado_id !=', DESAF_RECHAZADO)
            ->where('vd.desafio_estado_id !=', DESAF_CANCELADO)
            ->where('p.estado_postulacion !=', POST_ELIMINADO)
            ->where('p.estado_postulacion !=', POST_CANCELADO)
            ->where('p.estado_postulacion !=', POST_RECHAZADO)
            ->group_start()
            ->where('vd.estado_usuario_id', USR_ENABLED)
            ->or_where('vd.estado_usuario_id', USR_VERIFIED)
            ->group_end()
            ->group_by('vd.desafio_id')
            ->get()->result();
        return $query;
    }

    public function getPostuladosByDesafioId($desafio_id, $start = false, $limit = false)
    {
        if ($limit !== false && $start !== false) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->select('
            st.razon_social,
            st.titular,
            st.antecedentes,
            u.id as startup_id,
            CONCAT(u.nombre," ",u.apellido) as contacto_startup,
            ep.estado as estado_postulacion,
            (SELECT 
                COUNT(va.postulacion_id)
            FROM
                validaciones as va
            WHERE
                va.postulacion_id = p.id
            ) as cantidad_validadores
            ')
            ->from('postulaciones as p')
            ->join('usuarios as u', 'u.id = p.startup_id')
            ->join('startups as st', 'st.usuario_id = u.id')
            ->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion')
            ->where('p.desafio_id', $desafio_id)
            ->where('p.estado_postulacion !=', POST_ELIMINADO)
            ->get()->result();
        return $query;
    }

    public function getDesafiosById($desafio_id, $usuario_id)
    {
        $query = $this->db->select('vd.*')
            ->from('vi_desafios as vd')
            ->where('vd.id_empresa', $usuario_id)
            ->where('vd.desafio_id', $desafio_id)
            ->where('vd.desafio_estado_id !=', DESAF_ELIMINADO)
            ->group_start()
            ->where('vd.estado_usuario_id', USR_ENABLED)
            ->or_where('vd.estado_usuario_id', USR_VERIFIED)
            ->group_end()
            ->get()->row();
        return $query;
    }

    public function getStartupDataByIdAndDesafioId($desafio_id, $startup_id)
    {
        $query =  $this->db->select('
            vsi.*,
            vd.*,
            p.id as postulacion_id,
            p.estado_postulacion,
            ep.estado as nombre_estado_postulacion,
            p.detalle_rechazo_cancelado as detalle_rechazo_cancelado,
            cs.id as contacto_id')
            ->from('vi_startups_info as vsi')
            ->join('postulaciones as p', 'p.startup_id = vsi.usuario_id')
            ->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion')
            ->join('vi_desafios as vd', 'vd.desafio_id = p.desafio_id')
            ->join('contacto_startups as cs', 'cs.desafio_id = vd.desafio_id', 'left')
            ->where('vsi.usuario_id', $startup_id)
            ->where('vd.desafio_estado_id !=', DESAF_CERRADO)
            ->where('vd.desafio_estado_id !=', DESAF_CANCELADO)
            ->where('vd.desafio_estado_id !=', DESAF_ELIMINADO)
            ->where('p.estado_postulacion !=', POST_ELIMINADO)
            ->where('p.estado_postulacion !=', POST_CANCELADO)
            ->where('p.estado_postulacion !=', POST_RECHAZADO)
            ->where('p.desafio_id', $desafio_id)
            ->group_start()
            ->where('vd.estado_usuario_id', USR_ENABLED)
            ->or_where('vd.estado_usuario_id', USR_VERIFIED)
            ->group_end()
            ->get()->row();
        return $query;
    }

    public function insertarValidacion ($validacion_data){
        $this->db->trans_begin();

        $this->db->insert('validaciones', $validacion_data);

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

    public function getValidadores($postulacion_id){
        $query = $this->db->select('IFNULL(vaL.razon_social,"Administrador") as razon_social_validador')
        ->from('validaciones as va')
        ->where('postulacion_id',$postulacion_id)
        ->join('usuarios as u','u.id = va.validador_id','left')
        ->join('validadores as val','val.usuario_id = u.id','left')
        ->get()
        ->result();
        return $query;
    }

    public function getEstadoValidacionByValidadorId($validador_id,$postulacion_id){
        $query = $this->db->select('*')
        ->from('validaciones as va')
        ->where('va.validador_id',$validador_id)
        ->where('va.postulacion_id',$postulacion_id)
        ->get()
        ->row();
        return $query;
    }

    public function insertarContacto($data_contacto)
    {
        $this->db->trans_begin();

        $this->db->insert('contacto_startups', $data_contacto);

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

    public function getTodosLosPostulados()
    {
        $this->db->select('
        *,
        p.id as postulacion_id,
        ep.estado as estado_postulacion_nombre,
        IF(
            (SELECT 
                `va`.`validador_id`
            FROM
                `validaciones` as `va`
            WHERE 
                ' . $this->session->userdata('user_data')->id . ' = `va`.`validador_id` 
                AND 
                `p`.`id` = `va`.`postulacion_id`
            ),
            "Validado",
            "Pendiente"
        ) as `estado_validacion`
        ');
        $this->db->from('postulaciones as p');
        $this->db->join('vi_desafios as vd', 'vd.desafio_id = p.desafio_id');
        $this->db->join('vi_startups_info as vsi', 'vsi.usuario_id = p.startup_id');
        $this->db->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion');
        $this->db->where('vd.desafio_estado_id =', DESAF_VIGENTE);
        $this->db->where('p.estado_postulacion!=', POST_ELIMINADO);
        $this->db->where('p.estado_postulacion!=', POST_RECHAZADO);
        $this->db->where('p.estado_postulacion!=', POST_CANCELADO);
        $this->db->group_start();
        $this->db->where('vd.estado_usuario_id', USR_ENABLED);
        $this->db->or_where('vd.estado_usuario_id', USR_VERIFIED);
        $this->db->group_end();
        return $this->db->get()->result();
    }
    public function updatePostulacion($data_postulacion, $postulacion_id)
    {
        $this->db->trans_begin();


        $this->db->where('id', $postulacion_id);
        $this->db->update('postulaciones', $data_postulacion);

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

    public function getStartupData($startup_id)
    {
        $this->db->select('vst.*');
        $this->db->from('vi_startups_info as vst');
        $this->db->where('vst.usuario_id', $startup_id);
        $this->db->group_start();
        $this->db->where('vst.estado_usuario_id', USR_ENABLED);
        $this->db->or_where('vst.estado_usuario_id', USR_VERIFIED);
        $this->db->group_end();
        return $this->db->get()->row();
    }

    public function getDesafioData($desafio_id)
    {
        $this->db->select('*');
        $this->db->from('vi_desafios as vd');
        $this->db->where('vd.desafio_id', $desafio_id);
        $this->db->where('vd.desafio_estado_id !=', DESAF_ELIMINADO);
        $this->db->group_start();
        $this->db->where('vd.estado_usuario_id', USR_ENABLED);
        $this->db->or_where('vd.estado_usuario_id', USR_VERIFIED);
        $this->db->group_end();
        return $this->db->get()->row();
    }

    public function updatePostulado($postulacion_data, $startup_id, $desafio_id)
    {
        $this->db->where('startup_id', $startup_id);
        $this->db->where('desafio_id', $desafio_id);
        $this->db->update('postulaciones', $postulacion_data);
    }

    public function getPostulacionesByDesafioId($desafio_id, $startup_id)
    {
        return $this->db->select('p.id')
            ->from('postulaciones p')
            ->join('desafios as d', 'p.desafio_id = d.id')
            ->where('p.desafio_id', $desafio_id)
            ->where('p.startup_id', $startup_id)
            ->where('d.estado_id !=', DESAF_ELIMINADO)
            ->where('p.estado_postulacion !=', POST_ELIMINADO)
            ->get()
            ->result();
    }
    public function getPostulacionesByStartupId($startup_id)
    {
        $query = $this->db->select('p.*')
            ->from('postulaciones p')
            ->join('desafios as d', 'p.desafio_id = d.id')
            ->where('startup_id', $startup_id)
            ->where('d.estado_id !=', DESAF_ELIMINADO)
            ->where('p.estado_postulacion !=', POST_ELIMINADO)
            ->order_by('desafio_id')
            ->get()
            ->result();
        return $query;
    }
}
