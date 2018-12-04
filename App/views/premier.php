<?php echo $header;?>
<!--/Header-->
<!--Body-->
	<div class="x_panel">
		<div class="x_title">
			<h2>Envio Campa&ntilde;a premier</h2>
			<ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
				<li><a class="close-link"><i class="fa fa-close"></i></a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<!--p>En esta pantalla podra agregar la campa&ntilde;a que desea enviar y programar la fecha en que se realizara el env&iacute;o.</p-->
			<div class="ln_solid"></div>
			<form id="add" action="/ApiUrl/mensajesPost" method="POST" class="form-horizontal">

			<div class="form-group row">
				<label class="control-label col-md-2 col-sm-4 col-xs-12">Mensaje : </label>
				<div class="col-md-10 col-sm-8 col-xs-12">
				<input type="text" class="form-control" placeholder="Mensaje" name="mensaje" id="mensaje" required>
				</div>
			</div>

			<div class="form-group row">
				<label class="control-label col-md-2 col-sm-4 col-xs-12">Inicio : </label>
				<div class="col-md-10 col-sm-8 col-xs-12">
				<input type="text" class="form-control" placeholder="Inicio" name="inicio" id="inicio" required>
				</div>
			</div>	

			<div class="form-group row">
				<label class="control-label col-md-2 col-sm-4 col-xs-12">Fin : </label>
				<div class="col-md-10 col-sm-8 col-xs-12">
				<input type="text" class="form-control" placeholder="Fin" name="fin" id="fin" required>
				</div>
			</div>		

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
