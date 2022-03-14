window.addEventListener("load", () => {
  getTotalUsuariosPorRoles();
  getCategoriasTotales();
});

const listenDescargarGraficoTotalDeUsuarios = () => {
  $("#export").on("click", function () {
    html2canvas(document.querySelector("#tiposDeUsuarios")).then((canvas) => {
      var url = canvas.toDataURL();
      $("<a>", {
        href: url,
        download: "tipos_de_usuarios.png",
      })
        .on("click", function () {
          $(this).remove();
        })
        .appendTo("body")[0]
        .click();
    });
  });
};

const getTotalUsuariosPorRoles = () => {
  $.ajax({
    type: "POST",
    url: BASE_URL + "home/getTotalesPorRoles",
    dataType: "JSON",
    success: function (resp) {
      cargarGraficoPie(resp);
    },
  });
};

const getCategoriasTotales = () => {
  $.ajax({
    type: "POST",
    url: BASE_URL + "home/getTotalesCategorias",
    dataType: "JSON",
    success: function (resp) {
      cargarGraficoBar(resp);
    },
  });
};

const cargarGraficoPie = (totalDeUsuariosPorRoles) => {
  let totalDeUsuarios = 0;
  const total = {
    Startups: 0,
    Empresas: 0,
    Partners: 0,
  };
  const labels = ["Startups", "Empresas", "Partners"];
  for (i = 0; i < totalDeUsuariosPorRoles.length; i++) {
    totalDeUsuarios =
      totalDeUsuarios +
      parseInt(totalDeUsuariosPorRoles[i].total_de_usuarios_por_roles);
    switch (parseInt(totalDeUsuariosPorRoles[i].rol_id)) {
      case 1:
        total.Startups = parseInt(
          totalDeUsuariosPorRoles[i].total_de_usuarios_por_roles
        );
        break;
      case 2:
        total.Empresas = parseInt(
          totalDeUsuariosPorRoles[i].total_de_usuarios_por_roles
        );
        break;
      case 5:
        total.Partners = parseInt(
          totalDeUsuariosPorRoles[i].total_de_usuarios_por_roles
        );
        break;
    }
  }
  const tablaUsuariosRegistrados = document.getElementById(
    "tabla_usuarios_registrados"
  );
  const tbodyTablaUsuariosRegistrados =
    tablaUsuariosRegistrados.getElementsByTagName("tbody")[0];
  const tfootTablaUsuariosRegistrados =
    tablaUsuariosRegistrados.getElementsByTagName("tfoot")[0];
  const trTfootTablaUsuariosRegistrados =
    tfootTablaUsuariosRegistrados.getElementsByTagName("tr")[0];
  labels.forEach((label) => {
    const etiquetaTr = document.createElement("tr");
    const etiquetaTdTipoDeUsuario = document.createElement("td");
    const etiquetaTdCantidadTipoDeUsuario = document.createElement("td");

    etiquetaTdTipoDeUsuario.innerHTML = label;
    etiquetaTdCantidadTipoDeUsuario.innerHTML = total[label];

    etiquetaTr.appendChild(etiquetaTdTipoDeUsuario);
    etiquetaTr.appendChild(etiquetaTdCantidadTipoDeUsuario);
    tbodyTablaUsuariosRegistrados.appendChild(etiquetaTr);
  });
  const etiquetaThTotalDeUsuarios = document.createElement("th");
  etiquetaThTotalDeUsuarios.innerHTML = totalDeUsuarios;
  trTfootTablaUsuariosRegistrados.appendChild(etiquetaThTotalDeUsuarios);

  var options = {
    chart: {
      type: "pie",
    },
    toolbar: {
      show: true,
      offsetX: 0,
      offsetY: 0,
      tools: {
        download: true,
        selection: true,
        zoom: true,
        zoomin: true,
        zoomout: true,
        pan: true,
        reset: true | '<img src="/static/icons/reset.png" width="20">',
        customIcons: [],
      },
      export: {
        csv: {
          filename: undefined,
          columnDelimiter: ",",
          headerCategory: "category",
          headerValue: "value",
          dateFormatter(timestamp) {
            return new Date(timestamp).toDateString();
          },
        },
        svg: {
          filename: undefined,
        },
        png: {
          filename: undefined,
        },
      },
      autoSelected: "zoom",
    },
    series: [total.Startups, total.Empresas, total.Partners],
    labels: labels,
    colors: ["#00bcd4", "#f44336", "#ff9800"],
    legend: {
      show: true,
      position: "bottom",
      horizontalAlign: "center",
      offsetX: 0,
      offsetY: 0,
      markers: {
        width: 12,
        height: 12,
        strokeWidth: 0,
        strokeColor: "#fff",
        fillColors: undefined,
        radius: 12,
        customHTML: undefined,
        onClick: undefined,
        offsetX: 0,
        offsetY: 0,
      },
      itemMargin: {
        horizontal: 5,
        vertical: 0,
      },
      onItemClick: {
        toggleDataSeries: true,
      },
      onItemHover: {
        highlightDataSeries: true,
      },
    },
    dataLabels: {
      enabled: true,
      enabledOnSeries: undefined,
      formatter: function (val) {
        return val.toFixed(2) + "%";
      },
      textAnchor: "middle",
      distributed: false,
      offsetX: 0,
      offsetY: 0,
      style: {
        fontSize: "14px",
        fontFamily: "Helvetica, Arial, sans-serif",
        fontWeight: "bold",
        colors: undefined,
      },
      background: {
        enabled: true,
        foreColor: "#fff",
        padding: 4,
        borderRadius: 2,
        borderWidth: 1,
        borderColor: "#fff",
        opacity: 0.9,
        dropShadow: {
          enabled: false,
          top: 1,
          left: 1,
          blur: 1,
          color: "#000",
          opacity: 0.45,
        },
      },
      dropShadow: {
        enabled: false,
        top: 1,
        left: 1,
        blur: 1,
        color: "#000",
        opacity: 0.45,
      },
    },
  };

  var chart = new ApexCharts(
    document.querySelector("#tiposDeUsuarios"),
    options
  );

  chart.render();
  listenDescargarGraficoTotalDeUsuarios();
};

const cargarGraficoBar = (categoriasTotales) => {
  let categoriasLabel = [];
  let categoriasDesafiosLabel = [];
  let categoriasStartupsLabel = [];

  for (i = 0; i < categoriasTotales.categorias.length; i++) {
    categoriasLabel.push(categoriasTotales.categorias[i].descripcion);
    categoriasDesafiosLabel.push(
      parseInt(
        categoriasTotales.categorias_desafios[i].categorias_total_por_desafios
      )
    );
    categoriasStartupsLabel.push(
      parseInt(
        categoriasTotales.categorias_startups[i].categorias_total_por_startups
      )
    );
  }
  var options = {
    series: [
      {
        name: "Desafíos",
        data: categoriasDesafiosLabel,
      },
      {
        name: "Startups",
        data: categoriasStartupsLabel,
      },
    ],
    chart: {
      type: "bar",
      height: 250,
      toolbar: {
        show: true,
        offsetX: 0,
        offsetY: 0,
        tools: {
          download: true,
        },
        export: {
          csv: {
            filename:
              "Cantidad de Desafíos y Startups discriminados por categorias",
            columnDelimiter: ";",
            headerCategory: "Categorias",
            headerValue: "value",
            dateFormatter(timestamp) {
              return new Date(timestamp).toDateString();
            },
          },
          svg: {
            filename: "Cantidad de Desafíos y Startups discriminados por categorias",
          },
          png: {
            filename: "Cantidad de Desafíos y Startups discriminados por categorias",
          },
        },
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "55%",
        endingShape: "rounded",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      colors: ["transparent"],
    },
    xaxis: {
      categories: categoriasLabel,
    },
    yaxis: {
      title: {
        text: "Cantidad",
      },
    },
    fill: {
      opacity: 1,
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val;
        },
      },
    },
    colors: ["#f44336", "#00bcd4"],
  };

  var chart = new ApexCharts(
    document.querySelector("#categoriasSeleccionadas"),
    options
  );
  chart.render();
};
