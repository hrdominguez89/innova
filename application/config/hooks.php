<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

//CARGA LOS MENSAJES DE CADA USUARIO
$hook['pre_controller'][] = array(
    'class'    => 'notificaciones',
    'function' => 'cargar_notificaciones',
    'filename' => 'Notificaciones.php',
    'filepath' => 'modules/notificaciones/controllers'
);

//VERIFICA QUE EL USUARIO TENGA UN ROL.
$hook['pre_controller'][] = array(
    'class'    => 'notificaciones',
    'function' => 'verificar_rol',
    'filename' => 'Notificaciones.php',
    'filepath' => 'modules/notificaciones/controllers'
);

//VERIFICA QUE EL USUARIO HAYA CARGADO SU PERFIL.
$hook['pre_controller'][] = array(
    'class'    => 'notificaciones',
    'function' => 'verificar_perfil_completo',
    'filename' => 'Notificaciones.php',
    'filepath' => 'modules/notificaciones/controllers'
);
