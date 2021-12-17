window.addEventListener('load', () => {
        getTotalUsuariosPorRoles();
        getCategoriasTotales();
    });
    const getTotalUsuariosPorRoles = () => {
        $.ajax({
            type: "POST",
            url: BASE_URL + "home/getTotalesPorRoles",
            dataType: "JSON",
            success: function(resp) {
                cargarGraficoPie(resp);
            },
        });
    };

    const getCategoriasTotales = () => {
        $.ajax({
            type: "POST",
            url: BASE_URL + "home/getTotalesCategorias",
            dataType: "JSON",
            success: function(resp) {
                cargarGraficoBar(resp);
            },
        });
    };

    const cargarGraficoPie = (totalDeUsuariosPorRoles) => {
        const total = {
            startups: 0,
            empresas: 0,
            partners: 0,
        }
        for (i = 0; i < totalDeUsuariosPorRoles.length; i++) {
            switch (parseInt(totalDeUsuariosPorRoles[i].rol_id)) {
                case 1:
                    total.startups = parseInt(totalDeUsuariosPorRoles[i].total_de_usuarios_por_roles);
                    break;
                case 2:
                    total.empresas = parseInt(totalDeUsuariosPorRoles[i].total_de_usuarios_por_roles);
                    break;
                case 5:
                    total.partners = parseInt(totalDeUsuariosPorRoles[i].total_de_usuarios_por_roles);
                    break;
            }
        }

        let data = {
            series: [total.startups, total.empresas, total.partners]
        };

        let sum = function(a, b) {
            return a + b
        };

        let j = 0;
        new Chartist.Pie('#tiposDeUsuarios', data, {
            labelInterpolationFnc: function(value) {
                const label = Math.round(value / data.series.reduce(sum) * 100) + '%';
                $(`#porcentaje${j}`).html(`(${value}) ${label}`);
                j++;
                return label;
            }
        });
    }

    const cargarGraficoBar = (categoriasTotales) => {


        let categoriasLabel = [];
        let categoriasDesafiosLabel = [];
        let categoriasStartupsLabel = [];

        for (i = 0; i < categoriasTotales.categorias.length; i++) {
            categoriasLabel.push(categoriasTotales.categorias[i].descripcion);
            categoriasDesafiosLabel.push(parseInt(categoriasTotales.categorias_desafios[i].categorias_total_por_desafios));
            categoriasStartupsLabel.push(parseInt(categoriasTotales.categorias_startups[i].categorias_total_por_startups));
        }

        let data = {
            labels: categoriasLabel,
            series: [
                categoriasDesafiosLabel,
                categoriasStartupsLabel
            ]
        };

        var defaultOptions = {
            low: 0,
            // Options for X-Axis
            axisX: {
                // The offset of the chart drawing area to the border of the container
                offset: 35,
                // Position where labels are placed. Can be set to `start` or `end` where `start` is equivalent to left or top on vertical axis and `end` is equivalent to right or bottom on horizontal axis.
                position: 'end',
                // Allows you to correct label positioning on this axis by positive or negative x and y offset.
                labelOffset: {
                    x: 0,
                    y: 0
                },
                // If labels should be shown or not
                showLabel: true,
                // If the axis grid should be drawn or not
                showGrid: true,
            },
            // Options for Y-Axis
            axisY: {
                // The offset of the chart drawing area to the border of the container
                offset: 20,
                // Position where labels are placed. Can be set to `start` or `end` where `start` is equivalent to left or top on vertical axis and `end` is equivalent to right or bottom on horizontal axis.
                position: 'start',
                // If labels should be shown or not
                showLabel: true,
                // If the axis grid should be drawn or not
                showGrid: true,
                // This value specifies the minimum height in pixel of the scale steps
                scaleMinSpace: 20,
                // Use only integer values (whole numbers) for the scale steps
                onlyInteger: true
            },
            // Unless low/high are explicitly set, bar chart will be centered at zero by default. Set referenceValue to null to auto scale.
            referenceValue: 5,
            // Padding of the chart drawing area to the container element and labels as a number or padding object {top: 5, right: 5, bottom: 5, left: 5}
            chartPadding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            },
            // Specify the distance in pixel of bars in a group
            // seriesBarDistance: 15,
            
        };

        new Chartist.Bar('#categoriasSeleccionadas', data, defaultOptions);
    }