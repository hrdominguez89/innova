<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 d-lg-none">
      </div>
      <div class="col-12">
        <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
          </ol>
        </nav>
      </div>
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">inbox</i>
            </div>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table id="datatablesNotificaciones" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th class="disabled-sorting"></th>
                    <th class="text-center">Nro</th>
                    <th class="text-center">Fecha</th>
                    <th>Título</th>
                    <th class="text-center">Estado</th>
                    <th class="disabled-sorting text-right">Acción</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th class="text-center">Nro</th>
                    <th class="text-center">Fecha</th>
                    <th>Título</th>
                    <th class="text-center">Estado</th>
                    <th class="text-right">Acción</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $cantitad_total_notificaciones = count($total_notificaciones);
                  foreach ($total_notificaciones as $notificacion) :;
                  ?>
                    <tr class="<?php echo !$notificacion->leido ? 'font-weight-bold font-italic notificacion-fuente-lista-'.$notificacion->id : ''; ?>">
                      <td><i class="<?php echo !$notificacion->leido? 'fas fa-envelope notificacion-icono-lista-'.$notificacion->id:'far fa-envelope-open';?>"></i></td>
                      <td class="text-center"><?php echo $cantitad_total_notificaciones; ?></td>
                      <td class="text-center"><?php echo date('d/m/Y', strtotime($notificacion->fecha_alta)); ?></td>
                      <td><?php echo $notificacion->titulo_mensaje; ?></td>
                      <td class="text-center notificacion-leido-lista-<?php echo $notificacion->id;?>"><?php echo !$notificacion->leido ? 'No leido' : 'Leido'; ?></td>
                      <td class="text-right">
                        <!-- Button trigger modal -->
                        <a href="#" class="verNotificacion" data-notificacion-id="<?php echo $notificacion->id; ?>" data-toggle="modal" data-target="#notificacionesModal"><i class="far fa-eye"></i></a></td>
                    </tr>
                    <?php $cantitad_total_notificaciones-- ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
    </div>
  </div>
</div>