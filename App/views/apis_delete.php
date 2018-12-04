<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2> Eliminar Api</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/apis/delete_apis" method="POST" id="form">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Seleccione api: <?php echo $messageCustomer; ?></label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <select class="form-control col-md-12 col-sm-12 col-xs-12" name="apis" id="apis">Apis
                <option disabled selected hidden>- Selecciona la Api -</option>
                <?php echo $apisOption; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <button type="submit" class="btn btn-primary">Eliminar</button>
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