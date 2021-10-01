const mix = require('laravel-mix');


mix.styles([
   'resources/assets/carpeta/css/bootstrap-grid.min.css',
   'resources/assets/carpeta/css/bootstrap-reboot.min.css',
   'resources/assets/carpeta/css/bootstrap.css',
   //'resources/assets/carpeta/css/bootstrap.min.css.map',
   'resources/assets/carpeta/css/sty.css',
], 'public/css/estilos.css')
.scripts([
   'resources/assets/carpeta/js/jquery-3.4.1.min.js',
   'resources/assets/carpeta/js/popper.min.js',
   'resources/assets/carpeta/js/bootstrap.bundle.min.js',
   'resources/assets/carpeta/js/bootstrap.min.js',
   //'resources/assets/carpeta/js/bootstrap.min.js.map',
   'resources/assets/carpeta/js/sweetalert2.all.js',
   'resources/assets/carpeta/js/all.min.js',
], 'public/js/estilos.js')
.js(['resources/js/app.js'], 'public/js/app.js');
