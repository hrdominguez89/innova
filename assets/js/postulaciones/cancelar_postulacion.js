$(document).ready(() => {
  escucharBotonCancelarPostulacion();
});

let postulacion_id;

const escucharBotonCancelarPostulacion = () => {
  $(".botonCancelarPostulacion").on("click", (element) => {
      console.log(element)
    postulacion_id = element.target.dataset.postulacionId;
    $("#inputHiddenPostulacionId").val(postulacion_id);
    $("#cancelarPostulacionModal").modal("show");
  });
};
