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
            <h2> Añadir número</h2>
          </div>
          <div class="col-md-8 col-sm-8"></div>
          <div class="col-md-4 col-sm-4 col-xs-12">
            <a href="/client/seleccionaCliente/<?php echo $id_client; ?>"><button class="btn btn-success">Cargar Excel</button></a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/client/msisdn_add" method="POST" id="add">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Msisdn:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="ej: 5545250512" name="msisdn" id="msisdn">
            </div>
          </div>
          <div class="form-group">
            <label  class="col-md-12 col-sm-12 col-xs-12">Carrier:</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <select class="form-control" id="carrier" name="carrier">
                  <option value="" disabled selected hidden>Carrier</option>
                    <?php echo $option_carrier; ?>
                </select>
              </div>
          </div>
          <input type="hidden" name="client" value="<?php echo $id_client; ?>">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <button type="submit" class="btn btn-primary">Agregar</button>
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
