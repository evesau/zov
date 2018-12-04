<?php echo $header; ?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
  <form class="form-horizontal form-label-left input_mask" action="/Device/deviceAdd" method="POST" id="add" enctype="multipart/form-data">

      <div class="x_title">
        <br><br>
        <h1 class="page-header">Agregar Dispositivo</h1>
        <div class="clearfix"></div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Agregar Mediante:</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" name="opcion" id="opcion">
            <option value="1">Unitario</option>
            <option value="2">CSV</option>
          </select>
        </div>
      </div>

      <div id="contenedor">

        <div class="form-group">
          <label class="control-label col-md-2 col-sm-2 col-xs-2">Token: </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" type="text" name="token" id="token" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2 col-sm-2 col-xs-2">Msisdn: </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" type="text" name="msisdn" id="msisdn" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2 col-sm-2 col-xs-2">Sistema Operativo: </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" type="text" name="sistema_operativo" id="sistema_operativo" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2 col-sm-2 col-xs-2">Nombre: </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" type="text" name="nombre" id="nombre" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2 col-sm-2 col-xs-2">Apellido: </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" type="text" name="apellido" id="apellido" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2 col-sm-2 col-xs-2">Cuenta: </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" type="text" name="cuenta" id="cuenta" />
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

      </div>

      <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
          <input type="submit" id="btnGuardar" class="btn btn-primary" value="Guardar" />
          <input type="button" id="btnVolver" class="btn btn-primary" value="Volver" />
        </div>
      </div>

  </form>
</div>
</div>

<?php echo $footer; ?>
