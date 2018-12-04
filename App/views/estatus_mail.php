<?php echo $header; ?>
<!--/Header-->
<!--Body-->
	<div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12">
      		<div class="x_panel tile fixed_height_240">
        		<div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          			<h1 class="page-header">Estatus de su reporte enviado x correo</h1>
          			<div class="clearfix"></div>
          			<div class="list-group">
            			<strong class="list-group-item list-group-item-success" style="color: ;">Refresque esta pagina para ver el estatus de su reporte.</strong>
          			</div>
                <div class="list-group">
                  <strong class="list-group-item list-group-item-warning" style="color: ;">Nota: Revise se configuraci&oacute;n de mail para recibir archivos adjuntos grandes.</strong>
                </div>
          			<div class="row">
          			  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          			    	<div class="panel panel-default">
          			      		<div class="panel-heading"><h4 style="color: #73879C">Estatus reporte x mail</h4></div>
          			      		<div class="panel-body">
          			        		<div class="dataTable_wrapper">
          			          			<div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12">
          			            			<table class="table table-striped table-bordered table-hover" id="reporte_mail">
          			              				<thead>
          			                				<tr>
          			                  					<th>Fecha</th>
          			                  					<th>Correo</th>
          			                  					<th>Campaign Id</th>
          			                  					<th>Fecha Inicial</th>
          			                  					<th>Fecha Final</th>
          			                  					<th>Carrier</th>
          			                  					<th>Destination</th>
          			                  					<th>Source</th>
          			                  					<th>Estatus</th>
          			                  					<th>LoteID</th>
          			                  					<th>Proceso</th>
          			                  					<th>Acci&oacute;n</th>
          			                				</tr>
          			              				</thead>
          			            			</table>
          			          			</div>
          			        		</div>
          			      		</div>
          			    	</div>
          			  	</div>
          			</div>
          			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<a href="/ReportesmtCamp" class="btn btn-success" type="button" style="width: 100%; height: 100%;">Regresar a los reportes</a>
					</div>
        		</div><!-- /.col-lg-12 a -->
      		</div><!-- x_panel tile fixed_height_240 -->
    	</div><!-- col-md-12 col-sm-12 col-xs-12 -->
  	</div><!-- row a -->
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->