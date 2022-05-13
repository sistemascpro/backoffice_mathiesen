    @include("eco_templates.eco_template_01")
    <div id="eco_productos">
        @include("layouts.ecommerce_slider")
        @include("layouts.ecommerce_buscadorcategorias")
        @include("layouts.ecommerce_categorias")

        <?php
        if( count($DatosGen['SliderContenidos'])>0 )
        {
            ?>
            <div id="slider" class="nivoSlider"> 
                <?php
                    foreach($DatosGen['SliderContenidos'] as $lsRow)
                    {
                        ?>
                            <img src="<?=$lsRow->imagen?>" alt="" title="<?=nl2br($lsRow->texto)?>" class="card-title" />
                        <?php
                    }
                ?>
            </div>
            <?php
        }
        ?>
        @include("layouts.ecommerce_noticias")
        @include("layouts.ecommerce_marcas")
    </div>
    @include("eco_templates.eco_template_02")
