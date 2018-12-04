<?php echo $header; ?>
	<div class="x_title">
		<h1>Editar Campaña</h1>
	  <div class="clearfix"></div>
  </div>
  
  <div class="panel-heading">&nbsp;</div>
  <form action="/ApiDoppler/campaignEdit" method="POST" id="edit" enctype="multipart/form-data">

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Nombre Campaña:</label>
        <input type="text" class="form-control" name="name" id="name" value="<?= $campaign['nombre']?>" readonly>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Nombre Remitente:</label>
        <input type="text" class="form-control" name="fromName" id="fromName" value="<?= $campaign['name_sender']?>" readonly>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Email Remitente:</label>
        <input type="text" class="form-control" name="fromEmail" id="fromEmail" value="<?= $campaign['email_sender']?>" readonly>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Asunto:</label>
        <input type="text" class="form-control" name="subject" id="subject" value="<?= $campaign['subject']?>" readonly>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Lista Suscriptores:</label>
        <select class="form-control" name="listId" id="listId">
            <?php echo $sListId; ?>
        </select>
    </div>

   <div class="col-md-6 col-sm-6 col-xs-6" id="automated_days" <?= $visible?>>
      <label class="col-md-12 col-sm-12 col-xs-12">Seleccionar los dias para enviar la campa&ntilde;a:</label>
      <?php echo $sDias; ?>
   </div>

   <div class="col-md-3 col-sm-3 col-xs-3" id="automated_options">
      <label class="col-md-12 col-sm-12 col-xs-12">Hora de salida:</label>
      <div class='input-group date' id='datetimepicker2'>
         <input type='text' class="form-control" name="hour_automated" id='hour_automated' value="<?= $fecha ?>" readonly/>
         <span class="input-group-addon" style="float:center;">
            <span class="glyphicon glyphicon-calendar"></span>
         </span>
      </div>
   </div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <br>
        <input type="submit" id="btnAgregar" class="btn btn-success" value="Guardar">
        <a href="/ApiDoppler/" class="btn btn-danger">Regresar</a>
        <input type="hidden" name="campaignId" id="campaignId" value="<?= $campaign['doppler_campaign_id']?>">
        <input type="hidden" name="campaign_parent_id" id="campaign_parent_id" value="<?= $campaign['doppler_campaign_parent_id']?>">
        <input type="hidden" name="shippingId" id="shippingId" value="<?= $campaign['shippingId']?>">
        <input type="hidden" name="status" id="status" value="<?= $campaign['status']?>">
        <input type="hidden" name="type" id="type" value="<?= $campaign['type']?>">
        <input type="hidden" name="type_shipping" id="type_shipping" value="<?= $type_shipping?>">
    </div>
  </form>

  <div id="response">      
  </div>
<?php echo $footer; ?>
