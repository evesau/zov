<?php echo $header;?>
<!--/Header-->
<!--Body-->
  <div class="row">

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <h1>Numeros de pruebas </h1>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><b><?php echo $titulo_add_edit; ?></b></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
              <li><a class="collapse-link collapse-link-1"><i class="fa fa-chevron-up"></i></a></li>
            </ul>

            <div class="clearfix"></div>

          </div>

          <div class="x_content">

            <div id="result"></div>
            <br />
            <form id="form-add-msisdn1" data-parsley-validate class="form-horizontal form-label-left" action="/Sembrados/<?php echo $accion ?>/" method="POST">
              <div class="form-group">
                <input type="hidden" name="msisdn_sembrado_id" value="<?php echo $msisdnId ?>">
                <label class="control-label col-md-1 col-sm-1 col-xs-3" for="telefono">Telefono</label>
                <div class="col-md-3 col-sm-3 col-xs-3">
                  <input type="text" id="telefono" name ="telefono" placeholder="5511223344"  class="form-control col-md-7 col-xs-3" maxlength="10" minlength="10"  value="<?php echo $msisdn ?>">
                </div>
                <label class="control-label col-md-1 col-sm-1 col-xs-3" for="identificador">Identificador </label>
                <div class="col-md-3 col-sm-3 col-xs-3">
                  <input type="text" id="identificador" name="identificador" placeholder="Ingresa un Nombre" class="form-control col-md-7 col-xs-12" value="<?php echo $identificador ?>">
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                  <input type="submit" value="<?php echo $btn_add_edit ?>" id="add-msisdn" class="btn <?php echo $btn_alert; ?> col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>

              <div class="form-group">
              </div>

            </form>
          </div>

        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><b> Registro de los numeros telefonicos de pruebas </b></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>

            <div class="clearfix"></div>

          </div>

          <div class="x_content">

          <form role="form" id="servicios" method="POST" action="/Sembrados/delete">
            <div class="buttons">
              <button type="button" id="delete" class="btn btn-danger btn-sm">
                <span class="fa fa-remove"> Eliminar </span>
              </button>
              <button style=" <?php echo $display; ?>" type="button" id="addMsisdn" class="btn btn-success btn-sm">
                <span class="fa fa-plus"> Agregar </span>
              </button>
              <?php echo $btnAdd; ?>
            </div>
            <div class="panel-body">
              <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="datatable-checkbox">
                  <thead>
                    <tr>
                      <th><input type="checkbox" name="checkAll" id="checkAll" value=""/></th>
                      <th>#</th>
                      <th>Identificador</th>
                      <th>Numero</th>
                      <th>Compa&ntilde;ia telef&oacute;nica</th>
                      <th>Acci&oacute;n</th>
                    </tr>
                  </thead>
                  <tbody id="tabla-consulta" >
                    <?php echo $tabla; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </form>
          </div>

        </div>
      </div>
    </div>
            
    
  
  </div>


<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
