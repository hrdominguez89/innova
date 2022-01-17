var botonIrAlMensaje;
var datalistOptions;
var datalistInput;
var dataListTitulosMensajesError;
var botonLimpiar;

window.addEventListener("load", () => {
  datalistOptions = document.getElementById("dataListTitulosMensajes");
  dataListTitulosMensajesError = $("#dataListTitulosMensajesError");
  escucharBotonIrAlMensaje();
  escucharBotonLimpiar();
});

const escucharBotonLimpiar = () => {
  botonLimpiar = $("#dataListTitulosMensajesBotonLimpiar");
  botonLimpiar.on("click", () => {
    dataListTitulosMensajesError.hide();
    datalistInput = $("#dataListTitulosMensajesInput");
    datalistInput.val('');
  });
};

const escucharBotonIrAlMensaje = () => {
  botonIrAlMensaje = $("#dataListTitulosMensajesBotonIrAlMensaje");
  botonIrAlMensaje.on("click", () => {
    dataListTitulosMensajesError.hide();
    datalistInput = $("#dataListTitulosMensajesInput");

    if (
      Array.from(datalistOptions.options).find(
        (option) => option.value == datalistInput.val()
      )
    ) {
      const cardMensajeId = `card-mensaje-id-${
        datalistInput.val().split("-")[0]
      }`;
      window.location.replace(`#${cardMensajeId}`);
    } else {
      dataListTitulosMensajesError.show();
    }
  });
};
