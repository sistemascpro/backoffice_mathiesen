<div class="container  mt-48">
    <div class="row">
    <div class="col">
        <h2 class="title-Section2"> Sectores <span class="textBrandAcent">industriales</span> </h2>
    </div>
    </div>
    <div class="row mt-24 ">
        <?php
        foreach($DatosGen['Familias'] as $lsRow)
        {
        ?>
        <div class="col-xl-2 col-md-4 col-sm-6 iconCat">
            <a href="#" onclick="CargarProductos('Familia', '<?=$lsRow->id?>')">
                <div class="iconCat-inner">
                    <span class="categoryIcon"><img src="<?=$lsRow->ruta?>"></span>
                    <span class="categoryDescriton"><?=$lsRow->nombre?></span>
                </div>
            </a>
        </div>
        <?php
        }
        ?>
    </div>
</div>