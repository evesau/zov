<?php echo $header; ?>
	<div class="x_title">
		<h1>Agregar Suscriptor</h1>
	  <div class="clearfix"></div>
  </div>
  
  <div class="panel-heading">&nbsp;</div>
  <form action="https://restapi.fromdoppler.com/accounts/jorge.manon%40airmovil.com/lists/1149662/subscribers?api_key=2B55B4D51DA0C1F6CF721687D4E8BF7F" method="POST">

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Email:</label>
        <input type="text" class="form-control" name="Email" id="Email">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Nombre:</label>
        <input type="text" class="form-control" name="Nombre" id="Nombre">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Apellido:</label>
        <input type="text" class="form-control" name="Apellido" id="Apellido">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Cumpleaños:</label>
        <input type="text" class="form-control" name="Cumpleaños" id="Cumpleaños">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Sexo:</label>
        <input type="text" class="form-control" name="Sexo" id="Sexo">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Phone:</label>
        <input type="text" class="form-control" name="phone" id="phone">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Fecha Limite:</label>
        <input type="text" class="form-control" name="fechaLimite" id="fechaLimite">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label>Fecha Corte:</label>
        <input type="text" class="form-control" name="fechaCorte" id="fechaCorte">
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <br>
        <input type="button" id="btnAgregar" class="btn btn-success" value="Agregar">
    </div>

  </form>

  <div id="response">
      
  </div>
<?php echo $footer; ?>
