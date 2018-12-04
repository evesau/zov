<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Editar Customer <small>Todos los campos son obligatorios</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form  id="edit" class="form-horizontal form-label-left input_mask" enctype="multipart/form-data" action="/Customer/editCustomer" method="POST">
                      
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" >Selecciona el Customer: </label>
                        <div class="col-md-10 col-sm-9 col-xs-11">
                          <select class="select2_single form-control" tabindex="-1" id="idcustomer" name="idcustomer">
                            <option></option>
                            <?php echo $showcustomer; ?>
                          </select>
                        </div>
                      </div>

                      <input type="hidden" name="img_hidden" id="img_hidden">

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
                              <input type="checkbox" name="status" id="status" /> Inactivo/Activo
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <h2>Elige la Marcación y el Carrier </h2>
                              <br>
                                <!--div class="form-group"-->
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Code y Carrier</label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <select class="select2_multiple form-control" multiple="multiple" name="shortcode_carrier[]" id="multiple">
                                          <?php echo $show_shortcode_carrier; ?>
                                        </select>
                                    </div>
                                <!--/div-->
                          </div>
                        </div>
                      </div>

                      <div class="ln_solid"></div>

                      <label>Modulos permitidos para este usuario <small>(Debe elegir al menos 1)</small>:</label>
                      <div class="col-md-12 col-sm-9 col-xs-12">
                        <p style="padding: 10px;">
                        <?php echo $showmodules; ?>
                        </ul>
                      </div>

                        <br><br><br>

                      <div class="ln_solid"></div>



                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" onclick="badWords()">Actualizar</button>
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