
<?php echo $header; ?>
<div class="container body">
	<div class="main_container">

		<!-- page content -->
		<div class="" role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<h3>Configuración de PIN</h3>
					</div>
				</div>
				<div class="clearfix"></div>

				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
              <div class="x_content" style="text-align: center; padding: 50px;">
                <span class="fa fa-eye" style="font-size: 44px; color: #c1c1c1;"> </span>
                <span class="fa fa-mobile" style="font-size: 44px; color: #c1c1c1;"> </span>
                <span class="fa fa-paper-plane" style="font-size: 44px; color: #c1c1c1;"> </span>
                <p><br>
                  <h3> Vista general de PIN</h3>
                  <h2>Dentro de esta sección se visualiza el PIN de envío por SMS/RCS</h2>
                </p>

                <p><br>
                  <a href="/Config/edit" class="btn btn-success">Modificar PIN</a>
                </p>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <form id="myForm">
                    <input type="radio" name="radioName" value="SMS" checked /> Vista de SMS 
                    <input type="radio" name="radioName" value="RCS" /> Vista de RCS
                  </form>
                </div>

              </div>
            </div>
						<div class="x_panel">
              <div class="x_title">
                <h2>PIN <small>Configuración de PIN</small></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <form class="form-horizontal form-label-left input_mask">

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                      <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Email" value="Marca del mensaje: <?php echo $data_pin['pin_marca'] ?>" readonly="readonly">
                      <span class="fa fa-certificate form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                      <input type="text" class="form-control" id="inputSuccess5" value="Hora de creación: <?php echo $data_pin['ctime'] ?> " readonly="readonly">
                      <span class="fa fa-clock-o form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de PIN(s)</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" readonly="readonly" value="<?php echo $data_pin['pin_tipo'] ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Logitud de PIN(s)
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" readonly="readonly" value="<?php echo $data_pin['pin_longitud'] ?> caracteres">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Expiracion PIN
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" readonly="readonly" value="<?php echo "{$data_pin['pin_expiracion']} {$data_pin['pin_expiracion_tipo']}" ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Mensaje SMS</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <textarea type="text" class="form-control" readonly="readonly"><?php echo $data_pin['mensaje_rcs'] ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Mensaje RCS</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <textarea type="text" class="form-control" readonly="readonly"><?php echo $data_pin['mensaje_rcs'] ?></textarea>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                      <!--div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary">Cancel</button>
  						            <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div-->
                  </form>
                </div>
              </div>
            </div>
					</div>

          <div class="col-md-6 col-sm-6 col-xs-12">

            
              <div class="row" style="margin:0px 100px 0px 100px; background: #f6f6f6">
                <h2 class="StepTitle">Vista SMS/RCS</h2>
                <div class="col-md-12 col-xs-12 col-sm-12" style="">
                  <div class="smartphone">
                    <div class="smartphone-header">
                      <ul class="li-content">
                        <li> 100% </li>
                        <li> <span class="fa fa-clock-o"></span> </li>
                        <li> <span class="fa fa-wifi"></span> </li>
                        <li> <span class="glyphicon glyphicon-tent"></span></li>
                      </ul>
                    </div>
                    <div class="content-sms-top" id="top-sms">
                      <div class="content-sms-msg-in"><span class="glyphicon glyphicon-chevron-left" style="color:#111;"></span></div>
                      <div class="content-sms-msg-in-shorcode"><b>24766</b></div>
                      <div class="content-sms-msg-in"><span class="glyphicon glyphicon-option-vertical" style="color:#111;"></span></div>
                    </div>
                    <div class="content-sms-top" id="top-rcs">
                      <div class="content-sms-msg-in"><span class="glyphicon glyphicon-chevron-left" style="color:#111;"></span></div>
                      <div class="content-sms-msg-in-name"><b>SKY</b></div>
                      <div class="content-sms-msg-in"><span class="glyphicon glyphicon-option-vertical" style="color:#111;"></span></div>
                      <div class="content-sms-msg-in"><span class="fa fa-shield" style="color:#111;"></span></div>
                    </div>
                    <div class="line"></div>

                    <div class="content-sms-date" id="content-sms" style="height: 78%;">
                      <div style="position: absolute; bottom: 70px;left: 0; width: 100%;">
                        <p class="content-sms-hour" style=" width: 100%;"><?php echo $fecha ?></p>
                        <div class="content-sms-icon" >
                          <span class="fa fa-user" style="color:#8eadd8;font-size: 25px;background:#1a3776;border-radius: 50%; margin: 10px; padding: 10px; "></span>
                        </div>
                        <div class="content-sms-content"><span id="mensaje-sms-pin"><?php echo $sms_set['mensaje_muestra'] ?></span> </div>
                      </div>
                    </div>

                    <div id="content-top-rcs" style="text-align: center; height: 78%; background: #f6f6f6;">
                      <img src="https://i.blogs.es/826560/sky/450_1000.png" class="content-rcs-img"  alt="">
                      <p class="content-rcs-description">Descripcion de SKY: Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere vero tempora nobis </p>
                      <div class="line"></div>
                      <div style="position: absolute; bottom: 70px;left: 0; width: 100%;">
                        <div id="content-rcs" style="margin-left: 10px; margin-right: 10px;">
                          <p class="content-sms-hour" style=" width: 100%;"><?php echo $fecha ?></p>
                          <div class="content-card-img">
                            <h1 class="content-card-img-text"> <p class="content-card-pin"><?php echo $rcs_set['pin'] ?><span id="set-pin-rcs"></span></p></h1>
                          </div>
                          <div class="content-card-pin-info">
                            <p><b><span id="mensaje-rcs-pin"><?php echo $rcs_set['mensaje_muestra'] ?></span> </b></p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="content-sms-msg">
                      <div class="content-sms-msg-in"><span class="fa fa-plus-circle" class="content-sms-msg-icon"></span></div>
                      <div class="content-sms-msg-text">Mensaje de texto</div>
                      <div class="content-sms-msg-in"><span class="fa fa-paper-plane-o" style="color:#111;"></span></div>
                    </div>

                    <div class="content-control">
                      <div class="content-control-button">
                        <span class="glyphicon glyphicon-modal-window"></span>
                      </div>
                      <div class="content-control-button">
                        <span class="glyphicon glyphicon-unchecked"></span>
                      </div>
                      <div class="content-control-button">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                      </div>
                    </div>
                  </div>          
                </div>
              </div>
            
          </div>
				</div>
			</div>
		</div>
		<!-- /page content -->
	</div>
</div>
<?php echo $footer; ?>