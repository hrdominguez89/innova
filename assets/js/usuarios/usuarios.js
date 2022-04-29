$(document).ready(() => {
  cargarTablaDeUsuarios();
  escucharBotonCrearUsuarioModal();
  escucharBotonCrearUsuario();
  escucharBotonGuardarUsuario();
});

let usuarioAEliminar;

const escucharBotonGuardarUsuario = () => {
  $("#botonGuardarUsuario").on("click", () => {
    guardarUsuario();
  });
};

const escucharBotonCrearUsuario = () => {
  $("#botonCrearUsuario").on("click", () => {
    crearUsuario();
  });
};

const escucharBotonCrearUsuarioModal = () => {
  $("#botonCrearUsuarioModal").on("click", () => {
    reiniciarModalCrearUsuario();
    $("#modalCrearUsuario").modal("show");
  });
};

const cargarTablaDeUsuarios = (rol_id = false) => {
  var tableUsuarios = $("#dataTableUsuarios").DataTable({
    fixedHeader: {
      header: true,
    },
    destroy: true,
    responsive: false,
    info: false,
    ajax: {
      type: "post",
      url: BASE_URL + "usuarios/cargarUsuarios",
    },
    columns: [
      {
        render: function (full, type, data, meta) {
          return data.nombre;
        },
      },
      {
        render: function (full, type, data, meta) {
          return data.apellido;
        },
      },
      {
        render: function (full, type, data, meta) {
          return data.email;
        },
      },
      {
        render: function (full, type, data, meta) {
          return data.rol_descripcion;
        },
      },
      {
        render: function (full, type, data, meta) {
          return data.razon_social;
        },
      },
      {
        render: function (full, type, data, meta) {
          return data.descripcion;
        },
      },
      {
        render: function (full, type, data, meta) {
          return moment(data.fecha_alta).format("DD-MM-YYYY");
        },
      },
      {
        render: function (full, type, data, meta) {
          return `<span id="data_estado_id_${data.id}">${data.estado_descripcion}</span>`;
        },
      },
      {
        render: function (full, type, data, meta) {
          let colorToggle;
          let toggle;
          let activarUsuario;
          let title;
          if (data.estado_id == 3) {
            colorToggle = "success";
            toggle = "on";
            activarUsuario = false;
            title = "Deshabilitar";
          } else if (data.estado_id == 4) {
            colorToggle = "secondary";
            activarUsuario = true;
            toggle = "off";
            title = "Habilitar";
          }
          return `
                <a href='javascript:void(0)' onclick="activarUsuario(${data.id})" id="activar_usuario_${data.id}" data-activar-value=${activarUsuario} title="${title} usuario" class='activarUsuario text-${colorToggle}'><i class="fas fa-toggle-${toggle}"></i></a>
                <a href='javascript:void(0)' onclick="editarUsuario(${data.id})" id="editar_usuario_${data.id}" title="Editar usuario" class='editarUsuario ml-2 text-warning'><i class='fas fa-edit size-18' aria-hidden='true'></i></a>
                <a href='javascript:void(0)' onclick="eliminarUsuario(this)" id="eliminar_usuario_${data.id}" data-usuario-data='{"nombre":"${data.nombre}","apellido":"${data.apellido}","id":${data.id}}' title="Eliminar usuario" class='eliminarUsuario ml-2 text-danger'><i class='fas fa-trash-alt size-18' aria-hidden='true'></i></a>
                `;
        },
        orderable:false,
      },
    ],
    columnDefs: [
      {
        targets: 0, // your case first column
        className: "text-left",
        orderable: true,
      },
      {
        targets: 1,
        className: "text-left",
        orderable: true,
      },
      {
        targets: 2,
        className: "text-center",
        orderable: true,
      },
      {
        targets: 3,
        className: "text-center",
        orderable: true,
      },
      {
        targets: 4,
        className: "text-center",
        orderable: true,
      },
      {
        targets: 5,
        className: "text-center",
        orderable: true,
      },
      {
        targets: 6,
        className: "text-center",
        orderable: false,
      },
    ],
    language: {
      url: "./assets/js/datatables/es_es.json",
    },
    dom: "Bfrtip",
    buttons: ["excel", "pdf", "print"],
  });
};

const reiniciarModalCrearUsuario = () => {
  $("#errorCrearUsuarioModal").html("");
  $("#errorCrearUsuarioModal").css("display", "none");
  $("#crearUsuarioForm")[0].reset();
  $("#rol_id")
    .find("option:first-child")
    .prop("selected", true)
    .end()
    .trigger("chosen:updated");
};

const crearUsuario = () => {
  let dataUsuario = $("#crearUsuarioForm").serialize();
  $.ajax({
    type: "POST",
    url: BASE_URL + "usuarios/crearUsuario",
    dataType: "JSON",
    data: dataUsuario,
    beforeSend: function () {
      //   toggleModalEditarInfo(true);
    },
    error: function () {
      //   $("#errorCrearUsuarioModal").html(
      //     'No fue posible dar de alta este usuario, por favor intente nuevamente.'
      //   );
    },
    success: function (resp) {
      let mensaje;
      if (resp.status) {
        cargarTablaDeUsuarios();
        $("#modalCrearUsuario").modal("hide");
        mensaje = {
          title: "Usuario creado",
          texto: "Se creo el usuario correctamente",
          tipo: "success",
        };
      } else {
        $("#errorCrearUsuarioModal").css("display", "block");
        $("#errorCrearUsuarioModal").html(resp.msg);
        mensaje = {
          title: "Error",
          texto: resp.msg,
          tipo: "error",
        };
      }
      mensajeUsuarios(mensaje);
    },
    timeout: 5000,
  });
};

const editarUsuario = (usuario_id) => {
  reiniciarModalEditarUsuario();
  rellenarFormularioEditarUsuario(usuario_id);
};

const rellenarFormularioEditarUsuario = (usuario_id) => {
  $.ajax({
    type: "POST",
    url: BASE_URL + "usuarios/getDataUSuario",
    dataType: "JSON",
    data: { usuario_id: usuario_id },
    error: function () {
      alert(
        "No fue posible obtener los datos del usuario, por favor prueba mas tarde"
      );
    },
    success: function (resp) {
      switch (resp.status_code) {
        case 200:
          $("#nombre_editar").val(resp.data.nombre);
          $("#apellido_editar").val(resp.data.apellido);
          $("#email_editar").val(resp.data.email);
          $("#edidarUsuarioId").val(resp.data.id);
          let options = $("#rol_id_editar").find("option");
          for (let i = 0; i < options.length; i++) {
            options[i].removeAttribute("selected", "");
          }
          for (let i = 0; i < options.length; i++) {
            if (parseInt(options[i].value) == parseInt(resp.data.rol_id)) {
              options[i].setAttribute("selected", "");
              break;
            }
          }
          $('#rol_id_editar').trigger("chosen:updated");
          break;
      }
    },
    timeout: 5000,
  });
};

const activarUsuario = (id) => {
  let activarValue = document.getElementById(`activar_usuario_${id}`).dataset
    .activarValue;
  if (activarValue == "true") {
    activarValue = true;
  } else {
    activarValue = false;
  }
  let data = `activar=${activarValue}&usuario_id=${id}`;
  $.ajax({
    type: "POST",
    url: BASE_URL + "usuarios/activarUsuario",
    dataType: "JSON",
    data: data,
    error: function () {
      alert(
        "Error al intentar activar el usuario, por favor intente mas tarde"
      );
    },
    success: function (resp) {
      switch (resp.status_code) {
        case 200:
          cambiarToggleActivarUsuario(id, activarValue);
          break;
      }
    },
    timeout: 5000,
  });
};

const cambiarToggleActivarUsuario = (id, value) => {
  if (value) {
    $(`#activar_usuario_${id}`).attr("data-activar-value", false);
    $(`#activar_usuario_${id}`).attr("title", "Deshabilitar usuario");
    $(`#activar_usuario_${id}`).html('<i class="fas fa-toggle-on"></i>');
    $(`#activar_usuario_${id}`).removeClass("text-secondary");
    $(`#activar_usuario_${id}`).addClass("text-success");
    $(`#data_estado_id_${id}`).html("Habilitado");
  } else {
    $(`#activar_usuario_${id}`).attr("data-activar-value", true);
    $(`#activar_usuario_${id}`).attr("title", "Activar usuario");
    $(`#activar_usuario_${id}`).html('<i class="fas fa-toggle-off"></i>');
    $(`#activar_usuario_${id}`).removeClass("text-success");
    $(`#activar_usuario_${id}`).addClass("text-secondary");
    $(`#data_estado_id_${id}`).html("Deshabilitado");
  }
};

const guardarUsuario = () => {
  const formEditarUsuario = $("#editarUsuarioForm");
  let dataEditarUsuario = formEditarUsuario.serialize();
  $.ajax({
    type: "POST",
    url: BASE_URL + "usuarios/editarUsuario",
    dataType: "JSON",
    data: dataEditarUsuario,
    error: function () {
      alert(
        "No fue posible guardar los datos del usuario, por favor prueba mas tarde"
      );
    },
    success: function (resp) {
      if (resp.status) {
        cargarTablaDeUsuarios();
        $("#modalEditarUsuario").modal("hide");
      } else {
        $("#errorEditarUsuarioModal").html(resp.msg);
        $("#errorEditarUsuarioModal").css("display", "block");
      }
    },
    timeout: 5000,
  });
};

const reiniciarModalEditarUsuario = () => {
  $("#errorEditarUsuarioModal").html("");
  $("#errorEditarUsuarioModal").css("display", "none");
  $("#editarUsuarioForm")[0].reset();
  $("#modalEditarUsuario").modal("show");
};

const eliminarUsuario = (data) => {
  usuarioAEliminar = JSON.parse(data.dataset.usuarioData);
  $("#spanUsuario").html(
    `${usuarioAEliminar.apellido}, ${usuarioAEliminar.nombre}`
  );
  $("#modalEliminarUsuario").modal("show");
};

const eliminarUsuarioModal = async () => {
  let respuesta;

  await $.ajax({
    type: "POST",
    url: BASE_URL + "usuarios/eliminar",
    dataType: "JSON",
    data: { usuario_id: usuarioAEliminar.id },
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
    $("#modalEliminarUsuario").modal("hide");
    cargarTablaDeUsuarios();
    mensajeUsuarioEliminado();
  } else {
    $("#modalEliminarUsuario").modal("hide");
    mensajeUsuarioEliminado(respuesta.msg);
  }
};

const mensajeUsuarioEliminado = (msg = false) => {
  swal({
    title: msg ? "No se pudo eliminar" : "Usuario eliminado",
    text: msg ? msg : "El usuario se eliminó correctamente",
    type: msg ? "error" : "success",
    buttonsStyling: true,
    timer: 5000,
    confirmButtonClass: "btn btn-success",
  });
};

const mensajeUsuarios = (dataMsg) => {
  swal({
    title: dataMsg.title,
    text: dataMsg.texto,
    type: dataMsg.tipo,
    buttonsStyling: true,
    timer: 5000,
    confirmButtonClass: "btn btn-success",
  });
};
