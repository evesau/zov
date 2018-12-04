<?php echo $header; ?>
<div class="row">
  
  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
    <div class="panel panel-default">
      <div class="x_title">
        <h1 class="page-header">Administración Dispositivos</h1>
      </div>
      <form name="all" id="all" action="/Device/delete" method="POST">
        <div class="panel-body">
          <a href="/Device/add" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
            <button id="delete" type="submit" class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></button>
        </div>
        <div class="panel-body">
          <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="muestra-cupones">
              <thead>
                <tr>
                  <th><input type="checkbox" name="checkAll" id="checkAll" value=""/></th>
                  <th>MSISDN</th>
                  <th>SISTEMA OPERATIVO</th>
                  <th>NOMBRE</th>
                  <th>CUENTA</th>
                  <th>STATUS</th>
                  <th>SEXO</th>
                  <th>ACCIONES</th>
                </tr>
              </thead>
              <tbody>
                <?= $tabla; ?>
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>

