<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Añadir Carrier </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form  id="add" class="form-horizontal form-label-left input_mask" enctype="multipart/form-data" action="/carrier/editCompanyPost" method="POST">

                      <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Nombre</label>
                        <div class="col-md-11 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" placeholder="Nombre de Carrier" name="nombre" id="nombre" value="<?php echo $carrier->_nombre; ?>">
                        </div>
                      </div>

                        <br>
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-12 col-sm-9 col-xs-12">
                          <button type="submit" class="btn btn-success pull-right">Guardar</button>
                        </div>
                      </div>
			<input type="hidden" name="id" value="<?php echo $carrier->_id;?>" />
			<input type="hidden" name="nombre_hidden" id="nombre_hidden" value="<?php echo $carrier->_nombre; ?>" />
                    </form>
                  </div>
                </div>
            </div>
            </div>

<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
