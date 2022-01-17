<div class="modal fade" id="startupsCompatibles" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="startupsCompatiblesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="startupsCompatiblesLabel">Startups Compatibles</h5>
        <button type="button" class="close" onclick="cerrarModal(this)" data-modal-id="startupsCompatibles" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">
        <div class="text-center" id="startupsCompatiblesLoading" style="display:block;">
          <img src="<?php echo base_url();?>assets/img/loading.gif" alt="loading gif">
          <p>Cargando...</p>
        </div>
        <div id="startupsCompatiblesDiv" style="display:none;">
          <table id="startupsCompatiblesTable" class="table table-striped table-no-bordered table-hover" style="width: 100%;">
            <thead>
              <tr>
                <td>
                  Nombre Startup
                </td>
                <td class="text-center">
                </td>
              </tr>
            </thead>
            <tbody id="tbodyStartupsCompatibles">
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="cerrarModal(this)" data-modal-id="startupsCompatibles">Cerrar</button>
      </div>
    </div>
  </div>
</div>