let postulacionIdAEliminar;

const eliminarPostulacionModal = (data) => {
  postulacionIdAEliminar = data.dataset.postulacionId;
  $("#modalEliminarPostulacion").modal("show");
};

const eliminarPostulacion = async (dataBoton) => {
  let respuesta;

  await $.ajax({
    type: "POST",
    url: BASE_URL + "postulados/eliminar",
    dataType: "JSON",
    data: { postulado_id: postulacionIdAEliminar },
    // beforeSend: function () {
    // codigo
    // },
    error: function (resp) {
      console.log(resp);
    },
    success: function (resp) {
      respuesta = resp;
    },
    timeout: 5000,
  });
  if (respuesta.status) {
    $("#modalEliminarPostulacion").modal("hide");
    eliminarLineaDePostulacion();
    mensajePostulacionEliminado();
  } else {
    $("#modalEliminarPostulacion").modal("hide");
    mensajePostulacionEliminado(respuesta.msg);
    
  }
};

const eliminarLineaDePostulacion = () => {
  $(`#row_postulacion_id_${postulacionIdAEliminar}`).remove();
};

const mensajePostulacionEliminado = (msg = false) => {
  swal({
    title: msg ? "No se pudo eliminar" : "Postulación eliminada",
    text: msg ? msg : "La postulación se eliminó correctamente",
    type: msg ? "error" : "success",
    buttonsStyling: true,
    timer: 5000,
    confirmButtonClass: "btn btn-success",
  });
};
