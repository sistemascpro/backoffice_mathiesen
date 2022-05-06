    @include("eco_templates.eco_template_01")
    <div id="eco_productos">
        <!-- evidal
            <nav aria-label="breadcrumb" style="margin-top:95px; margin-left: 28px;">
        -->
        <nav aria-label="breadcrumb" style="margin-left: 28px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Página de inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Página de iniciar sesión</li>
        </ol>
        </nav>
        <div class="container-flow fullBanner-sm"  style="background-image: url('img/LoginHeader.png'); background-repeat: no-repeat; background-size: cover; background-position:top center" >
        </div>

<div class="container contContact" style="position:relative; top:-100px">
    <div class="row">
        <div class="col-xl-6 col-md-12 formContact">
            <h1>Iniciar sesión</h1>
            <form class="row g-12" method="post" action="userLogin">
                @csrf
                <div class="col-12">
                    <label for="inputEmailAddress" class="form-label">USUARIO</label>
                    <input type="text" class="form-control" id="user" name="user">
                </div>
                <div class="col-12 mb-4">
                    <label for="inputChoosePassword" class="form-label">CONTRASEÑA</label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" class="form-control border-end-0" id="password" name="password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide' onclick="ver_pass()"></i></a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>INGRESAR</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xl-6 col-md-12 formContact">
            <img src="img/Login.jpg" alt="..."/>
        </div>
    </div>
</div>
    @include("eco_templates.eco_template_02")
