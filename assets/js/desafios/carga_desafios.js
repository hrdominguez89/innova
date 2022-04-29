$(document).ready(function () {
  cargarDesafios();
  escucharBotonVigentes();
  escucharBotonFinalizados();
  escucharBotonNuevoDesafio();
  escucharBotonGuardarDesafios();
  escucharbotonGuardarEditarDesafio();
});

const escucharbotonGuardarEditarDesafio = () => {
  $("#botonGuardarEditarDesafio").on("click", () => {
    const formDesafio = $("#formularioEditarDesafio");
    data = formDesafio.serialize();
    $.ajax({
      type: "POST",
      url: BASE_URL + "desafios/editar",
      dataType: "JSON",
      data: data,
      beforeSend: function () {
        toggleModalInfo(true);
      },
      error: function () {
        toggleModalInfo(false);
        $("#erroresModalEditarDesafio").html(
          '<div class="alert alert-danger">No fue posible guardar el desafío, por favor intente nuevamente.</div>'
        );
      },
      success: function (resp) {
        switch (resp.status_code) {
          case 200:
            toggleModalInfo(false);
            $("#editarDesafioModal").modal("hide");
            swal({
              title: "Felicidades",
              text: "Tu desafío se editó exitosamente.",
              type: "success",
              buttonsStyling: true,
              timer: 5000,
              confirmButtonClass: "btn btn-success",
            });
            cargarDesafios();
            $("#botonFinalizados").removeClass("active");
            $("#botonVigentes").addClass("active");
            break;
          case 403: //no esta logueado
            $(location).attr("href", BASE_URL + "auth/login");
            break;
          case 422: //volvio con validaciones
            toggleModalInfo(false);
            $("#erroresModalEditarDesafio").html(resp.msg);
            break;
        }
      },
      timeout: 5000,
    });
  });
};

const escucharBotonNuevoDesafio = () => {
  $("#botonNuevoDesafio").on("click", () => {
    $("#formularioNuevoDesafio")[0].reset();
    $("#erroresModalNuevoDesafio").html("");
    $("#nuevoDesafioModal").modal("show");
  });
};

const escucharBotonGuardarDesafios = () => {
  $("#botonGuardarDesafio").on("click", () => {
    const formDesafio = $("#formularioNuevoDesafio");
    data = formDesafio.serialize();
    $.ajax({
      type: "POST",
      url: BASE_URL + "desafios/insertar",
      dataType: "JSON",
      data: data,
      beforeSend: function () {
        toggleModalInfo(true);
      },
      error: function () {
        toggleModalInfo(false);
        $("#erroresModalNuevoDesafio").html(
          '<div class="alert alert-danger">No fue posible guardar el desafío, por favor intente nuevamente.</div>'
        );
      },
      success: function (resp) {
        switch (resp.status_code) {
          case 200:
            toggleModalInfo(false);
            $("#nuevoDesafioModal").modal("hide");
            swal({
              title: "Felicidades",
              text: "Tu desafío se cargó exitosamente.",
              type: "success",
              buttonsStyling: true,
              timer: 5000,
              confirmButtonClass: "btn btn-success",
            });
            cargarDesafios();
            $("#botonFinalizados").removeClass("active");
            $("#botonVigentes").addClass("active");
            break;
          case 403: //no esta logueado
            $(location).attr("href", BASE_URL + "auth/login");
            break;
          case 422: //volvio con validaciones
            toggleModalInfo(false);
            $("#erroresModalNuevoDesafio").html(resp.msg);
            break;
        }
      },
      timeout: 5000,
    });
  });
};

const toggleModalInfo = (cargando) => {
  if (cargando) {
    //esconde el titulo el formulario y los botones y muestra el gif de cargando
    $("#tituloNuevoDesafioModal").hide();
    $("#formularioNuevoDesafio").hide();
    $("#botonesFooterNuevoDesafioModal").hide();
    $("#loadingNuevoModal").show();
    $("#erroresModalNuevoDesafio").html("");
  } else {
    $("#tituloNuevoDesafioModal").show();
    $("#formularioNuevoDesafio").show();
    $("#botonesFooterNuevoDesafioModal").show();
    $("#loadingNuevoModal").hide();
  }
};

const toggleModalEditarInfo = (cargando) => {
  if (cargando) {
    //esconde el titulo el formulario y los botones y muestra el gif de cargando
    $("#tituloEditarDesafioModal").hide();
    $("#formularioEditarDesafio").hide();
    $("#botonesFooterEditarDesafioModal").hide();
    $("#loadingEditarModal").show();
    $("#erroresModalEditarDesafio").html("");
  } else {
    $("#tituloEditarDesafioModal").show();
    $("#formularioEditarDesafio").show();
    $("#botonesFooterEditarDesafioModal").show();
    $("#loadingEditarModal").hide();
  }
};

const escucharBotonVigentes = () => {
  $("#botonVigentes").on("click", () => {
    cargarDesafios("vigentes");
    $("#botonFinalizados").removeClass("active");
    $("#botonVigentes").addClass("active");
  });
};

const escucharBotonFinalizados = () => {
  $("#botonFinalizados").on("click", () => {
    cargarDesafios("finalizados");
    $("#botonVigentes").removeClass("active");
    $("#botonFinalizados").addClass("active");
  });
};

const cargarDesafios = (estadoDesafio = false) => {
  estadoDesafio = estadoDesafio ? estadoDesafio : "vigentes";
  var table = $("#datatablesDesafios").DataTable({
    destroy: true,
    responsive: true,
    info: false,
    ajax: {
      type: "post",
      url: BASE_URL + "desafios/getDesafiosByUserId",
      data: {
        estadoDesafio: estadoDesafio,
      },
      dataSrc: "",
    },
    columns: [
      { data: "nombre_del_desafio" },
      { data: "descripcion_del_desafio" },
      {
        render: function (full, type, data, meta) {
          return moment(data.fecha_inicio_de_postulacion).format("DD-MM-YYYY");
        },
      },
      {
        render: function (full, type, data, meta) {
          return moment(data.fecha_fin_de_postulacion).format("DD-MM-YYYY");
        },
      },
      {
        render: function (full, type, data, meta) {
          // <a href='javascript:void(0)' onclick="verDesafio(${data.id})" title="Ver desafío" class='editarDesafio mx-2 text-success'><i class="far fa-eye"></i></a>
          // <a href='javascript:void(0)' onclick="eliminarDesafio${data.id}" title="Eliminar desafío" class='eliminarDesafio mx-2 text-danger'><i class='fas fa-trash-alt size-18' aria-hidden='true'></i></a>
          return `

            <a href='javascript:void(0)' onclick="editarDesafio(${data.id})" title="Editar desafío" class='editarDesafio mx-2 text-warning'><i class='fas fa-edit size-18' aria-hidden='true'></i></a>
              
            `;
        },
      },
    ],
    columnDefs: [
      {
        targets: 2, // your case first column
        className: "text-center",
      },
      {
        targets: 3,
        className: "text-center",
      },
      {
        targets: 4,
        className: "text-center",
      },
    ],
    language: {
      url: "./assets/js/datatables/es_es.json",
    },
  });
};


const editarDesafio = (desafio_id) => {
  $.ajax({
    type: "POST",
    url: BASE_URL + "desafios/getDesafioByDesafioId",
    dataType: "JSON",
    data: {
      desafio_id: desafio_id,
    },
    beforeSend: function () {
      toggleModalEditarInfo(true);
    },
    error: function () {
      toggleModalEditarInfo(false);
      $("#erroresModalEditarDesafio").html(
        '<div class="alert alert-danger">No fue posible guardar el desafío, por favor intente nuevamente.</div>'
      );
    },
    success: function (resp) {
      switch (resp.status_code) {
        case 200:
          toggleModalEditarInfo(false);
          cargarDatosEnInputsEditarDesafio(resp.data);
          break;
        case 403: //no esta logueado
          $(location).attr("href", BASE_URL + "auth/login");
          break;
        case 422: //volvio con validaciones
          toggleModalEditarInfo(false);
          $("#erroresModalEditarDesafio").html(resp.msg);
          break;
      }
    },
    timeout: 5000,
  });
};

const eliminarDesafio = (desafio_id) => {
  console.log(desafio_id);
};

const cleanCheckboxCategorias = () => {
  const categorias = document.getElementsByClassName("editar-categorias");
  for (i = 0; i < categorias.length; i++) {
    const categoria = categorias[i];
    categoria.removeAttribute("checked");
  }
};

const cargarDatosEnInputsEditarDesafio = (data) => {
  cleanCheckboxCategorias();
  if(data.id_de_categorias){
    const categoriasDesafio = data.id_de_categorias.split(",");
    const categorias = document.getElementsByClassName("editar-categorias");
    for (i = 0; i < categorias.length; i++) {
      const categoria = categorias[i];
      for (j = 0; j < categoriasDesafio.length; j++) {
        const categoriaDesafio = parseInt(categoriasDesafio[j]);
        if (categoria.value == categoriaDesafio) {
          categoria.setAttribute("checked", "");
          break;
        }
      }
    }
  }
  $("#editar_inicio_del_desafio").val(data.fecha_inicio_de_postulacion);
  if(moment().isAfter(data.fecha_inicio_de_postulacion)){
    $("#editar_inicio_del_desafio").attr('min',data.fecha_inicio_de_postulacion);
  }else{
    $("#editar_inicio_del_desafio").attr('min',moment().format('YYYY-MM-DD'));
  }
  $("#editar_fin_del_desafio").val(data.fecha_fin_de_postulacion);
  $("#editar_fin_del_desafio").attr('min',data.fecha_inicio_de_postulacion);
  $("#editar_nombre_del_desafio").val(data.nombre_del_desafio);
  $("#editar_descripcion_del_desafio").val(data.descripcion_del_desafio);
  $("#editar_requisitos_del_desafio").val(data.requisitos_del_desafio);
  $("#editar_desafio_id").val(data.id);
  $("#editarDesafioModal").modal("show");
};
