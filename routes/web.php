<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login_Controller;
use App\Http\Controllers\Home_Controller;
use App\Http\Controllers\Eco_Controller;
use App\Http\Controllers\UsuarioPerfil_Controller;
use App\Http\Controllers\MantUsuarios_Controller;
use App\Http\Controllers\MantRoles_Controller;
use App\Http\Controllers\MantClientes_Controller;
use App\Http\Controllers\MantVendedores_Controller;
use App\Http\Controllers\MantProductos_Controller;
use App\Http\Controllers\MantProdPromosRegalos_Controller;
use App\Http\Controllers\MantBanners_Controller;
use App\Http\Controllers\MantProductosSinCanje_Controller;
use App\Http\Controllers\MantPopup_Controller;
use App\Http\Controllers\MantCodigosDescuentos_Controller;
use App\Http\Controllers\MantSliders_Controller;
use App\Http\Controllers\EcoPaginas_Controller;
use App\Http\Controllers\SendMail_Controller;
use App\Http\Controllers\MantProductosBloqueados_Controller;
use App\Http\Controllers\MantNoticias_Controller;
use App\Http\Controllers\MantProductosFamilias_Controller;
use App\Http\Controllers\MantProductosSubFamilias_Controller;
use App\Http\Controllers\MantProductosCaracteristicas_Controller;
use App\Http\Controllers\MantMarcas_Controller;
use App\Http\Controllers\MantProveedores_Controller;
use App\Http\Controllers\MantPaises_Controller;
use App\Http\Controllers\MantSliderContenidos_Controller;

Route::get('/CerrarFeria', [Eco_Controller::class, 'CerrarFeria']);
Route::post('/eco_SetClienteActivo', [Eco_Controller::class, 'SetClienteActivo']);
Route::post('/carrito', [Eco_Controller::class, 'carrito']);
Route::get('/categoryFeria', [Eco_Controller::class, 'categoryFeria']);
Route::any('/category', [Eco_Controller::class, 'category']);
/***********************************************/
Route::post('/mant_slidersEliminar', [MantSliders_Controller::class, 'Eliminar']);
Route::post('/mant_slidersGuardar', [MantSliders_Controller::class, 'Guardar']);
Route::get('/mant_sliders', [MantSliders_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_codigosdescuentosEliminarCodigo', [MantCodigosDescuentos_Controller::class, 'EliminarCodigo']);
Route::post('/mant_codigosdescuentosEliminarCliente', [MantCodigosDescuentos_Controller::class, 'EliminarCliente']);
Route::post('/mant_codigosdescuentosAgregarCliente', [MantCodigosDescuentos_Controller::class, 'AgregarCliente']);
Route::post('/mant_codigosdescuentosBuscarClientes', [MantCodigosDescuentos_Controller::class, 'BuscarClientes']);
Route::post('/mant_codigosdescuentosCargarDetalle', [MantCodigosDescuentos_Controller::class, 'CargarDetalle']);
Route::post('/mant_codigosdescuentosGuardar', [MantCodigosDescuentos_Controller::class, 'Guardar']);
Route::post('/mant_codigosdescuentosCrearEditar', [MantCodigosDescuentos_Controller::class, 'CrearEditar']);
Route::get('/mant_codigosdescuentos', [MantCodigosDescuentos_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_popupAgregar', [MantPopup_Controller::class, 'Agregar']);
Route::get('/mant_popup', [MantPopup_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_prodsincanjeEliminar', [MantProductosSinCanje_Controller::class, 'Eliminar']);
Route::post('/mant_prodsincanjeAgregar', [MantProductosSinCanje_Controller::class, 'Agregar']);
Route::get('/mant_prodsincanje', [MantProductosSinCanje_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_productosbloqueadosEliminar', [MantProductosBloqueados_Controller::class, 'Eliminar']);
Route::post('/mant_productosbloqueadosAgregar', [MantProductosBloqueados_Controller::class, 'Agregar']);
Route::get('/mant_productosbloqueados', [MantProductosBloqueados_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_paisesUpdateEstado', [MantPaises_Controller::class, 'UpdateEstado']);
Route::post('/mant_paisesGuardar', [MantPaises_Controller::class, 'Guardar']);
Route::post('/mant_paisesCrearEditar', [MantPaises_Controller::class, 'CrearEditar']);
Route::get('/mant_paises', [MantPaises_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_proveedoresUpdateEstado', [MantProveedores_Controller::class, 'UpdateEstado']);
Route::post('/mant_proveedoresGuardar', [MantProveedores_Controller::class, 'Guardar']);
Route::post('/mant_proveedoresCrearEditar', [MantProveedores_Controller::class, 'CrearEditar']);
Route::get('/mant_proveedores', [MantProveedores_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_marcasUpdateEstado', [MantMarcas_Controller::class, 'UpdateEstado']);
Route::post('/mant_marcasGuardar', [MantMarcas_Controller::class, 'Guardar']);
Route::post('/mant_marcasCrearEditar', [MantMarcas_Controller::class, 'CrearEditar']);
Route::get('/mant_marcas', [MantMarcas_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_bannersEliminarBanner', [MantBanners_Controller::class, 'EliminarBanner']);
Route::post('/mant_bannersEliminarProducto', [MantBanners_Controller::class, 'EliminarProducto']);
Route::post('/mant_bannersCargarDetalleBanner', [MantBanners_Controller::class, 'CargarDetalleBanner']);
Route::post('/mant_bannersAgregarProducto', [MantBanners_Controller::class, 'AgregarProducto']);
Route::post('/mant_bannersGuardar', [MantBanners_Controller::class, 'Guardar']);
Route::post('/mant_banners_crearEditar', [MantBanners_Controller::class, 'CrearEditar']);
Route::get('/mant_banners', [MantBanners_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_prodpromosregalosGuardar', [MantProdPromosRegalos_Controller::class, 'Guardar']);
Route::post('/mant_prodpromosregalosCargarProducto', [MantProdPromosRegalos_Controller::class, 'CargarProducto']);
Route::post('/mant_prodpromosregalosCrearEditar', [MantProdPromosRegalos_Controller::class, 'CrearEditar']);
Route::get('/mant_prodpromosregalos', [MantProdPromosRegalos_Controller::class, 'index']);
/***********************************************/
Route::post('/eco_RealizarPago', [Eco_Controller::class, 'RealizarPago']);
Route::post('/eco_UpdateComentario', [Eco_Controller::class, 'UpdateComentario']);
Route::post('/eco_UpdateDireccionDespacho', [Eco_Controller::class, 'UpdateDireccionDespacho']);
Route::post('/eco_UpdateOpcionDespacho', [Eco_Controller::class, 'UpdateOpcionDespacho']);
Route::post('/eco_ValidarCodigoDescuento', [Eco_Controller::class, 'ValidarCodigoDescuento']);
Route::post('/eco_addQuitarLinea', [Eco_Controller::class, 'addQuitarLinea']);
Route::post('/eco_ModificarUno', [Eco_Controller::class, 'ModificarUno']);
Route::post('/eco_getDetalleBolsa', [Eco_Controller::class, 'getDetalleBolsa']);
Route::post('/eco_getSubTotalBolsa', [Eco_Controller::class, 'getSubTotalBolsa']);
Route::post('/eco_addProducto', [Eco_Controller::class, 'addProducto']);
Route::post('/eco_getProductosDetalle', [Eco_Controller::class, 'getProductosDetalle']);
Route::post('/eco_getProductosActivos', [Eco_Controller::class, 'getProductosActivos']);
Route::get('/eco_index', [Eco_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_productoscaracteristicasEliminarOpcion', [MantProductosCaracteristicas_Controller::class, 'EliminarOpcion']);
Route::post('/mant_productoscaracteristicasGuardar', [MantProductosCaracteristicas_Controller::class, 'Guardar']);
Route::post('/mant_productoscaracteristicasGetOpciones', [MantProductosCaracteristicas_Controller::class, 'GetOpciones']);
Route::post('/mant_productoscaracteristicasCrearEditar', [MantProductosCaracteristicas_Controller::class, 'CrearEditar']);
Route::post('/mant_productoscaracteristicasUpdateEstado', [MantProductosCaracteristicas_Controller::class, 'UpdateEstado']);
Route::get('/mant_productoscaracteristicas', [MantProductosCaracteristicas_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_productossubfamilias_eliminar', [MantProductosSubFamilias_Controller::class, 'Eliminar']);
Route::post('/mant_productossubfamilias_Guardar', [MantProductosSubFamilias_Controller::class, 'Guardar']);
Route::post('/mant_productossubfamilias_crearEditar', [MantProductosSubFamilias_Controller::class, 'crearEditar']);
Route::post('/mant_productossubfamilias_updateEstado', [MantProductosSubFamilias_Controller::class, 'updateEstado']);
Route::get('/mant_productossubfamilias', [MantProductosSubFamilias_Controller::class, 'index']);
/***********************************************/

Route::post('/mant_productosfamiliasEliminarArchivo2', [MantProductosFamilias_Controller::class, 'EliminarArchivo2']);
Route::post('/mant_productosfamiliasEliminarArchivo1', [MantProductosFamilias_Controller::class, 'EliminarArchivo1']);
Route::post('/mant_productosfamiliasEliminarCaracteristica', [MantProductosFamilias_Controller::class, 'EliminarCaracteristica']);
Route::post('/mant_productosfamiliasCargarCaracteristicasFamilias', [MantProductosFamilias_Controller::class, 'CargarCaracteristicasFamilias']);
Route::post('/mant_productosfamiliasGuardarCaracteristica', [MantProductosFamilias_Controller::class, 'GuardarCaracteristica']);
Route::post('/mant_productosfamiliasCargarFormaCaracteristica', [MantProductosFamilias_Controller::class, 'CargarFormaCaracteristica']);
Route::post('/mant_productosfamiliasEliminar', [MantProductosFamilias_Controller::class, 'Eliminar']);
Route::post('/mant_productosfamiliasGuardar', [MantProductosFamilias_Controller::class, 'Guardar']);
Route::post('/mant_productosfamiliasCrearEditar', [MantProductosFamilias_Controller::class, 'CrearEditar']);
Route::post('/mant_productosfamiliasUpdateEstado', [MantProductosFamilias_Controller::class, 'UpdateEstado']);
Route::get('/mant_productosfamilias', [MantProductosFamilias_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_productosGetHistorialArchivos', [MantProductos_Controller::class, 'GetHistorialArchivos']);
Route::post('/mant_productosCargarCaracteristicasFamilia', [MantProductos_Controller::class, 'CargarCaracteristicasFamilia']);
Route::post('/mant_productosEliminarArchivo', [MantProductos_Controller::class, 'EliminarArchivo']);
Route::post('/mant_productosEliminar', [MantProductos_Controller::class, 'Eliminar']);
Route::post('/mant_productosGuardar', [MantProductos_Controller::class, 'Guardar']);
Route::post('/mant_productosCargarFamiliasSecundarias', [MantProductos_Controller::class, 'CargarFamiliasSecundarias']);
Route::post('/mant_productosCrearEditar', [MantProductos_Controller::class, 'CrearEditar']);
Route::post('/mant_productosUpdateEstado', [MantProductos_Controller::class, 'UpdateEstado']);
Route::get('/mant_productos', [MantProductos_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_vendedores_updateEstado', [MantVendedores_Controller::class, 'UpdateEstado']);
Route::post('/mant_vendedores_Guardar', [MantVendedores_Controller::class, 'Guardar']);
Route::post('/mant_vendedores_crearEditar', [MantVendedores_Controller::class, 'CrearEditar']);
Route::get('/mant_vendedores', [MantVendedores_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_clientes_GuardarSubFamilias', [MantClientes_Controller::class, 'GuardarSubFamilias']);
Route::post('/mant_clientes_GuardarUsuarioExistente', [MantClientes_Controller::class, 'GuardarUsuarioExistente']);
Route::post('/mant_clientes_updateEstadoUsuario', [MantClientes_Controller::class, 'UpdateEstadoUsuario']);
Route::post('/mant_clientes_EditarUsuario', [MantClientes_Controller::class, 'EditarUsuario']);
Route::post('/mant_clientes_GuardarUsuario', [MantClientes_Controller::class, 'GuardarUsuario']);
Route::post('/mant_clientes_crearEditar', [MantClientes_Controller::class, 'crearEditar']);
Route::get('/mant_clientes', [MantClientes_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_roles_eliminarRol', [MantRoles_Controller::class, 'Eliminar']);
Route::post('/mant_roles_Guardar', [MantRoles_Controller::class, 'Guardar']);
Route::post('/mant_roles_crearEditar', [MantRoles_Controller::class, 'crearEditar']);
Route::post('/mant_roles_updateEstado', [MantRoles_Controller::class, 'updateEstado']);
Route::get('/mant_roles', [MantRoles_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_slidercontenidosEliminar', [MantSliderContenidos_Controller::class, 'Eliminar']);
Route::post('/mant_slidercontenidosGuardar', [MantSliderContenidos_Controller::class, 'Guardar']);
Route::post('/mant_slidercontenidos_crearEditar', [MantSliderContenidos_Controller::class, 'crearEditar']);
Route::post('/mant_slidercontenidos_updateEstado', [MantSliderContenidos_Controller::class, 'updateEstado']);
Route::get('/mant_slidercontenidos', [MantSliderContenidos_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_noticiasEliminar', [MantNoticias_Controller::class, 'Eliminar']);
Route::post('/mant_noticiasGuardar', [MantNoticias_Controller::class, 'Guardar']);
Route::post('/mant_noticias_crearEditar', [MantNoticias_Controller::class, 'crearEditar']);
Route::post('/mant_noticias_updateEstado', [MantNoticias_Controller::class, 'updateEstado']);
Route::get('/mant_noticias', [MantNoticias_Controller::class, 'index']);
/***********************************************/
Route::post('/mant_usuariosGuardar', [MantUsuarios_Controller::class, 'Guardar']);
Route::post('/mant_usuarios_crearEditar', [MantUsuarios_Controller::class, 'crearEditar']);
Route::post('/mant_usuarios_updateEstado', [MantUsuarios_Controller::class, 'updateEstado']);
Route::get('/mant_usuarios', [MantUsuarios_Controller::class, 'index']);
/***********************************************/
Route::post('/usuarioPerfilUpdateInformacion', [UsuarioPerfil_Controller::class, 'updateInformacion']);
/***********************************************/
Route::post('/usuarioPerfilUpdateContasenia', [UsuarioPerfil_Controller::class, 'updateContrasenia']);
/***********************************************/
Route::get('/usuarioPerfil', [UsuarioPerfil_Controller::class, 'index']);
/***********************************************/
Route::post('/eco_LogOutFeria', [Login_Controller::class, 'LogOutFeria']);
Route::post('/eco_LoginFeria', [Login_Controller::class, 'LoginFeria']);
Route::post('/userLogin', [Login_Controller::class, 'userLogin']);
Route::get('/userLogout', [Login_Controller::class, 'userLogout']);
/***********************************************/
Route::get('/eco_noticias', [EcoPaginas_Controller::class, 'Noticias']);
Route::get('/eco_noticia', [EcoPaginas_Controller::class, 'DetalleNoticias']);
Route::get('/eco_contacto', [EcoPaginas_Controller::class, 'Contacto']);
Route::post('/eco_EnviarRegistro', [SendMail_Controller::class, 'EnviarRegistro']);
Route::post('/eco_EnviarCorreoContacto', [SendMail_Controller::class, 'EnviarCorreoContacto']);
Route::get('/eco_registrate', [EcoPaginas_Controller::class, 'registrate']);
Route::get('/eco_nosotros', [EcoPaginas_Controller::class, 'nosotros']);
Route::get('/eco_politicascomerciales', [EcoPaginas_Controller::class, 'politicascomerciales']);
/***********************************************/
Route::get('/', [Eco_Controller::class, 'index']);
Route::get('/home', [Home_Controller::class, 'index']);
/***********************************************/
Route::get('/login', [Login_Controller::class, 'index']);
/***********************************************/
Route::get('/index', function () {
    return view('index');
});

Route::get('/dashboard-alternate', function () {
    return view('dashboard-alternate');
});
/*App*/
Route::get('/app-emailbox', function () {
    return view('app-emailbox');
});
Route::get('/app-emailread', function () {
    return view('app-emailread');
});
Route::get('/app-chat-box', function () {
    return view('app-chat-box');
});
Route::get('/app-file-manager', function () {
    return view('app-file-manager');
});
Route::get('/app-contact-list', function () {
    return view('app-contact-list');
});
Route::get('/app-to-do', function () {
    return view('app-to-do');
});
Route::get('/app-invoice', function () {
    return view('app-invoice');
});
Route::get('/app-fullcalender', function () {
    return view('app-fullcalender');
});
/*Charts*/
Route::get('/charts-apex-chart', function () {
    return view('charts-apex-chart');
});
Route::get('/charts-chartjs', function () {
    return view('charts-chartjs');
});
Route::get('/charts-highcharts', function () {
    return view('charts-highcharts');
});
/*ecommerce*/
Route::get('/ecommerce-products', function () {
    return view('ecommerce-products');
});
Route::get('/ecommerce-products-details', function () {
    return view('ecommerce-products-details');
});
Route::get('/ecommerce-add-new-products', function () {
    return view('ecommerce-add-new-products');
});
Route::get('/ecommerce-orders', function () {
    return view('ecommerce-orders');
});

/*Components*/
Route::get('/widgets', function () {
    return view('widgets');
});
Route::get('/component-alerts', function () {
    return view('component-alerts');
});
Route::get('/component-accordions', function () {
    return view('component-accordions');
});
Route::get('/component-badges', function () {
    return view('component-badges');
});
Route::get('/component-buttons', function () {
    return view('component-buttons');
});
Route::get('/component-cards', function () {
    return view('component-cards');
});
Route::get('/component-carousels', function () {
    return view('component-carousels');
});
Route::get('/component-list-groups', function () {
    return view('component-list-groups');
});
Route::get('/component-media-object', function () {
    return view('component-media-object');
});
Route::get('/component-modals', function () {
    return view('component-modals');
});
Route::get('/component-navs-tabs', function () {
    return view('component-navs-tabs');
});
Route::get('/component-navbar', function () {
    return view('component-navbar');
});
Route::get('/component-paginations', function () {
    return view('component-paginations');
});
Route::get('/component-popovers-tooltips', function () {
    return view('component-popovers-tooltips');
});
Route::get('/component-progress-bars', function () {
    return view('component-progress-bars');
});
Route::get('/component-spinners', function () {
    return view('component-spinners');
});
Route::get('/component-notifications', function () {
    return view('component-notifications');
});
Route::get('/component-avtars-chips', function () {
    return view('component-avtars-chips');
});
/*Content*/
Route::get('/content-grid-system', function () {
    return view('content-grid-system');
});
Route::get('/content-typography', function () {
    return view('content-typography');
});
Route::get('/content-text-utilities', function () {
    return view('content-text-utilities');
});
/*Icons*/
Route::get('/icons-line-icons', function () {
    return view('icons-line-icons');
});
Route::get('/icons-boxicons', function () {
    return view('icons-boxicons');
});
Route::get('/icons-feather-icons', function () {
    return view('icons-feather-icons');
});
/*Authentication*/
Route::get('/authentication-signin', function () {
    return view('authentication-signin');
});
Route::get('/authentication-signup', function () {
    return view('authentication-signup');
});
Route::get('/authentication-signin-with-header-footer', function () {
    return view('authentication-signin-with-header-footer');
});
Route::get('/authentication-signup-with-header-footer', function () {
    return view('authentication-signup-with-header-footer');
});
Route::get('/authentication-forgot-password', function () {
    return view('authentication-forgot-password');
});
Route::get('/authentication-reset-password', function () {
    return view('authentication-reset-password');
});
Route::get('/authentication-lock-screen', function () {
    return view('authentication-lock-screen');
});
/*Table*/
Route::get('/table-basic-table', function () {
    return view('table-basic-table');
});
Route::get('/table-datatable', function () {
    return view('table-datatable');
});
/*Pages*/
Route::get('/user-profile', function () {
    return view('user-profile');
});
Route::get('/timeline', function () {
    return view('timeline');
});
Route::get('/pricing-table', function () {
    return view('pricing-table');
});
Route::get('/errors-404-error', function () {
    return view('errors-404-error');
});
Route::get('/errors-500-error', function () {
    return view('errors-500-error');
});
Route::get('/errors-coming-soon', function () {
    return view('errors-coming-soon');
});
Route::get('/error-blank-page', function () {
    return view('error-blank-page');
});
Route::get('/faq', function () {
    return view('faq');
});
/*Forms*/
Route::get('/form-elements', function () {
    return view('form-elements');
});

Route::get('/form-input-group', function () {
    return view('form-input-group');
});
Route::get('/form-layouts', function () {
    return view('form-layouts');
});
Route::get('/form-validations', function () {
    return view('form-validations');
});
Route::get('/form-wizard', function () {
    return view('form-wizard');
});
Route::get('/form-text-editor', function () {
    return view('form-text-editor');
});
Route::get('/form-file-upload', function () {
    return view('form-file-upload');
});
Route::get('/form-date-time-pickes', function () {
    return view('form-date-time-pickes');
});
Route::get('/form-select2', function () {
    return view('form-select2');
});
/*Maps*/
Route::get('/map-google-maps', function () {
    return view('map-google-maps');
});
Route::get('/map-vector-maps', function () {
    return view('map-vector-maps');
});
/*Un-found*/
Route::get('/test/content-grid-system', function () {
    return view('test/content-grid-system');
});
