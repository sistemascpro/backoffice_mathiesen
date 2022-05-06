
<div class="slider-home">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php
            $i=0;
            foreach($DatosGen['Sliders'] as $lsRow)
            {
                if($i==0)
                {
                    ?>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?=$i?>" class="active" aria-current="true" aria-label="Slide <?=($i+1)?>"></button>
                    <?php
                }
                else
                {
                    ?>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?=$i?>" aria-current="true" aria-label="Slide <?=($i+1)?>"></button>
                    <?php
                }
            }
            ?>
        </div>
        <div class="carousel-inner">
            <?php
            $i=0;
            foreach($DatosGen['Sliders'] as $lsRow)
            {
                if($i==0)
                {
                    ?>
                        <div class="carousel-item active">
                            <img src="<?=$lsRow->ruta?>" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block"></div>
                        </div>
                    <?php
                }
                else
                {
                    ?>
                        <div class="carousel-item">
                            <img src="<?=$lsRow->ruta?>" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block"></div>
                        </div>
                    <?php
                }
                $i++;
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>