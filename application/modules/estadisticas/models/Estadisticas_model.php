<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estadisticas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getDesafiosPorMes($fecha_desde = false, $fecha_hasta = false)
    {
        $this->db->select('COUNT(id) as cantidad, EXTRACT(YEAR_MONTH FROM fecha_alta) as anio_mes')
            ->from('desafios')
            ->where('estado_id !=', DESAF_CANCELADO)
            ->where('estado_id !=', DESAF_ELIMINADO)
            ->where('estado_id !=', DESAF_RECHAZADO)
            ->group_by('anio_mes')
            ->order_by('anio_mes', 'ASC');
        if ($fecha_desde && $fecha_hasta) {
            $this->db->where("fecha_alta BETWEEN '{$fecha_desde}' AND '{$fecha_hasta}'");
        }
        $query = $this->db->get()
            ->result();
        return $query;
    }

    public function getPostulacionesPorMes($fecha_desde = false, $fecha_hasta = false)
    {
        $this->db->select('COUNT(id) as cantidad, EXTRACT(YEAR_MONTH FROM fecha_postulacion) as anio_mes')
            ->from('postulaciones')
            ->group_start()
            ->where('estado_postulacion =', POST_PENDIENTE)
            ->or_where('estado_postulacion =', POST_VALIDADO)
            ->or_where('estado_postulacion =', POST_ACEPTADO)
            ->group_end()
            ->group_by('anio_mes')
            ->order_by('anio_mes', 'ASC');
        if ($fecha_desde && $fecha_hasta) {
            $this->db->where("fecha_postulacion BETWEEN '{$fecha_desde}' AND '{$fecha_hasta}'");
        }
        $query = $this->db->get()
            ->result();
        return $query;
    }

    public function getMatchPorMes($fecha_desde = false, $fecha_hasta = false)
    {
        $this->db->select('COUNT(id) as cantidad, EXTRACT(YEAR_MONTH FROM fecha_de_contacto) as anio_mes')
            ->from('contacto_startups')
            ->group_by('anio_mes')
            ->order_by('anio_mes', 'ASC');
        if ($fecha_desde && $fecha_hasta) {
            $this->db->where("fecha_de_contacto BETWEEN '{$fecha_desde}' AND '{$fecha_hasta}'");
        }
        $query = $this->db->get()
            ->result();
        return $query;
    }

    public function getRegistrosPorRolPorMes($fecha_desde = false, $fecha_hasta = false)
    {
        $this->db->select('r.rol as rol_descripcion, r.id as rol_id, COUNT(u.id) as cantidad,EXTRACT(YEAR_MONTH FROM u.fecha_alta) as anio_mes')
            ->from('usuarios as u')
            ->join('roles as r', 'u.rol_id = r.id', 'left')
            ->group_start()
            ->where('r.id =', ROL_STARTUP)
            ->or_where('r.id =', ROL_EMPRESA)
            ->or_where('r.id =', ROL_PARTNER)
            ->group_end()
            ->group_start()
            ->where('u.estado_id =', USR_ENABLED)
            ->or_where('u.estado_id =', USR_VERIFIED)
            ->group_end()
            ->group_by('anio_mes,rol_id')
            ->order_by('anio_mes,rol_id', 'ASC');
        if ($fecha_desde && $fecha_hasta) {
            $this->db->where("fecha_alta BETWEEN '{$fecha_desde}' AND '{$fecha_hasta}'");
        }
        $query = $this->db->get()
            ->result();
        return $query;
    }
}
