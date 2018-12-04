<?php echo $header;?>
<!--/Header-->
<!--Body-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
        <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h1 class="page-header">Reporte MT</h1>
          <div class="clearfix"></div>
          <div class="list-group">
            <strong class="list-group-item list-group-item-success" style="color: ;">Para el reporte de todas las campa&ntilde;as debe seleccionar la opcion de "Todas las campa&ntilde;as" y seleccionar la fecha de inicio junto con la fecha final para el reporte.</strong>
          </div>
          <form id="formulario_buscador" action="#" method="post">
            <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="panel panel-default">
                <div class="x_content"></div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Selecciona la campa&ntilde;a</strong>
                          <select class="select2_single col-xs-12 col-sm-12 col-md-12 col-lg-12" onChange="actualizarDataTable()" id="campaign_id" name="campaign_id">
                            <option value="null">Todas las campa&ntilde;as</option>
                            <?php echo $select; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 div_fecha">
                    <div class="list-group">
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
                        <p class="help-block" style="color: white;">Fecha inicial, apartir de la cual se va a consultar los mensajes que se han mandado.<span id="fecha_sistema"></span></p>
                        </strong>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 div_fecha">
                    <div class="list-group">
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
                        <p class="help-block" style="color: white;">Fecha final, es la fecha límite con la que se van a consultar los mensajes que se han mandado.<span id="fecha_sistema"></span></p>
                      </strong>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"-->
                    <div class="form-group">
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Carrier:</strong>
                          <select class="select2_single form-control" name="carrier" id="carrier" disabled="true">
                            <option value="">Todos los carriers</option>
                            <option value="telcel">Telcel</option>
                            <option value="att">ATT</option>
                            <option value="movistar">Movistar</option>
                            <option value="null">Sin Carrier</option>
                          </select>
                        </div>                      
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Destination:</strong>
                          <input class="form-control" id="destination" name="destination" type="text" disabled="true" />
                        </div>
                      </div>
                      <!--div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Source:</strong>
                          <input class="form-control" id="source" name="source" type="text" disabled="true"/>
                        </div>
                      </div-->
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Source:</strong>
                          <select class="select2_single form-control" id="source" name="source">
                            <?php echo $selectSource; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Estatus:</strong>
                          <select class="select2_single form-control" id="estatus" name="estatus" disabled="true">
                            <option value="" >Todos</option>
                            <option value="ACCEPTD">Acceptd</option>
                            <option value="delivered">Delivered</option>
                            <option value="encolado">Queued</option>
                            <option value="blacklist">Blacklist</option>
                            <option value="preparado para envio">preparado para envio</option>
                            <option value="error">Error</option>
                            <option value="REJECTD">Rejectd</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                        <div class="list-group">
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <button onclick="actualizarDataTableSearchReportMT()" style="width: 100%; height: 100%;" type="submit" class="btn btn-primary pull-right">
                              <span class="glyphicon glyphicon-search"></span> Buscar
                            </button>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <button id="reporte" class="btn btn-success" type="button" style="width: 100%; height: 100%;">Descargar Detalle</button>
                          </div>
                        </div>
                      </div>                          
                    </div>
                      <!-- Fin Buscador -->
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="panel panel-default">
                <div class="panel-heading"><h4 style="color: #73879C">Reportes MT</h4></div>
                <div class="panel-body">
                  <div class="dataTable_wrapper">
                    <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <table class="table table-striped table-bordered table-hover" id="reporte_mt">
                        <thead>
                          <tr>
                            <th>Fecha</th>
                            <th>Carrier</th>
                            <th>Destination</th>
                            <th>Source</th>
                            <th>Content</th>
                            <th>Estatus</th>
                            <th>LoteID</th>
                            <th>LoteDetalleId</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <!-- Fin DataTable -->
        </div><!-- /.col-lg-12 a -->
      </div><!-- x_panel tile fixed_height_240 -->
    </div><!-- col-md-12 col-sm-12 col-xs-12 -->
  </div><!-- row a -->
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
