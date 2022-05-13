<div class="slider-home" style="margin-top: 114px;">
    <div id="carouselExampleCaptions" class="carousel slide pointer-event" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php
            for($i=0; $i<count($DatosGen['Sliders']); $i++)
            {
                $Active = " ";
                if($i==0)
                {
                    $Active = " active ";
                }
                ?>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?=$i?>" class="<?=$Active?>" aria-label="Slide <?=$i?>"></button>
                <?php
            }
            ?>
        </div>
        <div class="carousel-inner">
            <?php
            for($i=0; $i<count($DatosGen['Sliders']); $i++)
            {
                $Active = " ";
                if($i==0)
                {
                    $Active = " active ";
                }
                ?>
                    <div class="carousel-item <?=$Active?>">
                        <img src="<?=$DatosGen['Sliders'][$i]->ruta?>" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block"></div>
                    </div>
                <?php
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden"></span>
        </button>
    </div>
</div>