var tablaStartupsCompatibles;
var desafioId;
var empresaId;
var startupId;
var startupData;
var listadoDeStartups;
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
      data: "razon_social",
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
      className: "text-right",
      searchable: false,
      orderable: false,
      render: function (data, type, full, meta) {
        const startup_id = full.startup_id;
        return `<a href="javascript:void(0);" class="text-primary" onclick="verStartupCompatible(this)" data-startup-id="${startup_id}"><i class="fas fa-eye"></i></a>`;
      },
    },
  ],
};

window.addEventListener("load", () => {
  escucharBotonVerStartupsCompatibles();
  escucharBotonCompartirDesafio();
  tablaStartupsCompatibles = $("#startupsCompatiblesTable").DataTable(
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
  });
};

const mostrarResultadoCompartir = (resultado) => {
  resultado.then((res) => {
    console.log(res);
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

const escucharBotonVerStartupsCompatibles = () => {
  const botonesVerStartupsCompatibles = document.getElementsByClassName(
    "verStartupsCompatibles"
  );
  Array.from(botonesVerStartupsCompatibles).forEach(
    (botonVerStartupsCompatibles) => {
      botonVerStartupsCompatibles.addEventListener("click", () => {
        $("#startupsCompatibles").modal("show");
        desafioId = botonVerStartupsCompatibles.dataset.desafioId;
        empresaId = botonVerStartupsCompatibles.dataset.empresaId;
        listadoDeStartups = consultarStartupsCompatiblesParaDesafioId();
        cargarDatatable();
      });
    }
  );
};

const consultarStartupsCompatiblesParaDesafioId = () => {
  const data = {
    desafio_id: desafioId,
  };
  let respuesta = new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: BASE_URL + "startups/getStartupsCompatiblesPorDesafioId",
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
  tablaStartupsCompatibles.clear();
  await listadoDeStartups.then((startups) => {
    tablaStartupsCompatibles.rows.add(startups);
  });
  tablaStartupsCompatibles.draw();
  switchLoadingGif("startupsCompatibles", "ocultar");
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

const verStartupCompatible = (data) => {
  startupId = data.dataset.startupId;
  startupData = getStartupData();
  botonDesafioCompartido.hide();
  botonCompartirDesafio.hide();
  botonDesafioPostulado.hide();
  $("#startupCompatible").modal("show");
  mostrarDatosStartup();
};

const mostrarDatosStartup = async () => {
  const bodyStartups = $("#startupCompatibleDiv");
  bodyStartups.html("");
  await startupData.then((resp) => {
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
    $("#startupCompatibleLabel").html(resp.razon_social);
    if (resp.logo) {
      bodyStartups.append(`
      <div class="text-center">
        <img src="${BASE_URL}uploads/imagenes_de_usuarios/${startupId}.png" class="rounded-circle" alt="Logo Startup">
      </div>
      `);
    } else {
      bodyStartups.append(`
      <div class="text-center">
        <img src="${BASE_URL}assets/img/usuario.jpeg" class="rounded-circle" alt="Logo Startup">
      </div>
      `);
    }
    if (resp.rubro) {
      bodyStartups.append(`
      <p class="text-primary font-weight-bold">
        Rubro: <span class="text-secondary font-weight-normal">${resp.rubro}</span>
      </p>
      `);
    }
    if (resp.descripcion) {
      bodyStartups.append(`
      <p class="text-primary font-weight-bold">
        Descripción: <span class="text-secondary font-weight-normal">${resp.descripcion}</span>
      </p>
      `);
    }
    if (resp.antecedentes) {
      bodyStartups.append(`
      <p class="text-primary font-weight-bold">
        Antecedentes: <span class="text-secondary font-weight-normal">${resp.antecedentes}</span>
      </p>
      `);
    }
    if (resp.exporta) {
      bodyStartups.append(`
      <p class="text-primary font-weight-bold">
        Exporta: <span class="text-secondary font-weight-normal">${resp.exporta}</span>
      </p>
      `);
    }
    if (resp.nombre_de_categorias) {
      bodyStartups.append(`
      <p class="text-primary font-weight-bold">
        Categorías: <span class="text-secondary font-weight-normal">${resp.nombre_de_categorias}</span>
      </p>
      `);
    }
    if (resp.objetivo_y_motivacion) {
      bodyStartups.append(`
      <p class="text-primary font-weight-bold">
        Objetivo y motivación: <span class="text-secondary font-weight-normal">${resp.objetivo_y_motivacion}</span>
      </p>
      `);
    }
  });
  switchLoadingGif("startupCompatible", "ocultar");
};

const getStartupData = () => {
  const data = {
    startup_id: startupId,
    desafio_id: desafioId,
  };
  let respuesta = new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: BASE_URL + "startups/getStartupById",
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
