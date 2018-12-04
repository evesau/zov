<?php echo $header; ?>

<div class="row">
  <form class="form-horizontal" action="/Device/deviceEdit" method="POST" id="edit" enctype="multipart/form-data">
    <div class="form-group">

      <div class="x_title">
        <br><br>
        <h1 class="page-header">Editar Dispositivo</h1>
        <div class="clearfix"></div>
      </div>


      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Token: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" type="text" name="token" id="token" value="<?php echo $device['token']; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Msisdn: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" type="text" name="msisdn" id="msisdn" value="<?php echo $device['msisdn']; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Sistema Operativo: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" type="text" name="sistema_operativo" id="sistema_operativo" value="<?php echo $device['sistema_operativo']; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Nombre: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $device['nombre']; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Apellido: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $device['apellido']; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Cuenta: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" type="text" name="cuenta" id="cuenta" value="<?php echo $device['cuenta']; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Sexo: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" type="text" name="sexo" id="sexo">
          <?php echo $sSexo; ?>
        </select>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Visible: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" type="text" name="estatus" id="estatus">
          <?php echo $sEstatus; ?>
        </select>
        </div>
      </div>

      <input type="hidden" name="push_device" id="push_device" value="<?php echo $device['push_device']; ?>">

      <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
          <input type="submit" id="btnGuardar" class="btn btn-primary" value="Guardar" />
          <input type="button" id="btnVolver" class="btn btn-primary" value="Volver" />
        </div>
      </div>

    </div>
  </form>
</div>

<?php echo $footer; ?>
