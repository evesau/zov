<?php echo $header;?>
<div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile fixed_height_240">
         <div class="col-lg-12">
            <h1 class="page-header"> Generar Reporte MT Api Web Test</h1>
            <div class="clearfix"></div>
            <div class="row" id="reportemt">
               <div class="col-lg-12">
               <!--/**********ENCABEZADO**********/-->
               <div class="x_content">
                  <label class="col-md-12 control-label">Selecciona la campaña de la que deseas generar el reporte. </label>
                  <br>
                  <form role="form" id="mt_api" method="POST" action="/Reportesapi/reporte_mt_api">
                     <div class="form-group row" style="margin-top: 2%;">
                        <label class="col-md-2 control-label">Campaña:  </label>
                        <br>
                        <div class="col-md-12 col col-sm-12">
                        
                             <select class="form-control" onChange="actualizarDataTable()" id="id_campania" name="reporte">
                               <option value="" disabled selected>Campaña -- Short Code</option>
                                 <?php echo $select; ?>
                             </select>
                           
                        </div>
                    </div>

                    <div class="form-group row" style="margin-top: 2%;">
                        
                        <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1">Carrier:</label>
                        <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                           <input class="form-control" id="carrier" name="carrier" type="text">
                        </div>

                        <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1">Destination:</label>
                        <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                           <input class="form-control" id="destination" name="destination" type="text">
                        </div>

                        <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1">Source:</label>
                        <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                           <input class="form-control" id="source" name="source" type="text">
                        </div>

                        <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1">Estatus:</label>
                        <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                           <select class="form-control" id="estatus" name="estatus">
                              <option></option>
                              <option value="ACCEPTD">Acceptd</option>
                              <option value="delivered">Delivered</option>
                              <option value="queued">Queued</option>
                              <option value="blacklist">Blacklist</option>
                              <option value="preparado para envio">preparado para envio</option>
                              <option value="error">Error</option>
                              <option value="REJECTD">Rejectd</option>
                           </select>
                        </div>
                     </div>

                     <div class="form-group row" style="margin-top: 2%;">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                           <div class="control-group">
                              <div class="controls">
                                 <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 xdisplay_inputx form-group has-feedback" style="width: 20%">
                                    <label class="">Fecha Inicial: </label>
                                 </div>
                                 <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 xdisplay_inputx form-group has-feedback" style="width: 80%">
                                    <input class="form-control has-feedback-left" id="datetimepicker4" placeholder="Fecha inicial" name="datetimepicker4" aria-describedby="inputSuccess2Status2" required="" type="text">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                           <div class="control-group">
                              <div class="controls">
                                 <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 xdisplay_inputx form-group has-feedback" style="width: 20%">
                                    <label class="">Fecha Final: </label>
                                 </div>
                                 <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 xdisplay_inputx form-group has-feedback" style="width: 80%">
                                    <input class="form-control has-feedback-left" id="datetimepicker5" placeholder="Fecha final" name="datetimepicker5" aria-describedby="inputSuccess2Status2" required="" type="text">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </div>

                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button id="btnDescargar" style="width: 100%;" type="button" class="btn btn-success pull-right">
                           <span class="fa fa-download"></span> Descargar Detalle
                        </button>
                     </div>


                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button id="btnBuscar" style="width: 100%;" type="button" class="btn btn-primary pull-right">
                           <span class="glyphicon glyphicon-search"></span> Buscar
                        </button>
                     </div>

                     <div class="row">
                        <div class="col-lg-12">
                           <div class="panel panel-default">
                              <div class="panel-heading">&nbsp;</div>
                              <div class="panel-body">
                                 <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="reporte_mt">
                                       <thead>
                                          <tr>
                                             <th>Fecha</th>
                                             <th>Carrier</th>
                                             <th>Destination</th>
                                             <th>Source</th>
                                             <th>Content</th>
                                             <th>Estatus</th>
                                          </tr>
                                       </thead>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               <!--/**********ENCABEZADO**********/-->
<?php echo $footer;?>
   