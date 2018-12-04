<?php echo $header;?>
<!--/Header-->
<!--Body-->
  <div class="row">
            
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
        <div class="x_title">
          <h1 class="page-header">Generar Reporte Sms Push</h1>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <label class="col-md-12 control-label">Selecciona las fechas de las que deseas generar el reporte. </label>
          <br><br>
          <form role="form" id="servicios" method="POST" action="">
            <div class="form-group" id="shortcode">
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
                      <br>
                    </div>                  
                    <!--Boton enviar-->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <div class="form-group row">
                        <div class="col-md-6">
                          <input type="button" onclick="" value="Consultar" id="Consultar" class="btn btn-info">
                          <br><br>
                          <p class="help-block" align="justify">Para hacer las consultas, es necesario que ningun campo esté vacío. <span id="fecha_sistema"></span></p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div align="center">
                          <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Descargar Detalle</button>
                          </span>
                        </div>
                      </div>
                    </div>
            </div>
          </form>
            </div>
          </div>
        </div>
      </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading">&nbsp;</div>
              <div class="panel-body">
                <div class="dataTable_wrapper">
                  <table class="table table-striped table-bordered table-hover" id="reporte_smspush">
                    <thead>
                      <tr>
                        <th>T&iacute;tulo</th>
                        <th>Mensaje</th>
                        <th>Tipo</th>
                        <th>Total de Mensajes Procesados</th>
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
