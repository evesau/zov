<?php echo $header; ?>
<!--/Header-->
<!--Body-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
        <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h1 class="page-header">Reporte MT x mail</h1>
          <div class="clearfix"></div>
          <div class="list-group">
            <strong class="list-group-item list-group-item-success" style="color: ;">Ingrese una cuenta correo al que se enviara el reporte.</strong>
          </div>
          <form id="formulario_enviar_mail" action="#" method="post">
            <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="panel panel-default">
                <div class="x_content"></div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"-->
                    <div class="form-group">
                      
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Correo:</strong>
                          <input class="form-control" id="correo" name="correo" type="text" required />
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" hidden="true">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Customer:</strong>
                          <input class="form-control" id="customer_id" name="customer_id" type="text" disabled="true" value="<?php echo "$data->customer_id"; ?>" />
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" hidden="true">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Campaign_id:</strong>
                          <input class="form-control" id="campaign_id" name="campaign_id" type="text" disabled="true" value="<?php echo "$data->campaign_id"; ?>" />
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Fecha Inicial:</strong>
                          <input class="form-control" id="fecha_inicio" name="fecha_inicio" type="text" disabled="true" value="<?php echo "$data->fecha_inicio"; ?>" />
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Fecha Final:</strong>
                          <input class="form-control" id="fecha_fin" name="fecha_fin" type="text" disabled="true" value="<?php echo "$data->fecha_fin"; ?>" />
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Carrier:</strong>
                          <input class="form-control" id="carrier" name="carrier" type="text" disabled="true" value="<?php echo "$data->carrier"; ?>" />
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Destination:</strong>
                          <input class="form-control" id="destination" name="destination" type="text" disabled="true" value="<?php echo "$data->destination"; ?>" />
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Lote Id:</strong>
                          <input class="form-control" id="loteid" name="loteid" type="text" disabled="true" value="<?php echo "$data->loteid"; ?>" />
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Source:</strong>
                          <input class="form-control" id="source" name="source" type="text" disabled="true" value="<?php echo "$data->source"; ?>" />
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="list-group">
                          <strong class="list-group-item list-group-item-success form-control" style="color: white; background:#81A6CC !important">Estatus:</strong>
                          <input class="form-control" id="estatus" name="estatus" type="text" disabled="true" value="<?php echo "$data->estatus"; ?>" />
                        </div>
                      </div>
                      
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                        <div class="list-group">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button id="enviar" class="btn btn-success" type="submit" style="width: 100%; height: 100%;">
                            <span class="glyphicon glyphicon-send" ></span> Enviar</button>
                          </div>
                        </div>
                      </div>                          
                    </div>
                      <!-- Fin Buscador -->
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div><!-- /.col-lg-12 a -->
      </div><!-- x_panel tile fixed_height_240 -->
    </div><!-- col-md-12 col-sm-12 col-xs-12 -->
  </div><!-- row a -->
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
