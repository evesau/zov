<?php echo $header;?>
<!--/Header-->
<!--Body-->
  <div class="row">
            
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
        <div class="x_title">
          <br><br>
          <h2> Servicios</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <label class="col-md-12 control-label">Selecciona el servicio del que deseas generar el reporte. </label>
          <br><br>
          <form role="form" id="servicios" method="POST" action="/Reportes/reporte_servicio">
            <div class="form-group" id="shortcode">
              <label class="col-md-2 control-label">Servicio:  </label>
              <br>
              <div class="col-md-12 col col-sm-12">
                <div >
                  <select class="form-control" onChange="actualizarDataTableService()" id="id_campania" name="reporte">
                    <option value="" disabled selected>Servicio</option>
                      <?php echo $select; ?>
                  </select>
                </div>
                  <div class="col-md-6">
                    <div align="center">
                      <br>
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Descargar Detalle</button>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div align="center">
                      <br>
                      <span class="input-group-btn">
                        <input type="button" class="btn btn-success" value="Consultar por Campa&ntilde;a y Fecha" onclick="muestraCalendario()">
                      </span>
                      <span class="input-group-btn">
                        <input type="button" class="btn btn-success" value="Consultar por Fecha" onclick="muestraCalendario2()">
                      </span>
                    </div>
                  </div>
              </div>
            </div>
          </form>
            <br>

            <div class="row" id="calendario" style="display:none;">
              <form role="form" id="servicedetalle" method="GET" action="/Reportes/reporte_serviceDetalle">
                <div class="form-group row">
                    <br><br>
                    <!-- Select -->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <select class="form-control" id="id_campania_1" name="campania">
                        <option value="" disabled selected hidden>Campaña -- Short Code</option>
                      <?php echo $select; ?>
                      </select>
                      <br><br>
                      <p class="help-block">Selecciona la campaña de la que deseas obtener los reportes. <span id="fecha_sistema"></span></p>
                      <br><br><br>
                    </div>

                    <!-- Primer Calendario-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <fieldset>
                          <div class="control-group">
                            <div class="controls">
                              <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="datetimepicker" placeholder="Fecha inicial"  name="datetimepicker" aria-describedby="inputSuccess2Status2">
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
                                <input type="text" class="form-control has-feedback-left" id="datetimepicker1" placeholder="Fecha final"  name="datetimepicker1" aria-describedby="inputSuccess2Status2">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                              </div>
                            </div>
                          </div>
                      </fieldset>
                      <br>
                      <p class="help-block">Fecha final, es la fecha límite con la que se van a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                      <br><br><br>
                    </div>
                    
                    <!--Boton enviar-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <div class="form-group row">
                        <div class="col-md-6">
                          <input type="button" onclick="actualizarDataTableCampaniaFechaServices()" value="Consultar" class="btn btn-info">
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
                        <div align="center">
                          <br>
                          <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Descargar Detalle</button>
                          </span>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-group row">
                  <div id="tabla_" class="text-danger" align="center">
                    
                  </div>
                </div>

              </form>
              <br><br>
            </div>

            <div class="row" id="calendario2" style="display:none;">
              <form role="form" id="servicedetallefechas" method="GET" action="/Reportes/reporte_serviceDetalleFechas">
                <div class="form-group row">
                    <br><br>

                    <!-- Primer Calendario-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <fieldset>
                          <div class="control-group">
                            <div class="controls">
                              <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="datetimepicker2" placeholder="Fecha inicial"  name="datetimepicker2" aria-describedby="inputSuccess2Status2">
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
                                <input type="text" class="form-control has-feedback-left" id="datetimepicker3" placeholder="Fecha final"  name="datetimepicker3" aria-describedby="inputSuccess2Status2">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                              </div>
                            </div>
                          </div>
                      </fieldset>
                      <br>
                      <p class="help-block">Fecha final, es la fecha límite con la que se van a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                      <br><br><br>
                    </div>
                    
                    <!--Boton enviar-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <div class="form-group row">
                        <div class="col-md-6">
                          <input type="button" onclick="actualizarDataTableFechaServices()" value="Consultar" class="btn btn-info">
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
                        <div align="center">
                          <br>
                          <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Descargar Detalle</button>
                          </span>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-group row">
                  <div id="tabla_" class="text-danger" align="center">
                    
                  </div>
                </div>

              </form>
            </div>
            <br><br><br>
        </div>
      </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading">&nbsp;</div>
              <div class="panel-body">
                <div class="dataTable_wrapper">
                  <table class="table table-striped table-bordered table-hover" id="reporte_servicio">
                    <thead>
                      <tr>
                        <th>entry_time</th>
                        <th>source</th>
                        <th>destination</th>
                        <th>direction</th>
                        <th>content</th>
                        <th>status</th>
                        <th>keyword</th>
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

<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
