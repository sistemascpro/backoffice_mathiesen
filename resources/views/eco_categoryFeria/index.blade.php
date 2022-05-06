
    @include("eco_templates.eco_template_01Feria")
    <div class="containerEco containerEcoShadow bg-white">
        
    
    <div class="row pt-1 pb-1"  style="background-color: #f68a1e;">
            <?php if( $DatosGen['Session']->get('nombre')!=null ){}else{?>
                <div class="row col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                    <div class="row col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-1">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 col-xxx-2 pt-1">
                            <h6 class="form-label text-white">USUARIO</h6>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxx-3">
                            <input type="text" class="form-control" id="user" name="user">
                        </div>   
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 col-xxx-2 pt-1">
                            <h6 class="form-label text-white">CONTRASEÑA</h6>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxx-3">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>      
                    </div>      
                    <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 pt-1">
                        <button class="btn btn-primary mb-1" onclick="LoginFeria();"><i class="bx bxs-lock-open"></i>INGRESAR</button> 
                    </div>      
                </div>      
                <div class="row col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <a href="javascript:close();"><img src="/img/vOLVER.jpg" alt="logo"></a>
                </div>
            <?php } ?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 pt-1">
                    <?php
                    if( $DatosGen['Session']->get('nombre')!=null )
                    {?>
                        <span class="text-white font-weight-bold">BIENVENIDO <?=$DatosGen['Session']->get('nombre')?></span>
                        <select class="form-control" style="margin-left:0px !important; padding:0px !important" onChange="SetClienteActivo(1);" id="ClienteActivo1" name="ClienteActivo1">
                            <?php
                                if( $DatosGen['Session']->get('cliente_codigo')=='0' ){
                                    ?><option value="0" selected>Seleccionar...<?php
                                }else{
                                    ?><option value="0">Seleccionar...<?php
                                }
                            ?>
                            <?php
                                foreach($DatosGen['Clientes'] as $lsRow){
                                    if( $DatosGen['Session']->get('cliente_codigo')==$lsRow->codigo ) { $Selected = 'selected'; } else { $Selected = ''; }
                                    ?><option value="<?=$lsRow->codigo?>" <?=$Selected?>><?=$lsRow->nombre?></option><?php
                                }
                            ?>
                        </select>
                        <button class="btn btn-primary mt-1" onclick="LogOutFeria();"><i class="bx bxs-lock-open"></i>SALIR</button>
                    <?php }
                    else
                    { ?>
                        
                    <?php } ?>
            </div>
            <?php
            if( $DatosGen['Session']->get('nombre')!=null )
            {?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 row">
                <div class="col-6 logo text-center text-sm-left mb-10 mb-sm-0">
                    <a href="javascript:close();"><img  src="/img/vOLVER.jpg" alt="logo"></a>
                </div>
                <div class="col-6  d-flex align-items-center justify-content-center justify-content-sm-end">
                    <div class="cart-block-links theme2">
                        <ul class="d-flex">
                            <li class="mr-0 cart-block position-relative">
                                <a onclick="CargarCarritoFeria();" href="#">
                                    <span class="position-relative">
                                        <i class="icon-bag"></i>
                                        <span id="DivBolsaCantProductos" class="badge cbdg1">0</span>
                                    </span>
                                    <span id="DivBolsaTotal" class="cart-total position-relative">0</span>
                                </a>
                            </li>
                            <!-- cart block end -->
                        </ul>
                    </div>
                </div>
            </div> 
            <?php } ?>       
        </div>  
        
        <div id="eco_productos" class="row d-flex justify-content-center bg-white" style="min-width:100%">
            <div class=" contenedorBoxLoading col-12 text-center p-5">
                <div class="BoxLoading">
                    <div class="containerBoxLoading">
                        <span class="circleBoxLoading"></span>
                        <span class="circleBoxLoading"></span>
                        <span class="circleBoxLoading"></span>
                        <span class="circleBoxLoading"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("eco_templates.eco_template_02Feria")