<?php echo $header; ?>
	<div class="x_title">
		<h1>Agregar Usuario</h1>
	  <div class="clearfix"></div>
  </div>

        <div class="alert alert-warning alert-dismissible fade in" role="alert" style="color: black;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>Importante!</strong>
            Para asignar multiples IP's de acceso, Debe separar por comas ","
            <strong>Ejemplo: (192.168.1.1,192.168.1.3)</strong>
        </div>

  
  <div class="panel-heading">&nbsp;</div>
  <form action="/ApiControl/userInsert" method="POST" id="add" enctype="multipart/form-data">

    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
        <label>User:</label>
        <input type="text" class="form-control" name="user" id="user" value="">
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
        <label>Password:</label>
        <input type="text" class="form-control" name="password" id="password" value="">
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
        <label>Customer:</label>
        <input type="text" class="form-control" name="customer" id="customer" value="<?=$customer_id;?>" readonly>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
        <label>Status:</label>
        <select class="form-control" name="status" id="status">
          <option value="1">Visible</option>
          <option value="0">Oculto</option>
          <option value="2">Eliminado</option>
        </select>
    </div>

    <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
        <label>Apis:</label>
        <select class="form-control" name="apis" id="apis">
          <option value="">Selecciona una API</option>
          <?php echo $sApis; ?>
        </select>
    </div>

    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
        <br>
        <input type="button" id="btnAsignar" class="btn btn-success" value="Asignar API">
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
        <label>IP's de acceso:</label>
        <input class="form-control" type="text" name="ips" id="ips"/>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <label>Apis Asignadas:</label>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" id="contendor_apis">
        </div>
    </div>

    

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <br>
        <input type="submit" id="btnAgregar" class="btn btn-success" value="Agregar">
        <a href="/ApiControl/User/" class="btn btn-danger">Regresar</a>
    </div>
  </form>
<?php echo $footer; ?>
