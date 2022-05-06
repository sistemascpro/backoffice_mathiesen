		@extends("layouts.app")
        @section("script")
        <script src="{{ asset('assets/js/js/mant_noticias.js') }}"></script>
        @endsection
		@section("wrapper")
            <div class="page-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item pe-3"><a href="/home"><i class="fas fa-home fa-1x"></i></a></li>
                                    <li class="breadcrumb-item pe-3"><a href="mant_noticias">MANTENEDOR DE NOTICIAS</a></li>
                                    <li class="breadcrumb-item pe-3">CREAR/EDITAR NOTICIA</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card border-top border-0 border-4 border-primary">
                        <form class="row g-3" method="post" id="FormGuardar" enctype="multipart/form-data">@csrf
                            <input
                            type="hidden"
                            class="form-control"
                            value="<?=$Noticia[0]->noticiaid?>"
                            id="NoticiaId"
                            name="NoticiaId"
                            readonly
                            />
                            <input
                            type="hidden"
                            class="form-control"
                            value=""
                            id="Tipo"
                            name="Tipo"
                            readonly
                            />
                        <div class="card-body row">
                            <div class="col-6">
                                <div class="col-sm-3 mb-3 mt-3">
                                    <h5 class="mb-0 text-primary">IMAGEN</h5>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">TITULO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="text"
                                        class="ImagenRequired form-control"
                                        value="<?=$Noticia[0]->ImagenTitulo?>"
                                        id="ImagenTitulo"
                                        name="ImagenTitulo"
                                        onkeyup="ValidarCaracteres('ImagenTitulo')"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">CONTENIDO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <textarea
                                        type="text"
                                        class="ImagenRequired form-control"
                                        id="ImagenContenido"
                                        name="ImagenContenido"
                                        onkeyup="ValidarCaracteres('ImagenContenido')"
                                        ><?=$Noticia[0]->ImagenContenido?></textarea>
                                    </div>
                                </div>  
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">POSICION</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select
                                        class="ImagenRequired form-select"
                                        maxlength="30"
                                        id="ImagenPosicion"
                                        name="ImagenPosicion"
                                        >
                                            <option value=''>Seleccionar...</option>
                                            <?php
                                            for($i=0; $i<=6; $i++){
                                                if($Noticia[0]->ImagenPosicion==$i){
                                                    ?><option value='<?=$i?>' selected><?=$i?></option><?php
                                                }else{
                                                    ?><option value='<?=$i?>'><?=$i?></option><?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">IMAGEN</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="file"
                                        class="ImagenRequired form-control"
                                        id="ImagenImagen"
                                        name="ImagenImagen"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR IMAGEN" onclick="Guardar('Imagen');" />
                                </div>
                            </div>
                                            
                            <!--
                            <div class="col-6">
                                <div class="col-sm-3 mb-3 mt-3">
                                    <h5 class="mb-0 text-primary">VIDEO</h5>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">TITULO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="text"
                                        class="VideoRequired form-control"
                                        value="<?=$Noticia[0]->VideoTitulo?>"
                                        id="VideoTitulo"
                                        name="VideoTitulo"
                                        onkeyup="ValidarCaracteres('VideoTitulo')"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">CONTENIDO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <textarea
                                        type="text"
                                        class="VideoRequired form-control"
                                        id="VideoContenido"
                                        name="VideoContenido"
                                        onkeyup="ValidarCaracteres('VideoContenido')"
                                        ><?=$Noticia[0]->VideoContenido?></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">POSICION</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select
                                        class="VideoRequired form-select"
                                        maxlength="30"
                                        id="VideoPosicion"
                                        name="VideoPosicion"
                                        >
                                            <option value=''>Seleccionar...</option>
                                            <?php
                                            for($i=0; $i<=6; $i++){
                                                if($Noticia[0]->VideoPosicion==$i){
                                                    ?><option value='<?=$i?>' selected><?=$i?></option><?php
                                                }else{
                                                    ?><option value='<?=$i?>'><?=$i?></option><?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">PORTADA</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="file"
                                        class="form-control VideoRequired"
                                        id="VideoCover"
                                        name="VideoCover"
                                        />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">VIDEO</p>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input
                                        type="file"
                                        class="form-control VideoRequired"
                                        id="VideoVideo"
                                        name="VideoVideo"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-4 text-secondary align-middle">
                                    <input type="button" class="btn btn-primary px-4" value="GUARDAR VIDEO" onclick="Guardar('Video');" />
                                </div>
                            </div>
                            -->
                        </div>
                        </form>
                    </div>
                </div>
            </div>
		@endsection




