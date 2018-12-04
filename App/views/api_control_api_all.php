<?php echo $header; ?>
<div class="x_title">
  <h1>Apis</h1>
  <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<div class="panel-heading">&nbsp;</div>
<div class="row panel-body" id="buscador">
    <form action="/ApiControl/ApiDelete" method="POST" id="all">
    <div class="form-group">
      <div class="panel-body">
        <a href="/ApiControl/ApiAdd"><span class="btn btn-success">Agregar Api</span></a>
        <button type="button" class="btn btn-danger " id="delete"><i class="fa fa-trash"></i> Eliminar</button>
      </div>
      <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="tabla_campaign" role="form" style="text-align: center;">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Nombre</th>
                      <th>URL</th>
                      <th>Status</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?= $tabla; ?>
                  </tbody>
                </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
</div>
<?php echo $footer; ?>