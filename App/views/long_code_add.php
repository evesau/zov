<?php echo $header; ?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <form class="form-horizontal form-label-left input_mask" action="/LongCode/campaniaAdd" method="POST" id="add" enctype="multipart/form-data">

      <div class="x_title">
        <br><br>
        <h1 class="page-header">Agregar Campaña</h1>
        <div class="clearfix"></div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Nombre de Campaña: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" type="text" name="nombre" id="nombre" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Mensaje: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" type="text" name="mensaje" id="mensaje" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Fecha de Lanzamiento: </label>
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class='input-group date' id='datetimepicker'>
            <input type='text' class="form-control" name="fecha" id='fecha' />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-2">Numeros: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" type="text" name="numeros" id="numeros" />
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
