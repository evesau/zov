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
                    <form  id="add" class="form-horizontal form-label-left input_mask" enctype="multipart/form-data" action="/carrier/editCarrier" method="POST">

                      <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Nombre</label>
                        <div class="col-md-11 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" placeholder="Nombre de Carrier" name="nombre" id="nombre" value="<?php echo $carrier->_nombre; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Host</label>
                        <div class="col-md-11 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="host" id="host" placeholder="ip" value="<?php echo $carrier->_host; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Puerto</label>
                        <div class="col-md-11 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="puerto" id="puerto" placeholder="ejemplo : 2222" value="<?php echo $carrier->_puerto; ?>">
                        </div>
                      </div>
		      <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">System Id</label>
                        <div class="col-md-11 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="system_id" id="system_id" placeholder="system_id" value="<?php echo $carrier->_system_id; ?>">
                        </div>
                      </div>
		      <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Password</label>
                        <div class="col-md-11 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="password" id="password" placeholder="pwd" value="<?php echo $carrier->_password; ?>">
                        </div>
                      </div>
		      <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">System Type</label>
                        <div class="col-md-11 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="system_type" id="system_type" placeholder="system_type" value="<?php echo $carrier->_system_type; ?>">
                        </div>
                      </div>

			<div class="row">
			

		      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Source Ton</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="source_ton" id="source_ton" placeholder="source_ton" value="<?php echo $carrier->_source_ton; ?>">
                        </div>
                      </div>
		      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Source Npi</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="source_npi" id="source_npi" placeholder="source_npi" value="<?php echo $carrier->_source_npi; ?>">
                        </div>
                      </div>
		      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Destination Ton</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="destination_ton" id="destination_ton" placeholder="destination_ton" value="<?php echo $carrier->_destination_ton; ?>">
                        </div>
                      </div>

			</div>


			<div class="row">

		      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Destination Npi</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="destination_npi" id="destination_npi" placeholder="destination_npi" value="<?php echo $carrier->_destination_npi; ?>">
                        </div>
                      </div>
                      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Addr Ton</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="addr_ton" id="addr_ton" placeholder="addr_ton" value="<?php echo $carrier->_addr_ton; ?>">
                        </div>
                      </div>
                      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Addr Npi</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="addr_npi" id="addr_npi" placeholder="addr_npi" value="<?php echo $carrier->_addr_npi; ?>">
                        </div>
                      </div>

			</div>
			
			<!---->

			<div class="row">

			<div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Supports Wap Push</label>
                        <div class="col-md-8 col-sm-9 col-xs-12">
			    <input type="checkbox" class="js-switch" name="supports_wap_push" id="supports_wap_push" <?php echo $carrier->_supports_wap_push; ?>/> Inactivo/Activo
                        </div>
                      </div>
                      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mode</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
				                  <select class="form-control" name="mode">
                            <?php echo $modeShow; ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Estatus</label>
			<div class="col-md-8 col-sm-9 col-xs-12">
                            <input type="checkbox" class="js-switch" name="status" id="status" <?php echo $carrier->_status; ?>/> Inactivo/Activo
                        </div>
                      </div>

			</div>

                     	<!---->
			<div class="row">
			<div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tps Submit One</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="tps_submit_one" id="tps_submit_one" placeholder="tps_submit_one" value="<?php echo $carrier->_tps_submit_one; ?>">
                        </div>
                      </div>
                      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tps Submit Multi</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="tps_submit_multi" id="tps_submit_multi" placeholder="tps_submit_multi" value="<?php echo $carrier->_tps_submit_multi; ?>">
                        </div>
                      </div>
                      <div class="form-group col-md-4 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Submit Multi Size</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="submit_multi_size" id="submit_multi_size" placeholder="submit_multi_size" value="<?php echo $carrier->_submit_multi_size; ?>">
                        </div>
                      </div>
			</div>
			<!----> 

			<!---->
                        <div class="row">
                        <div class="form-group col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">White List</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
				<input type="checkbox" class="js-switch" name="white_list" id="white_list" <?php echo $carrier->_white_list; ?>/> Inactivo/Activo
                        </div>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">White List User</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="white_list_user" id="white_list_user" placeholder="white_list_user" value="<?php echo $carrier->_white_list_user; ?>">
                        </div>
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">White List Pwd</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="white_list_pwd" id="white_list_pwd" placeholder="white_list_pwd" value="<?php echo $carrier->_white_list_pwd; ?>" >
                        </div>
                      </div>
			<div class="form-group col-md-3 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Country Code</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="country_code" id="country_code" placeholder="country_code" value="<?php echo $carrier->_country_code; ?>">
			  <p class="help-block">0 es default 10 digitos, ejemplo 52 mexico lada internacional.</p>
                        </div>
                      </div>
			
                        </div>
                        <!---->


			<!---->

                        <div class="row">

                        <div class="form-group col-md-6 col-sm-3 col-xs-12">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Short Code</label>
                        <div class="col-md-8 col-sm-9 col-xs-12">
				<select class="form-control" name="short_code">
                                    <?php echo $shortCodeShow; ?>
                                </select>
                        </div>
                      </div>
                      <div class="form-group col-md-6 col-sm-3 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Carrier</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="carrier">
				    <?php echo $carrierShow; ?>
                                </select>
                        </div>
                      </div>

                        </div>
                        <!---->
			

                        <br>
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-12 col-sm-9 col-xs-12">
                          <button type="submit" class="btn btn-success pull-right">Guardar</button>
                        </div>
                      </div>
			<input type="hidden" name="id" value="<?php echo $carrier->_id;?>" />
			<input type="hidden" name="carrier_connection_id" value="<?php echo $carrier->_carrier_connection_id; ?>" />
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
