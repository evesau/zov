<?php echo $header; ?>
	<div class="x_title">
		<h1>Agregar Campaña</h1>
	  <div class="clearfix"></div>
  </div>
  
  <div class="panel-heading">&nbsp;</div>
  <form action="/ApiDoppler/campaignAdd" method="POST" id="add" enctype="multipart/form-data">

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Nombre Campaña:</label>
        <input type="text" class="form-control" name="name" id="name" value="Campania 1">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Nombre Remitente:</label>
        <input type="text" class="form-control" name="fromName" id="fromName" value="Jorge">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Email Remitente:</label>
        <input type="text" class="form-control" name="fromEmail" id="fromEmail" value="jorge.manon@airmovil.com">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Asunto:</label>
        <input type="text" class="form-control" name="subject" id="subject" value="Test 1 API">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Lista Suscriptores:</label>
        <select class="form-control" name="listId" id="listId">
            <?php echo $sListId; ?>
        </select>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Tipo Campaña:</label>
        <select class="form-control" name="type" id="type">
            <option value="scheduled">Programada</option>
            <option value="immediate">Inmediata</option>
            <option value="automated">Automatizada</option>
        </select>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3" id="automatica">
      <label>Automatización:</label>
      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
         <select class="form-control" name="type_automated" id="type_automated">
            <option value="">Selecciona una opción</option>
            <option value="semanal">Semanal</option>
            <option value="mensual">Mensual</option>
         </select>
      </div>
   </div>

   <div class="col-md-6 col-sm-6 col-xs-6" id="automated_days">
      <label class="col-md-12 col-sm-12 col-xs-12">Seleccionar los dias para enviar la campa&ntilde;a:</label>
      <?php echo $sDias; ?>
   </div>

   <div class="col-md-3 col-sm-3 col-xs-3" id="automated_options">
      <label class="col-md-12 col-sm-12 col-xs-12">Seleccionar la hora de salida:</label>
      <div class='input-group date' id='datetimepicker2'>
         <input type='text' class="form-control" name="muestra" id='muestra' />
         <input type='hidden' class="form-control" name="hour_automated" id='hour_automated' />
         <span class="input-group-addon" style="float:center;">
            <span class="glyphicon glyphicon-calendar"></span>
         </span>
      </div>
   </div>

   <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3" id="fechaCampaign">
      <label>Fecha Lanzamiento:</label>
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class='input-group date' id='datetimepicker'>
            <input type='text' class="form-control" name="scheduledDate" id='scheduledDate' />
            <span class="input-group-addon" style="float:center;">
               <span class="glyphicon glyphicon-calendar"></span>
            </span>
         </div>
      </div>
   </div>

   <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
      <label class="col-md-12 col-sm-12 col-xs-12 col-lg-12">Importar Plantilla:</label>
      <div class="col-md-9 col-sm-9 col-xs-9 col-lg-9">
         <input type="file" class="form-control" name="plantilla" id="plantilla">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
         <input type="button" class="btn btn-success" id="btnImportar" value="Importar">
      </div>
   </div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <label>Contenido:</label>
        <textarea class="form-control" name="content" id="content" rows="10"></textarea>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <br>
        <input type="button" id="btnAgregar" class="btn btn-success" value="Agregar">
        <a href="/ApiDoppler/" class="btn btn-danger">Regresar</a>
    </div>
  </form>

  <div id="response">      
  </div>
<?php echo $footer; ?>
