<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br>
        <h2> Editar mail</h2>
        <br>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" action="/Mail2sms/edit_mail2sms" method="POST" id="form">
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Mail:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="E-mail" name="mail" id="mail" value="<?php echo $mail; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Estatus</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="">
                <label>
                  <input type="checkbox" class="js-switch" name="status" id="status" <?php echo $checked; ?> /> Inactivo/Activo
                  <label style="color: red">*Si selecciona inactivo este mail no estar&aacute; disponible ni lo visualizara en la lista*</label>
                </label>
              </div>
            </div>
          </div>
          <!--div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">MT Máximos por mail</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="number" class="form-control" min="0" placeholder="1000" name="max_mail" id="max_mail" value="<?php echo $max_mail; ?>" required>
            </div>
          </div-->
          <!--div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">MT Máximos al día</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="number" class="form-control" min="0" placeholder="1000" name="max_dia" id="max_dia" value="<?php echo $max_dia; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">MT Máximos al mes</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="number" class="form-control" min="0" placeholder="10000" name="max_mes" id="max_mes" value="<?php echo $max_mes; ?>" required>
            </div>
          </div-->
          <div class="form-group">
            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Code y Carrier</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="select2_multiple form-control" multiple="multiple" name="shortcode_carrier[]">
                    <?php echo $show_shortcode_carrier; ?>
                  </select>
                  <label style="color: red">*Si este mail se le asigna m&aacute;s de un short code solo podra usar el ultimo agregado*</label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 col-sm-12 col-xs-12">Detalles para mail:</label>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="Defina caracter&iacute;sticas para este mail" name="detalle" id="detalle"  value="<?php echo $detalle; ?>" required>
              <input type="hidden" name="id" id="id"  value="<?php echo $id; ?>" >
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