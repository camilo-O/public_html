<?php
    require_once("../models/validator.php");
    $validator = new Validator();
    if(isset($_COOKIE['token_aplicante']) && isset($_COOKIE['id_aplicante'])){      
      $perfil =  $validator ->validate($_COOKIE['token_aplicante'], $_COOKIE['id_aplicante'], 'perfil.php');
    }else{
      echo "<script> window.location = '../login.php' </script>";
    }
    $nombre = $perfil['nombre_aplicante'];
    $apellidos = $perfil['apellido_aplicante'];
    $hola = $perfil['nuip_aplicante'];

?>
<html lang="es" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Ser en Acción</title>
    <!--mobile-->
        <!--iconspack fontawesome-->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
    <!-- bootstrap css -->
    <!--<link rel="stylesheet" href="css/bootstrap.min.css"> PENDIENTE-->
    <!--style css-->
    <link rel="stylesheet" href="css/style_perfil_aplicante.css">
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
</head>
<body>
    <header>
      <div class="navbar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <p class="tituloser"><small>Candidato: </small> <?php echo $nombre . " " . $apellidos ;?></p>
            </br>
            <p class="mensajeser">
            <?php
              if($perfil['id_perfil_aplicante']==NULL){
                echo 'Empieza por completar tu perfil';
              }else if($perfil['id_hvc_aplicante']==NULL){
                echo 'No olvides certificar tus competencias completando tu Hoja de Vida Convencional';
              }else if($perfil['activo_aplicante']){
                echo 'Manten tu información actualizada para aumentar tus posibilidades de encontrar empleo';
              }else{
                echo 'Activa la visibilidad de tu perfil para que las empresas lo vean';
              }
            ?>            
            <small>
              <br>&nbsp;&nbsp;&nbsp;
            <?php
              if(isset($_COOKIE['visible']) && $_COOKIE['visible']=='si'){
                echo '<a href="#" id="visible" class="fa fa-toggle-on"></a> Ocultar tu perfil a las empresas';
              }else{
                echo '<a href="#" id="visible" class="fa fa-toggle-off"></a> Mostrar tu perfil a las empresas';
              }
            ?></small></p>
          </li>       
        </ul>
      </div>
    </header>
      <nav class="container-principal">
        <div class="sideBar-lateral small">  
          <ul class="">
              <li class="menu-item" id="btn">
                  <a href="#" class="item-active" title="Perfil">
                      <i class="fa fa-bars" aria-hidden="true" title="Perfil"></i>
                      <label class="item-descript">Perfil</label> 
                  </a>  
              </li>
              <li class="menu-item">
                  <a href="#" class="item-active" title="¿Donde han visto tu HVC?">
                      <i class="fa fa-flag" aria-hidden="true"></i>
                      <label class="item-descript">¿Donde han visto tu HVC?</label>   
                  </a>
              </li>
              <li class="menu-item">
                  <a href="body.php" class="item-active" title="Te explicamos el modelo SER">
                      <i class="fa fa-book" aria-hidden="true"></i>
                      <label class="item-descript">Te explicamos el modelo SER</label>     
                  </a>
              </li>
              <li class="menu-item">
                  <a href="../registro.php?tipo=aplicante" class="item-active" title="Actualizar Info de Contacto">
                      <i class="fa fa-cog" aria-hidden="true"></i>
                      <label class="item-descript">Actualizar Info de Contacto</label>        
                  </a>
              </li>
              <li class="menu-item">
                  <a href="#" class="item-active" title="FAQ's">
                      <i class="fa fa-comments-o" aria-hidden="true"></i>
                      <label class="item-descript">FAQ's</label>                                                    
                  </a>
              </li>
              <div class="opacity-log">
              <a type="submit" class="log_out" href="../controlers/submit.php?action=logout&tipo=aplicante">
                    Cerrar Sesión</a>
                </div>
              </div>
          </ul>
            </div>
            </nav>
    <article>
      <h2>Registra tu información personal</h2>
      <h5>Registra el formulario de "Tu hoja de vida Ser en Acción", donde presentarás tus competencias personales, laborales e intereses organizacionales. Luego registra tu información en el formulario "Tu hoja de vida convencional".</h5>
      <input id='location' value="aplicante" hidden></input>
      <div class="formularios cards">
            <div class="wrapper image_lab">
              <div class="data">
                <div class="content">
                  <h6 class="type">Formulario</h6>
                  <h3 class="title"><a href="#">Tu Hoja de vida <br>SER Potencial</a>
                  <h5 class="text">Registra tus competencias bajo el modelo de SER en ACCIÓN.</h5>
                  <a href="formulario.php?form=perfil_aplicante" class="button">
                    <?php
                      if($perfil['id_perfil_aplicante']==NULL){
                        echo 'Empieza Ahora';
                      }else{
                       echo 'Actualiza tu Perfil';
                      }
                    ?>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="formularios cards">
            <div class="wrapper image_hvc">
              <div class="data">
                <div class="content">
                  <h6 class="type">Formulario</h6>
                  <h3 class="title"><a href="#">Tu Hoja de vida <br>SER Experiencia</a>
                  <h5 class="text">Habla de los demás aspectos que son tenidos en cuenta en los procesos de selección.</h5>
                    <?php
                      if($perfil['id_perfil_aplicante']==NULL){
                        echo '<a href="#" id="perfil_incompleto" class="button">Empieza Ahora</a>';
                      }
                      else if($perfil['id_hvc_aplicante']==NULL){
                        echo '<a href="formulario.php?form=hvc" class="button">Empieza Ahora</a>';
                      }else{
                        echo '<a href="formulario.php?form=hvc" class="button">Actualiza tu HVC</a>';
                      }
                    ?>
                </div>
              </div>
            </div>
          </div>
          <div class="formularios cards">
            <div class="wrapper image_ikigai">
              <div class="data">
                <div class="content">
                  <h6 class="type">Formulario (PRÓXIMAMENTE)</h6>
                  <h3 class="title"><a href="#">Tu Hoja de vida <br>IKIGAI</a>
                  <h5 class="text">Habla de tu proceso como persona, donde hables de tus virtudes y pasiones.</h5>
                  <a href="#" class="button">No disponible
                  </a>
                </div>
              </div>
            </div>
          </div>
    </article>
    <footer>Footer</footer>
  </body>
    <?php
  if($perfil['id_perfil_aplicante']!=NULL){
    echo '<label id="id_perfil">'.$perfil['id_perfil_aplicante'].'</label>';
  }
  if($perfil['id_hvc_aplicante']!=NULL){
    echo '<label id="id_hvc">'.$perfil['id_hvc_aplicante'].'</label>';
  }
  ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type = "text/javascript" src="../js/scripts.js"></script>
<script typr = "text/javascript" src="../js/js.cookie.js"></script>
<script>
const button = document.querySelector('#btn');
button.addEventListener('click', (event) => 
event.target.closest('.sideBar-lateral').classList.toggle('small'));
</script> 
</html>

