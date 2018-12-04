<?php echo $header; ?>
  <div class="x_title">
    <h1>Detalle del Grupo <?= $doppler_grupo_nombre?></h1>
    <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="panel-heading">&nbsp;</div>
  <div class="form-group">
    <form action="/ApiDoppler/crearExcel" method="POST" target="_blank">
      <table class="table table-striped table-bordered table-hover" border="1" id="muestra-cupones">
        <thead>
          <tr>
            <th style="text-align: center;"><h2>Campa&ntilde;as</h2></th>
            <th style="text-align: center;"><h2>Abiertos</h2></th>
            <th style="text-align: center;"><h2>No Abiertos</h2></th>
            <th style="text-align: center;"><h2>Rechazados Hard</h2></th>
            <th style="text-align: center;"><h2>Rechazados Soft</h2></th>
            <th style="text-align: center;"><h2>Entregados</h2></th>
	          <th style="text-align: center;"><h2>Total Clicks</h2></th>
            <th style="text-align: center;"><h2>Totales</h2></th>
          </tr>
        <thead>
        <tbody id="registros">
          <?= $tabla?>
        </tbody>
      </table>
    </form>

	<div class="col-md-2 col-sm-2 col-xs-2">
                <a class="btn btn-danger" href="/ApiDoppler/showGroups">Regresar</a>
        </div>
  </div>
<?php echo $footer; ?>
