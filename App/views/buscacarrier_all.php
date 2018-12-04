<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2> Clientes</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      	<form action="/buscacarrier/delete" method="POST" id="delete_form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						&nbsp;
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<a href="/buscacarrier/add" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                        	<button id="delete" type="button" class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></button>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="muestra-client">
                                    <thead>
                                        <tr>
                                            <th class="no-sort"><input type="checkbox" id="checkAll"/></th>
                                            <th>Nombre</th>
                                            <th>Status</th>
                                            <th style="text-align: center;">Total de registros</th>
                    					    <th>Action</th>
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
