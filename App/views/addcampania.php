<?php echo $header;?>
<!--/Header-->
<!--Body-->
	<div class="x_panel">
		<div class="x_title">
			<h2>Agregar Campa&ntilde;a</h2>
			<ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
				<li><a class="close-link"><i class="fa fa-close"></i></a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<p>En esta pantalla podra agregar la campa&ntilde;a que desea enviar y programar la fecha en que se realizara el env&iacute;o.</p>
			<div class="ln_solid"></div>
			<form id="add" action="/campania/add_campania" method="POST" class="form-horizontal">

			<div class="form-group row">
				<label class="control-label col-md-4 col-sm-4 col-xs-12">Nombre de la campa&ntilde;a : </label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				<input type="text" class="form-control" placeholder="Nombre de Campaña" name="nombre_campania" id="nombre_campania" required>
				</div>
			</div>

			<div class="form-group row">
				<label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Fecha vencimiento :</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<div class='input-group date' >
						<input type='text' class="form-control" name="datetimepicker" id='datetimepicker' required>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
					</div>
					<p class="help-block">Si no programas la fecha se enviara inmediatamente, si la fecha es anterior a la actual de igual manera se enviara automaticamente.<span id="fecha_sistema"></span></p>
				</div>
			</div>

			<?php echo $shortCodeHtml ?>

			

			<div class="ln_solid"></div>

			<div class="form-group">
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
