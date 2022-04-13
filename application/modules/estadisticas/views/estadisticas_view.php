<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-lg-none">
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Estadísticas</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 d-flex align-items-stretch">

                <div class="card card-stats">
                    <div class="card-header">
                        <h4 class="card-title text-left">
                            <span class="font-weight-bold">
                                Desafíos por mes
                            </span>
                        </h4>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <input type="date" id="fechaDesdeDesafiosPorMes" class="form-control form-control-sm inputFechaDesde" max="<?php echo date('Y-m-d',time());?>">
                            </div>
                            <div class="col-4">
                                <input type="date" id="fechaHastaDesafiosPorMes" class="form-control form-control-sm inputFechaHasta">
                            </div>
                            <div class="col-4 text-center">
                                <button class="btn btn-sm btn-primary botonCargarGrafico" data-grafico="DesafiosPorMes">Cargar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="ct-chart ct-double-octave" id="graficosDesafiosPorMes"></div>
                    </div>
                </div>

            </div>
            <div class="col-md-6 d-flex align-items-stretch">

                <div class="card card-stats">
                    <div class="card-header">
                        <h4 class="card-title text-left">
                            <span class="font-weight-bold">
                                Postulaciones por mes
                            </span>
                        </h4>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <input type="date" id="fechaDesdePostulacionesPorMes" class="form-control form-control-sm inputFechaDesde" max="<?php echo date('Y-m-d',time());?>">
                            </div>
                            <div class="col-4">
                                <input type="date" id="fechaHastaPostulacionesPorMes" class="form-control form-control-sm inputFechaHasta">
                            </div>
                            <div class="col-4 text-center">
                                <button class="btn btn-sm btn-primary botonCargarGrafico" data-grafico="PostulacionesPorMes">Cargar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="ct-chart ct-double-octave" id="graficoPostulacionesPorMes"></div>
                    </div>
                </div>

            </div>
            <div class="col-md-6 d-flex align-items-stretch">

                <div class="card card-stats">
                    <div class="card-header">
                        <h4 class="card-title text-left">
                            <span class="font-weight-bold">
                                Matcheos por mes
                            </span>
                        </h4>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <input type="date" id="fechaDesdeMatchPorMes" class="form-control form-control-sm inputFechaDesde" max="<?php echo date('Y-m-d',time());?>">
                            </div>
                            <div class="col-4">
                                <input type="date" id="fechaHastaMatchPorMes" class="form-control form-control-sm inputFechaHasta">
                            </div>
                            <div class="col-4 text-center">
                                <button class="btn btn-sm btn-primary botonCargarGrafico" data-grafico="MatchPorMes">Cargar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="ct-chart ct-double-octave" id="graficoMatchPorMes"></div>
                    </div>
                </div>

            </div>
            <!-- <div class="col-md-6 d-flex align-items-stretch">

                <div class="card card-stats">
                    <div class="card-header">
                        <h4 class="card-title text-left">
                            <span class="font-weight-bold">
                                Registros por rol por mes
                            </span>
                        </h4>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <input type="date" id="fechaDesdeRegistrosPorRolPorMes" class="form-control form-control-sm inputFechaDesde" max="<?php echo date('Y-m-d',time());?>">
                            </div>
                            <div class="col-4">
                                <input type="date" id="fechaHastaRegistrosPorRolPorMes" class="form-control form-control-sm inputFechaHasta">
                            </div>
                            <div class="col-4 text-center">
                                <button class="btn btn-sm btn-primary botonCargarGrafico" data-grafico="RegistrosPorRolPorMes">Cargar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="ct-chart ct-double-octave" id="graficoRegistrosPorRolPorMes"></div>
                    </div>
                </div>

            </div> -->
        </div>
    </div>
</div>