$(document).ready(function () {
    escucharbotonGuardarEditarDesafio();
  });

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

const cleanCheckboxCategorias = () => {
    const categorias = document.getElementsByClassName("editar-categorias");
    for (i = 0; i < categorias.length; i++) {
      const categoria = categorias[i];
      categoria.removeAttribute("checked");
    }
  };
  
  const cargarDatosEnInputsEditarDesafio = (data) => {
    cleanCheckboxCategorias();
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
    $("#editar_inicio_del_desafio").val(data.fecha_inicio_de_postulacion);
    $("#editar_fin_del_desafio").val(data.fecha_fin_de_postulacion);
    $("#editar_nombre_del_desafio").val(data.nombre_del_desafio);
    $("#editar_descripcion_del_desafio").val(data.descripcion_del_desafio);
    $("#editar_requisitos_del_desafio").val(data.requisitos_del_desafio);
    $("#editar_desafio_id").val(data.id);
    $("#editarDesafioModal").modal("show");
  };

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
                text: "El desafío se editó exitosamente.",
                type: "success",
                buttonsStyling: true,
                confirmButtonClass: "btn btn-success",
                allowOutsideClick: false,
              })
              .then(resp=>{
                  if(resp.value){
                    $(location).attr("href", BASE_URL + "desafios");
                  }
              });
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
