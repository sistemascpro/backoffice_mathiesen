<div class="register pt-20 pb-20">
    <div class="row">
        <div class="col-12">
            <div class="log-in-form">
                <div class="sidebar-widget theme1 mb-30">
                    <h3 class="post-title">Cliente Activo</h3>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Seleccione un cliente</label>
                    <div class="col-md-6">
                        <select class="form-control" id="ClienteActivo" name="ClienteActivo" onchange="SetClienteActivo()" style="padding:0px 0px 0px 5px !important">
                                <?php
                                if($DatosGen['Session']->get('cliente_codigo')==0) { ?><option value="0" selected>Sin Cliente Activo</option><?php } else { ?><option value="0">Sin Cliente Activo</option><?php }

                                foreach($DatosGen['Clientes'] as $lsRow) {
                                    if($DatosGen['Session']->get('cliente_codigo')==$lsRow->fk_cliente) { $selected = 'selected'; } else { $selected=''; }
                                    ?><option value="<?=$lsRow->fk_cliente?>" <?=$selected?>><?=$lsRow->fk_cliente?></option><?php
                                }
                                ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="register pb-20">
    <div class="row">
        <div class="col-12">
            <div class="log-in-form">
                <div class="sidebar-widget theme1 mb-30">
                    <h3 class="post-title">Pedido</h3>
                </div>
                <div class="form-group row">
                    <div class="form-group row">
                        <div class="col-md-3">Fecha Desde<input class="form-control" id="BuscPedFechaDesde" name="BuscPedFechaDesde" readonly/></div>
                        <div class="col-md-3">Fecha Hasta<input class="form-control" id="BuscPedFechaHasta" name="BuscPedFechaHasta" readonly/></div>
                        <div class="col-md-3">
                            <a class="mt-2 btn theme-btn--dark1 btn--md" onclick="BuscarPedidosCliente();">Buscar</a>
                        </div>
                    </div>
                    <div class="col-12 myaccount-table table-responsive text-center d-flex justify-content-center">
                        <div id="DivBuscarPedidosCliente" class="col-12 d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
