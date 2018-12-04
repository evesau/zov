<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Perfil de Usuario <small>Todos los campos son obligatorios</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div>
        <br/>
        <form  id="profile" class="form-horizontal form-label-left input_mask" enctype="multipart/form-data" action="/user/updateProfile" method="POST">
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Usuario: </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="color: Green;"> <?php echo $usuario; ?> </label>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ingrese su contraseña anterior</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="password" class="form-control" name="passAnterior" id="passAnterior" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ingrese la nueva contraseña</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="password" class="form-control" name="passNueva" id="passNueva">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Repite la nueva contraseña</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="password" class="form-control" name="passNueva1" id="passNueva1">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Imagen del Usuario</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="file" name="img" id="img" accept="jpg,jpeg,png,bmp">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
