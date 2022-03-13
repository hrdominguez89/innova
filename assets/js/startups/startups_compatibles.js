var tablaDesafiosCompatibles;
var desafioId;
var empresaId;
var startupId;
var desafioData;
var listadoDeDesafios;
var botonDesafioCompartido;
var botonCompartirDesafio;
var botonDesafioPostulado;

const dataTableOptions = {
  destroy: true,
  responsive: true,
  info: false,
  language: {
    url: "./assets/js/datatables/es_es.json",
  },
  columns: [
    {
      data: "nombre_del_desafio",
    },
    {
      data: "nombre_empresa",
    },
    {
      className: "text-center",
      searchable: false,
      render: function (data, type, full, meta) {
        return moment(full.fecha_fin_de_postulacion).format("DD-MM-YYYY");
      },
    },
    {
      className: "text-center",
      searchable: false,
      render: function (data, type, full, meta) {
        const postulado = parseInt(full.postulado)
          ? '<i class="text-success far fa-check-circle"></i>'
          : "";
        return postulado;
      },
    },
    {
      className: "text-center",
      searchable: false,
      render: function (data, type, full, meta) {
        const compartido = parseInt(full.compartido)
          ? '<i class="text-success far fa-check-circle"></i>'
          : "";
        return compartido;
      },
    },
    {
      className: "text-right text-primary",
      searchable: false,
      orderable: false,
      render: function (data, type, full, meta) {
        const desafio_id = full.desafio_id;
        const empresa_id = full.empresa_id;
        return `<a href="javascript:void(0);" onclick="verDesafioCompatible(this)" data-empresa-id="${empresa_id}" data-desafio-id="${desafio_id}"><i class="far fa-eye"></i></a>`;
      },
    },
  ],
};

window.addEventListener("load", () => {
  escucharBotonVerDesafiosCompatibles();
  escucharBotonCompartirDesafio();
  tablaDesafiosCompatibles = $("#desafiosCompatiblesTable").DataTable(
    dataTableOptions
  );
  botonDesafioCompartido = $("#botonDesafioCompartido");
  botonCompartirDesafio = $("#botonCompartirDesafio");
  botonDesafioPostulado = $("#botonDesafioPostulado");
});

const escucharBotonCompartirDesafio = () => {
  const botonCompartir = $("#compartirDesafioBoton");
  botonCompartir.on("click", async () => {
    const respCompartir = compartirDesafio();
    await mostrarResultadoCompartir(respCompartir);
    $("#compartirDesafio").modal("hide");
    cargarDatatable();
  });
};

const mostrarResultadoCompartir = (resultado) => {
  resultado.then((res) => {
    if (res.status) {
      swal({
        // title: "El desafio fue compartido",
        text: "El desafio fue compartido.",
        type: "success",
        buttonsStyling: true,
        timer: 5000,
        confirmButtonClass: "btn btn-success",
      });
      botonDesafioCompartido.show();
      botonCompartirDesafio.hide();
    } else {
      swal({
        // title: ,
        text: res.msg,
        type: "error",
        buttonsStyling: true,
        timer: 5000,
        confirmButtonClass: "btn btn-danger",
      });
    }
  });
};

const compartirDesafio = () => {
  const data = {
    desafio_id: desafioId,
    empresa_id: empresaId,
    startup_id: startupId,
  };
  let respuesta = new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: BASE_URL + "desafios/compartirDesafio",
      dataType: "JSON",
      data: data,
      // beforeSend: function () {
      // },
      // error: function () {
      // },
      success: function (resp) {
        resolve(resp);
      },
      // timeout: 5000,
    });
  });
  return respuesta;
};

const escucharBotonVerDesafiosCompatibles = () => {
  const botonesVerDesafiosCompatibles = document.getElementsByClassName(
    "verDesafiosCompatibles"
  );
  Array.from(botonesVerDesafiosCompatibles).forEach(
    (botonVerDesafioCompatibles) => {
      botonVerDesafioCompatibles.addEventListener("click", () => {
        $("#desafiosCompatibles").modal("show");
        startupId = botonVerDesafioCompatibles.dataset.startupId;
        listadoDeDesafios = consultarDesafiosCompatiblesParaDesafioId();
        cargarDatatable();
      });
    }
  );
};

const consultarDesafiosCompatiblesParaDesafioId = () => {
  const data = {
    startup_id: startupId,
  };
  let respuesta = new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: BASE_URL + "desafios/getDesafiosCompatiblesPorStartupId",
      dataType: "JSON",
      data: data,
      // beforeSend: function () {
      // },
      // error: function () {
      // },
      success: function (resp) {
        resolve(resp.data);
      },
      // timeout: 5000,
    });
  });
  return respuesta;
};

const cargarDatatable = async () => {
  tablaDesafiosCompatibles.clear();
  await listadoDeDesafios.then((desafios) => {
    tablaDesafiosCompatibles.rows.add(desafios);
  });
  tablaDesafiosCompatibles.draw();
  switchLoadingGif("desafiosCompatibles", "ocultar");
};

const switchLoadingGif = (idModal, accion = false) => {
  //accion = ocultar esconde gif
  if (accion == "ocultar") {
    $(`#${idModal}Loading`).hide();
    $(`#${idModal}Div`).show();
  } else {
    $(`#${idModal}Loading`).show();
    $(`#${idModal}Div`).hide();
  }
};

const verDesafioCompatible = (data) => {
  desafioId = data.dataset.desafioId;
  empresaId = data.dataset.empresaId;
  desafioData = getDesafioData();
  botonDesafioCompartido.hide();
  botonCompartirDesafio.hide();
  botonDesafioPostulado.hide();
  $("#desafioCompatible").modal("show");
  mostrarDatosDesafio();
};

const mostrarDatosDesafio = async () => {
  const bodyDesafios = $("#desafioCompatibleDiv");
  bodyDesafios.html("");
  // fecha_fin_de_postulacion
  // id_empresa
  // desafio_id
  await desafioData.then((resp) => {
    if (parseInt(resp.compartido) || parseInt(resp.postulado)) {
      if (parseInt(resp.postulado)) {
        botonDesafioPostulado.show();
      }
      if (parseInt(resp.compartido)) {
        botonDesafioCompartido.show();
      }
    } else {
      botonCompartirDesafio.show();
    }
    $("#desafioCompatibleLabel").html(resp.razon_social);
    console.log(resp);
    if (resp.logo) {
      bodyDesafios.append(`
      <div class="text-center">
        <img src="${BASE_URL}uploads/imagenes_de_usuarios/${resp.id_empresa}.png" class="rounded-circle" alt="Logo Startup">
      </div>
      `);
    } else {
      bodyDesafios.append(`
      <div class="text-center">
        <img src="${BASE_URL}assets/img/usuario.jpeg" class="rounded-circle" alt="Logo Startup">
      </div>
      `);
    }
    if (resp.nombre_empresa) {
      bodyDesafios.append(`
        <p class="text-primary font-weight-bold">
          Empresa: <span class="text-secondary font-weight-normal">${resp.nombre_empresa}</span>
        </p>
        `);
    }
    if (resp.nombre_del_desafio) {
      bodyDesafios.append(`
      <p class="text-primary font-weight-bold">
        Título desafío: <span class="text-secondary font-weight-normal">${resp.nombre_del_desafio}</span>
      </p>
      `);
    }
    if (resp.descripcion_del_desafio) {
      bodyDesafios.append(`
        <p class="text-primary font-weight-bold">
        Descripción: <span class="text-secondary font-weight-normal">${resp.descripcion_del_desafio}</span>
        </p>
        `);
    }
    if (resp.requisitos_del_desafio) {
      bodyDesafios.append(`
      <p class="text-primary font-weight-bold">
        Requisitos: <span class="text-secondary font-weight-normal">${resp.requisitos_del_desafio}</span>
      </p>
      `);
    }
    if (resp.nombre_de_categorias) {
      bodyDesafios.append(`
        <p class="text-primary font-weight-bold">
          Productos/Servicios que solicita: <span class="text-secondary font-weight-normal">${resp.nombre_de_categorias}</span>
        </p>
        `);
    }
    if (resp.fecha_fin_de_postulacion) {
      bodyDesafios.append(`
          <p class="text-primary font-weight-bold">
            Fecha fin de postulación: <span class="text-secondary font-weight-normal">${moment(
              resp.fecha_fin_de_postulacion
            ).format("DD-MM-YYYY")}</span>
          </p>
          `);
    }
  });
  switchLoadingGif("desafioCompatible", "ocultar");
};

const getDesafioData = () => {
  const data = {
    startup_id: startupId,
    desafio_id: desafioId,
  };
  let respuesta = new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: BASE_URL + "desafios/getDesafioById",
      dataType: "JSON",
      data: data,
      // beforeSend: function () {
      // },
      // error: function () {
      // },
      success: function (resp) {
        resolve(resp.data);
      },
      // timeout: 5000,
    });
  });
  return respuesta;
};

const cerrarModal = (data) => {
  const modalId = data.dataset.modalId;
  $(`#${modalId}`).modal("hide");
  switchLoadingGif(modalId);
};
