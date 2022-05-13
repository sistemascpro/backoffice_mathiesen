@include("eco_templates.eco_template_01")
<div id="eco_productos">
    <nav aria-label="breadcrumb" style="margin-left: 28px; margin-top: 110px !important;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Página de inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Página de noticias</li>
    </ol>
    </nav>
    <div class="container-flow fullBanner-sm  "  style="background-image: url('img/headernoticias.jpg'); background-repeat: no-repeat; background-size: cover; background-position:top center" >
    </div>

    <div class="container contContact" style="position:relative; top:-100px">
        <div class="row">
            <h1>Noticias</h1>
            <?php 
            for($i=0; $i<count($DatosGen['Noticias']); $i++ ){ 

            ?>
                    <div class="col-xl-3 col-md-6 col-xs-12" style="padding:24px; ">
                      <div class="card" style="width:100%">
                        <img src="<?=$DatosGen['Noticias'][$i]->imagen?>" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title"><?=$DatosGen['Noticias'][$i]->titulo?></h5>
                          <p class="card-text"><?=substr($DatosGen['Noticias'][$i]->contenido,0,50)?>...</p>
                            <a href="#" class="btn btn-primary soft-button" onclick="location.href ='/eco_noticia?id=<?=$DatosGen['Noticias'][$i]->id?>'">Ver más</a>
                        </div>
                      </div>
                    </div>
                <?php
            } ?>
        </div>
    </div>
</div>
@include("eco_templates.eco_template_02")

