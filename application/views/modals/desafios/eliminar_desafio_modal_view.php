<!-- Modal -->
<div class="modal fade" id="modalEliminarDesafio" tabindex="-1" role="dialog" aria-labelledby="modalEliminarDesafioLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarDesafioLabel">Eliminar desafío</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta a punto de eliminar este desafío: <span id="nombre_del_desafio_modal"></span><br>
                Una vez eliminado no podra revertir este cambio.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary m-2" data-dismiss="modal">Cancelar</button>
                <button type="button" id="botonEliminarDesafio" onclick="eliminarDesafio(this)" data-desafio-id="" class="btn btn-danger m-2">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<!--        Here you can write extra buttons/actions for the toolbar              -->