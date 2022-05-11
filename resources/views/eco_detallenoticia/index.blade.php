@include("eco_templates.eco_template_01")
    <div id="eco_productos">
        <!-- evidal
            <nav aria-label="breadcrumb" style="margin-top:95px; margin-left: 28px;">
        -->
        <nav aria-label="breadcrumb" style="margin-left: 28px; margin-top:110px !important">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Página de inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Página de noticia</li>
        </ol>
        </nav>
        <div class="container-flow fullBanner-sm  "  style="background-image: url('img/headernoticias.jpg'); background-repeat: no-repeat; background-size: cover; background-position:top center" >
        <!--<img src="images/contacto.png" alt="..."/>-->
        </div>

<div class="container contContact" style="position:relative; top:-100px">
<div class="row">
      <div class="col-xl-12 col-md-12 formContact">
        <?php
    for($i=0; $i<count($DetalleNocitia); $i++ ){

          ?>
          <h1><?=$DetalleNocitia[$i]->titulo?></h1>

            <div class="col-12" style="padding:24px; ">
              <div class="card" style="width:100%">
                <img src="<?=$DetalleNocitia[$i]->imagen?>" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title"></h5>
                  <p class="card-text"><?=$DetalleNocitia[$i]->contenido?>...</p>
                </div>
              </div>
            </div>
        <?php
         } ?>
      </div>
    </div>
</div>
</div>
</div>
    @include("eco_templates.eco_template_02")

