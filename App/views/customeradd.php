<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Añadir Customer <small>Todos los campos son obligatorios</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form  id="add" class="form-horizontal form-label-left input_mask" enctype="multipart/form-data" action="/Customer/addCustomer" method="POST">
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nickname</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="customer" id="customer">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">MT Máximos al día</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="number" class="form-control" name="max_dia" id="max_dia">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">MT Máximos al mes</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="number" class="form-control" name="max_mes" id="max_mes">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tolerancia de env&iacute;o %</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="number" class="form-control" name="tolerance" id="tolerance" maxlength="3" minlength="1" max="100" min="0" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Logo del Customer</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="file" name="img" id="img">
                        </div>
                      </div>
                        
                        <br>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Estatus</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="">
                            <label>
                              <input type="checkbox" class="js-switch" checked name="status" id="status" /> Inactivo/Activo
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-12 col-sm-9 col-xs-12">
                          <h2>Modulos a los que tendrán acceso los usuarios de este Customer <small>(Debe elegir al menos 1)</small>:</h2><br>
                            <ul class="nav nav-pills">
                              <?php echo $showmodules; ?>
                            </ul>
                          <label class="error" for="modules" style="display: inline;"></label>
                        </div>
                      </div>
                        
                      <br>

                      <div class="ln_solid"></div>
                      
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <h2>Elige la Marcación y el Carrier </h2>
                              <br>
                                <!--div class="form-group"-->
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Code y Carrier</label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <select class="select2_multiple form-control" multiple="multiple" name="shortcode_carrier[]">
                                          <?php echo $show_shortcode_carrier; ?>
                                        </select>
                                    </div>
                                <!--/div-->
                          </div>
                        </div>
                      </div>

                      <div class="ln_solid"></div>

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <h2>Administrador de este Customer <small>Todos los campos son obligatorios</small></h2>
                          </div>
                        </div>                     

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" id="nombre" name="nombre" placeholder="Nombre (s)">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="email" class="form-control has-feedback-left" id="mail" name="mail" placeholder="Email">
                            <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Nickname</label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" placeholder="Nombre de Usuario" name="nickname" id="nickname">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Contraseña</label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="password" class="form-control" name="pass1" id="pass1">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Repita la Contraseña</label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="password" class="form-control" name="pass2" id="pass2">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Imagen del Usuario</label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="file" name="img_usr" id="img_usr">
                          </div>
                        </div>
                      </div>

                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" onclick="badWords()">Agregar</button>
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