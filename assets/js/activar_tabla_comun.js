$(document).ready(()=>{
    cargarTabla();
});

const cargarTabla = ()=>{
    var table = $("#dataTableComun").DataTable({
        destroy: true,
        responsive: true,
        info: false,
        language: {
          url: "./assets/js/datatables/es_es.json",
        },
      });
}