<?php echo $header;?>
<div class="row">
  <form id="form" class="form-horizontal">

    <div class="x_title" >
      <br><br>
      <h1 class="page-header">Envio de Mensajes Push</h1>
      <div class="clearfix"></div>
      <br><br>
    </div>

    <div class="form-group ">

      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-4">
        <label> Tipo:</label>
        <select class="form-control" name="tipo" id="tipo" >
          <option value="1"> Envio de Nomina </option>
          <option value="2"> Transacción </option>
          <option value="3"> Alta de Servicio </option>
        </select>
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-4">
        <label> Titulo:</label>
        <input class="form-control" type="text" name="titulo" id="titulo" />
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-4">
        <label> Texto:</label>
        <input class="form-control" type="text" name="texto" id="texto" />
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-4">
        <label> Imagen:</label>
        <input class="form-control" type="text" name="imagen" id="imagen" />
      </div>

      <div id="contenedor"></div>

      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" >
        <br>
        <input class="btn btn-success" type="button" name="btnEnviar" id="btnEnviar" value="Enviar Push">
      </div>

    </div>
  </form>
</div>
<?php echo $footer;?>
<!--/Footer-->
