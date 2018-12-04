<?php echo $header;?>
<!--/Header-->
<!--Body-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
        <div class="col-lg-12">
          <h1 class="page-header">Reporte MO General</h1>
          <div class="clearfix"></div>
        </div>

        <div class="row">
          <form id="reporte_mo_general" name="reporte_mo_general" action="/Reportes/generarExcelMOGeneral" method="POST" target="_blank">
          <div class="form-group col-md-12 col-sm-12 col-xs-12">

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Fecha Inicio:</label>
                <div class="col-md-9 col-sm-9 col-xs-6">
                  <div class="col-md-9 col-sm-9 col-xs-6 xdisplay_inputx form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left col-sm-12" id="fecha_inicio" name="fecha_inicio" aria-describedby="inputSuccess2Status2">
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>
            </div>
  
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Fecha Fin:</label>
                <div class="col-md-9 col-sm-9 col-xs-6">
                  <div class="col-md-9 col-sm-9 col-xs-6 xdisplay_inputx form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left col-sm-12" id="fecha_fin" name="fecha_fin" aria-describedby="inputSuccess2Status2">
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Source:</label>
                <div class="col-md-9 col-sm-9 col-xs-6">
                  <input type="text" class="form-control" placeholder="Source" name="source" id="source">
                </div>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Destination:</label>
                <div class="col-md-9 col-sm-9 col-xs-6">
                  <input type="text" class="form-control" placeholder="Destination" name="destination" id="destination">
                </div>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Content:</label>
                <div class="col-md-9 col-sm-9 col-xs-6">
                  <input type="text" class="form-control" placeholder="Content" name="keyword" id="keyword">
                </div>
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" value="<?php echo $in; ?>" id="in" name="in">
                <input type="button" class="btn btn-info" value="Aplicar" id="btnAplicar" name="btnAplicar">
                <input type="button" class="btn btn-success" value="Descargar Excel" id="btnExcel" name="btnExcel">
            </div>

          </div>
          </form>
      </div>

          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading">&nbsp;</div>
              <div class="panel-body">
                <div class="datable_wrappaTer">
                  <table class="table table-striped table-bordered table-hover" id="reporte_mo">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Content</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>

<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
