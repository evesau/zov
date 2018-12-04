<?php echo $header; ?>
  <div class="x_title">
    <h1>Grupos de campañas</h1>
    <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="panel-heading">&nbsp;</div>
  <div class="form-group">
    <form action="/ApiDoppler/crearExcel" method="POST" target="_blank">
          
      <div class="form-group col-md-12 col-sm-12 col-xs-12">
	<div class="col-md-2 col-sm-2 col-xs-2">
        	<input type="submit" class="btn btn-success" value="Descargar Excel" id="btnExcel" name="btnExcel">
	</div>
	<div class="col-md-2 col-sm-2 col-xs-2">
        	<a class="btn btn-danger" href="/ApiDoppler/">Regresar</a>
      	</div>
      </div>

      <table class="table table-striped table-bordered table-hover" border="1" id="muestra-cupones">
        <thead>
          <tr>
            <th style="text-align: center;"><h2>Grupo</h2></th>
            <th style="text-align: center;"><h2>Campa&ntilde;as</h2></th>
            <th style="text-align: center;"><h2>Abiertos</h2></th>
            <th style="text-align: center;"><h2>No Abiertos</h2></th>
            <th style="text-align: center;"><h2>Rechazados Hard</h2></th>
            <th style="text-align: center;"><h2>Rechazados Soft</h2></th>
            <th style="text-align: center;"><h2>Entregados</h2></th>
	          <th style="text-align: center;"><h2>Total Clicks</h2></th>
            <th style="text-align: center;"><h2>Totales</h2></th>
            <th style="text-align: center;"><h2>Acciones</h2></th>
          </tr>
        <thead>
        <tbody id="registros">
          <?= $tabla?>
        </tbody>
      </table>
    </form>
  </div>
<?php echo $footer; ?>
