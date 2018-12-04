
<?php echo $header; ?>
<div class="container body">
	<div class="main_container">

		<!-- page content -->
		<div class="" role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<h3>Configuracion de PIN</h3>
					</div>
				</div>
				<div class="clearfix"></div>

				<div class="row">

					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Configuracion de PIN <small>Generacion</small></h2>
								<ul class="nav navbar-right panel_toolbox">
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">Settings 1</a></li>
											<li><a href="#">Settings 2</a></li>
										</ul>
									</li>
									<li><a class="close-link"><i class="fa fa-close"></i></a></li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<!-- Tabs -->
								<div id="wizard" class="form_wizard wizard_horizontal">
									<ul class="list-unstyled wizard_steps">
										<li><a href="#step-11" id="step-111"><span class="step_no" id="step-no-111">1</span></a></li>
										<li><a href="#step-22" id="step-222"><span class="step_no" id="step-no-222">2</span></a></li>
										<li><a href="#step-33" id="step-333"><span class="step_no" id="step-no-332">3</span></a></li>
										<!--li><a href="#step-44" id="step-444"><span class="step_no" id="step-no-442">4</span></a></li-->
									</ul>
									<?php $colorErrores = "#ec435c"; ?>
									<div id="step-11" style="display: none;">
										<div class="row" style="margin:0px 100px 0px 100px; background: #f6f6f6">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="col-md-6 col-sm-6 col-xs-12" style="background: #385473; padding: 50px 10px 50px 10px;">
													<h1 style="color: #fff">Configuracion de PIN</h1>
													<p style="color: #f6f6f6; font-size: 18px;">Se puede configurar un PIN con las siguientes características</p>
													<ul>
														<li class="li-caracteristicas">
															Tipo de PIN: Numérico, Alfabético o Alfanumérico
														</li>
														<li class="li-caracteristicas">
															Logitud de PIN: 3 a 6 caracteres
														</li>
														<li class="li-caracteristicas">
															Tiempo de expiración: Segundos o Minutos
														</li>
														<li class="li-caracteristicas">
															Texto del mensaje: 160 caracteres para SMS y 90 caracteres para el RCS
														</li>
													</ul>

													<div class="row">
														<label for="" style="padding-left: 10px; font-size: 15px; color: #f6f6f6;"> <span class="fa fa-bookmark"></span> Cuentanos cual es el nombre de tu marca, ya que es el identificador de tus PINES</label>
														<div class="col-md-6 col-xs-6 col-sm-12">
															<input type="text" required="required" class="form-control col-md-12 col-xs-12 col-sm-12" name="marca" id="marca" maxlength="15" placeholder="'Marca Promocion','Marca PINES','Marca alerta',etc." style="text-align: center;" value="<?php echo $data_pin['pin_marca'] ?>"/>

															<span style="color: <?php echo $colorErrores; ?>" id="marca-requerido"></span>
														</div>
														<div class="col-md-6 col-xs-6 col-sm-12" style="text-align: center;">
															<a class="btn btn-success form-control col-md-12 col-xs-12 col-sm-12" id="siguiente-1">Siguiente</a>
														</div>
													</div>
													<br>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12" style="padding: 50px 10px 50px 10px; background: #f6f6f6 ">
													<h1>Informacion  </h1>
													<table class="table table-bordered col-md-12 col-sm-12 col-xs-12" style="background: #FFF;">
														<thead>
															<tr>
																<th style="text-align: center; vertical-align: middle;">Tipo de env&iacute;o</th>
																<th style="text-align: center; vertical-align: middle;">Logitud de mensaje</th>
																<th style="text-align: center; vertical-align: middle;">Soporte de contenido</th>
																<th style="text-align: center; vertical-align: middle;">Ejemplo</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<th style="vertical-align: middle;">SMS</th>
																<td style="vertical-align: middle;">160 Caracteres</td>
																<td style="vertical-align: middle;">Contenido Alfanumerico</td>
																<?php echo $valMarca; ?>
																<td style="vertical-align: middle;"><b id="marca-table-sms"><?php echo $data_pin['pin_marca'] ?></b> Ingresa el <b>PIN</b> en el sistema para obtener acceso.</td>
															</tr>
															<tr>
																<th style="vertical-align: middle;">RCS</th>
																<td style="vertical-align: middle;">90</td>
																<td style="vertical-align: middle;">Contenido Alfanumerico, caracteres especiales</td>
																<td style="vertical-align: middle;"><b id="marca-table-rcs"><?php echo $valMarca ?> </b> Ingresa el <b>PIN</b> en el sistema 🖥 para obtener acceso👌.</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div id="step-22" style="display: none;">
										<div class="row" style="margin:0px 100px 0px 100px; background: #f6f6f6">
											<div class="col-md-5 col-xs-5 col-sm-12" style="background: #f6f6f6; padding: 50px;">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<h1>Configuración <small>PIN</small></h1>

													<div class="row">
														<label> <span class="glyphicon glyphicon-sort-by-alphabet"></span> Se puede generar diferentes tipos de PINES, ya sean PINES como: 1234, ABCD o 1A2B3 </label>
														<div class="col-md-12 col-xs-12 col-sm-12">
															<select required="required" class="form-control col-md-12 col-xs-12 col-sm-12" name="type_pin" id="type_pin">
																<option value="">Selecciona el tipo de generacion de PIN</option>
																<?php echo $getOptionsTYPEPIN; ?>
															</select>
														</div>
														<span style="color: <?php echo $colorErrores; ?>" id="pintipo-requerido"></span>
													</div><br>


													<div class="row">
														<label for="" style="padding-left: 10px; font-size: 15px;"><span class="glyphicon glyphicon-sound-5-1"></span> Configura la longitud de los <b>PINES</b> de 1 - 6 <i>(Caracteres)</i> </label><br>
														<div class="col-md-12 col-xs-12 col-sm-12">
															<select required="required" class="form-control col-md-12 col-xs-12 col-sm-12" name="lenght_pin" id="lenght_pin">
																<option value="">Selecciona el tamaño del PIN</option>
																<?php echo $getOptionsLENGTHPIN; ?>
															</select>
															<span style="color: <?php echo $colorErrores; ?>" id="pinlongitud-requerido"></span>
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-7 col-xs-7 col-sm-12" style="background: #385473; padding: 50px;">
												<div class="row">
													<label for="" style="padding-left: 10px; font-size: 15px; color:#fff;"><span class="glyphicon glyphicon-time"></span> Un <b>PIN</b> puede expirar en segundos o minutos, por ejemplo: 10 segundos o 3 minutos </label>
													<div class="col-md-4 col-xs-4 col-sm-12">
														<select required="required" class="form-control col-md-12 col-xs-12 col-sm-12" name="time_pin" id="time_pin">
															<option value="">Selecciona el tiempo para expiraci&oacute;n</option>
															<?php echo $getOptionsTIMEPIN; ?>
														</select>
														<span style="color: <?php echo $colorErrores; ?>" id="pintimepo-requerido"></span>
													</div>
													<!--div class="col-md-4 col-xs-4 col-sm-12">
														<select required="required" class="form-control col-md-12 col-xs-12 col-sm-12" name="time_pin_count" id="time_pin_count">
															<option value="">Selecciona la cantidad de tiempo</option>
															<div id="contendor-tiempos"></div>
														</select>
													</div-->
													<!-- Lista de tiempo -->
													<div id="contendor-tiempos"></div>
													

													<!--div class="col-md-4 col-xs-4 col-sm-12">
														<div class="input-group">
															<label type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" style="background: #f6f6f6;"> <span id="time-count-select">0</span> <span id="time-type-select"></span> </label>
														</div>		
													</div-->
												</div>
												<div class="row">
													<div class="col-md-12 col-xs-12 col-sm-12">
														<span class="fa fa-info" data-toggle="tooltip" data-placement="top" title="El mensaje SMS puede contener un m&aacute;ximo de  160 caracteres(alfanumérico)." style="background: #52a24c; padding: 3px;border-radius: 3px; box-shadow: 1px 1px 1px green; color: #f6f6f6;"> </span> 
														<label for="" style="padding-left: 10px; font-size: 15px; color: #fff;"> Agrega el mensaje para SMS <span style="color: <?php echo $colorErrores; ?>" id="pinsmstext-requerido"></span> </label>
														<textarea required="required" class="form-control col-md-12 col-xs-12 col-sm-12" name="text_pin" id="text_pin"><?php echo $data_pin['mensaje_sms'] ?></textarea>
													</div>
													<div class="col-md-12 col-xs-12 col-sm-12">
														<span class="fa fa-info" data-toggle="tooltip" data-placement="top" title="El mensaje SMS puede contener un m&aacute;ximo de  160 caracteres(alfanumérico)." style="background: #52a24c; padding: 3px;border-radius: 3px; box-shadow: 1px 1px 1px green; color: #f6f6f6;"> </span>
														<label for="" style="padding-left: 10px; font-size: 15px; color: #fff;"> Agrega el mensaje para RCS  <span style="color: <?php echo $colorErrores; ?>" id="pinrcstext-requerido"></span></label>
														<textarea required="required" class="form-control col-md-12 col-xs-12 col-sm-12" name="text_rcs" id="text_rcs"><?php echo $data_pin['mensaje_rcs'] ?></textarea>
													</div>

													<div class="col-md-12 col-xs-12 col-sm-12" style="color: white; margin-top: 20px;">
														<p>Ejemplo de como configurar el mensaje:</p>
														<p>Puedes escribir el signo @ y se desplegaran unas etiquetas @key_marca@ y @key_pin@, selecciona la que se requiera para formar el mensaje</p><b>Ejemplo</b>
														<p>@key_marca@ ingresa el PIN @key_pin@ en la plataforma ...</p>
														<p><i>Es requerido @key_marca@ y @key_pin@</i></p>
													</div>
												</div>
												<br><br>
											</div>

											<div class="col-md-6 col-xs-6 col-sm-12" style="text-align: center!important; margin-top: 50px; margin-left: 50px;">
												<a id="anterior-2" class="btn btn-danger col-md-3 col-xs-3 col-sm-12" style="margin-right: 10px;"> Anterior</a>
												<a id="limpiar" class="btn btn-warning col-md-3 col-xs-3 col-sm-12" style="margin-right: 10px;"> Limpiar</a>
												<a id="siguiente-2" class="btn btn-success col-md-3 col-xs-3 col-sm-12" style="margin-right: 10px;"> Siguiente</a>
											</div>
										</div>
									</div>
									<div id="step-33" style="display: none;">
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="x_panel">
													<div class="x_content" style="text-align: center; padding: 50px;">
														<span class="fa fa-eye" style="font-size: 44px; color: #c1c1c1;"> </span>
														<span class="fa fa-mobile" style="font-size: 44px; color: #c1c1c1;"> </span>
														<span class="fa fa-paper-plane" style="font-size: 44px; color: #c1c1c1;"> </span>
														<p><br>
															<h3> Vista general de PIN</h3>
															<h2>Dentro de esta sección se visualiza el PIN de envío por SMS/RCS</h2>
														</p>
														<div class="col-md-12 col-sm-12 col-xs-12">
															<p><b>Visualiza la sección de envío del mensaje</b></p>
															<form id="myForm">
																<input type="radio" name="radioName" value="SMS" checked /> Vista de SMS 
																<input type="radio" name="radioName" value="RCS" /> Vista de RCS
															</form>
														</div>
														<div class="col-md-6 col-xs-6 col-sm-12" style="text-align: center!important; margin-top:50px;margin-left: 50px;">
															<a id="anterior-3" class="btn btn-danger col-md-3 col-xs-3 col-sm-12" style="margin-right: 10px;"> Anterior</a>
															<a id="siguiente-3" class="btn btn-success col-md-3 col-xs-3 col-sm-12" style="margin-right: 10px;"> Guardar</a>
														</div>
													</div>
												</div>
												<div class="x_panel">
													<div class="x_title">
														<h2>PIN <small>Configuración de PIN</small></h2>
														<div class="clearfix"></div>
													</div>
													<div class="x_content">
														<div class="col-md-12 col-sm-12 col-xs-12">
															<form class="form-horizontal form-label-left input_mask">
																<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
																	<input type="text" class="form-control has-feedback-left" id="marca-view" placeholder="Email" value="Marca del mensaje:" readonly="readonly">
																	<span class="fa fa-certificate form-control-feedback left" aria-hidden="true"></span>
																</div>
																<div class="form-group">
																	<label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de PIN(s)</label>
																	<div class="col-md-9 col-sm-9 col-xs-12">
																		<input type="text" class="form-control" readonly="readonly"  id="tipo-view" value="">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-md-3 col-sm-3 col-xs-12">Logitud de PIN</label>
																	<div class="col-md-9 col-sm-9 col-xs-12">
																		<input class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" readonly="readonly" value="caracteres" id="logitud-view">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-md-3 col-sm-3 col-xs-12">Expiracion PIN</label>
																	<div class="col-md-9 col-sm-9 col-xs-12">
																		<input class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" readonly="readonly" value="" id="expiracion-view">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-md-3 col-sm-3 col-xs-12">Mensaje SMS</label>
																	<div class="col-md-9 col-sm-9 col-xs-12">
																		<textarea type="text" class="form-control" readonly="readonly" id="sms-view"></textarea>
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-md-3 col-sm-3 col-xs-12">Mensaje RCS</label>
																	<div class="col-md-9 col-sm-9 col-xs-12">
																		<textarea type="text" class="form-control" readonly="readonly" id="rcs-view"></textarea>
																	</div>
																</div>
																<div class="ln_solid"></div>
															</form>
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="row" style="margin:0px 100px 0px 100px;">
													<h2 class="StepTitle">Vista SMS/RCS</h2>
													<div class="col-md-12 col-xs-12 col-sm-12" style="">
														<div class="smartphone">
															<div class="smartphone-header">
																<ul class="li-content">
																	<li> 100% </li>
																	<li> <span class="fa fa-clock-o"></span> </li>
																	<li> <span class="fa fa-wifi"></span> </li>
																	<li> <span class="glyphicon glyphicon-tent"></span></li>
																</ul>
															</div>
															<div class="content-sms-top" id="top-sms">
																<div class="content-sms-msg-in"><span class="glyphicon glyphicon-chevron-left" style="color:#111;"></span></div>
																<div class="content-sms-msg-in-shorcode"><b>24766</b></div>
																<div class="content-sms-msg-in"><span class="glyphicon glyphicon-option-vertical" style="color:#111;"></span></div>
															</div>
															<div class="content-sms-top" id="top-rcs">
																<div class="content-sms-msg-in"><span class="glyphicon glyphicon-chevron-left" style="color:#111;"></span></div>
																<div class="content-sms-msg-in-name"><b>SKY</b></div>
																<div class="content-sms-msg-in"><span class="glyphicon glyphicon-option-vertical" style="color:#111;"></span></div>
																<div class="content-sms-msg-in"><span class="fa fa-shield" style="color:#111;"></span></div>
															</div>
															<div class="line"></div>

															<div class="content-sms-date" id="content-sms" style="height: 78%;">
																<div style="position: absolute; bottom: 70px;left: 0; width: 100%;">
																	<p class="content-sms-hour" style=" width: 100%;"><?php echo $fecha ?></p>
																	<div class="content-sms-icon" >
																		<span class="fa fa-user" style="color:#8eadd8;font-size: 25px;background:#1a3776;border-radius: 50%; margin: 10px; padding: 10px; "></span>
																	</div>
																	<div class="content-sms-content"><span id="mensaje-sms-pin"><?php echo $sms_set['mensaje_muestra'] ?></span> </div>
																</div>
															</div>

															<div id="content-top-rcs" style="text-align: center; height: 78%; background: #f6f6f6;">
																<img src="https://i.blogs.es/826560/sky/450_1000.png" class="content-rcs-img"  alt="">
																<p class="content-rcs-description">Descripcion de SKY: Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere vero tempora nobis </p>
																<div class="line"></div>
																<div style="position: absolute; bottom: 70px;left: 0; width: 100%;">
																	<div id="content-rcs" style="margin-left: 10px; margin-right: 10px;">
																		<p class="content-sms-hour" style=" width: 100%;"><?php echo $fecha ?></p>
																		<div class="content-card-img">
																			<h1 class="content-card-img-text"> <p class="content-card-pin"><?php echo $rcs_set['pin'] ?><span id="set-pin-rcs"></span></p></h1>
																		</div>
																		<div class="content-card-pin-info">
																			<p><b><span id="mensaje-rcs-pin"><?php echo $rcs_set['mensaje_muestra'] ?></span> </b></p>
																		</div>
																	</div>
																</div>
															</div>

															<div class="content-sms-msg">
																<div class="content-sms-msg-in"><span class="fa fa-plus-circle" class="content-sms-msg-icon"></span></div>
																<div class="content-sms-msg-text">Mensaje de texto</div>
																<div class="content-sms-msg-in"><span class="fa fa-paper-plane-o" style="color:#111;"></span></div>
															</div>

															<div class="content-control">
																<div class="content-control-button">
																	<span class="glyphicon glyphicon-modal-window"></span>
																</div>
																<div class="content-control-button">
																	<span class="glyphicon glyphicon-unchecked"></span>
																</div>
																<div class="content-control-button">
																	<span class="glyphicon glyphicon-chevron-left"></span>
																</div>
															</div>
														</div>
													</div>
												</div>            
											</div>
										</div>
									</div>
								</div>
								<!-- End SmartWizard Content -->
							</div>

							<div class="col-md-12 col-xs-12 col-sm-12">
								<input type="hidden" id="mensaje_rcs_db" value="">
								<input type="hidden" id="mensaje_sms_db" value="">
								<input type="hidden" id="pin_tipo_db" value="">
								<input type="hidden" id="pin_longitud_db" value="">
								<input type="hidden" id="pin_expiracion_db" value="">
								<input type="hidden" id="pin_expiracion_tipo_db" value="">
								<input type="hidden" id="pin_marca_db" value="">
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /page content -->
	</div>
</div>
<?php echo $footer; ?>