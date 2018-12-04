<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br>
        <h2>Editard Webhook</h2>
        <br>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/Apis/webHookUpdate" method="POST" id="form">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Usuario:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="Usuario para el basic authentication" name="usuario" id="usuario" value="<?= $usuario?>" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Password:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="Password para el basic authentication" name="password" id="password" value="<?= $password?>" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">WebHook URL</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input class="form-control noresize" name="webhook" id="webhook" placeholder="Ingresa la url de tu webhook" value="<?= $url?>" required/>              
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Tipo de WebHook</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <select class="form-control" name="type" id="type">
                <?= $sType?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="hidden" name="webhook_id" id="webhook_id" value="<?= $webhook_id?>">
              <button type="submit" class="btn btn-success">Guardar</button>
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