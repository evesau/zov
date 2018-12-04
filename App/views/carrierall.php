<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Carrier</h1>
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
                        	<a href="/carrier/add" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                        	<button id="delete" type="button" class="btn btn-danger btn-circle"><i class="fa fa-remove"></i></button>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="muestra-cupones">
                                    <thead>
                                        <tr>
                                            <th class="no-sort"><input type="checkbox" id="checkAll"/></th>
                                            <th>Nombre</th>
                                            <th>System Id</th>
                                            <th>Modo</th>
					    <th>Estatus</th>
					    <th>Carrier</th>
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
