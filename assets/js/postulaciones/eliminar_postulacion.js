
const eliminarPostulacionModal = (data) => {
    $("#botonEliminarPostulacion").attr("data-postulacion-id", data.dataset.postulacionId);
    $("#modalEliminarPostulacion").modal("show");
  };
  
  const eliminarPostulacion = async (dataBoton) => {
    let postulacionId = dataBoton.dataset.postulacionId;
  
    let data = `postulacion_id=${postulacionId}`;
  
    let respuesta;
  
    await $.ajax({
      type: "POST",
      url: BASE_URL + "postulados/eliminar",
      dataType: "JSON",
      data: data,
      // beforeSend: function () {
      // codigo
      // },
      error: function (resp) {
        alert(resp);
      },
      success: function (resp) {
        if (resp.status) {
          respuesta = true;
        } else {
          alert(resp.msg);
        }
      },
      timeout: 5000,
    });
    if (respuesta) {
      $("#modalEliminarPostulacion").modal("hide");
      eliminarLineaDePostulacion(postulacionId);
      mensajePostulacionEliminado();
    }
  };
  
  const eliminarLineaDePostulacion = (postulacionId) => {
    $(`#row_postulacion_id_${postulacionId}`).remove();
  };
  
  const mensajePostulacionEliminado = () => {
    swal({
      title: "Desafío eliminado",
      text: "El desafío se eliminó correctamente",
      type: "success",
      buttonsStyling: true,
      timer: 5000,
      confirmButtonClass: "btn btn-success",
    });
  };