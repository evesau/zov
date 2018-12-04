<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2> Guardar Bad Word</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/Badword/add_word" method="POST" id="form">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Word:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="Bad word" name="word" id="word" required>
            </div>
          </div>
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