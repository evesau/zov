<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <h1>Mail2sms</h1>
        <div class="clearfix"></div>
      </div>
      <div class="alert alert-warning alert-dismissible fade in" role="alert" style="color: black;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <strong>Importante!</strong>
          <p>Este m&oacute;dulo permite enviar sms a trav&eacute;s de un correo electr&oacute;nico el cual debe ser enviado con el siguiente formato:</p>
            <p>email: mail2sms@smppfuenf.amovil.mx</p>
            <p>Asunto:Mensaje a enviar con una longitud máxima de 160 caracteres</p>
            <p>Contenido del mensaje: |5512345678|telcel|n&uacute;mero2|telcel|......|n&uacte;mero|telcel|</p>
      </div>
      <div class="x_content">
        <form action="/mail2sms/delete_mail2smsList" method="POST" id="delete_form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <h2>Mail2sms List</h2>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <a href="/mail2sms/add" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                            <!--button id="delete" type="button" class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></button-->
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="muestra-cupones">
                                    <thead>
                                        <tr>
                                            <!--th class="no-sort"><input type="checkbox" id="checkAll"/></th-->
                                            <th>Fecha</th>
                                            <th>Mail</th>
                                            <th>Carrier Connection Short Code</th>
                                            <th>Acci&oacute;n</th>
                                            <th>Editar</th>
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
