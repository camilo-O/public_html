<!DOCTYPE html>
<html lang="eS" dir="ltr">
  <head> 
    
      <!--SER-->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Iniciar sesión - Ser en Acción</title>
      <!--mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css"> <!--PENDIENTE-->
      <!--style css-->
      <link rel="stylesheet" href="css/style_newlogin.css">
      <!--fonts-->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    </head>
    <body>
      <?php
        require_once('models/forms/form_elements/elementor.php');
        require_once('models/requester.php');
        $requester = new Requester();
        $constructor = new Elementor();
        if(!isset($_GET['tipo']) && !isset($_COOKIE['tipo'])){
          require_once('models/login_inicial.html');
        }else if(isset($_GET['tipo'])){
          $requester->storeCookie('tipo', $_GET['tipo'], 604800);
          echo'<input id="tipo_previo" value="'.$_GET['tipo'].'" hidden/>';
          require_once('models/login_final.php');
        }else{
          $requester->storeCookie('tipo', $_COOKIE['tipo'], 604800);
          echo'<input id="tipo_previo" value="'.$_COOKIE['tipo'].'" hidden/>';
          require_once('models/login_final.php');
        }
        if(isset($_GET['warning']) && $_GET['warning']=='registro'){
          echo'
          <script>alert("Revise su correo para validar la cuenta y terminar el registro")</script>
          ';
        }else if(isset($_GET['warning']) && $_GET['warning']=='correo_password'){
          echo'
          <script>alert("Revise su correo para continuar con el cambio de contraseña")</script>
          ';
        }else if(isset($_GET['warning']) && $_GET['warning']=='correo_activar'){
          echo'
          <script>alert("Revise su correo para continuar con la activación de su cuenta")</script>
          ';
        }
      ?>
      
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="js/js.cookie.js"></script>
      <script src="js/jquery.validate.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="js/functions.js"></script>
      <script  src="js/script_login.js"></script>  
      <script>
          $(document).ready(function(){
              $('#loginModal').show()
          })
      </script>
      </body>
</html>