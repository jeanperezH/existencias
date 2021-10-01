<nav class="navbar navbar-expand-lg navbar-dark bg-primary" class="nav">
    
    <div class="container">
        <a @click="menu=0" class="navbar-brand " href="#">Valoración de Existencias</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li @click="menu=1" class="nav-item active">
            <a class="nav-link" href="#"><i class="fas fa-arrow-circle-down" > </i>COMPRAS</a>
        </li>
        <li @click="menu=2" class="nav-item active">
            <a class="nav-link" href="#"><i class="fas fa-arrow-circle-up" > </i>VENTAS</a>
        </li>
        <li @click="menu=3" class="nav-item active">
            <a class="nav-link" href="#"><i class="fas fa-cog" > </i>KPI</a>
        </li>
      </ul>
      
      <ul class="nav navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-shield"></i> J34N
                </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#"><i class="fas fa-user-edit"></i> Cuenta</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </div>
    </div>
</nav>