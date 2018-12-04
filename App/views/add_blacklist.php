<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">

<!-- Primer Columna  -->
            <div class="col-md-2 col-sm-2 col-xs-12"></div>

            <div class="col-md-8 col-sm-8 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>Números Agregados a Blacklist </h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form id="consult_one" class="form-horizontal form-label-left" >
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Archivo exportado: </label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input type="text" class="form-control" name="number" disabled="true" value="<?php echo $name_file; ?>" style="width:600px;">
                        </div>
                      </div>
                    </div>

                    <br>

                    <div class="form-group">
                      <div class="col-sm-12" align="center">
                        <div class="input-group">
                          <?php echo $table; ?>
                        </div>
                      </div>
                    </div>

                    
                  </form>
                </div>
              </div>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12"></div>

<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
