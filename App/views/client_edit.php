<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-6">
            <h2> Clientes</h2>
          </div>
          <div class="col-md-8 col-sm-8"></div>
          <div class="col-md-4 col-sm-4 col-xs-12">
            <a href="/client/seleccionaCliente/<?php echo $client_id; ?>"><button class="btn btn-success">Cargar Excel</button></a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/client/edit_client" method="POST" id="edit">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Nombre:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="Nombre del cliente" name="nombre" id="nombre" value="<?php echo $name ?>">
            </div>
          </div>
          <div class="form-group">
            <label  class="col-md-12 col-sm-12 col-xs-12">status:</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="text" class="form-control" placeholder="1|0" name="status" id="status" value="<?php echo $status ?>">
              </div>
          </div>
          <input type="hidden" name="customer" value="<?php echo $client_id; ?>">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <button type="submit" class="btn btn-primary">Guardar</button>
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
