<?php echo $header;?>
<!--/Header-->
<!--Body-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
        <div class="col-lg-12">
          <h1 class="page-header">Reporte MO Campa&ntilde;as</h1>
          <div class="clearfix"></div>
          <div class="list-group">
            <strong class="list-group-item list-group-item-success" style="color: ;">Para el reporte de todos los mensajes, no debe seleccionar ninguna campa&ntilde;a, solo la fecha de inicio y la fecha final para el reporte.</strong>
          </div>
        </div>
        <div class="x_content">
          <div class="panel panel-default">
            <form role="form" id="buscarMO" method="POST">
              <div class="form-group">
                <div class="col-md-12 col col-sm-12">
                  <div class="list-group">
                    <strong class="list-group-item list-group-item-success" style="color: white; background:#81A6CC !important">Selecciona la campaña:</strong>
                    <select class="form-control select2_single" onChange="actualizarDataTableMO()" id="id_campania" name="id_campania">
                      <option value="" disabled selected></option>
                        <?php echo $select; ?>
                    </select>
                  </div>
                  <div class="list-group" >
                    <!-- Primer Calendario-->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <strong class="list-group-item list-group-item-success" style="color:#696969; background:#81A6CC !important"><span style="color: white;">Fecha Inicial:</span>
                        <fieldset class="form-group" style="border: hidden;">
                            <div class="control-group">
                              <div class="controls">
                                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left" placeholder="Fecha inicial" id='datetimepicker' name="datetimepicker" aria-describedby="inputSuccess2Status2" required>
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                  <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                                </div>
                              </div>
                            </div>
                        </fieldset>
                        <p class="help-block" style="color: white;">Fecha inicial, apartir de la cual se va a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                        </strong>
                    </div>
                    <!-- Segundo Calendario-->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <strong class="list-group-item list-group-item-success" style="color:#696969; background:#81A6CC !important"><span style="color: white;">Fecha Final:</span>
                        <fieldset class="form-group" style="border: hidden;">
                            <div class="control-group">
                              <div class="controls">
                                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left" placeholder="Fecha final" id='datetimepicker1' name="datetimepicker1" aria-describedby="inputSuccess2Status2" required>
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                  <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                                </div>
                              </div>
                            </div>
                        </fieldset>
                        <p class="help-block" style="color: white;">Fecha final, es la fecha límite con la que se van a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                      </strong>
                    </div>
                  </div>
                  &nbsp;
                  <div class="list-group">
                    <!-- Parametros de busqueda -->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <strong class="list-group-item list-group-item-success" style="color: white; background:#81A6CC !important">Source:</strong>
                        <input class="form-control" type="text" name="source" id="source" placeholder="525512345678">
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <strong class="list-group-item list-group-item-success" style="color: white; background:#81A6CC !important">Destination:</strong>
                      <select class="form-control select2_single" id="shortcode" name="shortcode">
                        <option value="" disabled selected></option>
                        <?php echo $shortcode; ?>
                      </select>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <strong class="list-group-item list-group-item-success" style="color: white; background:#81A6CC !important">Content:</strong>
                      <input class="form-control" type="text" name="content" id="content" placeholder="content">
                    </div>
                  </div>
                  &nbsp;
                  <div class="list-group col-md-12 col-sm-12 col-xs-12"">
                    <!-- Botones -->
                    <span class="col-md-6 col-sm-6 col-xs-12">
                      <button id="buscarDatos" type="submit" class="btn btn-info btn-block" >Buscar <span class="glyphicon glyphicon-search"></span></button>
                    </span>
                    <span class="col-md-6 col-sm-6 col-xs-12">
                      <button id="descargarExcel" type="button" class="btn btn-success btn-block">Descargar Detalle <span class="glyphicon glyphicon-download-alt"></span></button>
                    </span>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="x_content">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading"><h4 style="color: #73879C">Reportes MO</h4></div>
              <div class="panel-body">
                <div class="datable_wrappaTer">
                  <table class="table table-striped table-bordered table-hover" id="reporte_mo">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Keyword</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
