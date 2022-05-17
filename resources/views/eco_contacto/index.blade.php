    @include("eco_templates.eco_template_01")
    <div id="eco_productos">
        <nav aria-label="breadcrumb" style="margin-left: 28px; padding: 20px 0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Página de inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Página de contacto</li>
        </ol>
        </nav>
        <div class="container-flow fullBanner-sm2  "  style="background-image: url('img/contacto.png'); background-repeat: no-repeat; background-size: cover; background-position:top center" >
        </div>

<div class="container contContact" style="position:relative;  margin-top:-80px !important;">
     <div class="row">
      <div class="col-xl-6 col-md-12 formContact">
        <h1>Contacto</h1>
          <div class="col">
            <label for="exampleInputEmail1" class="form-label">Nombre </label>
            <input type="name" class="form-control" id="ContNombre" name="ContNombre" aria-describedby="name">
            <div id="name" class="form-text">Ingresa tu nombre y apellido.</div>
          </div>
          <div class="col">
            <label for="disabledSelect" class="form-label">País</label>
            <select id="ContPais" name="ContPais" class="form-select">
              <option>Selecciona un país</option>
              <option value="Argentina">Argentina</option>
              <option value="Bolivia">Bolivia</option>
              <option value="Brasil">Brasil</option>
              <option value="Chile">Chile</option>
              <option value="China">China</option>
              <option value="Colombia">Colombia</option>
              <option value="Costa Rica">Costa Rica</option>
              <option value="Ecuador">Ecuador</option>
              <option value="España">España</option>
              <option value="Guatemala">Guatemala</option>
              <option value="Honduras">Honduras</option>
              <option value="México">México</option>
              <option value="Paraguay">Paraguay</option>
              <option value="Perú">Perú</option>
              <option value="Chile">Chile</option>
              <option value="República Dominicana">República Dominicana</option>
              <option value="Uruguay">Uruguay</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="col">
            <label for="exampleInputEmail1" class="form-label">Email </label>
            <input type="email" class="form-control" id="ContEmail" name="ContEmail" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">No compartiremos tu correo.</div>
          </div>
          <div class="col">
            <label for="exampleInputEmail1" class="form-label">Teléfono </label>
            <input type="tel" class="form-control" id="ContTelefono" name="ContTelefono" aria-describedby="Tel">
            <div id="tel" class="form-text">ingresa un número de 9 dígitos</div>
          </div>
          <div class="col">
            <label for="exampleInputSubjet1" class="form-label">Asunto </label>
            <input type="text" class="form-control" id="ContAsunto" name="ContAsunto" aria-describedby="Subjet">
            <!--<div id="name" class="form-text">Ingresa tu nombre y apellido.</div>-->
          </div>
          <div class="col">
            <label for="disabledSelect" class="form-label">Sector industria</label>
            <select id="ContIndustria" name="ContIndustria" class="form-select">
              <option>Seleccione un sector industria</option>
              <option value="">Alimentos</option>
              <option value="Construcción">Construcción</option>
              <option value="Cuidado y Limpieza Hogar y Automóvil">Cuidado y Limpieza Hogar y Automóvil</option>
              <option value="Cuidado personal">Cuidado personal</option>
              <option value="Curtiembres">Curtiembres</option>
              <option value="Industria Farmacéutica">Industria Farmacéutica</option>
              <option value="Industria Química y Aditivos Construcción">Industria Química y Aditivos Construcción</option>
              <option value="Mantenimiento Industrial">Mantenimiento Industrial</option>
              <option value="Minería">Minería</option>
              <option value="Papeles y Celulosa">Papeles y Celulosa</option>
              <option value="Pinturas, Tintas y Adhesivos">Pinturas, Tintas y Adhesivos</option>
              <option value="Polímeros y Elastómeros">Polímeros y Elastómeros</option>
            </select>
          </div>
          <div class="form-group">
            <label for="comment">Mensaje:</label>
            <textarea class="form-control" rows="5" id="ContMensaje" name="ContMensaje"></textarea>
          </div>
          <button class="btn btn-primar  btn-lg btn-primary-mat" style="width:100%" onclick="EnviarContacto();">Enviar</button>
      </div>
      <div class="col-xl-6 imgContact">
<img src="https://www.grupomathiesen.com/wp-content/uploads/2020/09/mathiesen-imagen-contacto.jpg" alt="imagen de página de contacto" />
      </div>
    </div>
     </div>
</div>
</div>
    @include("eco_templates.eco_template_02")
