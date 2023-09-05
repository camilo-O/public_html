<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!--PENDIENTE-->
    <!--style css-->
    <link rel="stylesheet" href="css/formularios.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" /> <!--PENDIENTE-->
    <!--iconspack fontawesome-->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <?php
        require_once "../models/validator.php";
        $validator = new Validator();
        setcookie('next_page', 'formulario.php', time()+60, '/aplicante', 'serenaccion.com.co', true, true);
        if(isset($_COOKIE['token_aplicante']) && isset($_COOKIE['id_aplicante'])){
            $perfil = $validator ->validate($_COOKIE['token_aplicante'], $_COOKIE['id_aplicante'], 'formulario.php');
        }else{
            echo "<script> window.location = '../login.php' </script>";
        }


    ?>
    <!--style css-->
        <title>Personaliza tu perfil - SER en Acción</title>    
    </head>
    <body>
        <header>
            <div class="navbar">
            <a class="navbar-brand mr-auto" href="perfil.php"><img src="images/SER.png" alt="logo" height="30"></a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <?php
                        if(isset($_GET['form']) && $_GET['form']=='hvc'){
                            echo '<p class="tituloser">Tu Hoja de Vida Convencional</p>';
                        }else{
                            echo '<p class="tituloser">Perfil de Usuario (Competencias)</p>';
                        }
                    ?>
                        
                    </li>       
                </ul>
            </div>
        </header>
        <div class="container">
            <?php
                if(isset($_GET['form']) && $_GET['form']=='hvc'){
                    require_once('../models/forms/completar_hvc.php');
                }else{
                    require_once('../models/forms/perfil_aplicante.php');
                }
            ?>
        </div>
    </body>    
</html>
