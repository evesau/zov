<?php echo $header;?>

	<form id="add" action="/SmsPush/enviarPush" method="POST">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Push Notification</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p>En esta pantalla podra confeccionar el mensaje que desea enviar y programar la fecha en que se realizara el env&iacute;o.</p>
                    <div class="ln_solid"></div>
                    <form id="add" action="/Santander/envioPostExistente" method="POST">

                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Nombre de la campaña : </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
        <input type="text" class="form-control" placeholder="Nombre de Campaña" name="nombre_campania" id="nombre_campania">
                            </div>
                        </div>

			<div class="form-group row">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Titulo del Mensaje : </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
        <input type="text" class="form-control" placeholder="Titulo del Mensaje" name="titulo" id="titulo">
                            </div>
                        </div>

			<div class="form-group row">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Tipo de Mensaje : </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
				<select class="form-control col-md-12 col-sm-12 col-xs-12" name="tipo_mensaje" id="tipo_mensaje">Tipo
                			<option value="1"> General</option>
               				<option value="2"> Deposito</option>
					<option value="3"> Transaccion</option>              
				</select>
                            </div>
                        </div>

			<div class="alert alert-warning alert-dismissible fade in" role="alert">
                    	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    	    <strong>Importante!</strong> Para hacer uso de los comodines usa la tecla @. Quedara encerrado en @, por ejemplo @folio@
                  	</div>

                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Texto del Mensaje : </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
        <textarea name="mensaje" id="mensaje" class="resizable_textarea form-control" placeholder="En la redacción del mensaje no es válido el uso de la letra “ñ”, símbolos o vocales acentuadas El mensaje debera ser mayor a 5 caracteres. ..."></textarea>
                            </div>
                        </div>


      <div class="form-group row">
                            <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Fecha Lanzamiento :</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                              <div class='input-group date' id='datetimepicker'>
                              <input type='text' class="form-control" name="datetimepicker" id='datetimepicker' />
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
            </div>
        <p class="help-block">Si no programadas la fecha se enviara inmediatamente, si la fecha es anterior a la actual de igual manera se enviara automaticamente.<span id="fecha_sistema"></span></p>
          </div>
                        </div>

                        <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-12 col-sm-9 col-xs-12">
                          <input type="submit" class="btn btn-success pull-right" value="Siguiente">
                        </div>
                      </div>
                  </div>
                </div>
          </form>

<?php echo $footer;?>
<!--/Footer-->
