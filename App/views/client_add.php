<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2> Clientes</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/client/add_client" method="POST" id="add">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Nombre:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="Nombre del cliente" name="nombre" id="nombre">
            </div>
          </div>
          <div class="form-group">
            <label  class="col-md-12 col-sm-12 col-xs-12">status:</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- <input type="text" class="form-control" placeholder="1|0" name="status" id="status"> -->
                <select name='status' id="status">
                  <option value='1'>1</option>
                  <option value="0">0</option>
                </select>
              </div>
          </div>
          <input type="hidden" name="customer" value="<?php echo $customer_id; ?>">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <button type="submit" class="btn btn-primary">Siguiente</button>
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
