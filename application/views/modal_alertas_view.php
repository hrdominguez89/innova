<script>
  window.addEventListener('load',()=>{
    $('#alertas_modal').modal('show');
  });
</script>
<!-- Modal -->
<div class="modal fade" id="alertas_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="font-weight-bold" id="staticBackdropLabel"><?php echo $this->session->flashdata('message')->titulo;?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $this->session->flashdata('message')->mensaje_cuerpo;?>
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>