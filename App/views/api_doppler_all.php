<?php echo $header; ?>
<div class="x_title">
  <h1>Campa&ntilde;as</h1>
  <div class="clearfix"></div>
</div>
<div class="alert alert-warning alert-dismissible fade in" role="alert" style="color: black;">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
  <strong>Importante!</strong>Debe seleccionar las campañas de las que desea visualizar los detalles de envío
</div>
<div class="clearfix"></div>
<div class="panel-heading">&nbsp;</div>
<div class="row panel-body" id="buscador">
    <form action="/ApiDoppler/showDetalle" method="POST" id="all">
    <div class="form-group">
      <div class="panel-body">
        <a href="/ApiDoppler/add"><span class="btn btn-success">Agregar Campaña</span></a>
        <button type="button" class="btn btn-primary" id="btnShow"> Ver Agrupamiento</button>
        <a href="/ApiDoppler/showGroups"><span class="btn btn-primary">Ver Grupos</span></a>
        <button type="button" class="btn btn-danger " id="delete"><i class="fa fa-trash"></i> Eliminar</button>
      </div>
      <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="tabla_campaign" role="form">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Id Campa&ntilde;a</th>
                      <th>Fecha de Creaci&oacute;n</th>
                      <th>Tipo Campa&ntilde;a</th>
                      <th>Nombre</th>
                      <th>Email Envío</th>
                      <th>Asunto</th>
                      <th>Estatus</th>
                      <th>Total Clicks</th>
                      <th>Abiertos</th>
                      <th>No abiertos</th>
                      <th>Rechazados Hard</th>
                      <th>Rechazados Soft</th>
                      <th>Entregados</th>
                      <th>Total</th>
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




















