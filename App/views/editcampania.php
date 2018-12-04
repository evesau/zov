<?php echo $header;?>
<!--/Header-->
<!--Body-->
	<div class="x_panel">
		<div class="x_title">
			<h2>Modificar Campa&ntilde;a</h2>
			<ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
				<li><a class="close-link"><i class="fa fa-close"></i></a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<p>En esta pantalla podra modificar la campa&ntilde;a que desea enviar y  reprogramar la fecha en que se realizara el env&iacute;o.</p>
			<div class="ln_solid"></div>
			<form id="add" action="/campania/edit_campania" method="POST" class="form-horizontal">

				<div class="form-group row">
					<label class="control-label col-md-4 col-sm-4 col-xs-12">Nombre de la campa&ntilde;a : </label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" placeholder="Nombre de Campaña" name="nombre_campania" id="nombre_campania" value="<?php echo $nombre_campania; ?>" required>
					</div>
				</div>

				<div class="form-group row">
					<label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Fecha Lanzamiento :</label>
					<div class="col-md-8 col-sm-8 col-xs-12">
						<div class='input-group date' >
							<input type='text' class="form-control" name="datetimepicker" id='datetimepicker' value="<?php echo $fecha; ?>" required>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
						</div>
						<!-- <label>La fecha de lanzamiento es la siguiente: <?php echo $fecha; ?> </label> -->
						<p class="help-block">Si no programas la fecha se enviara inmediatamente, si la fecha es anterior a la actual de igual manera se enviara automaticamente.<span id="fecha_sistema"></span></p>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-4 col-sm-4 col-xs-12">Estatus de la campa&ntilde;a: </label>
					<div class="col-md-8 col-sm-8 col-xs-12">
						<select type="text" class="form-control" name="status" id="status">
							<option value="">Selecciona el Estatus</option>
							<?php echo $status; ?>
						</select>
						<p class="help-block">Puedes cambiar el estatus del envio de tu campaña.</p>
					</div>
				</div>

				<div class="ln_solid"></div>

				<div class="form-group">
					<input type="hidden" name="campania" value="<?php echo $campaign_id; ?>">
					<div class="col-md-12 col-sm-9 col-xs-12">
						<button type="submit" class="btn btn-success pull-right">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->