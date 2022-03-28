<div class="modal fade" id="compartirPorEmailModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="compartirPorEmailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="compartirPorEmailModalLabel">Compartir desafío por e-mail</h5>
        <button type="button" class="close" onclick="cerrarModal(this)" data-modal-id="compartirPorEmailModal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="compartirPorEmailModal" class="row">
          <div class="col-sm-12">
            <label for="emails">E-Mails:<br>
            <small class="text-muted">(Escriba uno o más correos separados por coma como indica el ejemplo)</small></label>
            <input type="text" class="form-control" id="emails" name="emails" placeholder="ejemplo1@ejemplo.com, ejemplo2@ejemplo.com">
            <div id="error"></div>
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default m-2" onclick="cerrarModal(this)" data-modal-id="compartirPorEmailModal">Cerrar</button>

        <div id="botonCompartirDesafio">
          <button type="button" class="btn btn-primary m-2" id="compartirDesafioPorEmailModal">Compartir desafío</button>
        </div>
      </div>
    </div>
  </div>
</div>