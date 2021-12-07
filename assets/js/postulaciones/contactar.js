$(document).ready(function () {
  escucharBotonCotactar();
});

const escucharBotonCotactar = () => {
  $("#botonContactarModal").on("click", function (e) {
    let startupId = $(this).data("startupId");
    let desafioId = $(this).data("desafioId");
    generarContacto(startupId, desafioId);
  });
};

const generarContacto = (startupId, desafioId) => {
  const data = `startup_id=${startupId}&desafio_id=${desafioId}`;
  $.ajax({
    type: "POST",
    url: BASE_URL + "postulados/contactar",
    dataType: "JSON",
    data: data,
    // beforeSend: function () {
    //   frmElement.find("form").css("opacity", "0.5");
    //   frmElement.find(".statusMsg").css("display", "none");
    // },
    success: function (resp) {
      if (resp.status_code == 200) {
          $('#modalContactar').modal('hide');
        swal({
          title: "Felicidades",
          text: "Se ha enviado la solicitud de contacto",
          type: "success",
          buttonsStyling: true,
          timer: 5000,
          confirmButtonClass: "btn btn-success",
        });
        habilitarDatosDeContacto(resp.startup_data);
      }
    },
  });
};

const habilitarDatosDeContacto = (data) => {
    console.log(data);
    $('#botonContactar').css('display','none');
    $('#datosDeContacto').css('display','block');
    $('#dataContactoNombre').html(data.nombre);
    $('#dataContactoApellido').html(data.apellido);
    $('#dataContactoEmail').html(data.email_contacto);
    $('#dataContactoTelefono').html(data.telefono_contacto);
};
