<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Existencias</title>
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <link rel="shortcut icon" href="#" />
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
    <div id="app">
      @include('cabecera.nabvar')

      <!--contenido-->
        @yield('contenido')
      <!--Fin contenido-->
  </div>
    <footer class="app-footer">
        <div class="container">
            <div class="row">
               <div class="col-lg-4 col-md-6 col-12">
                  <div class="footer_blog_section">
                     <h6 class="text-uppercase">Valoración de existencias</h6>
                     <p style="margin-top: 5px;">Utilizando los métodos FIFO, LIFO y PMP</p>
                  </div>
               </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="footer_blog_section">
                        <h6 class="text-uppercase">UNCP - 2021</h6>
                        <p style="margin-top: 5px;">Facultad de Ing. Sistemas</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="footer_blog_section">
                        <h6 class="text-uppercase">Contacto</h6>
                        <p style="margin-top: 5px;">Celular: 920125043</p>
                    </div>
                </div>
            </div>
         </div>
         <center>
            <span>&copy; 2020</span>
            <span class="ml-auto">Desarrollado por J34N</span>
          </center>
    </footer>

    <script src="js/estilos.js"></script>
    <script src="js/app.js"></script>
  
</body>
</html>