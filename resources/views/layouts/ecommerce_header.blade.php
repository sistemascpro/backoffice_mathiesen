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
          <div class="cont-cart" onclick="CargarCotizador();"> 
         <span class="bubble-number">0</span>
         <svg stroke="currentColor" fill="none" viewBox="0 0 32 32" height="32" width="32" xmlns="http://www.w3.org/2000/svg" style="color: #fff; width: 26px;float: right;margin-top: 3px; cursor:pointer" class="Fractal-Header--icon"><path d="M3 5H7.26596L11.1175 21.7104H26.5481L28.157 9.81444H8.37511" stroke="var(--textColor-strong)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M13.885 24.3188H13.8728C12.9977 24.3188 12.2883 25.0282 12.2883 25.9033V25.9155C12.2883 26.7906 12.9977 27.5 13.8728 27.5H13.885C14.7601 27.5 15.4695 26.7906 15.4695 25.9155V25.9033C15.4695 25.0282 14.7601 24.3188 13.885 24.3188Z" stroke="var(--textColor-strong)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M13.885 24.3188H13.8728C12.9977 24.3188 12.2883 25.0282 12.2883 25.9033V25.9155C12.2883 26.7906 12.9977 27.5 13.8728 27.5H13.885C14.7601 27.5 15.4695 26.7906 15.4695 25.9155V25.9033C15.4695 25.0282 14.7601 24.3188 13.885 24.3188Z" stroke="var(--textColor-strong)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M22.2457 24.3188H22.2335C21.3584 24.3188 20.649 25.0282 20.649 25.9033V25.9155C20.649 26.7906 21.3584 27.5 22.2335 27.5H22.2457C23.1208 27.5 23.8302 26.7906 23.8302 25.9155V25.9033C23.8302 25.0282 23.1208 24.3188 22.2457 24.3188Z" stroke="var(--textColor-strong)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
      </div>
        <?php
      }
      else
      {
        ?>
          <span class="hola">¡Hola! </span>
          <span class="sesion"> <a href="/login">Inicia sesión </a> o <a href="/eco_registrate">regístrate</a> </span>
        <div class="cont-cart" onclick="CargarCotizador();"> 
          <span class="bubble-number">0</span>
          <svg stroke="currentColor" fill="none" viewBox="0 0 32 32" height="32" width="32" xmlns="http://www.w3.org/2000/svg" style="color: #fff; width: 26px;float: right;margin-top: 3px; cursor:pointer" class="Fractal-Header--icon"><path d="M3 5H7.26596L11.1175 21.7104H26.5481L28.157 9.81444H8.37511" stroke="var(--textColor-strong)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M13.885 24.3188H13.8728C12.9977 24.3188 12.2883 25.0282 12.2883 25.9033V25.9155C12.2883 26.7906 12.9977 27.5 13.8728 27.5H13.885C14.7601 27.5 15.4695 26.7906 15.4695 25.9155V25.9033C15.4695 25.0282 14.7601 24.3188 13.885 24.3188Z" stroke="var(--textColor-strong)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M13.885 24.3188H13.8728C12.9977 24.3188 12.2883 25.0282 12.2883 25.9033V25.9155C12.2883 26.7906 12.9977 27.5 13.8728 27.5H13.885C14.7601 27.5 15.4695 26.7906 15.4695 25.9155V25.9033C15.4695 25.0282 14.7601 24.3188 13.885 24.3188Z" stroke="var(--textColor-strong)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M22.2457 24.3188H22.2335C21.3584 24.3188 20.649 25.0282 20.649 25.9033V25.9155C20.649 26.7906 21.3584 27.5 22.2335 27.5H22.2457C23.1208 27.5 23.8302 26.7906 23.8302 25.9155V25.9033C23.8302 25.0282 23.1208 24.3188 22.2457 24.3188Z" stroke="var(--textColor-strong)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </div>
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
            <li class="marginButtonNav nav-item dropdown"><button type="button" onclick="CargarCotizador();"  style="margin-top: -10px;" class="btn btn-primar btn-primary-mat">Cotizador</button> </li>
          </ul>
        </div>
      </div>
    </nav>