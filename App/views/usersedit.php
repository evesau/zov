<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Editar Usuario <small>Todos los campos son obligatorios</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" id="edit" enctype="multipart/form-data" action="/Menu/editUser" method="POST">

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12">Selecciona el usuario: </label>
                        <div class="col-md-10 col-sm-9 col-xs-11">
                          <select class="select2_single form-control" tabindex="-1" id="usuarios" name="usuarios">
                            <option></option>
                            <?php echo $showuser; ?>
                          </select>
                        </div>
                      </div>
                      <input type="hidden" name="img_hidden" id="img_hidden">
                      <input type="hidden" name="nickname_hidden" id="nickname_hidden">
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="nombre" name="nombre" placeholder="Nombre (s)"  value ="" >
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" >
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <input type="email" class="form-control has-feedback-left" id="mail" name="mail" placeholder="Email" >
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
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
                          <input type="password" class="form-control" name="pass1" id="pass1" >
                        </div>
                      </div>
                      <label class="control-label"><small>(Si no desea cambiar la contraseña, puede dejar estos espacios en blanco)</small></label>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Repita la Contraseña</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="password" class="form-control" name="pass2" id="pass2" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Imagen del Usuario</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="file" id="img" name="img" accept="jpg,jpeg,png,bmp">
                          <label class="control-label"><small>(Seleccione una imagen sólo si desea actualizar la foto de perfil)</small></label>
                        </div>
                      </div>
                      <br>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Estatus</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="">
                            <label>
                              <input type="checkbox" class="js-switch" name="status" id="status" checked /> Inactivo/Activo
                            </label>
                          </div>
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

                      <label>Modulos permitidos para este usuario <small>(Debe elegir al menos 1)</small>:</label>
                      <p style="padding: 5px;">
                      <?php echo $showmodules; ?>
                      </ul>
                      <p>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Actualizar</button>
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
