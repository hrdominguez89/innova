<div class="modal fade" id="desafiosCompatibles" data-backdrop="true" data-keyboard="true" tabindex="-1" aria-labelledby="desafiosCompatiblesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="desafiosCompatiblesLabel">Desafíos Compatibles</h5>
        <button type="button" class="close" onclick="cerrarModal(this)" data-modal-id="desafiosCompatibles" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">
        <div class="text-center" id="desafiosCompatiblesLoading" style="display:block;">
          <img src="<?php echo base_url();?>assets/img/loading.gif" alt="loading gif">
          <p>Cargando...</p>
        </div>
        <div id="desafiosCompatiblesDiv" style="display:none;">
          <table id="desafiosCompatiblesTable" class="table table-striped table-no-bordered table-hover" style="width: 100%;">
            <thead>
              <tr>
                <td>
                  Desafío
                </td>
                <td>
                  Empresa
                </td>
                <td>
                  Fecha fin de postulación
                </td>
                <td>
                  Postulado
                </td>
                <td>
                  Compartido
                </td>
                <td>
                </td>
              </tr>
            </thead>
            <tbody id="tbodyStartupsCompatibles">
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="cerrarModal(this)" data-modal-id="desafiosCompatibles">Cerrar</button>
      </div>
    </div>
  </div>
</div>