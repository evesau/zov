<?php echo $header; ?>
	<div class="x_title">
		<h1>Detalle de envío campañas</h1>
	  <div class="clearfix"></div>
  	</div>
  	<div class="clearfix"></div>
  	<div class="panel-heading">&nbsp;</div>
  	<div class="x_title">
		<h2>Agrupamiento temporal de las campa&ntilde;as</h2>
	  	<div class="clearfix"></div>
  	</div>
	<div class="form-group">
		<table class="table table-striped table-bordered table-hover" border="1" id="muestra-cupones">
			<thead>
				<tr>
					<th style="text-align: center;"><h2>Campa&ntilde;as</h2></th>
					<th style="text-align: center;"><h2>Abiertos</h2></th>
					<th style="text-align: center;"><h2>No Abiertos</h2></th>
					<th style="text-align: center;"><h2>Rechazados Hard</h2></th>
					<th style="text-align: center;"><h2>Rechazados Soft</h2></th>
					<th style="text-align: center;"><h2>Clicks Links</h2></th>
					<th style="text-align: center;"><h2>Entregados</h2></th>
					<th style="text-align: center;"><h2>Totales</h2></th>
				</tr>
			<thead>
			<tbody>
				<?= $tabla?>
			</tbody>
		</table>
	</div>
	<div>
		<form id="campaigns">
			<div class="form-group">
			
				<div class="col-md-12 col-sm-12 col-xs-12">
					<label class="col-md-2 col-sm-2 col-xs-2 form-label">Nombre del grupo: </label>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<input class="form-control" type="text" name="name" placeholder="Nombre Grupo">
					</div>
					<?php echo $campaign_div; ?>
					<input class="btn btn-primary col-md-2 col-sm-2 col-xs-2" type="button" id="btnCrear" value="Crear Grupo">
				<div class="col-md-2 col-sm-2 col-xs-2">
                                        <a class="btn btn-danger" href="/ApiDoppler/">Regresar</a>
                               </div>
				</div>

			</div>

			
		</form>
		
	</div>

	<div id="response_group_add">
		
	</div>
	
	

<?php echo $footer; ?>














