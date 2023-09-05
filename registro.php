<!DOCTYPE html>
<html lang="eS" dir="ltr">
  <head>
    
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <!--SER-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Ser en Acción</title>
    <!--mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!--PENDIENTE-->
    <!--style css-->
    <link rel="stylesheet" href="css/style_reg.css">
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
  </head>
<style>
.header {
  display: flex;
  justify-content: space-between;
  width: 99%;
  height: 116px;
  padding-top: 5px;
  padding-bottom: 45px;
}
.logo_ser {
  padding-top: 20px !important;
  position: relative;
}
.logo_ser a {
  float: left;
  padding: 11px 20px;
}
.titulo_pag {
  padding-top: 30px !important;
  font-family:'Montserrat', sans-serif;
  text-align: end;
  font-weight: 600;
  font-size:1.8vw;
  color:#1453a0;
  line-height: 1vw;
}
.form{
  margin: 0 auto;
  font-family:'Montserrat', sans-serif;
  font-weight: 500;
  width: 75%;
  padding: 1%;
  background:#ffffff;
  border:1px solid rgba(0, 0, 0, 0.075);
  margin-bottom:25px;
  color:#727272 !important;
  font-size:13px;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
#contenedor {
  width: 100%;
    display: flex;
    flex-wrap: wrap;
    display: inline-block;
}
#contenedor > div{
    display:inline-block;
    width: 47%;
    padding: 1%;
}
.titulo{
    padding-left: 1%;
    font-weight: 500;
    font-size: 40px;
}
.cajas{
    width: 100%;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 10px;
    border: none;
    border-left: 10px solid #1453a0;
    border-bottom: 1px solid #1453a0;
    transition: all .5s ease;
}
.chosen-container-single{
  width: 100%;
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 10px;
  border: none;
  border-left: 10px solid #1453a0;
  border-bottom: 1px solid #1453a0;
  transition: all .5s ease;
}
</style>
  <body>
    <?php
      require_once("models/validator.php");
      require_once("models/forms/form_elements/elementor.php");
      $validator = new Validator();
      $constructor = new Elementor();
      $tipo = $_GET['tipo'];
      if(isset($_COOKIE['tipo']) && isset($_COOKIE['token_'.$tipo]) && isset($_COOKIE['id_'.$tipo])){      
        $perfil =  $validator ->validate($_COOKIE['token_'.$tipo], $_COOKIE['id_'.$tipo], 'perfil.php');
      }else if(!isset($_GET['tipo'])){
          echo "<script> window.location = '../login.html' </script>";
      }
      if(isset($_GET['error']) && $_GET['error']=='repeated'){
          echo'
              <script>window.alert(Este correo ya ha sido utilizado)</script>
          ';
      }
    ?>
    <div class="header">
      <div class="logo_ser">
          <?php
            if(isset($perfil['email_'.$tipo])){
              echo'<a href="'.$tipo.'/perfil.php"><img src="icon/SER_logo.png" alt="Logo_SER" height="100"></br></a>';
            }else{
              echo'<a href="../login.php"><img src="icon/SER_logo.png" alt="Logo_SER" height="100"></br></a>';
            }
          ?>
      </div>
      <div class="titulo_pag">
        <br>INFORMACIÓN DE</br><br>USUARIO</br></a>
      </div>
    </div>
    <div id='loader'>
            <?php
                require_once('models/loader.html');
            ?>
        </div>
    <section id="main">
      <div id="tabs">
        <?php
          if(isset($_GET['tipo']) && $_GET['tipo']=='aplicante'){
            require_once('models/forms/registro_aplicante.php');
          }else{
            require_once('models/forms/registro_empresa.php');
          }
          
        if(isset($_GET['error']) && $_GET['error']=='repeated'){
          echo'
              <script>window.alert("Este correo ya ha sido utilizado")</script>
          ';
        }
        ?>
      </div>
    </section>
  </body>
</html>
