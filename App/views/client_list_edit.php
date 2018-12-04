<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2>Editar Cliente</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/listaclient/edit_client" method="POST" id="edit">
          <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3">Key Santander:</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
              <input type="text" class="form-control" placeholder="Key Santander" name="key_santander" id="key_santander" value="<?php echo $Cliente->key_santander ?>" readonly="readonly" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3">Celular:</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
              <input type="text" class="form-control" placeholder="Celular" name="msisdn" id="msisdn" value="<?php echo substr($Cliente->msisdn, -10) ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3">Correo:</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
              <input type="text" class="form-control" placeholder="Correo" name="mail" id="mail" value="<?php echo $Cliente->mail ?>">
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
              <input type="text" class="form-control" placeholder="Token Dispositivo" name="token_device" id="token_device" value="<?php echo $Cliente->token_device ?>">
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
          <input type="hidden" name="client_list_id" value="<?php echo $Cliente->client_list_id; ?>">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
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
<!--/Footer-->