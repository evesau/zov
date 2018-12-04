<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h2> Campa&ntilde;as</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="/campania/delete_campania" method="POST" id="delete_form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        &nbsp;
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <a href="/campania/add" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                            <?php  echo $botonDelete ?>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="muestra-cupones">
                                    <thead>
                                        <tr>
                                            <th class="no-sort"><input type="checkbox" id="checkAll"/></th>
                                            <th>Id Campa&ntilde;a</th>
                                            <th>Nombre</th>
                                            <th>Delivery Date</th>
                                            <!-- <th>Status</th> -->
                                            <th>Accion</th>
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
