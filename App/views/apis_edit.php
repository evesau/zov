<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br>
        <h2> Editar api</h2>
        <br>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/apis/edit_apis" method="POST" id="form">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Usuario:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="Usaurio api" name="usuario" id="usuario" value="<?php echo $usuarioApi; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Password:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?php echo $passwordApi; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">ip</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <textarea class="form-control" style="resize: vertical;" placeholder="Ingresar IP's separados por comas ',' (127.0.0.1 , 192.168.1.1)" name="ip" id="ip" required><?php echo $ip; ?></textarea>
              <input type="hidden" name="api_id" id="api_id" value="<?php echo $api_id; ?>" >
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
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