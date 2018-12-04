<!-- Header -->
<?php echo $header;?>
<!--/Header -->

	<!-- page content -->
	<div class="" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Board</h3>
				</div>
			</div>
		</div>

		<div class="clearfix"></div>

		<div class="row">
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Lista de customer <small>Cantidad</small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Settings 1</a></li>
									<li><a href="#">Settings 2</a></li>
								</ul>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="">
							<div class="row tile_count">
								<div class="col-md-12 col-sm-12 col-xs-12 tile_stats_count">
									<h2><i class="fa fa-building"></i> Customer Administrador: <?php echo $setInfoMasterCustomer['user_name']; ?></h2>
									<span class="count_top"><i class="fa fa-building-o"></i> Total Customer asociados</span>
									<div class="count"><?php echo $setInfoMasterCustomer['count'] ?></div>
									<p>Lista de customers</p>
									<?php echo $setAllListCustomerAsigned; ?>
								</div>
							</div>
							<ul class="to_do">
								<h2>Administrador</h2>
								<?php echo $setCustomerUserMaster; ?>
							</ul>
							<ul class="to_do">
								<h2>Clientes customer</h2>
								<?php echo $setListCustomers; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-8 col-sm-12 col-xs-12">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Reporte por<small> CUSTOMER	</small></h2>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="heard">Selecciona el customer:</label>
									<select class="form-control" id="content-select-report-customers">
										<?php echo $setSelectOptionCustomers; ?>
									</select>
								</div> <br><br><br><br>
							</div>
							<div id="content-select-report"></div>

							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-12">
									<div class="form-group">
										<label>Selecciona el mes que deseas ver la cantidad de envios</label>
										<select class="select2_multiple form-control" id="select-month">
											<?php echo $months; ?>
										</select>
									</div>
								</div>
								
								<div id="content-report-month-before" style="text-align: center;">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h3><img src="/img/rotating-balls-spinner.gif" height="40px" width="40px"  alt=""> <b>Cargando contenido</b></h3>
									</div>
								</div>
								
								<div id="content-report-month"></div>
								
							</div>
						</div>
					</div>
				</div>


				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Reporte GENERAL<small> CUSTOMERS	</small></h2>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-12">
									<div class="form-group">
										<label>Selecciona el mes que deseas ver el total </label>
										<select class="select2_multiple form-control" id="select-month-all">
											<?php echo $months; ?>
										</select>
									</div>
								</div>
								
								<div id="content-report-month-before-all" style="text-align: center;">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h3><img src="/img/rotating-balls-spinner.gif" height="40px" width="40px"  alt=""> <b>Cargando contenido</b></h3>
									</div>
								</div>
								
								<div id="content-report-month-all"></div>
								
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- /page content -->


<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->