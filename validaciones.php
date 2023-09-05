<html>
  <head>
    <!--SER-->
    <meta charset="utf-8">
    <meta name="viewport" content="ºdth=device-width, initial-scale=1.0">
    <title>Registro - Ser en Acción</title>
    <!--mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!--PENDIENTE-->
    <!--style css-->
    <link rel="stylesheet" href="css/formularios.css">
    <!-- Responsive-->
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" /> <!--PENDIENTE-->
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
  </head>
  <body>
  <header>
    <div class="navbar">
      <a class="navbar-brand mr-auto" href="../login.php"><img src="images/SER.png" alt="logo" height="30"></a>
      </ul>
    </div>
        </header>
        <article>
          <?php
            include_once('models/validator.php');
            include_once('models/forms/form_elements/elementor.php');
            $constructor = new Elementor();
            $validator = new Validator();
            $tipo = $_GET['tipo'];
            setcookie('tipo', $tipo, time()+1, '/', 'serenaccion.com.co', 1, 1);
            $_COOKIE['tipo'] = $tipo;
            if(isset($_GET['token']) && isset($_GET['id'])){   
              $perfil =  $validator ->validate($_GET['token'], $_GET['id'], '');
            }else if(isset($_GET['id'])){
              echo "<script>window.location='login.php'</script>";
            }
            $solicitud = $_GET['solicitud'];
            if( $solicitud =='verificar_correo'){
              if($validator->activarCuenta($_GET['token'], $_GET['id'],$_GET['tipo'])=='activación completa'){
                echo'<p>Tu cuenta ha sido activada satisfactoriamente, ahora puedes ingresar</p>';
                echo'<a class="btn btn-primary" href="login.php">Ir a Login</a>';
              }else{
                echo'<p>Esta cuenta ya ha sido activada, si tiene problemas contactese con servicio técnico</p>';
                echo'<a class="btn btn-primary" href="login.php">Ir a Login</a>';
              }
            }else if( $solicitud == 'reset_pass'){
              if(isset($_GET['error']) && $_GET['error'] == 'wrong_email'){
                echo'Usuario incorrecto, introduzca el correo q utilizó para registrarse (Correo de representante para empresas)';
              }
              echo'<form action="controlers/submit.php" method="POST">';
                $constructor->inputElement('email', 'email', 'Correo Electrónico', 'email', '', 'Correo Electrónico', 'caja', '', '', 'required', '');
              echo'
                <input name="tipo" value="'.$_GET['tipo'].'" hidden/>
                <input name="reset" value="noauth" hidden/>
                <button>Confirmar</button>
              </form>';
            }else if($solicitud == 'activar_cuenta'){
              $tipo = $_GET['tipo'];
              $email = $_GET['email'];
              if(isset($_GET['error']) && $_GET['error']=='wrong_credentials'){
                echo'intentelo de nuevo';
              }
              echo'
              <p>Confirma tus datos</p>
              <form  action="controlers/submit.php" method="POST">
                <input name="activar" value="true" hidden/>';
                $constructor->loginFormConfirm($tipo, $email);
              echo '
              </form>';
            }else if($solicitud == 'reset_pass_request'){ 
              echo'
              <form  action="controlers/submit.php" method="POST">
                <input name="id" value="'.$_GET['id'].'" hidden />
                <input name="email" value="'.$_GET['email'].'" hidden />';
                $constructor->inputElement('new_password', 'new_password', 'Nueva Contraseña', 'password', '', 'Nueva Contraseña', 'caja', '', '', 'required', '');
                $constructor->inputElement('cnew_password', 'cnew_password', 'Confirmar Contraseña', 'password', '', 'Confirmar Contraseña', 'caja', '', '', 'required', '');
                echo'
                <input name="reset" value="auth" hidden/>
                <input name="tipo" value="'.$_GET['tipo'].'" hidden/>
                <button>Confirmar</button>
              </form>';
            }
          ?>
        </article>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
  <script src="js/jquery.validate.js"></script>
  <script>
    $.validator.addMethod("password", function(value, element) {
            // The password must contain at least one uppercase letter, one special character, one number, and be at least 8 characters long
            return this.optional(element) || /^(?=.*[A-Z])(?=.*\d)(?=.*\W)[a-zA-Z0-9\S]{8,}$/.test(value);
          }, "Su contrasña debe terner al menos 8 caracteres, un número, una letra en mayúscula y un símbolo");
        $("form").validate({
            rules:{
                "email":{
                    email: true
                },
                "new_password":{
                    password: true
                },
                "cnew_password":{
                    equalTo: '#new_password'
                }
            },messages: {
                "email":{
                    email: 'Por favor use una dirección de correo electrónico valida'
                }
            },
            submitHandler: function(form) {
                form.submit();
            }, lang: 'es'
        });
  </script>
</html>