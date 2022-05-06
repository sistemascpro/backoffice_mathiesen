
    @include("eco_templates.eco_template_01")
    <form class="row g-3" method="post" id="FormLoadGrillaProductos" enctype="multipart/form-data" style="display:none">@csrf
    <input type="hidden" id="Codigo" name="Codigo" value="<?=$Codigo?>" readonly/>
    <input type="hidden" id="Order" name="Order" value="<?=$Order?>" readonly/>
    <input type="hidden" id="Type" name="Type" value="<?=$Type?>" readonly/>
    <input type="hidden" id="Texto" name="Texto" value="<?=$Texto?>" readonly/>
    <input type="hidden" id="OrderCant" name="OrderCant" value="<?=$OrderCant?>" readonly/>
    <?php 
    if( count($Paises)>0 ){
        foreach( $Paises as $lsRow){
            ?>
                <input class="form-check-input" type="checkbox" value="<?=$lsRow->id?>" id="ChkProdPais[]" name="ChkProdPais[]">
            <?php
        }
    }
    ?>

    <?php 
    if( count($Proveedores)>0 ){
        foreach( $Proveedores as $lsRow){
            ?>
                <input class="form-check-input" type="checkbox" value="<?=$lsRow->id?>" id="ChkProdProveedores[]" name="ChkProdProveedores[]">
            <?php
        }
    }
    ?>  
    
    <?php 
    if( count($Marcas)>0 ){
        foreach( $Marcas as $lsRow){
            ?>
                <input class="form-check-input" type="checkbox" value="<?=$lsRow->id?>" id="ChkProdMarcas[]" name="ChkProdMarcas[]">
            <?php
        }
    }
    ?>      
    
    <?php 
    if( count($Familias)>0 ){
        foreach( $Familias as $lsRow){
            ?>
                <input class="form-check-input" type="checkbox" value="<?=$lsRow->id?>" id="ChkProdFamilias[]" name="ChkProdFamilias[]">
            <?php
        }
    }
    ?> 
    </form>
    <div id="eco_productos" >
        <div class=" contenedorBoxLoading col-12 text-center p-5">
            <div class="BoxLoading">
                <div class="containerBoxLoading">
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                    <span class="circleBoxLoading"></span>
                </div>
            </div>
        </div>
    </div>
    @include("eco_templates.eco_template_02")