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
    url: BASE_URL + "empresas/cambiarEstadoEmpresa",
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

const eliminarEmpresaModal = (data) => {
  $("#nombre_de_la_empresa_modal").html(data.dataset.nombreEmpresa);
  $("#botonEliminarEmpresa").attr("data-usuario-id", data.dataset.usuarioId);
  $("#modalEliminarEmpresa").modal("show");
};

const eliminarEmpresa = async (dataBoton) => {
  let usuarioId = dataBoton.dataset.usuarioId;

  let data = `usuario_id=${usuarioId}`;

  let respuesta;

  await $.ajax({
    type: "POST",
    url: BASE_URL + "empresas/eliminar",
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
    $("#modalEliminarEmpresa").modal("hide");
    eliminarLineaDeEmpresa(usuarioId);
    mensajeEmpresaEliminada();
  }
};

const eliminarLineaDeEmpresa = (usuarioId) => {
  $(`#row_empresa_id_${usuarioId}`).remove();
};

const mensajeEmpresaEliminada = () => {
  swal({
    title: "Empresa eliminada",
    text: "La empresa se eliminó correctamente",
    type: "success",
    buttonsStyling: true,
    timer: 5000,
    confirmButtonClass: "btn btn-success",
  });
};
