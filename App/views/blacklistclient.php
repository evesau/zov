<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
  <!-- Primer Columna  -->
  <!-- Segunda Columna  -->
            <!-- <div class="col-md-4 col-sm-4 col-xs-12"> -->
            <?php echo $tamanio_div;?>
              <div class="x_panel tile fixed_height_520 overflow_hidden">
                <div class="x_title">
                  <h2>Consulta Varios Números</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <p class="text-info" align="center">Ingrese, números a 10 dígitos y separelos con <strong>'coma (,)',</strong> <strong>'enter'</strong> o <strong>'tab'</strong></p>
                  <form id="consult_multi">
                    <div class="control-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Ingresa los números a consultar: </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="tags_1" type="text" class="tags form-control" name="numbers" />
                        <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                      </div>
                    </div>

                    <div class="row" align="center">
                      <div class="col-sm-12">
                        <label class="radio-inline"><input type="radio" name="carrier_multi" value="telcel" checked="checked">Telcel</label>
                        <label class="radio-inline"><input type="radio" name="carrier_multi" value="movistar">Movistar</label>
                        <label class="radio-inline"><input type="radio" name="carrier_multi" value="att">AT&T</label>
                      </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="button" class="btn btn-success pull-right" onclick="blacklist()">Buscar <i class="fa fa-search"></i></button>
                      </div>
                    </div>
                    <div id="message" class="text-danger" align="center"></div>
                  </form>
                </div>
              </div>
            </div>
<!-- Tercer Columna  -->
            <?php echo $tercer_columna;?>
          </div>
          
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
