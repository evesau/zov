<?php echo $header;?>
<!--/Header-->
<!--Body-->
        <div class="col-md-2"></div>
        <div class="col-md-10
        " role="main">
          
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i></div>
                  <div class="count"><?php echo $telcel; ?></div>
                  <h3>Telcel</h3>
                  <p>Mensajes enviados en este mes.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i></div>
                  <div class="count"><?php echo $movi; ?></div>
                  <h3>Movistar</h3>
                  <p>Mensajes enviados en este mes.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i></div>
                  <div class="count"><?php echo $att; ?></div>
                  <h3>AT&T</h3>
                  <p>Mensajes enviados en este mes.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12"></div>
            </div>
        </div>

        <!-- Buscador -->
        <div class="row panel-body" id="buscador">
          <!-- <div class="col-md-10" role="main">  
            <div class="row top_tiles"> -->
              <form role="form" id="buscarReportes" method="GET" action="/Reportes/searchDate">
              <div class="form-group row">
              
                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-2">
                  <label>Campa&ntilde;a:</label>
                  <select class="form-control" name="campania" style="width: 100%;">
                    <option value="">Selecciona una Campaña</option>
                    <?php echo $sCampaigns; ?>
                  </select>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-1">
                  <label>Shortcode:</label>
                  <select class="form-control" name="shortcode" style="width: 100%;">
                    <option value="">Selecciona un ShortCode</option>
                    <?php echo $sShortCode; ?>
                  </select>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-3">
                  <label>Fecha Inicial:</label>
                  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 xdisplay_inputx form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="datetimepicker" placeholder="Fecha Inicial"  name="datetimepicker" aria-describedby="inputSuccess2Status2" required>
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-3">
                  <label>Fecha Final:</label>
                  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 xdisplay_inputx form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="datetimepicker1" placeholder="Fecha final"  name="datetimepicker1" aria-describedby="inputSuccess2Status2" required>
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-1">
                  <label>Status:</label>
                  <select class="form-control" name="status" style="width: 100%;">
                    <option value="">Selecciona un Status</option>
                    <?php echo $sStatus; ?>
                  </select>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-1">
                  <label>Direction:</label>
                  <select name="direction" style="width: 100%">
                    <option value=""></option>
                    <option value="envio_mt">MT</option>
                    <option value="envio_mo">MO</option>
                  </select>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-1">
                  <button onclick="actualizarDataTableSearch()" type="button" class="btn btn-primary btn-sm" style="margin:20px 30px 20px auto">
                    <span class="glyphicon glyphicon-search"></span> Search
                  </button>
                </div>
              </div>
              </form>
            <!-- </div>
          </div> -->
        </div>
      <!-- Fin Buscador -->

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                  <div class="panel-heading">&nbsp;</div>
                  <div class="panel-body">
                    <div class="dataTable_wrapper">
                      <table class="table table-striped table-bordered table-hover" id="reportes_admin" name="tabla_reportes_admin">
                        <thead>
                          <tr role="row" >
                            <th>Campaña</th>
                            <th>Tipo de mensaje</th>
                            <th>Delivery date</th>
                            <th>Status</th>
                            <th>Short Code</th>
                            <th>Total de Mensajes Procesados</th>
                          </tr>
                        </thead>
                        <tbody id="reportes_admin">
                          <br>
                          <?php echo $tabla; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->