<!-- Header -->
<?php echo $header;?>
<!-- /Header -->
<!-- Body -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="x_panel tile fixed_height_240">
            <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="page-header">Reporte MT Clicks</h1>
                <div class="clearfix"></div>
                <form id="formulario_buscador" action="/Reportesclicks" method="post">
                    <div class="row" id="reporteurl">
                        <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="x_content"></div>
                            <div class="row" id="calendario" style="display:none;"></div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Buscador -->
                                    <div class="col-xs-8 col-sm-8 col-md-12 col-lg-12" id="buscador">
                                        <div class="form-group row" style="margin: 2%;">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 div_fecha">
                                                <fieldset>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 xdisplay_inputx form-group has-feedback" style="width: 20%">
                                                                <label class="">Fecha Inicial: </label>
                                                            </div>
                                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 xdisplay_inputx form-group has-feedback" style="width: 80%">
                                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                                <input type="text" class="form-control has-feedback-left" id="datetimepicker4" placeholder="Fecha inicial"  name="datetimepicker4" aria-describedby="inputSuccess2Status2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 div_fecha">
                                                <fieldset>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 xdisplay_inputx form-group has-feedback" style="width: 20%">
                                                                <label class="">Fecha Final: </label>
                                                            </div>
                                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 xdisplay_inputx form-group has-feedback" style="width: 80%">
                                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                                <input type="text" class="form-control has-feedback-left" id="datetimepicker5" placeholder="Fecha final"   name="datetimepicker5" aria-describedby="inputSuccess2Status2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <button onclick="actualizarDataTableSearchReportMT()" type="submit" style="width: 100%; height: 100%;" type="button" class="btn btn-primary pull-right">
                                                <span class="glyphicon glyphicon-search"></span> Buscar
                                            </button>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <button type="button" id="reporte" class="btn btn-success" style="width: 100%; height: 100%;">Descargar Detalle</button>
                                        </div>
                                    </div>
                                    <!-- Fin Buscador -->
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">&nbsp;</div>
                                        <div class="panel-body">
                                            <div class="dataTable_wrapper">
                                                <table class="table table-striped table-bordered table-hover" id="reporte_mt">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Campa&ntilde;a</th>
                                                            <th>ShortCode</th>
                                                            <th>Total de enviados</th>
                                                            <th>Total Clicks</th>
                                                            <th>Ver Detalle</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php echo $tabla; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin DataTable -->
                        </div><!-- /.col-lg-12 b -->
                    </div><!-- row b-->
                </form>
            </div><!-- /.col-lg-12 a -->
        </div><!-- x_panel tile fixed_height_240 -->
    </div><!-- col-md-12 col-sm-12 col-xs-12 -->
</div><!-- row a -->
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
