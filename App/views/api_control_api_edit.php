<?php echo $header; ?>
	<div class="x_title">
		<h1>Editar Api</h1>
	  <div class="clearfix"></div>
  </div>
  
  <div class="panel-heading">&nbsp;</div>
  <form action="/ApiControl/apiUpdate" method="POST" id="edit" enctype="multipart/form-data">

    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
        <label>Nombre:</label>
        <input type="text" class="form-control" name="nombre" id="nombre" value="<?= $api['nombre']?>">
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
        <label>URL:</label>
        <input type="text" class="form-control" name="api_url" id="api_url" value="<?= $api['url']?>">
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
        <label>Status:</label>
        <select class="form-control" name="status" id="status">
          <?= $sStatus?>
        </select>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <br>
        <input type="hidden" name="api_id" value="<?= $api['api_id']?>">
        <input type="submit" id="btnAgregar" class="btn btn-success" value="Guardar">
        <a href="/ApiControl/ApiAll/" class="btn btn-danger">Regresar</a>
    </div>
  </form>
<?php echo $footer; ?>
