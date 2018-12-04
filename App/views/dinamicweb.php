<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2>Lista de n&uacute;meros con url dinamica</h2>
        <br><br>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      	<form action="/dinamicweb/delete" method="POST" id="delete_form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						&nbsp;
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<a href="/dinamicweb/add" type="button" class="btn btn-primary btn-circle" title="Agregar"><i class="fa fa-plus"></i></a>
                        	<button id="delete" type="button" class="btn btn-danger btn-circle" title="Eliminar"><i class="fa fa-trash-o"></i></button>
                            <a href="/dinamicweb/seleccionaCliente" type="button" class="btn btn-success btn-circle" title="Realizar env&iacute;o">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                            </a>
                            <!--a href="/reporteglobal" type="button" class="btn btn-warning btn-circle" title="Ver Reporte Global"><i class="fa fa-file-text-o" aria-hidden="true"></i></a-->
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="muestra-client">
                                    <thead>
                                        <tr>
                                            <th class="no-sort"><input type="checkbox" id="checkAll"/></th>
                                            <th>Fecha</th>
                                            <th>N&uacute;mero</th>
                    					    <th>Identificador web</th>
                                            <th class="text-center">Acciones</th>
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
