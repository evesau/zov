<?php echo $header;?>
<!--/Header-->
<!--Body-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
        <div class="col-lg-12">
          <h1 class="page-header"> Generar Reporte MT</h1>
          <div class="clearfix"></div>
            <div class="row" id="reportemt">
              <div class="col-lg-12">  
                <div class="x_content">
                  <!-- Reporte MT Principal -->
                  <label class="col-md-12 control-label">Selecciona la campaña de la que deseas generar el reporte. </label>
                  <br><br>
                  <form role="form" id="mt" method="POST" action="/Reportes/reporte_mt">
                    <div class="form-group" id="shorcode">
                      <label class="col-md-2 control-label">Campaña:  </label>
                      <br>
                      <div class="col-md-12 col col-sm-12">
                        <div>
                          <select class="form-control" onChange="actualizarDataTable()" id="id_campania" name="reporte">
                            <option value="" disabled selected>Campaña -- Short Code</option>
                              <?php echo $select; ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <div align="center">
                            <br>
                            <span class="input-group-btn">
                              <input type="hidden" name="campanias" id="campanias" value="campanias">
                              <button type="submit" class="btn btn-primary">Descargar Detalle</button>
                            </span>
                          </div>
                        </div>
                        <!-- </div> -->
                        <div class="col-md-6">
                          <div align="center">
                            <br>
                            <span class="input-group-btn">
                              <input type="button" class="btn btn-success" value="Consultar por Campa&ntilde;a y Fecha" onclick="muestraCalendario()" id="muestracalendario">
                            </span>
                            <span class="input-group-btn">
                              <input type="button" class="btn btn-success" value="Consultar por Fecha" onclick="muestraCalendario2()" id="muestracalendario2">
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">  
                        </div>
                      </div>
                    </div>
                  
                </div><!-- </div> -->
                <!-- Fin Reporte MT Principal -->
                <!-- Reporte MT Principal Campaña y Fecha -->
                <div class="row" id="calendario" style="display:none;">
                <form role="form" id="mtdetalle" method="GET" action="/Reportes/reporte_mtDetalle">
                  <div class="form-group row">
                    <br><br>
                      <!-- Select -->
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control" id="id_campania_1" name="campania">
                          <option value="" disabled selected>Campaña -- Short Code</option>
                        <?php echo $select; ?>
                        </select>
                        <br><br>
                        <p class="help-block">Selecciona la campaña de la que deseas obtener los reportes. <span id="fecha_sistema"></span></p>
                      </div>
                      <!-- Primer Calendario-->
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <fieldset>
                            <div class="control-group">
                              <div class="controls">
                                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left" id="datetimepicker" placeholder="Fecha inicial"  name="datetimepicker" aria-describedby="inputSuccess2Status2" required>
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                              </div>
                            </div>
                        </fieldset>
                        <br>
                        <p class="help-block">Fecha inicial, apartir de la cual se va a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                      </div>                                   
                      <!-- Segundo Calendario-->
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <fieldset>
                            <div class="control-group">
                              <div class="controls">
                                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left" id="datetimepicker1" placeholder="Fecha final"  name="datetimepicker1" aria-describedby="inputSuccess2Status2" required>
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                              </div>
                            </div>
                        </fieldset>
                        <br>
                        <p class="help-block">Fecha final, es la fecha límite con la que se van a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                      </div>
                      
                      <!--Boton enviar-->
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <input type="button" onclick="actualizarDataTableCampaniaFecha()" value="Consultar" class="btn btn-info" id="Consultar">
                            <br><br>
                            <p class="help-block" align="justify">Para hacer las consultas, es necesario que ningun campo esté vacío. <span id="fecha_sistema"></span></p>
                          </div>
                          <div class="col-md-6">
                            <input type="button" onclick="ocultaInfo()" value="Ocultar" class="btn btn-secondary">
                            <br><br>
                            <p class="help-block"> <span id="fecha_sistema"></span></p>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <input type="text" name="muestra1" id="muestra1" value="cambiar" readonly="true" >
                          <!--label type="text" name="muestra1" id="muestra1" value="cambiar"></label-->
                          <div align="center">
                            <br>
                            <span class="input-group-btn">                              
                              <button type="submit" class="btn btn-primary">Descargar Detalle</button>
                            </span>
                          </div>
                        </div>
                      </div>
                  </div>
                
                </div>
                <!-- Fin Reporte MT Principal Campaña y Fecha -->
                <!-- Reporte MT Principal Fecha -->
                <div class="row" id="calendario2" style="display:none;">
                <form role="form" id="mtdetallefechas" method="GET" action="/Reportes/reporte_mtDetalleFechas">
                  <div class="form-group row">
                      <br><br>
                      <!-- Primer Calendario-->
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <fieldset>
                            <div class="control-group">
                              <div class="controls">
                                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left" id="datetimepicker2" placeholder="Fecha inicial"  name="datetimepicker2" aria-describedby="inputSuccess2Status2" required>
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                  <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                                </div>
                              </div>
                            </div>
                        </fieldset>
                        <br>
                        <p class="help-block">Fecha inicial, apartir de la cual se va a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                      </div>             
                      <!-- Segundo Calendario-->
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <fieldset>
                            <div class="control-group">
                              <div class="controls">
                                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left" id="datetimepicker3" placeholder="Fecha final"  name="datetimepicker3" aria-describedby="inputSuccess2Status2" required>
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                  <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                                </div>
                              </div>
                            </div>
                        </fieldset>
                        <br>
                        <p class="help-block">Fecha final, es la fecha límite con la que se van a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                      </div>
                      <!--Boton enviar-->
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <input type="hidden" name="fechas" id="fechas" value="fechas">
                            <input type="button" onclick="actualizarDataTableFecha()" value="Consultar" class="btn btn-info" id="Consultar">
                            <br><br>
                            <p class="help-block" align="justify">Para hacer las consultas, es necesario que ningun campo esté vacío. <span id="fecha_sistema"></span></p>
                            
                          </div>
                                              
                          <div class="col-md-6">
                            <input type="button" onclick="ocultaInfo()" value="Ocultar" class="btn btn-secondary">
                            <br><br>
                            <p class="help-block"> <span id="fecha_sistema"></span></p>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <input type="text" name="muestra2" id="muestra2" value="cambiar" readonly="true">
                          <!--label name="muestra2" id="muestra2" value="cambiar"></label-->
                          <div align="center">
                            <br>
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-primary">Descargar Detalle</button>
                            </span>
                          </div>
                        </div>
                      </div>
                  </div>
                
                </div> 
                <!-- Fin Reporte MT Principal Fecha -->
                <!-- DataTable -->
                <div class="row">
                  <div class="col-lg-12">
                    <h2  class="page-header"> Reporte MT</h2>
                    <!-- Buscador -->
                    <div class="row" id="buscador">
                      <!-- <div class="col-md-10" role="main">  
                        <div class="row top_tiles"> -->
                          <form role="form" id="buscarReportes" method="GET" action="/Reportes/searchDateReportMT">
                          <div class="form-group row">
                          <table border="0" style="width: 75%" align="center">
                            <tr>
                              <!-- Calendario Fecha Inicial-->
                              <!--
                              <td align="right" valign="middle" style="width: 10%"><b>Fecha Inicial:</b></td> 
                              <td valign="middle" align="right" style="width: 5%">
                                <div class="col-md-3 col-sm-3 col-xs-12" style="width: 105%">
                                  <fieldset>
                                    <div class="control-group">
                                      <div class="controls">
                                        <div class="col-md-11 xdisplay_inputx form-group has-feedback" style="width: 100%">
                                          <input type="text" class="form-control has-feedback-left" id="datetimepicker4" placeholder="Fecha inicial"  name="datetimepicker4" aria-describedby="inputSuccess2Status2" required>
                                          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>
                                </div>                                   
                              </td>
                              -->
                            <!-- Segundo Calendario Fecha Final -->
                              <!--
                              <td align="right" valign="middle" style="width: 10%"><b>Fecha Final:</b></td>
                              <td valign="middle" align="right" style="width: 5%">
                                <div class="col-md-3 col-sm-3 col-xs-12" style="width: 105%" >
                                  <fieldset>
                                    <div class="control-group">
                                      <div class="controls">
                                        <div class="col-md-11 xdisplay_inputx form-group has-feedback" style="width: 100%">
                                          <input type="text" class="form-control has-feedback-left" id="datetimepicker5" placeholder="Fecha final"  name="datetimepicker5" aria-describedby="inputSuccess2Status2" required>
                                          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>
                                </div>
                              </td>
                              -->
                              <td align="right" valign="middle"><b>Carrier:</b></td>
                              <td valign="middle" align="center" style="width: 5%">
                                <div class="col-md-3 col-sm-3 col-xs-12" style="width: 50%">
                                  <fieldset>
                                    <div class="control-group">
                                      <div class="controls">
                                        <input id="carrier" name="carrier" type="text"/>
                                      </div>
                                    </div>
                                  </fieldset>
                                </div>
                              </td>
                            <!-- </tr>
                            <tr> -->
                              <td align="right" valign="middle"><b>Destination:</b></td> 
                              <td valign="middle" align="center">
                                <div class="col-md-3 col-sm-3 col-xs-12" style="width: 70%">
                                  <fieldset>
                                    <div class="control-group">
                                      <div class="controls">
                                        <input id="destination" name="destination" type="text"/>
                                      </div>
                                    </div>
                                  </fieldset>
                                </div>
                              </td>
                              <td align="right" valign="middle"><b>Source:</b></td>
                              <td valign="middle" align="center">
                                <div class="col-md-3 col-sm-3 col-xs-12" style="width: 70%">
                                  <fieldset>
                                    <div class="control-group">
                                      <div class="controls">
                                        <input id="source" name="source" type="text"/>
                                      </div>
                                    </div>
                                  </fieldset>
                                </div>
                              </td>
                              <td align="right" valign="middle"><b>Estatus:</b></td>
                              <td valign="middle" align="center">  
                                <select id="estatus" name="estatus">
                                  <option ></option>
                                  <option value="queued">Queued</option>
                                  <option value="delivered">Delivered</option>
                                  <option value="blacklist">Blacklist</option>
                                  <option value="preparado para envio">preparado para envio</option>
                                  <!--option value="failed">failed</option-->
                                  <option value="error">Error</option>
                                  <!--option value="received">received</option-->
                                  <!--option value="received_error_endpoint">received_error_endpoint</option-->
                                  <!--option value="received_error_parse">received_error_parse</option-->
                                </select>
                              </td>
                              <td valign="middle" align="center">
                                <!--<input onclick="" type="button" class="btn btn-primary" value="Buscar" id="Buscar" style="color:White"/>
                                <i class="glyphicon glyphicon-search " style="color:Black;" ></i>-->
                                <button onclick="actualizarDataTableSearchReportMT()" type="button" class="btn btn-primary">
                                  <span class="glyphicon glyphicon-search"></span> Search
                                </button>
                              </td> 
                            </tr>
                          </table>
                          </div>
                          </form>
                          </form>
                          </form>
                          </form>
                        <!-- </div>
                      </div> -->
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
        </div><!-- /.col-lg-12 a -->
      </div><!-- x_panel tile fixed_height_240 -->
    </div><!-- col-md-12 col-sm-12 col-xs-12 -->
  </div><!-- row a -->
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->