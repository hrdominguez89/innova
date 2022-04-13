$(document).ready(() => {
  cargarGraficoDesafiosPorMes();
  cargarGraficoPostulacionesPorMes();
  cargarGraficoMatchPorMes();
  // cargarGraficoRegistrosPorRolPorMes();
  escucharBotonesCargarGrafico();
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

let fechaDesde = false;
let fechaHasta = false;

let dataDesafiosPorMes;
let dataPostulacionesPorMes;
let dataMatchPorMes;
let dataRegistrosPorRolPorMes;

let graficoDesafioPorMes;
let graficoPostulacionesPorMes;
let graficoMatchPorMes;
let graficoRegistrosPorRolPorMes;

const cargarGraficoDesafiosPorMes = async () => {
  if (graficoDesafioPorMes) {
    graficoDesafioPorMes.destroy();
  }

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
  if (primerAnio == ultimoAnio) {
    let indiceMes = 0;
    let indiceUltimoMes = ultimoMes - 1;
    while (indiceMes <= indiceUltimoMes) {
      mesesLabel.push(`${meses[indiceMes]}-${indiceAnio}`);
      mesesData.push(0);
      indiceMes++;
    }
  } else {
    while (indiceAnio <= ultimoAnio) {
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
            headerCategory: "Meses",
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

  graficoDesafioPorMes = new ApexCharts(
    document.querySelector("#graficosDesafiosPorMes"),
    options
  );
  graficoDesafioPorMes.render();
};

const cargarGraficoPostulacionesPorMes = async() => {
  if (graficoPostulacionesPorMes) {
    graficoPostulacionesPorMes.destroy();
  }

  await $.ajax({
    type: "GET",
    url: BASE_URL + "estadisticas/getPostulacionesPorMes",
    dataType: "JSON",
    data: { fecha_desde: fechaDesde, fecha_hasta: fechaHasta },
    success: function (resp) {
      dataPostulacionesPorMes = resp.data;
    },
  });

  console.log(dataPostulacionesPorMes);

  let mesesLabel = [];

  let mesesData = [];

  const primerAnio = parseInt(dataPostulacionesPorMes[0].anio_mes.slice(0, 4));
  const ultimoAnio = parseInt(
    dataPostulacionesPorMes[dataPostulacionesPorMes.length - 1].anio_mes.slice(0, 4)
  );

  const primerMes = parseInt(dataPostulacionesPorMes[0].anio_mes.slice(4));
  const ultimoMes = parseInt(
    dataPostulacionesPorMes[dataPostulacionesPorMes.length - 1].anio_mes.slice(4)
  );

  let indiceAnio = primerAnio;
  if (primerAnio == ultimoAnio) {
    let indiceMes = 0;
    let indiceUltimoMes = ultimoMes - 1;
    while (indiceMes <= indiceUltimoMes) {
      mesesLabel.push(`${meses[indiceMes]}-${indiceAnio}`);
      mesesData.push(0);
      indiceMes++;
    }
  } else {
    while (indiceAnio <= ultimoAnio) {
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
  }
  dataPostulacionesPorMes.map((elemento) => {
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

  var options = {
    series: [
      {
        name: "Cantidad de postulaciones",
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
            filename: "Postulaciones por mes",
            columnDelimiter: ";",
            headerCategory: "Meses",
            headerValue: "value",
            dateFormatter(timestamp) {
              return new Date(timestamp).toDateString();
            },
          },
          svg: {
            filename: "Postulaciones por mes",
          },
          png: {
            filename: "Postulaciones por mes",
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
        text: "Postulaciones",
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

  graficoPostulacionesPorMes = new ApexCharts(
    document.querySelector("#graficoPostulacionesPorMes"),
    options
  );
  graficoPostulacionesPorMes.render();
};

const cargarGraficoMatchPorMes = async() => {
  if (graficoMatchPorMes) {
    graficoMatchPorMes.destroy();
  }

  await $.ajax({
    type: "GET",
    url: BASE_URL + "estadisticas/getMatchPorMes",
    dataType: "JSON",
    data: { fecha_desde: fechaDesde, fecha_hasta: fechaHasta },
    success: function (resp) {
      dataMatchPorMes = resp.data;
    },
  });

  console.log(dataMatchPorMes);

  let mesesLabel = [];

  let mesesData = [];

  const primerAnio = parseInt(dataMatchPorMes[0].anio_mes.slice(0, 4));
  const ultimoAnio = parseInt(
    dataMatchPorMes[dataMatchPorMes.length - 1].anio_mes.slice(0, 4)
  );

  const primerMes = parseInt(dataMatchPorMes[0].anio_mes.slice(4));
  const ultimoMes = parseInt(
    dataMatchPorMes[dataMatchPorMes.length - 1].anio_mes.slice(4)
  );

  let indiceAnio = primerAnio;
  if (primerAnio == ultimoAnio) {
    let indiceMes = 0;
    let indiceUltimoMes = ultimoMes - 1;
    while (indiceMes <= indiceUltimoMes) {
      mesesLabel.push(`${meses[indiceMes]}-${indiceAnio}`);
      mesesData.push(0);
      indiceMes++;
    }
  } else {
    while (indiceAnio <= ultimoAnio) {
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
  }
  dataMatchPorMes.map((elemento) => {
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

  var options = {
    series: [
      {
        name: "Cantidad de matcheos",
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
            filename: "Matcheos por mes",
            columnDelimiter: ";",
            headerCategory: "Meses",
            headerValue: "value",
            dateFormatter(timestamp) {
              return new Date(timestamp).toDateString();
            },
          },
          svg: {
            filename: "Matcheos por mes",
          },
          png: {
            filename: "Matcheos por mes",
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
        text: "Matcheos",
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

  graficoMatchPorMes = new ApexCharts(
    document.querySelector("#graficoMatchPorMes"),
    options
  );
  graficoMatchPorMes.render();
};

const cargarGraficoRegistrosPorRolPorMes = async() => {
  if (graficoRegistrosPorRolPorMes) {
    graficoRegistrosPorRolPorMes.destroy();
  }

  await $.ajax({
    type: "GET",
    url: BASE_URL + "estadisticas/getRegistrosPorRolPorMes",
    dataType: "JSON",
    data: { fecha_desde: fechaDesde, fecha_hasta: fechaHasta },
    success: function (resp) {
      dataRegistrosPorRolPorMes = resp.data;
    },
  });

  console.log(dataRegistrosPorRolPorMes);

  let mesesLabel = [];

  let mesesData = [];

  const primerAnio = parseInt(dataRegistrosPorRolPorMes[0].anio_mes.slice(0, 4));
  const ultimoAnio = parseInt(
    dataRegistrosPorRolPorMes[dataRegistrosPorRolPorMes.length - 1].anio_mes.slice(0, 4)
  );

  const primerMes = parseInt(dataRegistrosPorRolPorMes[0].anio_mes.slice(4));
  const ultimoMes = parseInt(
    dataRegistrosPorRolPorMes[dataRegistrosPorRolPorMes.length - 1].anio_mes.slice(4)
  );

  let indiceAnio = primerAnio;
  if (primerAnio == ultimoAnio) {
    let indiceMes = 0;
    let indiceUltimoMes = ultimoMes - 1;
    while (indiceMes <= indiceUltimoMes) {
      mesesLabel.push(`${meses[indiceMes]}-${indiceAnio}`);
      mesesData.push(0);
      indiceMes++;
    }
  } else {
    while (indiceAnio <= ultimoAnio) {
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
  }
  dataRegistrosPorRolPorMes.map((elemento) => {
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

  var options = {
    series: [
      {
        name: "Cantidad de Registros por roles",
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
            filename: "Registros por roles por mes",
            columnDelimiter: ";",
            headerCategory: "Meses",
            headerValue: "value",
            dateFormatter(timestamp) {
              return new Date(timestamp).toDateString();
            },
          },
          svg: {
            filename: "Registros por roles por mes",
          },
          png: {
            filename: "Registros por roles por mes",
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
        text: "Registros por roles",
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

  graficoRegistrosPorRolPorMes = new ApexCharts(
    document.querySelector("#graficoRegistrosPorRolPorMes"),
    options
  );
  graficoRegistrosPorRolPorMes.render();
};

const escucharBotonesCargarGrafico = () => {
  $(".botonCargarGrafico").on("click", (element) => {
    fechaDesde = $(`#fechaDesde${element.target.dataset.grafico}`).val()
      ? $(`#fechaDesde${element.target.dataset.grafico}`).val()
      : false;

    fechaHasta = $(`#fechaHasta${element.target.dataset.grafico}`).val()
      ? $(`#fechaHasta${element.target.dataset.grafico}`).val()
      : false;
console.log(fechaDesde);
console.log(fechaHasta);

    eval("cargarGrafico" + element.target.dataset.grafico + "()");
  });
};
