<?php echo $this->load->view('modals/desafios/nuevo_desafio_modal_view');?>
<?php echo $this->load->view('modals/desafios/editar_desafio_modal_view');?>
<?php echo $this->load->view('modals/desafios/eliminar_desafio_modal_view');?>


<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 d-lg-none">
      </div>
      <div class="col-12">
        <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Desafíos</li>
          </ol>
        </nav>
      </div>
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">ballot</i>
            </div>
            <h4 class="card-title ">Lista de desafíos</h4>
          </div>
          <div class="card-body">
            <div class="toolbar mb-3 border-bottom pb-2">
              <div class="row">
                <div class="col-8">
                  <button id="botonVigentes" class="btn btn-sm btn-primary mb-5 active">
                    Vigentes
                  </button>
                  <button id="botonFinalizados" class="btn btn-sm btn-primary mb-5">
                    Finalizados
                  </button>
                </div>
                <div class="col-4 text-right">
                <button type="button" id="botonNuevoDesafio" class="btn btn-primary mb-5">
                Nuevo desafío
              </button>
                </div>
              </div>
            </div>
            <div class="material-datatables">
              <table id="datatablesDesafios" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th style="width:20%">Nombre del desafío</th>
                    <th style="width: 30%;">Descripción</th>
                    <th class="text-center">Fecha inicio de postulación</th>
                    <th class="text-center">Fecha fin de postulación</th>
                    <th class="disabled-sorting text-center" style="width:100px">Acción</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nombre del desafío</th>
                    <th>Descripción</th>
                    <th class="text-center">Fecha inicio de postulación</th>
                    <th class="text-center">Fecha fin de postulación</th>
                    <th class="text-center">Acción</th>
                  </tr>
                </tfoot>
                <tbody>

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