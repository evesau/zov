<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2>Reporte Global</h2>
        <br><br>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      	<form action="/Reporteglobal/descargarReporte" method="POST" id="buscar_form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						&nbsp;
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<!--a href="/listaclient/add" type="button" class="btn btn-primary btn-circle" title="Agregar"><i class="fa fa-plus"></i></a-->
                        	<!--button id="delete" type="button" class="btn btn-danger btn-circle" title="Eliminar"><i class="fa fa-trash-o"></i></button-->
                            <a type="button" id="descargarReporte" name="descargarReporte" class="btn btn-success btn-circle" title="Descargar reporte" ><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            <!--a href="/reporteglobal" type="button" class="btn btn-warning btn-circle" title="Ver Reporte Global"><i class="fa fa-file-text-o" aria-hidden="true"></i></a-->
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label >Key Santander:</label>
                                    <input type="text" class="form-control" placeholder="Key Santander" name="key_santander" id="key_santander" >
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label >N&uacute;mero:</label>
                                    <input type="text" class="form-control" placeholder="N&uacute;mero a 10 d&iacute;gitos" name="msisdn" id="msisdn" maxlength="10" minlength="10" >
                                </div>
                                <!--div class="col-md-4 col-sm-4 col-xs-4">
                                    <label >Campa&ntilde;a:</label>
                                    <input type="text" class="form-control" placeholder="Campa&ntilde;a" name="campania" id="campania" >
                                </div-->
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label>Selecciona la o las Campa&ntilde;as</label>
                                    <select class="select2_multiple form-control" multiple="multiple" name="campania[]" id="campania">
                                        <?php echo $show_campanias; ?>
                                    </select>
                                </div>
                                <!--div class="col-md-3 col-sm-3 col-xs-3">
                                    <label >Total:</label>
                                    <input type="text" class="form-control" placeholder="Total" name="total" id="total" >
                                </div-->
                                <br>                                
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label>Fecha Inicial:</label>
                                        <div class='input-group date'>
                                            <input type='text'  placeholder="Fecha inicial" class="form-control"  id='datetimepicker1' name="fecha_inicial" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        <label>Si no ingresas Fecha Inicial se tomar&aacute; la actual</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label>Fecha Final:</label>
                                        <div class='input-group date' >
                                            <input type='text' placeholder="Fecha final" class="form-control" id='datetimepicker2' name="fecha_final" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        <label>Si no ingresas Fecha Final se tomar&aacute; la actual</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <button type="button" class="btn btn-primary pull-right" title="Buscar" id="btnBuscar">
                                        <i class="fa fa-search" aria-hidden="true"></i>Buscar
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="muestra_reporte">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Key Santander</th>
                                            <th>N&uacute;mero</th>
                                            <th>Campa&ntilde;as</th>
                                            <th>Total de SMS</th>                                            
                    					    <th>Direction</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					                   <?php echo $table; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
	    </form>
      </div>
    </div>
  </div>
</div>
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
