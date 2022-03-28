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

    public function getDesafioByDesafioId($desafio_id, $usuario_id = false)
    {
        $this->db->select('
            *,
            (
                SELECT
                    GROUP_CONCAT(c.id SEPARATOR \',\')
                    FROM categorias_desafios as cd
                    INNER JOIN categorias as c ON c.id = cd.categoria_id
                    WHERE d.id = cd.desafio_id
            ) as id_de_categorias
            ');
        $this->db->from('desafios as d');
        $this->db->where('d.id', $desafio_id);
        if ($usuario_id) {
            $this->db->where('d.usuario_empresa_id', $usuario_id);
        }
        return  $this->db->get()->row();
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

    public function getDesafiosVigentes($start = false, $limit = false)
    {
        if ($limit !== false && $start !== false) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->select('vd.*')
            ->from('vi_desafios vd')
            ->where('vd.desafio_estado_id', DESAF_VIGENTE)
            ->group_start()
            ->where('vd.estado_usuario_id', USR_ENABLED)
            ->or_where('vd.estado_usuario_id', USR_VERIFIED)
            ->group_end()
            ->order_by('vd.desafio_id')
            ->get()->result();
        return $query;
    }

    public function getDesafiosVigentesPorCategorias($array_categorias, $start = false, $limit = false)
    {
        if ($limit !== false && $start !== false) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->select('vd.*')
            ->from('vi_desafios vd')
            ->join('categorias_desafios as cd', 'cd.desafio_id = vd.desafio_id')
            ->where('vd.desafio_estado_id', DESAF_VIGENTE)
            ->where_in('cd.categoria_id', $array_categorias)
            ->group_start()
            ->where('vd.estado_usuario_id', USR_ENABLED)
            ->or_where('vd.estado_usuario_id', USR_VERIFIED)
            ->group_end()
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
            ->group_start()
            ->where('vd.estado_usuario_id', USR_ENABLED)
            ->or_where('vd.estado_usuario_id', USR_VERIFIED)
            ->group_end()
            ->group_by('vd.desafio_id')
            ->get()->result();
        return $query;
    }

    public function getCategoriasStartups($usuario_id)
    {
        $this->db->select('categoria_id');
        $this->db->from('categorias_startups');
        $this->db->where('startup_id', $usuario_id);
        return $this->db->get()->result();
    }

    public function getCantidadDePostulacionesByEmpresa($usuario_id, $empresa_id)
    {
        return $this->db->select('p.id')
            ->from('postulaciones p')
            ->join('desafios d', 'd.id = p.desafio_id', 'left')
            ->group_start()
            ->where('p.estado_postulacion', POST_PENDIENTE)
            ->or_where('p.estado_postulacion', POST_VALIDADO)
            ->group_end()
            ->where('p.startup_id', $usuario_id)
            ->where('d.usuario_empresa_id', $empresa_id)
            ->where('d.estado_id!=', DESAF_ELIMINADO)
            ->group_start()
            ->where('d.estado_id', DESAF_VIGENTE)
            ->or_where('d.estado_id', DESAF_FINALIZADO)
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
        $this->db->where('vd.desafio_estado_id!=', DESAF_ELIMINADO);
        $this->db->group_start();
        $this->db->where('vd.estado_usuario_id', USR_ENABLED);
        $this->db->or_where('vd.estado_usuario_id', USR_VERIFIED);
        $this->db->group_end();
        $this->db->group_by('vd.desafio_id');
        return $this->db->get()->result();
    }

    public function getTodosLosDesafiosVigentes()
    {
        $this->db->select('vd.*,SUM(CASE WHEN p.startup_id IS NULL THEN 0 ELSE 1 END) AS cantidad_de_startups_postuladas');
        $this->db->from('vi_desafios as vd');
        $this->db->join('postulaciones as p', 'p.desafio_id = vd.desafio_id', 'left');
        $this->db->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion', 'left');
        $this->db->where('vd.desafio_estado_id', DESAF_VIGENTE);
        $this->db->group_start();
        $this->db->where('vd.estado_usuario_id', USR_ENABLED);
        $this->db->or_where('vd.estado_usuario_id', USR_VERIFIED);
        $this->db->group_end();
        $this->db->group_by('vd.desafio_id');
        return $this->db->get()->result();
    }
    public function getDesafioCompartido($startup_id, $desafio_id, $partner_id)
    {
        return $this->db->select('*')
            ->from('recomendaciones')
            ->where('startup_id', $startup_id)
            ->where('desafio_id', $desafio_id)
            ->where('partner_id', $partner_id)
            ->get()
            ->row();
    }

    public function getDesafioById($desafio_id)
    {
        $this->db->select('vd.*,u.email as email_contacto');
        $this->db->where('vd.desafio_id', $desafio_id);
        $this->db->group_start();
        $this->db->where('vd.estado_usuario_id', USR_ENABLED);
        $this->db->or_where('vd.estado_usuario_id', USR_VERIFIED);
        $this->db->group_end();
        $this->db->from('vi_desafios as vd');
        $this->db->join('usuarios as u', 'u.id = vd.id_empresa');
        return $this->db->get()->row();
    }

    public function getPostuladosByDesafioId($desafio_id)
    {
        $this->db->select(
            '
                            *,
                            ep.estado as estado_postulacion_descripcion,
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
                            ) as `estado_validacion`'
        );
        $this->db->from('postulaciones as p');
        $this->db->where('p.desafio_id', $desafio_id);

        $this->db->group_start();
        $this->db->where('p.estado_postulacion !=', POST_RECHAZADO);
        $this->db->where('p.estado_postulacion !=', POST_CANCELADO);
        $this->db->where('p.estado_postulacion !=', POST_ELIMINADO);
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('vd.estado_usuario_id', USR_ENABLED);
        $this->db->or_where('vd.estado_usuario_id', USR_VERIFIED);
        $this->db->group_end();

        $this->db->join('vi_startups_info as vsi', 'vsi.usuario_id = p.startup_id', 'left');
        $this->db->join('vi_desafios as vd', 'vd.desafio_id = p.desafio_id', 'left');
        $this->db->join('estados_postulaciones as ep', 'ep.id = p.estado_postulacion');
        $query = $this->db->get()->result();
        return $query;
    }

    public function actualizarDesafio($data, $desafio_id)
    {
        $this->db->trans_begin();

        $this->db->where('id', $desafio_id);

        $this->db->update('desafios', $data);

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

    public function getCategoriasDelDesafio($desafio_id)
    {
        $query = $this->db->select('*')
            ->from('categorias_desafios')
            ->where('desafio_id', $desafio_id)
            ->get()
            ->result();
        return $query;
    }

    public function compartirDesafio($data_compartir)
    {
        $this->db->trans_begin();

        $this->db->insert('recomendaciones', $data_compartir);

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

    public function getDesafiosCompatiblesPorStartupId($array_categorias, $partner_id, $startup_id)
    {
        $query = $this->db->select('
            vd.id_empresa as empresa_id,
            vd.nombre_empresa,
            vd.nombre_del_desafio,
            vd.fecha_fin_de_postulacion,
            vd.desafio_id,
            IF(
                (SELECT 
                    post.startup_id 
                FROM 
                    postulaciones post 
                WHERE
                    post.startup_id=' . $startup_id . ' 
                    AND
                    post.desafio_id=vd.desafio_id
                    AND
                    post.estado_postulacion != '.POST_ELIMINADO.'
                    AND
                    post.estado_postulacion != '.POST_RECHAZADO.'
                    AND
                    post.estado_postulacion != '.POST_CANCELADO.'
                    )
                , 1, 0) as postulado,
            IF(
                (SELECT
                    rec.startup_id
                FROM
                    recomendaciones rec
                WHERE 
                    rec.startup_id=' . $startup_id . '
                    AND 
                    rec.partner_id=' . $partner_id . '
                    AND
                    rec.desafio_id=vd.desafio_id)
                , 1, 0) as compartido')
            ->from('vi_desafios vd')
            ->join('categorias_desafios as cd', 'cd.desafio_id = vd.desafio_id')
            ->where_in('cd.categoria_id', $array_categorias)
            ->group_start()
            ->where('vd.estado_usuario_id', USR_ENABLED)
            ->or_where('vd.estado_usuario_id', USR_VERIFIED)
            ->group_end()
            ->where('vd.desafio_estado_id', DESAF_VIGENTE)
            ->order_by('vd.desafio_id')
            ->group_by('vd.desafio_id')
            ->get()->result();
        return $query;
    }
    public function getDesafioByIdForPartner($startup_id, $partner_id, $desafio_id)
    {
        $this->db->select('
        vd.logo,
        vd.nombre_empresa,
        vd.nombre_del_desafio,
        vd.fecha_fin_de_postulacion,
        vd.descripcion_del_desafio,
        vd.requisitos_del_desafio,
        vd.nombre_de_categorias,
        vd.id_empresa,
        vd.desafio_id,
        IF(ISNULL((SELECT post.startup_id FROM postulaciones post where post.startup_id=' . $startup_id . ' and post.desafio_id=' . $desafio_id . ')), 0, 1) as postulado,
        IF(ISNULL((SELECT rec.startup_id FROM recomendaciones rec where rec.startup_id=' . $startup_id . ' and rec.partner_id=' . $partner_id . ' and rec.desafio_id=' . $desafio_id . ')), 0, 1) as compartido
        ');
        $this->db->from('vi_desafios vd');
        $this->db->where('vd.desafio_id', $desafio_id);
        return $this->db->get()->row();
    }
}
