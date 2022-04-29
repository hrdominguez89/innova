<div class="modal fade" id="modalEliminarPostulacion" tabindex="-1" role="dialog" aria-labelledby="modalEliminarPostulacionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarPostulacionLabel">Eliminar postulación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta a punto de eliminar esta postulación<br>
                Una vez eliminado no podra revertir este cambio.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-2" data-dismiss="modal">Cancelar</button>
                <button type="button" id="botonEliminarPostulacion" onclick="eliminarPostulacion(this)" data-postulacion-id="" class="btn btn-danger m-2">Eliminar</button>
            </div>
        </div>
    </div>
</div>