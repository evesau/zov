<?php echo $header; ?>
<div class="row">
  <form class="form-horizontal" action="/LongCode/delete" method="POST" id="all" enctype="multipart/form-data">
    <div class="form-group">

      <div class="x_title">
        <br><br>
        <h1 class="page-header">Administración Campañas</h1>
        <div class="clearfix"></div>
        <div class="panel-body">
            <a href="/LongCode/add" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
            <button id="delete" type="submit" class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></button>
        </div>
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <table class="table table-bordered table-hover dataTable">
          <tr>
            <th></th>
            <th>MENSAJE</th>
            <th>FECHA</th>
            <th>TOTAL</th>
            <th>ACCIONES</th>
          </tr>
          <?php echo $tabla; ?>
        </table>
      </div>

    </div>
  </form>
</div>


<?php echo $footer; ?>
