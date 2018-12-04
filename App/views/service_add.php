<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2> Crear un Servicio</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/Service/add_service" method="POST" id="form">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Campaña:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <select class="form-control col-md-12 col-sm-12 col-xs-12" name="campania" id="campania">Campaña
                <option disabled selected hidden>-Campañas- </option>
                <?php echo $campania_option; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Short Code:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <select class="form-control col-md-12 col-sm-12 col-xs-12" name="short_code" id="short_code">Short Code
                <option value="" disabled selected hidden>-Short Code-</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Titulo:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="Titulo" name="title" id="title">
            </div>
          </div>
          <div class="form-group">
            <label  class="col-md-12 col-sm-12 col-xs-12">Descripci&oacute;n:</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="text" class="form-control" placeholder="Descripci&oacute;n" name="description" id="description">
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Tipo de servicio:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <select class="form-control col-md-12 col-sm-12 col-xs-12" name="handler" id="handler">Handler
                <option disabled selected hidden>-Tipo de servicio- </option> 
                <option value="staticText">staticText</option>
                <option value="url">url</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Configuraci&oacute;n:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input class="form-control" placeholder="Configuraci&oacute;n" name="configuration" id="configuration">
            </div>
          </div>
          <br>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Keyword:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <textarea rows="1" cols="70" name="keywords" form="form">
keyword
              </textarea>
            </div>
            <!--h6>Nota: Cada palabra debe estar en diferente renglon.</h6-->
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