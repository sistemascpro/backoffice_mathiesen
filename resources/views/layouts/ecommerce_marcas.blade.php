
<div class="p-5 mt-5 bg-white">
    <div class="col mb-5">
        <h2 class="title-Section2"> Marcas <span class="textBrandAcent"> Destacadas</span></h2>
    </div>
    <div class="row">
        <?php 
        for($i=0; $i<count($DatosGen['Marcas']); $i++ )
        {
        ?>
            <div class="col-3" style="cursor:pointer" onclick="CargarProductos('Marca', '<?=$DatosGen['Marcas'][$i]->id?>')">
                <img src="<?=$DatosGen['Marcas'][$i]->ruta?>" class="card-img-top" alt="...">
                <h4 class="bodyLg bold text-center"><?=$DatosGen['Marcas'][$i]->nombre?></h4>
            </div>
        <?php
        }
        ?>
    </div>
</div>
