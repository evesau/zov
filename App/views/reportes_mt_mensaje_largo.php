<?php echo $header;?>
<!--/Header-->
<!--Body-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
        <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h1 class="page-header">Reporte MT de Mensaje Largo</h1>
          <div class="clearfix"></div>


            <div class="list-group">
              <strong class="list-group-item list-group-item-success" style="color: ;">Para el reporte de todas las campa&ntilde;as debe seleccionar la opcion de "Todas las campa&ntilde;as" y seleccionar la fecha de inicio y la fecha final para el reporte.</strong>
              <strong class="list-group-item list-group-item-success" style="color: ;">Selecciona la campaña de la que deseas generar el reporte..</strong>
            </div>


          <form id="formulario_buscador" action="#" method="post">
            <div class="row" id="reportemt">
              <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="x_content">
                  <!-- Reporte MT Principal -->
                  <br><br>
                    <div class="form-group" id="shorcode">
                      <label class="col-md-2 control-label">Campaña:  </label>
                      <br>
                      <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div>
                          <select class="form-control" onChange="actualizarDataTable()" id="id_campania" name="reporte">
                            <option value="">Todas las campa&ntilde;as</option>
                              <?php echo $select; ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <div align="center">
                            <br>
                            <span class="input-group-btn">
                              <input type="hidden" name="campanias" id="campanias" value="campanias">
                            </span>
                          </div>
                        </div>
                        <!-- </div> -->
                      </div>
                    </div>

                </div>
                <div class="row" id="calendario" style="display:none;">
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    
                    <!-- Buscador -->
                    <div class="col-xs-8 col-sm-8 col-md-12 col-lg-12" id="buscador">
                      <!-- <div class="col-md-10" role="main">
                        <div class="row top_tiles"> -->
                            <div class="form-group row">
                              <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1">Carrier:</label>
                              <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                <select class="form-control" name="carrier" id="carrier">
                                  <option value="">Todos los carriers</option>
                                  <option value="telcel">Telcel</option>
                                  <option value="att">ATT</option>
                                  <option value="movistar">Movistar</option>
                                  <option value="null">Sin Carrier</option>
                                </select>
                              </div>
                              <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1">Destination:</label>
                              <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                <input class="form-control" id="destination" name="destination" type="text"/>
                              </div>
                              <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1">Source:</label>
                              <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                <input class="form-control" id="source" name="source" type="text"/>
                              </div>
                              <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1">Estatus:</label>
                              <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                <select class="form-control" id="estatus" name="estatus">
                                  <option ></option>
                                  <option value="ACCEPTD">Acceptd</option>
                                  <!--<option value="delivered">Delivered</option>-->
                                  <option value="queued">Queued</option>
                                  <option value="blacklist">Blacklist</option>
                                  <option value="preparado para envio">preparado para envio</option>
                                  <option value="error">Error</option>
                                  <option value="REJECTD">Rejectd</option>
                                </select>
                              </div>
                              
                            </div>
                            
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
                                          <input type="text" class="form-control has-feedback-left" id="datetimepicker4" placeholder="Fecha inicial"  name="datetimepicker4" aria-describedby="inputSuccess2Status2" required>
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
                                          <input type="text" class="form-control has-feedback-left" id="datetimepicker5" placeholder="Fecha final"   name="datetimepicker5" aria-describedby="inputSuccess2Status2" required>
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>

                              </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                              <button onclick="actualizarDataTableSearchReportMT()" style="width: 100%; height: 100%;" type="button" class="btn btn-primary pull-right">
                                <span class="glyphicon glyphicon-search"></span> Buscar
                              </button>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                              <button id="reporte" class="btn btn-success" style="width: 100%; height: 100%;">Descargar Detalle</button>
                            </div>


                          
                    </div>
                    <!-- Fin Buscador -->
                    <div class="clearfix"></div>
                  </div>
                </div><!-- /.col-lg-12 -->
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
                                <th>Carrier</th>
                                <th>Destination</th>
                                <th>Source</th>
                                <th>Content</th>
                                <th>Estatus</th>
                              </tr>
                            </thead>
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
