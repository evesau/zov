<?php echo $header; ?>
	<div class="x_title">
		<h1>Editar Usuario</h1>
      <div class="clearfix"></div>
   </div>

    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="color: black;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <strong>Importante!</strong>
      Para asignar multiples IP's de acceso, Debe separar por comas ","
      <strong>Ejemplo: (192.168.1.1,192.168.1.3)</strong>
    </div>

   <div class="panel-heading">&nbsp;</div>
      <form action="/ApiControl/userUpdate" method="POST" id="edit" >

          <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
              <label>User:</label>
              <input type="text" class="form-control" name="user" id="user" value="<?= $usuario['user']?>">
          </div>

          <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
              <label>Customer:</label>
              <input type="text" class="form-control" name="customer" id="customer" value="<?= $usuario['customer_id']?>">
          </div>

          <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
              <label>Restaurar Password:</label>
              <input type="text" class="form-control" name="password_reset" id="password_reset" value="">
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
              <input class="form-control" type="text" name="ips" id="ips" value="<?= $ips?>"/>
          </div>

          <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
              <label>Status:</label>
              <select class="form-control" name="status" id="status">
                <?php echo $sStatus; ?>
              </select>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" >
              <label>Apis Asignadas:</label>
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" id="contendor_apis">
                <?php echo $apisAsignadas;?>
              </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
              <br>
              <input type="hidden" name="user_id" value="<?= $usuario['user_id']?>">
              <input type="hidden" name="password" value="<?= $usuario['password']?>">
              <input type="submit" id="btnAgregar" class="btn btn-success" value="Guardar">
              <a href="/ApiControl/UserAll/" class="btn btn-danger">Regresar</a>
          </div>
      </form>
<?php echo $footer; ?>
