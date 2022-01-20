$(document).ready(()=>{
    cargarTabla();
});

const cargarTabla = ()=>{
    var table = $("#dataTableComun").DataTable({
        destroy: true,
        responsive: true,
        info: false,
        language: {
          url: `${BASE_URL}/assets/js/datatables/es_es.json`,
        },
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print',
        ]
      });
}