<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalEliminarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarUsuarioLabel">Eliminar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta a punto de eliminar este usuario<br>
                Una vez eliminado no podra revertir este cambio.<br>
                Usuario: <span id="spanUsuario"></span><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cancelar</button>
                <button type="button" id="botonEliminarUsuario" onclick="eliminarUsuarioModal(this)" data-usuario-id="" class="btn btn-danger m-2">Eliminar</button>
            </div>
        </div>
    </div>
</div>