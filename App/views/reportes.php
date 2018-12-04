<?php echo $header;?>
<!--/Header-->
<!--Body-->
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="x_panel tile fixed_height_240">
          <div class="x_content">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
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
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div>
                  <button id="btnBuscar" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 btn btn-success btn-lg pull-right">Buscar <span class="fa fa-search"></span></button>
                </div>
              </div>
              <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                  <div class="panel-heading">&nbsp;
                  </div>
                  <div class="panel-body">
                    <div class="dataTable_wrapper">
                      <table class="table table-striped table-bordered table-hover" id="reportes">
                        <thead>
                          <tr class="table-dark" >
                            <th>Fecha</th>
                            <th>Destination</th>
                            <th>Source</th>
                            <th>Content</th>
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
    </div>
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->