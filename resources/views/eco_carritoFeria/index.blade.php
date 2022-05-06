
   
    @include("eco_templates.eco_template_01Feria")
    <div class="containerEco containerEcoShadow bg-white">
        @include("eco_templates.eco_template_HeaderFeria")
        <div id="eco_productos" class="row d-flex justify-content-center bg-white" style="min-width:100%">
        <?=$Salida?>
        </div>
    </div>
    @include("eco_templates.eco_template_02Feria")
    <script>
    function CerrarFeria(){
        window.location.href = '/CerrarFeria';
    }
    </script>