<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">

		<!--/INICIO-->

		
		                    <h2>Add Campaign</h2>
                    <!-- Tabs -->
		    <form class="form-horizontal form-label-left" action="/campaign/addCampaing" method="POST" id="add">
                    <div id="wizard_verticle" class="form_wizard wizard_verticle">
                      <ul class="list-unstyled wizard_steps">
                        <li>
                          <a href="#step-11">
                            <span class="step_no">1</span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-22">
                            <span class="step_no">2</span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-33">
                            <span class="step_no">3</span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-44">
                            <span class="step_no">4</span>
                          </a>
                        </li>
                      </ul>

                      <div id="step-11">
                        <h2 class="StepTitle">Step 1 Campaign</h2>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3" for="first-name">Nombre <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                              <input type="text" id="nombre" name="nombre" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3">Fecha Lanzamiento</label>
                            <div class="col-md-6 col-sm-6">
			      <div class='input-group date' >
                              <input type='text' class="form-control" name="fecha" id='datetimepicker'>                              
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
			      <p class="help-block">Si aun no tienes fecha programada la puedes dejar vacia.</p>
                            </div>
                          </div>

                      </div>
                      <div id="step-22">
                        <h2 class="StepTitle">Step 2 Short Code</h2>

			
			<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3" for="last-name">Short Code<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                 <select name="short_code" id="short_code">
				    <?php echo $short_code; ?>
                                </select> 
                            </div>
                        </div>				


			<br />			

			<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3" for="last-name">Carrier<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
				<div id="carrier" name="carrier"></div>
				<p class="help-block">Selecciona primero el Short Code.</p>
                            </div>
                        </div>	

	

                      </div>



			 <div id="step-33">
                        <h2 class="StepTitle">Step 2 Carrier</h2>


                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3" for="last-name">Short Code<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                 <select name="tipo" id="tipo">
                                  <option value="volvo">Mensaje Dinamico</option>
                                  <option value="saab">Mensajes Iguales</option>
                                  <option value="mercedes">Mensajes Concatenados</option>
                                  <option value="audi">Wap Push</option>
                                </select>
                            </div>
                        </div>

                        <br />
                        <br />

                      </div>



			 <div id="step-44">
                        <h2 class="StepTitle">Step 2 Carrier</h2>


                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3" for="last-name">Short Code<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                 <select name="tipo" id="tipo">
                                  <option value="volvo">Mensaje Dinamico</option>
                                  <option value="saab">Mensajes Iguales</option>
                                  <option value="mercedes">Mensajes Concatenados</option>
                                  <option value="audi">Wap Push</option>
                                </select>
                            </div>
                        </div>

                        <br />
                        <br />

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3" for="last-name">Tipo de Mensaje<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                 <select name="tipo" id="tipo">
                                    <?php echo $short_code; ?>
                                </select>
                            </div>
                        </div>

                      </div>




                    </div>
                    <!-- End SmartWizard Content -->

		</form>
		<!--/FIN-->
               </div>
            </div>

<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
