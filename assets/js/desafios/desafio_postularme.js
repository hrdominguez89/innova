$(document).ready(() => {
  escucharBotonPostularmeModal();
  escucharBotonVerMas();
});

const escucharBotonPostularmeModal = () => {
  $(".botonPostularme").on("click", function (e) {
    let desafioId = $(this).data("desafioId");
    enviarPostulacion(desafioId);
  });
};

const escucharBotonVerMas = ()=>{
  $(".botonVerMas").on("click", function (e) {
    let botonVerMas = $(this);
    const desafioId = botonVerMas.data("desafioId");
    const dataValue = botonVerMas.data("value");
    nuevosValoresBotonVerMas = collapseDesafio(dataValue,desafioId)
    botonVerMas.data('value',nuevosValoresBotonVerMas.dataValue);
    botonVerMas.html(nuevosValoresBotonVerMas.dataHtml);
  });
}

const collapseDesafio = (valor,id)=>{
  if(valor){
    $(`#verMasDesafioCollapse${id}`).collapse('hide');
    return {
      dataValue:false,
      dataHtml:'Ver más... <i class="fas fa-chevron-circle-down"></i>'
    }
  }else{
    $(`#verMasDesafioCollapse${id}`).collapse('show');
    return {
      dataValue:true,
      dataHtml:'Ver menos <i class="fas fa-chevron-circle-up"></i>'
    }
  }
}

const enviarPostulacion = (desafioId) => {
  const dataPost = "desafio_id=" + desafioId;
  $.ajax({
    type: "POST",
    url: BASE_URL + "desafios/postularse",
    dataType: "JSON",
    data: dataPost,
    beforeSend: function () {
      $(`#desafio-modal-${desafioId}`).modal('hide');
    },
    error: function () {
      // toggleModalInfo(false);
      // $("#erroresModalEditarDesafio").html(
      //   '<div class="alert alert-danger">No fue posible generar la postulación, por favor intente nuevamente.</div>'
      // );
    },
    success: function (resp) {
      switch (resp.status_code) {
        case 200:
          if (resp.postulado) {
            swal({
              title: "Felicidades",
              text: resp.mensaje,
              type: "success",
              buttonsStyling: true,
              timer: 5000,
              confirmButtonClass: "btn btn-success",
            });
          } else {
            swal({
              title: "Limite alcanzado",
              text: resp.mensaje,
              type: "error",
              buttonsStyling: true,
              timer: 5000,
              confirmButtonClass: "btn btn-danger",
            });
          }
          break;
        case 403: //no esta logueado
          $(location).attr("href", BASE_URL + "auth/login");
          break;
      }
    },
    timeout: 5000,
  });
};
