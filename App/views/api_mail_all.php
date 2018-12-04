<?php echo $header; ?>
<div class="x_title">
  <h1>API MAIL</h1>
  <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
  <div class="panel-heading">&nbsp;</div>
    <div class="row panel-body" id="buscador">
      <form action="/ApiDoppler/showDetalle" method="POST" id="all">
        <div class="form-group">
          <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3" hidden>
              <label>Email Remitente:</label>
              <input type="text" class="form-control" name="fromEmail" id="fromEmail" value="<?= $campaign['email_sender']?>">
          </div>

          <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3" >
              <input type="button" class="btn btn-primary" name="btnEnviar" id="btnEnviar" value="Enviar">
          </div>
        </div>
      </form>
      <div id="response"></div>
    </div>
</div>
<?php echo $footer; ?>




















