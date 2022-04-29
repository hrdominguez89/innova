<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partners_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getPartnerById($partner_id)
    {
        $this->db->select('u.*,pa.*,tdp.descripcion_partner as descripcion_tipo_de_partner');
        $this->db->where('u.id', $partner_id);
        $this->db->from('usuarios as u');
        $this->db->join('partners as pa', 'pa.usuario_id = u.id');
        $this->db->join('tipos_de_partners as tdp', 'pa.tipo_de_partner_id = tdp.id');

        return $this->db->get()->row();
    }

    public function getPartnersYCantidadDeDesafiosCompartidosDeUsuariosActivos()
    {
        $query = $this->db->select('
            u.id as usuario_id,
            u.nombre,
            u.apellido,
            u.email,
            u.telefono,
            u.logo,
            u.perfil_completo,
            u.fecha_alta,
            u.ultimo_login,
            (
                SELECT
                    COUNT(`rec`.`id`)
                FROM
                    `recomendaciones` as `rec`
                LEFT JOIN `usuarios` as `em`
                    ON `em`.`id` = `rec`.`empresa_id`
                LEFT JOIN `usuarios` as `st`
                    ON `st`.`id` = `rec`.`startup_id`
                WHERE
                (
                    `st`.`estado_id` = '.USR_ENABLED.'
                        OR 
                    `st`.`estado_id` = '.USR_VERIFIED.'
                )
                AND
                (
                    `em`.`estado_id` = '.USR_ENABLED.'
                        OR
                    `em`.`estado_id` = '.USR_VERIFIED.'
                )
            ) as `desafios_compartidos`,
            eu.id as id_estado_usuario,
            eu.estado as descripcion_estado_usuario,
            pa.razon_social,
            tpa.id as id_tipo_de_partner,
            tpa.descripcion_partner as descripcion_tipo_de_partner,
        ')
            ->from('usuarios as u')
            ->join('partners as pa', 'pa.usuario_id = u.id', 'left')
            ->join('estados_usuarios as eu', 'eu.id = u.estado_id', 'left')
            ->join('tipos_de_partners as tpa', 'tpa.id = pa.tipo_de_partner_id', 'left')

            ->where('u.rol_id', ROL_PARTNER)

            ->group_start() //estado partner sea activo
            ->where('u.estado_id', USR_ENABLED)
            ->or_where('u.estado_id', USR_VERIFIED)
            ->or_where('u.estado_id', USR_DISABLED)
            ->group_end()

            ->get()
            ->result();
        return $query;
    }

    public function actualizarPartner($data, $startup_id)
    {
        $this->db->trans_begin();

        $this->db->where('id', $startup_id);

        $this->db->update('usuarios', $data);

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

    public function getDesafiosCompartidosDeUsuariosActivos($partner_id)
    {
        $query = $this->db->select('
            rec.fecha as fecha_compartido,
            em.razon_social as razon_social_empresa,
            uem.id as empresa_id,
            st.razon_social as razon_social_startup,
            ust.id as startup_id,
            d.nombre_del_desafio,
            d.id as desafio_id
        ')
            ->from('recomendaciones as rec')

            ->join('usuarios as uem', 'uem.id = rec.empresa_id', 'left')
            ->join('empresas as em', 'em.usuario_id = uem.id', 'left')

            ->join('usuarios as ust', 'ust.id = rec.startup_id', 'left')
            ->join('startups as st', 'st.usuario_id = ust.id', 'left')

            ->join('desafios as d', 'd.id = rec.desafio_id', 'left')

            ->where('rec.partner_id', $partner_id)

            ->group_start() //estado empresa sea activo
            ->where('uem.estado_id', USR_ENABLED)
            ->or_where('uem.estado_id', USR_VERIFIED)
            ->group_end()

            ->group_start() //estado startup sea activo
            ->where('ust.estado_id', USR_ENABLED)
            ->or_where('ust.estado_id', USR_VERIFIED)
            ->group_end()
            ->get()
            ->result();
        return $query;
    }
}
