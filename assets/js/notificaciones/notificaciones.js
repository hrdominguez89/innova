$(document).ready(function () {
  cargarDataTable();
  escucharBotonVerNotificacion();
});

const cargarDataTable = () => {
  $("#datatablesNotificaciones").DataTable({
    columnDefs: [{ type: "num", targets: 0 }],
    pagingType: "full_numbers",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"],
    ],
    order: [
      [2, "desc"],
      [1, "desc"],
    ],
    responsive: true,
    language: {
      url: "./assets/js/datatables/es_es.json",
    },
  });
};

const escucharBotonVerNotificacion = () => {
  $(".verNotificacion").on("click", function (e) {
    let notificacionId = $(this).data("notificacionId");
    notificacionID = "notificacion_id=" + notificacionId;
    traerNotificacion(notificacionId);
  });
};

const traerNotificacion = (notificacionId) => {
  $.ajax({
    type: "POST",
    url: BASE_URL + "notificaciones/ver/",
    dataType: "JSON",
    data: notificacionID,
    // beforeSend: function () {
      //   frmElement.find("form").css("opacity", "0.5");
      //   frmElement.find(".statusMsg").css("display", "none");
    // },
    success: function (resp) {
        if(resp.status){
            if(resp.data.leido==0){
                marcarComoLeido(notificacionId);
            }
            rellenarModal(resp.data);
        }else{

        }
    },
  });
};
const restarNumeroDeNotificacionesTotal = ()=>{
    let mensajesTotalMenu = parseInt($(`.notificacion-total-menu`).html());
    let mensajesTotalHeader = parseInt($(`.notificacion-total-header`).html());

    //resto a menu lateral
    if(--mensajesTotalMenu){
        $(`.notificacion-total-menu`).html(mensajesTotalMenu);
    }else{
        $(`.notificacion-total-menu`).removeClass('badge badge-pill badge-secondary notificacion-total-bandeja-menu');
        $(`.notificacion-total-menu`).html('');
        $(`.notificacion-icono-menu`).html('notifications');
    }

    //resto a menu header
    if(--mensajesTotalHeader){
        $(`.notificacion-total-header`).html(mensajesTotalHeader);
    }else{
        $(`.notificacion-total-header`).html('');
        $(`.notificacion-total-header`).removeClass('badge badge-pill badge-secondary notificacion-total-bandeja-header');
        $(`.notificacion-color-header`).removeClass('text-primary');
        $(`.notificacion-icono-header`).html('notifications');

    }
}
const restarNumeroDeNotificacionesBandeja = (ubicacion)=>{
    let mensajesTotalBandeja = parseInt($(`.notificacion-total-bandeja-${ubicacion}`).html());

    //resto a bandeja menu lateral
    if(--mensajesTotalBandeja){
        $(`.notificacion-total-bandeja-${ubicacion}`).html(mensajesTotalBandeja);
    }else{
        $(`.notificacion-total-bandeja-${ubicacion}`).html('');
        $(`.notificacion-total-bandeja-${ubicacion}`).removeClass(`badge badge-pill badge-secondary notificacion-total-bandeja-${ubicacion}`);
    }
}

const marcarComoLeido = (notificacionId)=>{

    //marco como leido las notificaciones del header
    if($(`.notificacion-icono-menu-${notificacionId}`)[0]){
        $(`.notificacion-icono-menu-${notificacionId}`).html('drafts');
        $(`.notificacion-fuente-menu-${notificacionId}`).removeClass('font-weight-bold font-italic');      
    }else{//si no existe en el menu. descuento de la cantidad de las bandejas de entrada del header.
        restarNumeroDeNotificacionesBandeja('menu');
    }

    //marco leido las notificaciones del header
    if($(`.notificacion-icono-header-${notificacionId}`)[0]){
        $(`.notificacion-icono-header-${notificacionId}`).removeClass('fas fa-envelope');
        $(`.notificacion-icono-header-${notificacionId}`).addClass('far fa-envelope-open');
        $(`.notificacion-fuente-header-${notificacionId}`).removeClass('font-weight-bold font-italic');
    }else{
        //si no existe en el menu. descuento de la cantidad de las bandejas de entrada del header.
        restarNumeroDeNotificacionesBandeja('header');
    }
    //resto nro total de header y del menu latearal
    restarNumeroDeNotificacionesTotal();

    //marco como leido correos del listado
    $(`.notificacion-fuente-lista-${notificacionId}`).removeClass(`font-weight-bold font-italic`);
    $(`.notificacion-leido-lista-${notificacionId}`).html('Leido');
    $(`.notificacion-icono-lista-${notificacionId}`).removeClass(`fas fa-envelop`);
    $(`.notificacion-icono-lista-${notificacionId}`).addClass(`far fa-envelope-open`);
    
}

const rellenarModal = (data)=>{
  console.log(data)
    var date = moment(data.fecha_alta).format('DD-MM-YYYY hh:mm:ss a');

    const notificacionDe = $('#notificacionDe');
    const notificacionPara = $('#notificacionPara');
    const notificacionFechaEnviado = $('#notificacionFechaEnviado');
    const notificacionTitulo = $('#notificacionTitulo');
    const notificacionMensaje = $('#notificacionMensaje');

    notificacionDe.html(`<b>De:</b> ${data.de_nombre}`);
    notificacionPara.html(`<b>Para:</b> ${data.para_nombre}`);
    notificacionFechaEnviado.html(`<b>Fecha:</b> ${date}`);
    notificacionTitulo.html(`<b>Título:</b> ${data.titulo_mensaje}`);
    notificacionMensaje.html(`${data.mensaje}`);

}