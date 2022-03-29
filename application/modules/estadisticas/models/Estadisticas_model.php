<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estadisticas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getDesafiosPorMes()
    {
        $query = $this->db->select('COUNT(id) as cantidad, EXTRACT(YEAR_MONTH FROM fecha_alta) as anio_mes')
            ->from('desafios')
            ->where('estado_id !=', DESAF_CANCELADO)
            ->where('estado_id !=', DESAF_ELIMINADO)
            ->where('estado_id !=', DESAF_RECHAZADO)
            ->group_by('anio_mes')
            ->order_by('anio_mes', 'ASC')
            ->get()
            ->result();
        return $query;
    }

    public function getPostulacionesPorMes()
    {
        $query = $this->db->select('COUNT(id) as cantidad, EXTRACT(YEAR_MONTH FROM fecha_postulacion) as anio_mes')
            ->from('postulaciones')
            ->where('estado_postulacion =', POST_PENDIENTE)
            ->where('estado_postulacion =', POST_VALIDADO)
            ->where('estado_postulacion =', POST_ACEPTADO)
            ->group_by('anio_mes')
            ->order_by('anio_mes', 'ASC')
            ->get()
            ->result();
        return $query;
    }

    public function getMatchPorMes()
    {
        $query = $this->db->select('COUNT(id) as cantidad, EXTRACT(YEAR_MONTH FROM fecha_de_contacto) as anio_mes')
            ->from('contacto_startups')
            ->group_by('anio_mes')
            ->order_by('anio_mes', 'ASC')
            ->get()
            ->result();
        return $query;
    }

    public function getRegistrosPorRolPorMes()
    {
        $query = $this->db->select('COUNT(id) as cantidad, EXTRACT(YEAR_MONTH FROM fecha_alta) as anio_mes')
            ->from('desafios')
            ->where('estado_id !=', DESAF_CANCELADO)
            ->where('estado_id !=', DESAF_ELIMINADO)
            ->where('estado_id !=', DESAF_RECHAZADO)
            ->group_by('anio_mes')
            ->order_by('anio_mes', 'ASC')
            ->get()
            ->result();
        var_dump($this->db->last_query());
        die();
        return $query;
    }
}
