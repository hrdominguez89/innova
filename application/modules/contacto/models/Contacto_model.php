<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contacto_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getContactosData($usuario_id, $tipo_de_empresa)
    {
        $this->db->select('
            em.razon_social as nombre_empresa,
            st.razon_social as nombre_startup,
            uem.nombre as nombre_contacto_empresa,
            uem.apellido as apellido_contacto_empresa,
            uem.id as empresa_id,
            ust.nombre as nombre_contacto_startup,
            ust.apellido as apellido_contacto_startup,
            ust.id as startup_id,
            vd.desafio_id,
            vd.fecha_fin_de_postulacion,
            vd.nombre_del_desafio
            ');
        $this->db->from('contacto_startups as cs');
        $this->db->where('vd.desafio_estado_id!=', DESAF_ELIMINADO);
        if ($tipo_de_empresa == ROL_STARTUP) {
            $this->db->where('cs.startup_id', $usuario_id);
        } else if ($tipo_de_empresa == ROL_EMPRESA) {
            $this->db->where('cs.empresa_id', $usuario_id);
        }
        $this->db->group_start();
        $this->db->where('vd.estado_usuario_id', USR_ENABLED);
        $this->db->or_where('vd.estado_usuario_id', USR_VERIFIED);
        $this->db->group_end();
        $this->db->join('empresas as em', 'cs.empresa_id = em.usuario_id');
        $this->db->join('startups as st', 'cs.startup_id = st.usuario_id');
        $this->db->join('usuarios as uem', 'uem.id = cs.empresa_id');
        $this->db->join('usuarios as ust', 'ust.id = cs.startup_id');
        $this->db->join('vi_desafios as vd', 'cs.desafio_id = vd.desafio_id');
        $this->db->order_by('cs.fecha_de_contacto', 'DESC');
        return $this->db->get()->result();
    }

    public function getContactoData($usuario_id, $tipo_de_empresa, $usuario_a_buscar, $desafio_id)
    {
        $this->db->select('
            em.razon_social as nombre_empresa,
            em.titular as titular_empresa,
            em.cuit as cuit_empresa,
            em.descripcion as descripcion_empresa,
            em.exporta as exporta_empresa,
            em.rubro as rubro_empresa,
            em.pais as pais_empresa,
            em.provincia as provincia_empresa,
            em.localidad as localidad_empresa,
            em.direccion as direccion_empresa,
            em.telefono_empresa as telefono_empresa,
            em.email_empresa as email_empresa,
            em.url_web as url_web_empresa,
            em.url_facebook as url_facebook_empresa,
            em.url_twitter as url_twitter_empresa,
            em.url_instagram as url_instagram_empresa,
            em.url_youtube as url_youtube_empresa,

            uem.nombre as nombre_contacto_empresa,
            uem.apellido as apellido_contacto_empresa,
            uem.telefono as telefono_contacto_empresa,
            uem.email as email_contacto_empresa,
            uem.id as empresa_id,

            st.razon_social as nombre_startup,
            st.titular as titular_startup,
            st.cuit as cuit_startup,
            st.descripcion as descripcion_startup,
            st.exporta as exporta_startup,
            st.rubro as rubro_startup,
            st.pais as pais_startup,
            st.provincia as provincia_startup,
            st.localidad as localidad_startup,
            st.direccion as direccion_startup,
            st.telefono_startup as telefono_startup,
            st.email_startup as email_startup,
            st.url_web as url_web_startup,
            st.url_facebook as url_facebook_startup,
            st.url_twitter as url_twitter_startup,
            st.url_instagram as url_instagram_startup,
            st.url_youtube as url_youtube_startup,

            ust.nombre as nombre_contacto_startup,
            ust.apellido as apellido_contacto_startup,
            ust.telefono as telefono_contacto_startup,
            ust.email as email_contacto_startup,
            ust.id as startup_id,

            vd.desafio_id,
            vd.fecha_fin_de_postulacion,
            vd.nombre_del_desafio,
            vd.nombre_de_categorias,
            vd.descripcion_del_desafio,
            vd.requisitos_del_desafio
            ');
        $this->db->from('contacto_startups as cs');
        if ($tipo_de_empresa == ROL_STARTUP) {
            $this->db->where('cs.startup_id', $usuario_id);
            $this->db->where('cs.empresa_id', $usuario_a_buscar);
        } else if ($tipo_de_empresa == ROL_EMPRESA) {
            $this->db->where('cs.empresa_id', $usuario_id);
            $this->db->where('cs.startup_id', $usuario_a_buscar);
        }
        $this->db->where('cs.desafio_id', $desafio_id);
        $this->db->group_start();
        $this->db->where('vd.estado_usuario_id', USR_ENABLED);
        $this->db->or_where('vd.estado_usuario_id', USR_VERIFIED);
        $this->db->group_end();
        $this->db->join('empresas as em', 'cs.empresa_id = em.usuario_id');
        $this->db->join('startups as st', 'cs.startup_id = st.usuario_id');
        $this->db->join('usuarios as uem', 'uem.id = cs.empresa_id');
        $this->db->join('usuarios as ust', 'ust.id = cs.startup_id');
        $this->db->join('vi_desafios as vd', 'cs.desafio_id = vd.desafio_id');
        $this->db->order_by('cs.fecha_de_contacto', 'DESC');
        return $this->db->get()->row();
    }
}
