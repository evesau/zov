<?php echo $header;?>
<!--/Header-->
<!--Body-->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile fixed_height_240">
        <div class="x_title">
            <h1>Apis</h1>
            <div class="clearfix"></div>
        </div>
        <div class="alert alert-warning alert-dismissible fade in" role="alert" style="color: black;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>Importante!</strong>
              Selecciona las campañas que se desean utilizar con las apis, al seleccionar la campaña, se agregara automaticamente 
        </div>
      <div class="x_content">
        <form action="/apis/delete_apis" method="POST" id="delete_form">
            <div class="row">



            <!-- segunda tabla -->

                <div class="form-group">
                  <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="campaign">
                      <thead>
                        <tr>
                          <th><input type="checkbox" name="checkAll" id="checkAll" value=""/></th>
                          <th>Id Campaña</th>
                          <th>Campaña</th>
                          <th>Carriers</th>
                          <th>Short Code</th>
                          <th>Type</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php echo $tablaCampaign; ?>
                      </tbody>
                    </table>
                  </div>

                </div>


              <!-- segunda tabla-->

              <div class="col-lg-12">
                <div class="alert alert-warning alert-dismissible fade in" role="alert" style="color: black;">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <strong>Importante!</strong>
                  El uso del api quedaría de la siguiente manera:
                  https://smsmkt.amovil.mx/SendMt/sendGet?usuario=<strong>{usuario}</strong>&pwd=<strong>{password}</strong>&msisdn=<strong>{destino}</strong>&msj=<strong>{mensaje}</strong>&source=<strong>{marcacion}</strong>&campaign=<strong>{id_campa&ntilde;a}</strong><br>
                  <strong style="color: red;" >Nota: Sustituir los campos en la url</strong>
                  <strong>{destino} -></strong> 525512345678
                  <strong>{mensaje} -></strong> Mensaje test
                  <strong>{usuario} -></strong> usario dado de alta en api web
                  <strong>{password} -></strong> password del usuario para api web<br>
                  <strong style="color: red;" >Nota: La API usa Basic Athentication : </strong><strong>usuario: {4iM0v1L2oS28$} - </strong> <strong>password: {C4as4.$KkK9}</strong>
                </div>


<!-- /**********************TABLA DE NAVEGACION DE PETICIONES CURL Y PHP*********************************/ -->
</div>
              <!--div class="table-bordered"-->
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                     <h2><i class="fa fa-bars"></i> Documentación <span>API https://smsmkt.amovil.mx/SendMt/sendGet</span></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#curl" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Curl</a>
                        </li>
                        <li role="presentation" class=""><a href="#php" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">PHP</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="curl" aria-labelledby="home-tab" style="background: #2A3F54; color: white; border-radius: 5px; font-size: 12px;">
                          <p class="lead" style="margin:20px;">Peticion en Curl</p>
                          <p style="margin:20px;">
                          curl --request GET \<br>
                          --url 'https://smsmkt.amovil.mx/SendMt/sendGet?campaign={campaig_id}&source=59850&msj={Mensaje}&msisdn={destino}&pwd={password}&usuario={usuario}' \<br>
                          --header 'authorization: Basic NGlNMHYxTDJvUzI4JDpDNGFzNC4kS2tLOQ==' \<br>
                          --header 'content-type: text/plain'<br>
                          </p><br>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="php" aria-labelledby="profile-tab" style="background: #2A3F54; color: white; border-radius: 5px; font-size: 12px;">
                          <p class="lead" style="margin:20px;">Peticion en PHP</p>
                          <p style="margin:20px;">
                          &#60;&#63;php <br>
                          $curl = curl_init();<br>
                          curl_setopt_array($curl, array(<br>
                            CURLOPT_URL => "https://smsmkt.amovil.mx/SendMt/sendGet?campaign={campaig_id}&source=59850&msj={Mensaje}&msisdn={destino}&pwd={password}&usuario={usuario}",<br>
                            CURLOPT_RETURNTRANSFER => true,<br>
                            CURLOPT_ENCODING => "",<br>
                            CURLOPT_MAXREDIRS => 10,<br>
                            CURLOPT_TIMEOUT => 30,<br>
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,<br>
                            CURLOPT_CUSTOMREQUEST => "GET",<br>
                            CURLOPT_POSTFIELDS => "",<br>
                            CURLOPT_HTTPHEADER => array(<br>
                              "authorization: Basic NGlNMHYxTDJvUzI4JDpDNGFzNC4kS2tLOQ==",<br>
                              "content-type: text/plain"<br>
                            ),<br>
                          ));<br>
  <br>
                          $response = curl_exec($curl);<br>
                          $err = curl_error($curl);<br>
  <br>
                          curl_close($curl);<br>
  <br>
                          if ($err) {<br>
                            echo "cURL Error #:" . $err;<br>
                          } else {<br>
                            echo $response;<br>
                          }<br>
                          </p><br>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              </div>
              
<!-- /**********************FIN TABLA DE NAVEGACION DE PETICIONES CURL Y PHP*********************************/ -->
              <div class="row" >
                <div lass="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="x_content"></div>
                  <div class="panel panel-default">
                    <div class="col-lg-12">
                      
                    </div>
                    <div class="col-lg-12">
                      <div class="alert alert-warning alert-dismissible fade in" role="alert" style="color: black;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <p>
                          <strong>Importante!</strong> La api de seguimiento de los sms enviados debe usarse de la siguente manera
                          https://smsmkt.amovil.mx/Smsstatus?user=<strong>{usuario}</strong>&pass=<strong>{password}</strong>&sms_id=<strong>{smsid}</strong>
                        </p>
                        <p>
                          <strong style="color: red;">Nota:</strong> Sustituir 
                          <strong>{usuario} -></strong> usuario dado de alta en api web
                          <strong>{password} -></strong> password dado de alta en api web
                          <strong>{smsid} -></strong> el id obtenido con la api de SendGet
                        </p>
                        <p>
                          <strong style="color: red;" >Nota: </strong> La API usa Basic Athentication,
                          <strong>usuario: {4iM0v1L2oS28$} - </strong> <strong>password: {C4as4.$KkK9}</strong>                          
                        </p>
                      </div>
                    </div>
                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="x_panel">
                                    <div class="x_title">
                                       <h2><i class="fa fa-bars"></i> Documentación <span>API https://smsmkt.amovil.mx/Smsstatus</span></h2>
                                      <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">


                                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                          <li role="presentation" class="active"><a href="#curl1" id="home-tab-1" role="tab" data-toggle="tab" aria-expanded="true">Curl</a>
                                          </li>
                                          <li role="presentation" class=""><a href="#phpseg" role="tab" id="profile-tab-seg" data-toggle="tab" aria-expanded="false">PHP</a>
                                          </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                          <div role="tabpanel" class="tab-pane fade active in" id="curl1" aria-labelledby="home-tab-1" style="background: #2A3F54; color: white; border-radius: 5px; font-size: 12px;">
                                            <p class="lead" style="margin:20px;">Peticion en Curl</p>
                                            <p style="margin:20px;">
                                            curl --request GET \<br>
                                            --url 'https://smsmkt.amovil.mx/Smsstatus?user=<strong>{usuario}</strong>&pass=<strong>{password}</strong>&sms_id=<strong>{smsid}</strong>' \<br>
                                            --header 'authorization: Basic NGlNMHYxTDJvUzI4JDpDNGFzNC4kS2tLOQ==' \<br>
                                            --header 'content-type: text/plain'<br>
                                            </p><br>
                                          </div>
                                          <div role="tabpanel" class="tab-pane fade" id="phpseg" aria-labelledby="profile-tab-seg" style="background: #2A3F54; color: white; border-radius: 5px; font-size: 12px;">
                                            
                                            <pre style="background: #2A3F54">
                                              <p style="color: white;">Peticion en PHP</p>
                                              <p style="color: white;">
    $curl = curl_init();
    curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://smsmkt.amovil.mx/Smsstatus?user=<strong>{usuario}</strong>&pass=<strong>{password}</strong>&sms_id=<strong>{smsid}</strong>",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_POSTFIELDS => "",
                  CURLOPT_HTTPHEADER => array(
                    "authorization: Basic NGlNMHYxTDJvUzI4JDpDNGFzNC4kS2tLOQ==",
                  "content-type: text/plain"
                  )
                )
              );

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    print_r("Error curl:".$err);
    } else {
    print_r(json_decode($response));
    }
                                            </p>
                                            </pre>
                                          </div>
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                                </div>
                        <!-- /.panel-body -->
                        <div class="panel-body">
                        <div class="panel-heading">
                        <div class="clearfix"></div>
                        <h2>Lista de Apis</h2>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <a href="/webapis/add" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                            <!--button id="delete" type="button" class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></button-->
                        </div>
                        
                        </div>
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="muestra-cupones">
                                    <thead>
                                        <tr>
                                            <!--th class="no-sort"><input type="checkbox" id="checkAll"/></th-->
                                            <th>Usuario</th>
                                            <th>Password</th>
                                            <th>Direcci&oacute;n IP Permitidas</th>
                                            <th style="text-align: center">Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php echo $table; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                        <div id="test">
                          
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>








                <div class="col-lg-12">
                  <div class="alert alert-warning alert-dismissible fade in" role="alert" style="color: black;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Importante!</strong> El Webhook debe contar con <strong>Basic Athentication</strong>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h2>Lista de tus WebHooks</h2>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" <?= $webhook_add_visible?>>
                      <a href="/apis/webHookAdd" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                    </div>
                    <!-- /.panel-body -->
                    <div class="panel-body">
                      <div class="dataTable_wrapper">
                          <table class="table table-striped table-bordered table-hover" id="muestra-cupones">
                              <thead>
                                  <tr>
                                      <!--th class="no-sort"><input type="checkbox" id="checkAll"/></th-->
                                      <th>Usuario</th>
                                      <th>Password</th>
                                      <th>URL</th>
                                      <th>Tipo WebHook</th>
                                      <th style="text-align: center">Editar</th>
                                  </tr>
                              </thead>
                              <tbody>
                                 <?php echo $webhook_table; ?>
                              </tbody>
                          </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <div id="test"></div>
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