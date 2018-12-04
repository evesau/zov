<?php echo $header; ?>
	<div class="x_title">
		<h1>Agregar Lista</h1>
	  <div class="clearfix"></div>
  </div>
  
  <div class="panel-heading">&nbsp;</div>
  <form action="/ApiDoppler/importCSVSuscriptores" method="POST" id="add" enctype="multipart/form-data">

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
        <label class="col-md-12 col-sm-12 col-xs-12 col-lg-12">Accion:</label>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
         <select class="form-control" name="accion" id="accion">
           <option value="crear">Crear nueva lista</option>
           <option value="reemplazar">Reemplazar suscriptores</option>
         </select>
      </div>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3" id="contenedor_list_id">
        <label class="col-md-12 col-sm-12 col-xs-12 col-lg-12">Lista:</label>
        <div class="col-md-9 col-sm-9 col-xs-9 col-lg-9">
         <select class="form-control" name="list_id" id="list_id">
           <?php echo $sListId; ?>
         </select>
      </div>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3" id="contendor_list_nombre">
        <label>Nombre Lista:</label>
        <input type="text" class="form-control" name="name" id="name" value="Lista 1">
    </div>

   <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
      <label class="col-md-12 col-sm-12 col-xs-12 col-lg-12">Importar Suscriptores:</label>
      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
         <input type="file" class="form-control" name="suscriptores_list" id="suscriptores_list">
         <br>
      </div>

      <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
         <input type="button" class="btn btn-success" id="btnImportar" value="Importar">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
         <a href="/ApiDoppler/crearPlantilla/" class="btn btn-primary">Descargar Plantilla</a>
      </div>
   </div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <label>Contenido:</label>
        <textarea class="form-control" name="content" id="content" rows="10"></textarea>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <br>
        <input type="button" id="btnAgregar" class="btn btn-success" value="Agregar">
        <a class="btn btn-danger" href="/ApiDoppler/">Regresar</a>
    </div>
  </form>

  <div id="response">      
  </div>
<?php echo $footer; ?>
