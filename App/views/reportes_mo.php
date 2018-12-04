<?php echo $header;?>
<!--/Header-->
<!--Body-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
        <div class="col-lg-12">
          <h1 class="page-header">Reporte MO Campa&ntilde;as</h1>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <label class="col-md-12 control-label">Selecciona la campaña de la que deseas generar el reporte. </label>
          <br><br>
          <form role="form" id="mt" method="POST" action="/Reportes/reporte_mo">
            <div class="form-group" id="shorcode">
              <label class="col-md-2 control-label">Campaña:  </label>
              <br>
              <div class="col-md-12 col col-sm-12">
                    <div>
                      <select class="form-control" onChange="actualizarDataTableMO()" id="id_campania" name="reporte">
                        <option value="" disabled selected>Campaña -- Short Code</option>
                          <?php echo $select; ?>
                      </select>
                    </div>

                    <!-- <div id="shorcode" >
                      <div class="col-md-12">
                        <div align="center">
                          <br>
                          <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Descargar Detalle</button>
                          </span>
                        </div>
                      </div>
                    </div> -->


                    <div class="form-group col-md-6 col-sm-6 col-xs-12 col-md-12" id="shorcode">
                      <br>
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Descargar Detalle</button>
                      </span>
                    </div>

                 <div class="col-md-6">
                    <div align="center">
                      <br>
                      <span class="input-group-btn">
                        <!-- <input type="button" class="btn btn-success" value="Consultar por Campa&ntilde;a y Fecha" onclick="muestraCalendario()"> -->
                      </span>
                      <span class="input-group-btn">
                        <!-- <input type="button" class="btn btn-success" value="Consultar por Fecha" onclick="muestraCalendario2()"> -->
                      </span>
                    </div>
                  </div>
              </div>
            </div>
          </form>
            <br>

            <div class="row" id="calendario" style="display:none;">
              <form role="form" id="modetalle" method="POST" action="/Reportes/reporte_moDetalle">
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
                      <br><br><br>
                    </div>

                    <!-- Primer Calendario-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <fieldset>
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
                      <br>
                      <p class="help-block">Fecha inicial, apartir de la cual se va a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                    </div>

                                  
                    <!-- Segundo Calendario-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <fieldset>
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
                      <br>
                      <p class="help-block">Fecha final, es la fecha límite con la que se van a consultar las respuestas que han mandado.<span id="fecha_sistema"></span></p>
                      <br>
                    </div>
                    
                    <!--Boton enviar-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <div class="form-group row">
                        <div class="col-md-6">
                          <input type="button" onclick="actualizarDataTableCampaniaFechaMO()" value="Consultar" class="btn btn-info" id="Consultar">
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
                <br><br><br>
              </form>
              
            </div>

            <div class="row" id="calendario2" style="display:none;">
              <form role="form" id="modetallefechas" method="POST" action="/Reportes/reporte_moDetalleFechas">
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
                      <br><br>
                    </div>
                    
                    <!--Boton enviar-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <div class="form-group row">
                        <div class="col-md-6">
                          <input type="button" onclick="actualizarDataTableFechaMO()" value="Consultar" class="btn btn-info" id="Consultar">
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
                <br><br><br>
              </form>
            </div>
            <!-- <div class="row" id="total" style="display:none;"><div> -->
        </div>
      </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading">&nbsp;</div>
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

<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
