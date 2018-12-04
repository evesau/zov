<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Eliminar Usuario</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" id="form" action="/Menu/deleteUser" method="POST">

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3">Selecciona el usuario: </label>
                        <div class="col-md-10 col-sm-9 col-xs-8">
                          <select class="select2_single form-control" tabindex="-1" id="usuarios" name="usuarios" required="">
                            <option></option>
                            <?php echo $showuser; ?>
                          </select>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn btn-danger">Eliminar</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
            </div>
            </div>
            
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
