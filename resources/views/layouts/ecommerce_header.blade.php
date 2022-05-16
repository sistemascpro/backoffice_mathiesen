<div class="topBar">
  
      <div class="contTopBar">
        <div class="contenedor-corp">
          <form action="">
            <div class="selectbox">
              <?php
                if(isset($Pais))
                {
                  ?>
                  <input type="hidden" id="SearchPais" name="SearchPais" readonly value="<?=$Pais[0]->id?>">
                  <div class="select" id="select">
                    <div class="contenido-select">
                      <a href="#" class="opcion">
                        <div class="contenido-opcion">
                          <img src="<?=$Pais[0]->bandera?>" alt="">
                          <div class="textos">
                            <h1 class="titulo"><?=$Pais[0]->nombre?></h1>
                          </div>
                        </div>
                      </a>
                    </div>
                    <i style="font-weight:bold;" class="icon icon-chevron-down"></i>
                  </div>
                  <?php
                }
                else
                {
                  ?>
                    <input type="hidden" id="SearchPais" name="SearchPais" readonly value="1">
                    <div class="select" id="select">
                      <div class="contenido-select">
                        <a href="#" class="opcion">
                          <div class="contenido-opcion">
                            <img src="img/paises/flag-cl.png" alt="">
                            <div class="textos">
                              <h1 class="titulo">Chile</h1>
                            </div>
                          </div>
                        </a>
                      </div>
                      <i style="font-weight:bold;" class="icon icon-chevron-down"></i>
                    </div>
                  <?php
                }
              ?>
      
              <div class="opciones" id="opciones">
                <?php
                foreach ($DatosGen['Paises'] as $lsRow)
                {
                  ?>
                    <a href="#" class="opcion">
                      <div class="contenido-opcion" onclick="DefinirPais('<?=$lsRow->id?>')">
                        <img src="<?=$lsRow->bandera?>" alt="">
                        <div class="textos">
                          <h1 class="titulo"><?=$lsRow->nombre?></h1>
                        </div>
                      </div>
                    </a>
                  <?php
                }
                ?>
              </div>
            </div>
      
            <input type="hidden" name="pais" id="inputSelect" value="">
          </form>
      
        </div>
       
      <div class="loginBox-text">
      <?php
      if( $DatosGen['Session']->get('nombre')!=null )
      {
        ?>
          <span class="hola">Bienvenido <?=$DatosGen['Session']->get('nombre')?>!</span>
          <span class="sesion"> <a href="/userLogout">Salir</a> </span>
        <?php
      }
      else
      {
        ?>
          <span class="hola">¡Hola! </span>
          <span class="sesion"> <a href="/login">Inicia sesión</a> o <a href="/eco_registrate">regístrate</a> </span>
        <?php
      }
      ?>
    </div>
</div>

    </div>
    <nav class="navbar navbar-expand-lg navbar-fixed">
      <div class="container-fluid">
        <a class="navbar-brand" href="/eco_index"><img src="img/Logo001.png" alt="Logo"></a>
        <button id="navbar-toggler" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <i style="font-weight:bold; color:#fff;" class="icon icon-menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
          <ul class="navbar-nav">
            <li class="nav-item dropdown"><a class="nav-link" href="https://www.grupomathiesen.com/nosotros/" target="_blank">Nosotros</a></li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle " href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Producto e Industrias <i style="font-weight:bold;" class="icon icon-chevron-down"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark subMenuFullContent " aria-labelledby="navbarDarkDropdownMenuLink">
                <?php
                $Cont=0;
                for( $i=0; $i<count($DatosGen['MenuWebPadres']); $i++)
                {
                    if( $i==0 ) { ?> <div class="group-list group-list-marginFirst"> <?php }
                    ?><li class="submenu"><a class="dropdown-item" href="#" onclick="CargarProductos('Familia', '<?=$DatosGen['MenuWebPadres'][$i]->id?>')"><?=$DatosGen['MenuWebPadres'][$i]->nombre?></a></li><?php

                    if( $Cont%5==0 && $i>0 ) { ?></div><div class="group-list"><?php $Cont=0; }
                    $Cont++;
                }
                ?>
                </div>
             </ul>
            </li>
            <li class="marginButtonNav nav-item dropdown"><a class="nav-link " href="/eco_noticias">Noticias</a></li>
            <li class="marginButtonNav nav-item dropdown"><button onclick="CargarContacto();" type="button" style="margin-top: -10px;" class="btn btn-outline-secondary btn-outline-secondary-mathiense">Contacto</button></li>
            <li class="marginButtonNav nav-item dropdown"><button type="button" onclick="CargarCarrito();"  style="margin-top: -10px;" class="btn btn-primar btn-primary-mat">Cotizador</button> </li>
          </ul>
        </div>
      </div>
    </nav>