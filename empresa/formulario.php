<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- bootstrap css -->
        <link rel="stylesheet" href="css/bootstrap.min.css"> <!--PENDIENTE-->
        <!--style css-->
        <link rel="stylesheet" href="css/formularios.css">
        <!--iconspack fontawesome-->
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
        <!--fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
        <?php
            require_once "../models/validator.php";
            $validator = new Validator();
            $requester = new Requester();
            if(isset($_COOKIE['token_empresa']) && isset($_COOKIE['id_empresa'])){
                $empresa = $validator ->validate($_COOKIE['token_empresa'], $_COOKIE['id_empresa'], 'perfil.php');
            }else{
                echo "<script> window.location = '../login.php' </script>";
            }
        ?>
        <title>Postula tu Vacante - SER en Acción</title> 
    </head>
    <body>
        <header>
            <div class="navbar">
            <a class="navbar-brand mr-auto" href="perfil.php"><img src="images/SER.png" alt="logo" height="30"></a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <?php
                        echo '<p class="tituloser">Postula tu Vacante</p>';
                        
                    ?>                        
                    </li>       
                </ul><br>
            </div>
        </header>
        <div id='loader'>
            <?php
                require_once('../models/loader.html');
            ?>
        </div>
        <div class="container notranslate">
            <?php
                require_once('../models/forms/vacante.php');
            ?>
        </div>
    </body>
</html>
