<?php
    require_once("../models/validator.php");
    $validator = new Validator();
    $requester = new Requester();
    if(isset($_COOKIE['token_empresa']) && isset($_COOKIE['id_empresa'])){
        $perfil = $validator ->validate($_COOKIE['token_empresa'], $_COOKIE['id_empresa'], 'perfil.php');
    }else{
        echo'<script>window.location="../login.php";</script>';
    }
    $id = $perfil['id_empresa'];
    $nombre = $perfil['nombre_empresa'];
    $nit = $perfil['nit_empresa'];
    $ciudad = $perfil['ciudad_empresa'];
    $sector = $perfil['sector_empresa'];
    
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_perfil_empresa.css">
    <!--iconspack fontawesome-->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
    <!-- fevicon -->
    <link rel="icon" href="icon/SER_logo.png" type="image/gif" /> <!--PENDIENTE-->
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
  <
    <title>Ser Empresa</title>
</head>
<body>
  <header>
    <div class="navbar">
        <ul class="navbar-nav">
            <li class="nav-item">
              <a><?php echo $nombre . " - Nit: " . $nit  ?></a>
              <a href="../empresa/pasarela_pagos.php">
              
                <h5>Hazte premium</h5>
            
              </a>
            </li>
        </ul>
    </div>
  </header>
  <nav class="container-principal">
    <div class="sideBar-lateral small">  
      <ul class="">
          <li class="menu-item" id="btn">
              <a href="#" class="item-active" title="Perfil">
                  <i class="fa fa-bars" aria-hidden="true"></i>
                  <label class="item-descript">Perfil</label> 
              </a>  
          </li>
          <li class="menu-item">
              <a href="#" class="item-active" title="Te explicamos el modelo SER">
                  <i class="fa fa-book" aria-hidden="true"></i>
                  <label class="item-descript">Te explicamos el modelo SER</label>     
              </a>
          </li>
          <li class="menu-item">
              <a href="../registro.php?tipo=empresa" class="item-active" title="Actualizar Info de Contacto">
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
          <a type="submit" class="log_out" href="../controlers/submit.php?action=logout&tipo=empresa">
                Cerrar Sesión</a>
            </div>
          </div>
      </ul>
    </div>
  </nav>
  <article>
    <h2>Formularios del perfil</h2>
      <div class="postular cards">
        <div class="wrapper img_postular">
          <div class="data">
            <div class="content">
              <h6 class="type">Formulario</h6>
              <h1 class="title"><a href="#">Formulario para postultar un proceso de selección - SER</a><!--me toca hacer la página de explicar el modelo, por preguntar a Mónica, si no pues borrar el hipervinculo--></h1>
              <h5 class="text">Registra tu vacante bajo el modelo SER.</h5>
              <a class="button" id="postular_vacante">Postular Vacante</a><!--valida si ya tiene completa el perfil para poner (Editar o Empieza ahora)-->
            </div>
          </div>
        </div>
      </div>
      <section>
      <h2>Procesos de selección en curso</h2>
      </section>
  <?php
      if(isset($perfil['id_vacante_empresa'])){
        $url = 'rest.serenaccion.com.co/vacantes?linkTo=activa_vacante,id_empresa_vacante&equalTo=SI,'.$perfil['id_empresa'].'&token=no&except=dev_masabogalq&table=vacantes&sufix=vacante';
        $vacantes = str_replace(array("\n") , "", $requester -> getFunction($url));
        $vacantes = json_decode($vacantes, true, 4);
        if($vacantes['status']==200){
          $vacantes = $vacantes['results'];
          $ids = '';
          foreach($vacantes as $vacante){
            if($ids!=''){
              $ids.=',';
            }
            $ids.=$vacante['id_vacante'];
            echo '
            <div class="formularios cards1">
            <div class="wrapper img_proceso1">
            <div class="data">
            <div class="content">
            <h6 class="type">Proceso de selección #'.$vacante['id_vacante'].'</h6>
            <h3 class="title" id="cargo_'.$vacante['id_vacante'].'" class="text">'.$vacante['cargos_vacante'].'</h3>
                              <a id="ventana_'.$vacante['id_vacante'].'" class="button" target="_blank" rel="noopener noreferrer">Acceder a la Matriz</a>
                              <a id="editar_'.$vacante['id_vacante'].'" class="button" href="formulario.php?update=true&id='.$vacante['id_vacante'].'" rel="noopener noreferrer">Editar la Vacante</a>
                              </div>
                          </div>
                        </div>
                        </div>';
          }
          echo '<input id="ids_vacs" value="'.$ids.'" hidden></a>';
        }
      }
  ?>
  <section>
    <h2>Procesos de selección culminados</h2>
  </section>
  <section>
  <?php
      if(isset($perfil['id_vacante_empresa'])){
        $url = 'rest.serenaccion.com.co/vacantes?linkTo=activa_vacante,id_empresa_vacante&equalTo=NO,'.$id.'&token=no&except=dev_masabogalq&table=vacantes&sufix=vacante';
        $vacantes = str_replace(array("\n") , "", $requester -> getFunction($url));
        $vacantes = json_decode($vacantes, true, 4)['results'];
        if($vacantes != 'Not Found'){
          $ids = '';
          foreach($vacantes as $vacante){
            if($ids!=''){
              $ids.=',';
            }
            $ids.=$vacante['id_vacante'];
            echo '
            <div>
            <div class="formularios cards1">
            <div class="wrapper img_proceso2">
            <div class="data">
            <div class="content">
            <h6 class="type">Proceso de selección #'.$vacante['id_vacante'].'</h6>
            <h3 class="title" id="cargo_'.$vacante['id_vacante'].'" value="'.$vacante['cargos_vacante'].'" class="text">'.$vacante['cargos_vacante'].'</h3>
            <a id="ventana_'.$vacante['id_vacante'].'" class="button" target="_blank" rel="noopener noreferrer">Acceder a la Matriz</a>
            <a id="editar_'.$vacante['id_vacante'].'" class="button" href="../controlers/submit.php?cancel_vacante=false&id='.$vacante['id_vacante'].'" rel="noopener noreferrer">Reabrir la Vacante</a>
            </div>
            </div>
            </div>
            </div>
            </div>';
          }
          echo '<input id="ids_vacs_closed" value="'.$ids.'" hidden></a>';
        }else{
          echo'No tienes procesos Culminados';
        }
      }
    ?>
    </section>
  </article>
  <aside>
  <h2>Créditos</h2>
    <div class="formularios cards">
      <div class="wrapper image_per">
        <div class="data">
          <div class="content">
            </a><!--valida si ya tiene completa el perfil para poner (Editar o Empieza ahora)-->
          </div>
        </div>
      </div>
    </div>
  </aside>
  <footer>
    Footer
  </footer>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<script>
  const button = document.querySelector('#btn');
  button.addEventListener('click', (event) => 
  event.target.closest('.sideBar-lateral').classList.toggle('small'));
</script>
<script type = "text/javascript" src="../js/empresa.js"></script> <!--por meter en carpeta-->

<style>
  .boton_pago{
  margin-left: 150%;
  background-color:azure;
  padding: 50px;
  border-color: white;
  }

</style>
</html>