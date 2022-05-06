
  <div class="container  mt-48">
    <div class="row">
      <div class="col">
        <h2 class="title-Section2"> Últimas <span class="textBrandAcent"> Noticias</span></h2>
      </div>
    </div>
    <div class="row mt-24">

    <?php 
    for($i=0; $i<count($DatosGen['Noticias']); $i++ ){ 

        if($DatosGen['Noticias'][$i]->tipo=='Imagen'){ ?>
            <div class="col-xl-4 col-md-6 col-xs-12" style="padding:24px; ">
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
        } 
        ?>
    <?php } ?>

    </div>
</div>
