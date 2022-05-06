<div id="offcanvas-mobile-menu" class="offcanvas theme1 offcanvas-mobile-menu">
    <div class="inner">
        <div class="mb-4 pb-4 text-right">
            <button class="offcanvas-close">×</button>
        </div>
        <nav class="offcanvas-menu">
            <ul>
                <li><a href="contact.html">INICIO</a></li>
                <li><a href="contact.html">SOBRE CENTROVET</a></li>
                <li><a href="contact.html">SERVICIOS</a></li>

                <?php
                if( isset($DatosGen['NombreUsuario']) )
                {?>
                    <li>
                        <a href=" #">BIENVENIDO <?=$DatosGen['NombreUsuario']?></a>
                        <ul class="offcanvas-submenu">
                            <li><a href="#" onclick="window.location='/eco_clienteperfil'">VER PERFIL CLIENTE</a></li>
                        </ul>
                        <ul class="offcanvas-submenu">
                            <li>
                                <a href="#" class="text-dark font-weight-bold">CLIENTE ACTIVO
                                <select class="form-control" onChange="SetClienteActivo();">
                                    <option value="">opcion 1</option>
                                    <option value="">opcion 2</option>
                                    <option value="">opcion 3</option>
                                </select>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="/userLogout" class="text-danger">SALIR</a></li>
                <?php }
                else
                { ?>
                    <li><a href="/login" class="text-danger">INGRESAR</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>
