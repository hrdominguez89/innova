<div class="modal fade" id="desafioCompatible" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="desafioCompatibleLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="desafioCompatibleLabel"></h5>
        <button type="button" class="close" onclick="cerrarModal(this)" data-modal-id="desafioCompatible" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="desafioCompatibleLoading" class="text-center" style="display:block;">
          <img class="p-3" src="<?php echo base_url(); ?>assets/img/loading.gif" alt="loading gif">
          <p>Cargando...</p>
        </div>
        <div id="desafioCompatibleDiv" style="display:none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default m-2" onclick="cerrarModal(this)" data-modal-id="desafioCompatible">Cerrar</button>
        <div id="botonDesafioPostulado" style="display:none">
          <a href="javascript:void(0);"type="button" class="btn btn-success m-2">Startup postulada <i class="fas fa-check"></i></a>
        </div>
        <div id="botonDesafioCompartido" style="display:none">
          <a href="javascript:void(0);"type="button" class="btn btn-success m-2">Desafío compartido <i class="fas fa-check"></i></a>
        </div>

        <div id="botonCompartirDesafio" style="display: none;">
          <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#compartirDesafio">Compartir desafío</button>
        </div>
        
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="compartirDesafio" tabindex="-1" aria-labelledby="compartirDesafioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="compartirDesafioLabel">Compartir desafío</h5>
        <button type="button" class="close" data-dismiss="modal" data-modal-id="compartirDesafio" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Está seguro que deséa compartir este desafío?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default m-2" data-dismiss="modal" data-modal-id="compartirDesafio">Cancelar</button>
        <button type="button" class="btn btn-primary m-2" id="compartirDesafioBoton">Si, compartir</button>
      </div>
    </div>
  </div>
</div>