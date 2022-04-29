<!-- Modal -->
<div class="modal fade" id="editarDesafioModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tituloEditarDesafiosModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 id="tituloEditarDesafiosModal">Editar desafío</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formularioEditarDesafio">
          <input type="hidden" id="editar_desafio_id" name="editar_desafio_id" value="">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="editar_inicio_del_desafio">Inicio del desafío</label>
                <input type="date" class="form-control" name="inicio_del_desafio" id="editar_inicio_del_desafio">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="editar_fin_del_desafio">Fin del desafío</label>
                <input type="date" class="form-control" name="fin_del_desafio" id="editar_fin_del_desafio">
              </div>
            </div>
            <div class="col-12 mt-2">
              <div class="form-group">
                <label for="editar_nombre_del_desafio">Nombre del desafío</label>
                <input type="text" class="form-control" name="nombre_del_desafio" id="editar_nombre_del_desafio">
              </div>
            </div>
            <div class="col-12 mt-2">
              <div class="form-group">
                <label for="editar_descripcion_del_desafio">Descripción</label>
                <textarea class="form-control" name="descripcion_del_desafio" id="editar_descripcion_del_desafio" cols="30" rows="3"></textarea>
              </div>
            </div>
            <div class="col-12 mt-2">
              <div class="form-group">
                <label for="editar_requisitos_del_desafio">Requisitos del desafío</label>
                <textarea class="form-control" name="requisitos_del_desafio" id="editar_requisitos_del_desafio" cols="30" rows="3"></textarea>
              </div>
            </div>
            <div class="col-12 mt-2 text-left">
              <div class="form-group">
                <label>Categorías</label>
                <?php foreach ($categorias as $categoria) :; ?>
                  <div class="form-check">
                    <label class="form-check-label" for="editar_categoria_<?php echo $categoria->id; ?>">
                      <input class="form-check-input editar-categorias" type="checkbox" id="editar_categoria_<?php echo $categoria->id; ?>" name="categorias[]" value="<?php echo $categoria->id; ?>">
                      <?php echo $categoria->descripcion; ?>
                      <span class="form-check-sign">
                        <span class="check"></span>
                      </span>
                    </label>
                  </div>

                <?php endforeach; ?>
              </div>
            </div>
            <div class="col-12 mt-2 text-left" id="erroresModalEditarDesafio">
            </div>
          </div>
        </form>
        <div class="row" id="loadingEditarModal" style="display: none;">
          <div class="col-12 text-center">
            <img src="<?php echo base_url(); ?>assets/img/loading.gif" class="img-fluid" alt="">
            <h4>Guardando desafío, espere...</h4>
          </div>
        </div>
      </div>
      <div class="modal-footer" id="botonesFooterEditarDesafiosModal">
        <button type="button" class="btn btn-default m-1" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary m-1" id="botonGuardarEditarDesafio">Guardar desafío</button>
      </div>
    </div>

  </div>
</div>
<!--        Here you can write extra buttons/actions for the toolbar              -->