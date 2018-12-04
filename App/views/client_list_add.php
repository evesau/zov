<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2>Agregar Cliente</h2>
        <div class="clearfix"></div>
      </div>
      <?php echo $key_santander_existe ?>
      <div class="x_content">
        <form class="form-horizontal" action="/listaclient/add_client" method="POST" id="add">
          <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3">Key Santander:</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
              <input type="text" class="form-control" placeholder="Key Santander" name="key_santander" id="key_santander">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3">Celular:</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
              <input type="text" class="form-control" placeholder="Celular" name="msisdn" id="msisdn" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3">Correo:</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
              <input type="text" class="form-control" placeholder="Correo" name="mail" id="mail">
            </div>
          </div>
          <div class="form-group">
            <label  class="col-md-3 col-sm-3 col-xs-3">Tipo Dispositivo:</label>
              <div class="col-md-9 col-sm-9 col-xs-9">
                <select class="form-control" name="so_device" id="so_device" >
                 <?php echo $so_device ?>
                </select>
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3">Token Dispositivo:</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
              <input type="text" class="form-control" placeholder="Token Dispositivo" name="token_device" id="token_device" >
            </div>
          </div>
          <div class="form-group">
            <label  class="col-md-3 col-sm-3 col-xs-3">Estatus:</label>
              <div class="col-md-9 col-sm-9 col-xs-9">
                <select class="form-control" name="estatus" id="estatus" >
                 <?php echo $estatus ?>
                </select>
              </div>
          </div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-6">
              
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">              
              <a href="/listaclient" class="btn btn-danger pull-left" >Regresar</a>
              <button type="submit" class="btn btn-success pull-right">Guardar</button>
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
<!--/FooterCes4R2017-->