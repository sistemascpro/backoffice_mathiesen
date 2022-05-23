    <html lang="en"><head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/icon.css" rel="stylesheet">
  <link href="css/controls.css" rel="stylesheet">

  <!-- Load icon library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <title>Registro</title>
</head>

<body class="bodyRegistro">



  <div class="container contRegistro" style="margin-top: 45px;">
    <div class="row">
      <div class="col-xl-4 col-sm-12">
        <a class="navbar-brand" style="position:absolute; top:-28px;" href="/eco_index"><img src="https://www.grupomathiesen.com/wp-content/uploads/2020/07/LOGO-MATHIESEN.png" alt="Logo"></a>
      </div>
    </div>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/eco_index">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Inicio de sesión</li>
      </ol>
    </nav>

    <div class="center-card__body">
      <div class="center-card__header">
        <h1 class="center-card__title">¡Hola! Ingresa tu  e‑mail o usuario</h1>
      </div>
      <form class="row g-12" method="post" action="userLogin">
      @csrf

        <div class="col-12">
          <label for="exampleInputEmail1" class="form-label">Usuario </label>
          <input type="name" class="form-control" id="user" name="user"  aria-describedby="name" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
          <div id="name" class="form-text">Ingresa tu  e‑mail o usuario</div>
        </div>
      
        
       

        <div class="col-12">
          <label for="exampleInputpassword" class="form-label">Contraseña </label>
          <input type="password" class="form-control" id="password" name="password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
          <div id="pass" class="form-text">Ingresa tu contraseña de 8 caracteres</div>
        </div>
      

        
        
        <button type="submit" class="btn btn-primar  btn-lg btn-primary-mat" style="width:100%; margin-top:20px">Continuar</button>
        <p class="mt-3">
          <strong><a href="registro1.html" class="text-success">Regístrate</a></strong>
        </p>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body></html>