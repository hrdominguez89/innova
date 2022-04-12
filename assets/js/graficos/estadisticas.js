$(document).ready(() => {
  cargarGraficoDesafiosPorMes();
  cargarGraficoPostulacionesPorMes();
  cargarGraficoMatchPorMes();
  cargarGraficoRegistrosPorRolPorMes();
  escucharFechas();
});

var meses = [
  "Ene",
  "Feb",
  "Mar",
  "Abr",
  "May",
  "Jun",
  "Jul",
  "Ago",
  "Sep",
  "Oct",
  "Nov",
  "Dic",
];

let fechaDesde;
let fechaHasta;

let dataDesafiosPorMes;
let dataPostulacionesPorMes;
let dataMatchPorMes;
let dataRegistrosPorRolPorMes;

const escucharFechas = () => {};

const cargarGraficoDesafiosPorMes = async () => {
  await $.ajax({
    type: "GET",
    url: BASE_URL + "estadisticas/getDesafiosPorMes",
    dataType: "JSON",
    data: { fecha_desde: fechaDesde, fecha_hasta: fechaHasta },
    success: function (resp) {
      dataDesafiosPorMes = resp.data;
    },
  });

  let mesesLabel = [];

  let mesesData = [];

  const primerAnio = parseInt(dataDesafiosPorMes[0].anio_mes.slice(0, 4));
  const ultimoAnio = parseInt(
    dataDesafiosPorMes[dataDesafiosPorMes.length - 1].anio_mes.slice(0, 4)
  );

  const primerMes = parseInt(dataDesafiosPorMes[0].anio_mes.slice(4));
  const ultimoMes = parseInt(
    dataDesafiosPorMes[dataDesafiosPorMes.length - 1].anio_mes.slice(4)
  );

  let indiceAnio = primerAnio;
  while (indiceAnio <= ultimoAnio) {
    console.log(indiceAnio);
    let indiceMes;
    let indiceUltimoMes;
    if (indiceAnio != primerAnio) {
      indiceMes = 0;
      indiceUltimoMes = ultimoMes - 1;
    } else {
      indiceMes = primerMes - 1;
      indiceUltimoMes = 11;
    }
    while (indiceMes <= indiceUltimoMes) {
      mesesLabel.push(`${meses[indiceMes]}-${indiceAnio}`);
      mesesData.push(0);
      indiceMes++;
    }
    indiceAnio++;
  }
  dataDesafiosPorMes.map((elemento) => {
    indexMesData = mesesLabel.findIndex(
      (element) =>
        element ==
        `${meses[elemento.anio_mes.slice(4) - 1]}-${elemento.anio_mes.slice(
          0,
          4
        )}`
    );
    mesesData[indexMesData] = parseInt(elemento.cantidad);
  });

  let dataMes;
  let dataTotalDesafiosMes;

  var options = {
    series: [
      {
        name: "Desafíos cargados",
        data: mesesData,
      },
    ],
    
    chart: {
      height: 350,
      type: "area",
      dropShadow: {
        enabled: true,
        color: "#000",
        top: 18,
        left: 7,
        blur: 10,
        opacity: 0.2,
      },
      toolbar: {
        show: true,
        tools: {
          download: true,
        },
        export: {
          csv: {
            filename: "Desafios creados por mes",
            columnDelimiter: ";",
            headerCategory: "Categorias",
            headerValue: "value",
            dateFormatter(timestamp) {
              return new Date(timestamp).toDateString();
            },
          },
          svg: {
            filename: "Desafios creados por mes",
          },
          png: {
            filename: "Desafios creados por mes",
          },
        },
      },
    },
    colors: ["#77B6EA", "#545454"],
    dataLabels: {
      enabled: true,
    },
    stroke: {
      curve: "smooth",
    },
    grid: {
      borderColor: "#e7e7e7",
      row: {
        colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
        opacity: 0.5,
      },
    },
    markers: {
      size: 1,
    },
    xaxis: {
      categories: mesesLabel,
      title: {
        text: "Meses",
      },
    },
    yaxis: {
      title: {
        text: "Desafíos",
      },
      min: 0,
      max: 40,
    },
    legend: {
      position: "top",
      horizontalAlign: "right",
      floating: true,
      offsetY: -25,
      offsetX: -5,
    },
  };

  var chart = new ApexCharts(
    document.querySelector("#graficosDesafiosPorMes"),
    options
  );
  chart.render();
};

const cargarGraficoPostulacionesPorMes = () => {};

const cargarGraficoMatchPorMes = () => {};

const cargarGraficoRegistrosPorRolPorMes = () => {};
