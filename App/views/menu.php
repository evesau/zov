<?php echo $header;?>
<!--/Header-->
<!--Body-->
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="overflow-x:auto;">
                    <h1 class="page-header"><?php echo "Bienvenido " . $_SESSION['usuario']; ?></h1>
                    <!--<?php print_r($_SESSION) ?>-->
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" id="TotalMTM" class="form-group" ><!--<style="width:100%;">-->          
                    <!--le class="columns table table-responsive" style="width: 90%" align="center">
                      <tr>
                        <th colspan="3"><div id="TotalMTM" style="width:100%;"></div></th>
                      </tr>
                      <tr>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><div id="MT/MO_Telcel" style="display: block; width: 100%;"></div></td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><div id="MT/MO_Movistar" style="display: block; width: 100%;"></div></td>
                        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><div id="MT/MO_Att" style="display: block; width: 100%;"></div></td>
                      </tr>-->
                      <!--<tr>
                        <th colspan="3"><div id="TotalMOM" style="width:100%;"></div></th>
                      </tr>-->
                    <!--table>-->
                    </div>
                    <div class="form-group">
                      <?php echo $contenido; ?>
                    </div>
                <!-- /.col-lg-12 -->

            </div>
            <!-- /.row -->
<!--/Body-->
<!--Footer-->
<?php echo $footer;?>
<!--/Footer-->
