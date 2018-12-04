<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2> Añadir número</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/client/msisdn_edit" method="POST" id="edit">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Msisdn:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="ej: 5545250512" name="msisdn" id="msisdn" value="<?php echo $msisdn; ?>">
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
          <input type="hidden" name="msisdn_id" value="<?php echo $msisdn_id; ?>">
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <button type="submit" class="btn btn-primary">Actualizar</button>
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
