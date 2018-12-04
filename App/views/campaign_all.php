<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Campaign</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
	   <form action="/carrier/delete" method="POST" id="delete_form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
				&nbsp;
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<a href="/campaign/add" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="muestra-cupones">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Modulo</th>
					    <th>Estatus</th>
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
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
