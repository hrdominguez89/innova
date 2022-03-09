$(document).ready(() => {
  cargarTablaDeUsuarios();
  escucharBotonCrearUsuarioModal();
  escucharBotonCrearUsuario();
  escucharBotonGuardarUsuario();
});

const escucharBotonGuardarUsuario = () => {
  $("#botonGuardarUsuario").on("click", () => {
    guardarUsuario();
  });
};

const escucharBotonCrearUsuario = () => {
  $("#botonCrearUsuario").on("click", () => {
    crearUsuario();
    // $('#modalCrearUsuario').modal('hide');
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
      url: BASE_URL + "usuarios/cargarUsuarios/" + rol_id,
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
                <a href='javascript:void(0)' onclick="activarUsuario(${data.id})" id="activar_usuario_${data.id}" data-activar-value=${activarUsuario} title="${title} usuario" class='activarUsuario mx-2 text-${colorToggle}'><i class="fas fa-toggle-${toggle}"></i></a>
                <a href='javascript:void(0)' onclick="editarUsuario(${data.id})" id="editar_usuario_${data.id}" title="Editar usuario" class='editarUsuario mx-2 text-warning'><i class='fas fa-edit size-18' aria-hidden='true'></i></a>
                `;
        },
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
  $(".filter-option-inner-inner")[0].innerHTML = "Seleccione un rol";
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
      switch (resp.status_code) {
        case 200:
          if (resp.cargado) {
            cargarTablaDeUsuarios();
            $("#modalCrearUsuario").modal("hide");
          } else {
            $("#errorCrearUsuarioModal").css("display", "block");
            $("#errorCrearUsuarioModal").html(resp.msg);
          }
          break;
      }
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
          $(".filter-option-inner-inner")[1].innerHTML =
            resp.data.rol_descripcion;
          $("#nombre_editar").val(resp.data.nombre);
          $("#apellido_editar").val(resp.data.apellido);
          $("#email_editar").val(resp.data.email);
          $("#edidarUsuarioId").val(resp.data.id);
          let options = $("#rol_id_editar").find("option");
          options[1].removeAttribute("selected");
          for (i = 0; i < options.length; i++) {
            if (parseInt(options[i].value) == parseInt(resp.data.rol_id)) {
              options[i].setAttribute("selected", "");
              break;
            }
          }
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
      switch (resp.status_code) {
        case 200:
          if (resp.editado) {
            cargarTablaDeUsuarios();
            $("#modalEditarUsuario").modal("hide");
          } else {
            $("#errorEditarUsuarioModal").html(resp.msg);
            $("#errorEditarUsuarioModal").css("display", "block");
          }
          break;
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
