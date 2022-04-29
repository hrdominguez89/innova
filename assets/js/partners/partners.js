const cambiarEstadoUsuario = async (data) => {
    let usuarioId = data.dataset.usuarioId;
    let estado = data.dataset.estado;
    await actualizarEstadoUsuario(estado, usuarioId);
    actualizarToggle(data, estado, usuarioId);
  };
  
  const actualizarToggle = (data, estado, usuarioId) => {
    if (estado == "activado") {
      data.classList.remove("text-success");
      data.classList.add("text-dark");
      data.title = "desactivado";
      data.innerHTML = `<i class="fas fa-toggle-off">`;
      data.dataset.estado = "desactivado";
    } else {
      /* desactivado */
      data.classList.remove("text-dark");
      data.classList.add("text-success");
      data.title = "activado";
      data.innerHTML = `<i class="fas fa-toggle-on">`;
      data.dataset.estado = "activado";
    }
  };
  
  const actualizarEstadoUsuario = async (estado, usuarioId) => {
    if (estado == "activado") {
      data = `usuario_id=${usuarioId}&estado=false`; //pasa estado a desactivado
    } else {
      /* desactivado */
      data = `usuario_id=${usuarioId}&estado=true`; //pasa estado a activado
    }
    let respuesta;
  
    await $.ajax({
      type: "POST",
      url: BASE_URL + "partners/cambiarEstadoPartner",
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
    return respuesta;
  };

  
const eliminarPartnerModal = (data) => {
    $("#nombre_de_la_partner_modal").html(data.dataset.nombrePartner);
    $("#botonEliminarPartner").attr("data-usuario-id", data.dataset.usuarioId);
    $("#modalEliminarPartner").modal("show");
  };
  
  const eliminarPartner = async (dataBoton) => {
    let usuarioId = dataBoton.dataset.usuarioId;
  
    let data = `usuario_id=${usuarioId}`;
  
    let respuesta;
  
    await $.ajax({
      type: "POST",
      url: BASE_URL + "partners/eliminar",
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
      $("#modalEliminarPartner").modal("hide");
      eliminarLineaDePartner(usuarioId);
      mensajePartnerEliminada();
    }
  };
  
  const eliminarLineaDePartner = (usuarioId)=>{
      $(`#row_partner_id_${usuarioId}`).remove();
  };
  
  const mensajePartnerEliminada = () => {
    swal({
      title: "Partner eliminada",
      text: "El partner se eliminó correctamente.",
      type: "success",
      buttonsStyling: true,
      timer: 5000,
      confirmButtonClass: "btn btn-success",
    });
  };