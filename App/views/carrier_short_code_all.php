<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Short Code</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
				<h3>Add Short Code</h3>
                        </div>
			<div class="panel-body">
			<div class="x_content">
                    	<br />
                    	    <form  id="add" class="form-horizontal form-label-left input_mask" enctype="multipart/form-data" action="/carrier/addShortCode" method="POST">

                      	    	<div class="form-group">
                        	    <label class="control-label col-md-1 col-sm-3 col-xs-12">Marcacion</label>
                        	    <div class="col-md-11 col-sm-9 col-xs-12">
                          	    <input type="text" class="form-control" placeholder="Numero Corto" name="nombre" id="nombre">
                        	    </div>
                      		</div>
				<br />

				<div class="ln_solid"></div>

                      		<div class="form-group">
                        	    <div class="col-md-12 col-sm-9 col-xs-12">
                          	    	<button type="submit" class="btn btn-success pull-right">Agregar</button>
                        	    </div>
                      		</div>
			    </form>
			</div>
			</div>
		    </div>
		    <div class="panel panel-default">

                        <!-- /.panel-heading -->
                        <!-- /.panel-body -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="muestra-cupones">
                                    <thead>
                                        <tr>
                                            <th>Short Code</th>
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
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
