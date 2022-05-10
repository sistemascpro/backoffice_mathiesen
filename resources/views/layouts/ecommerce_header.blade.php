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
                <!--
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Argentina')">
                    <img src="img/flag-ar.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Argentina</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Bolivia')">
                    <img src="img/flag-bo.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Bolivia</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Brasil')">
                    <img src="img/flag-br.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Brasil</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Chile')">
                    <img src="img/flag-cl.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Chile</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('China')">
                    <img src="img/flag-cn.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">China</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Colombia')">
                    <img src="img/flag-co.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Colombia</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Costa Rica')">
                    <img src="img/flag-cr.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Costa Rica</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Ecuador')">
                    <img src="img/flag-ec.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Ecuador</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('España')">
                    <img src="img/flag-es.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">España</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Guatemala')">
                    <img src="img/flag-gt.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Guatemala</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Honduras')">
                    <img src="img/flag-hn.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Honduras</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('México')">
                    <img src="img/flag-mx.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">México</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Paraguay')">
                    <img src="img/flag-py.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Paraguay</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Perú')">
                    <img src="img/flag-pe.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Perú</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('República Dominicana')">
                    <img src="img/flag-do.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">República Dominicana</h1>
                    </div>
                  </div>
                </a>
                <a href="#" class="opcion">
                  <div class="contenido-opcion" onclick="DefinirPais('Uruguay')">
                    <img src="img/flag-uy.png" alt="">
                    <div class="textos">
                      <h1 class="titulo">Uruguay</h1>
                    </div>
                  </div>
                </a>
                -->
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

    <!--
    <div class="contriesBox" style="display: none;">
        <span class="msgInfo">Filtra el contenido por país</span>
        <select class="contries select-css" name="countries" style="height: 22px; margin-top:-4px">
            <option value="AR">🇦🇷 Argentina</option>
            <option value="BO">🇧🇴 Bolivia</option>
            <option value="BR">🇧🇷 Brasil</option>
            <option value="CL" selected="">🇨🇱 Chile</option>
            <option value="CH">🇨🇳 China</option>
            <option value="CO">🇨🇴 Colombia</option>
            <option value="CR">🇨🇴 Costa Rica</option>
            <option value="EC">🇪🇨 Ecuador</option>
            <option value="ES">🇪🇸 España</option>
            <option value="GU">🇬🇹 Guatemala</option>
            <option value="HO">🇭🇳 Honduras</option>
            <option value="ME">🇲🇽 México</option>
            <option value="PA">🇵🇾 Paraguay</option>
            <option value="PE">🇵🇪 Perú</option>
            <option value="RD">🇩🇴 República Dominicana</option>
            <option value="UR">🇺🇾 Uruguay</option>
        </select>
        <div id="AR-sel" class="contriesBox-item contriesBox-selected" style="display: none;">
            <span class="flag">🇦🇷</span>
            <span class="nameContrie">Argentina</span>
        </div>
        <div class="contriesBox-option contriesBox-optionActive" style="display: none;">
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
            <div id="AR" class="contriesBox-item"><span class="flag">🇦🇷 </span>Argentina</div>
        </div>
    </div>
    -->
</div>

 
     
      
    </div>
<nav class="navbar navbar-expand-lg navbar-fixed ">
      <div class="container-fluid">
        <a class="navbar-brand" href="/"><img src="img/Logo001.png" alt="Logo" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <i style="font-weight:bold; color:#fff;" class="icon icon-menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
          <ul class="navbar-nav">
            <li class="marginButtonNav nav-item dropdown"><a class="nav-link " href="https://www.grupomathiesen.com/nosotros/" target="_blank">Nosotros</a></li>

              <!-- evidal
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Nosotros <i style="font-weight:bold;" class="icon icon-chevron-down"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark subMenuFullContent" aria-labelledby="navbarDarkDropdownMenuLink">
                <div class="group-list-margin">
                <li class="submenu"><a class="dropdown-item" href="#">Visión y Compromiso</a></li>
                <li class="submenu"><a class="dropdown-item" href="#">Cultura</a></li>
                <li class="submenu"><a class="dropdown-item" href="#">Historia</a></li>
                <li class="submenu"><a class="dropdown-item" href="#">Equipo</a></li>
                <li class="submenu"><a class="dropdown-item" href="#">Excelencia operacional</a></li>
                <li class="submenu"><a class="dropdown-item" href="#">Innovación</a></li>
                </div>
              </ul>
            </li>
            -->
            <li class="marginButtonNav nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Producto e Industrias <i style="font-weight:bold;" class="icon icon-chevron-down"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark subMenuFullContent" aria-labelledby="navbarDarkDropdownMenuLink">
                <div class="col-12 row">
                    <?php
                    foreach ($DatosGen['MenuWebPadres'] as $lsPadre){
                        ?>
                            <div class="col-lg-4 col-md-12 submenu" onclick="CargarProductos('Familia', '<?=$lsPadre->id?>')"><a class="dropdown-item" href="#"><?=$lsPadre->nombre?></a></div>
                        <?php
                    }
                    ?>
                </div>
              </ul>
            </li>
            <!-- evidal
            <li class="nav-item dropdown responsiveHide"><a class="nav-link "href="#">Empresas Productivas</a></li>
            <li class="nav-item dropdown"><a class="nav-link"href="#">Aplicaciones </a></li>
            <li class="nav-item dropdown"><a class="nav-link"href="#">Carrera</a></li>
            <li class="nav-item dropdown"><a class="nav-link"href="#">Noticias</a></li>
            -->
            <li class="marginButtonNav nav-item dropdown"><a class="nav-link " href="/eco_noticias">Noticias</a></li>
            <li class="marginButtonNav nav-item dropdown"><a href="/eco_contacto"><button type="button"  style="margin-top: -10px;" class=" btn btn-outline-secondary btn-outline-secondary-mathiense">Contacto</button></a>   </li>
            <li class="marginButtonNav nav-item dropdown"><a href="#" onclick="CargarCarrito();"><button type="button"  style="margin-top: -10px;" class="btn btn-primar btn-primary-mat">Cotizador</button></a>   </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-flow header">
    </div>

