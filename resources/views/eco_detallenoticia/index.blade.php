@include("eco_templates.eco_template_01")
    <div id="eco_productos">
        <nav aria-label="breadcrumb" style="margin-left: 28px; margin-top:110px !important">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Página de inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Página de noticia</li>
            </ol>
        </nav>
        <?php for($i=0; $i<count($DetalleNocitia); $i++ ) { ?>
        <div class="container-flow fullBanner-sm2  ">
          <img src="<?=$DetalleNocitia[$i]->imagen?>" alt="Mathiesen Argentina Recertifica Norma de Inocuidad Alimentaria">
        </div>
        <div class="container contNoticia" style="padding-top:34px">
          <div class="row">
            <div class="col-12">
              <h2><?=$DetalleNocitia[$i]->titulo?></h2>
              <p><?=$DetalleNocitia[$i]->contenido?></p>
            </div>
          </div>

    
    
    
    
          <div class="row">
            <?php if( count($DetalleNocitiaAnterior)>0 ) { ?>
              <div class="col-xl-6 pagNoticia col-sm-6" style="text-align: left;" onclick="location.href ='/eco_noticia?id=<?=$DetalleNocitiaAnterior[0]->id?>'">
                <h2><?=$DetalleNocitiaAnterior[0]->titulo?></h2>
                <span><i style="font-weight:bold;" class="icon icon-chevron-left"></i> noticia previa</span>
              </div>
            <?php } ?>
            <?php if( count($DetalleNocitiaSiguiente)>0 ) { ?>
              <div class="col-xl-6 pagNoticia col-sm-6" style="text-align: left;" onclick="location.href ='/eco_noticia?id=<?=$DetalleNocitiaSiguiente[0]->id?>'">
                <h2><?=$DetalleNocitiaSiguiente[0]->titulo?></h2>
                <span>noticia siguiente <i style="font-weight:bold;" class="icon icon-chevron-right"></i></span>
              </div>
            <?php } ?>
    </div>
    <?php } ?>

  </div>

    @include("eco_templates.eco_template_02")

