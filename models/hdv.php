<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        /*$id_aplicante = '1';
        $id_cargo = '25120';*/
        require_once('../models/requester.php');
        $requester = new Requester();

        $url = 'rest.serenaccion.com.co/aplicantes?token=no&except=dev_masabogalq&linkTo=id_aplicante&equalTo='.$id_aplicante;
        $aplicante = str_replace(array("\n", "[" , "]") , "", $requester->getFunction($url));
        $aplicante = json_decode($aplicante, true, 3)['results'];

        $id_perfil = $aplicante['id_perfil_aplicante'];
        $id_hvc = $aplicante['id_hvc_aplicante'];

        $url = 'rest.serenaccion.com.co/perfiles?token=no&except=dev_masabogalq&linkTo=id_perfil&equalTo='.$id_perfil;
        $perfil = str_replace(array("\n", "[" , "]") , "", $requester->getFunction($url));
        $perfil = json_decode($perfil, true, 3)['results'];

        $url = 'rest.serenaccion.com.co/hvcs?token=no&except=dev_masabogalq&linkTo=id_hvc&equalTo='.$id_hvc;
        $hvc = str_replace(array("\n", "[" , "]") , "", $requester->getFunction($url));
        $hvc = json_decode($hvc, true, 3)['results'];
        
        $url = 'https://get.serenaccion.com.co/serenacc_dictionaries/cargos';
        $cargos = $requester->getFunction($url);
        $cargos = json_decode($cargos, true, 512)['results'];

        $url = 'https://get.serenaccion.com.co/serenacc_dictionaries/municipios';
        $municipios = $requester->getFunction($url);
        $municipios = json_decode($municipios, true, 512)['results'];

        $url = 'https://get.serenaccion.com.co/serenacc_dictionaries/descript_comp_l';
        $comp_l = $requester->getFunction($url);
        $comp_l = json_decode($comp_l, true, 512)['results'];

        $url = 'https://get.serenaccion.com.co/serenacc_dictionaries/descript_comp_p';
        $comp_p = $requester->getFunction($url);
        $comp_p = json_decode($comp_p, true, 512)['results'];

        $url = 'https://get.serenaccion.com.co/serenacc_dictionaries/carac_organ';
        $carac = $requester->getFunction($url);
        $carac = json_decode($carac, true, 512)['results'];

        $image = file_get_contents('https://www.serenaccion.com.co/images/SER.png');
    ?>
    <header>
        <a class="navbar-brand mr-auto"><?php echo('<img width="100px" src="data:image/svg+xml;base64,' . base64_encode($image) . '">');?></a>
        <br>
        <a class="tituloser">Hoja de vida para el cargo:
        <br>
        <?php
            $cargo = array_search($id_cargo, array_column($cargos, 'id_cargo'));
            $cargo = $cargos[$cargo]['nombre_cargo'];
            print_r($cargo);
        ?>
    </header>
    <article>
        <div class="main">
            <div class="mainname">
                <a class="nombre"><?php print_r($aplicante['nombre_aplicante']) ?></a>
                <h4><?php print_r($aplicante['apellido_aplicante']) ?></h4>
            </div>
            <div class="contact">
                <div class="text">
                    <p class="details">Cédula: <a href=""><?php print_r($aplicante['nuip_aplicante']) ?></a></p>
                    <p class="details">Ciudad: <a href="">
                    <?php 
                        $municipio = array_search($aplicante['ciudad_aplicante'], array_column($municipios, 'id'));
                        $municipio = $municipios[$municipio]['municipio'].', '.$municipios[$municipio]['departamento'];
                        print_r($municipio);
                    ?></a></p>
                    <p class="details">Dirección: <a href=""><?php print_r($aplicante['direccion_aplicante']) ?></a></p>
                    <p class="details">Teléfono: <a href="tel:+57<?php print_r($aplicante['telefono_aplicante']) ?>" ><?php print_r($aplicante['telefono_aplicante']) ?></a></p><!--en el href poner el teléfono para que llame-->
                    <p class="details">Email: <a href="mailto:<?php print_r($aplicante['email_aplicante']) ?>"> <?php print_r($aplicante['email_aplicante']) ?></a></p><!--en el fref poner el corro electronico con el adicional mailto-->
                    <p class="details">Celular: <a href="tel:+57<?php print_r($aplicante['celular_aplicante']) ?>"><?php print_r($aplicante['celular_aplicante']) ?></a></p>
                </div>
                <br>
            </div>
        </div>
        <h3>Competencias:</h3>
        <h4>Laborales</h4>
        <?php
            $comps = explode(',',$perfil['comp_lab_perfil']);
            foreach($comps as $comp){
                $text = array_search($comp, array_column($comp_l, 'id_comp_l'));
                $text = $comp_l[$text]['descript'];
                echo'<h6> +'.$text.'</h6>';
            }
        ?>
        <br>&nbsp;
        <h4>Personales</h4>
        <?php
            $comps = explode(',',$perfil['comp_per_perfil']);
            foreach($comps as $comp){
                $text = array_search($comp, array_column($comp_p, 'id'));
                $text = $comp_p[$text]['comp'].': '.$comp_p[$text]['descript'];
                echo'<h6> +'.$text.'</h6>';
            }
        ?>
        <h4>Intereses Organizacionales</h4>
        <?php
            $tipo_gest = array_search($perfil['tipo_gest_emp_perfil'], array_column($carac, 'id'));
            $tipo_gest = $carac[$tipo_gest]['tipo_gest_emp'].': '.$carac[$tipo_gest]['desc_tipo_gest_emp'];
            echo'<h6>+ Tipo de gestión empresarial: '.$tipo_gest.'</h6><br>';

            $esti_de_lide = array_search($perfil['esti_de_lide_perfil'], array_column($carac, 'id'));
            $esti_de_lide = $carac[$esti_de_lide]['esti_de_lide'].': '.$carac[$esti_de_lide]['desc_esti_de_lide'];
            echo'<h6>+ Estilo de Liderazgo: '.$esti_de_lide.'</h6><br>';

            $esti_comu_inte = array_search($perfil['esti_comu_inte_perfil'], array_column($carac, 'id'));
            $esti_comu_inte = $carac[$esti_comu_inte]['esti_comu_inte'].': '.$carac[$esti_comu_inte]['desc_esti_comu_inte'];
            echo'<h6>+ Estilo de Comunicación interna: '.$esti_comu_inte.'</h6><br>';

            $bene_extr = array_search($perfil['bene_extr_perfil'], array_column($carac, 'id'));
            $bene_extr = $carac[$bene_extr]['bene_extr'].': '.$carac[$bene_extr]['desc_bene_extr'];
            echo'<h6>+ Estilo de Liderazgo: '.$bene_extr.'</h6><br>';

            $jorn_labo_sema = array_search($perfil['jorn_labo_sema_perfil'], array_column($carac, 'id'));
            $jorn_labo_sema = $carac[$jorn_labo_sema]['jorn_labo_sema'].': '.$carac[$jorn_labo_sema]['desc_jorn_labo_sema'];
            echo'<h6>+ Jornada Laboral Semanal: '.$jorn_labo_sema.'</h6><br>';

            $jorn_labo_dia = array_search($perfil['jorn_labo_dia_perfil'], array_column($carac, 'id'));
            $jorn_labo_dia = $carac[$jorn_labo_dia]['jorn_labo_dia'].': '.$carac[$jorn_labo_dia]['desc_jorn_labo_dia'];
            echo'<h6>+ Jornada Laboral Diaria: '.$jorn_labo_dia.'</h6><br>';

            $mode_de_trab = array_search($perfil['mode_de_trab_perfil'], array_column($carac, 'id'));
            $mode_de_trab = $carac[$mode_de_trab]['mode_de_trab'].': '.$carac[$mode_de_trab]['desc_mode_de_trab'];
            echo'<h6>+ Jornada Laboral Semanal: '.$mode_de_trab.'</h6><br>';
        ?>
    </article>
</body>
<style>
  @page {
      size: A4;
      margin: 1cm;
    }
  
    html, body {
      /*height: 100%;*/
      margin: 0;
      padding: 0;
    }
    body {
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1;
      padding: 1cm;
    }
*{
        font-family: "Montserrat";
        box-sizing: border-box;
        padding: 0;
        margin: 0;
    }
  
  h3 {
    font-family:'Montserrat', sans-serif;
    letter-spacing: 0;
    font-weight: 600;
    font-size: 40px;
    position: relative;
    line-height: normal;
    color:#1453a0;
  }
  
  h4 {
    font-family:'Montserrat', sans-serif;
    letter-spacing: 0;
    font-weight: 500;
    font-size: 30px;
    position: relative;
    line-height: normal;
    color:#1453a0;
  }
  
  h5 {
    font-family:'Montserrat', sans-serif;
    letter-spacing: 0;
    font-weight: 500;
    font-size: 25px;
    position: relative;
    line-height: normal;
    color:#1453a0;
  }
  
  h6 {
    font-family:'Garamond', sans-serif;
    letter-spacing: 0;
    font-weight: 400;
    font-size: 20px;
    position: relative;
    padding: 10px 10px 10px 10px;
    line-height: normal;
    color:#282828;
  }
  
  body {
    display: grid;
    grid-template:
        "header header  header"   auto
        "article article article"   auto
        "footer footer  footer"     auto ;
  }
  header {
    grid-area: header;
  }
  article {
    grid-area: article;
    padding: 1em 5em;
    height: 100%;
    overflow: hidden;
    text-justify: auto;
    text-align: justify;
  }
  .container{
    grid-area: article;
  }
  
  nav {
    grid-area: nav;
  }
  
  footer {
    grid-area: footer;
  }
    header {
    background-color: #1453a0;
    height: 13vh;
    padding: 15px 80px;
    align-items: center;
    display: flex;  
    flex-direction: center;  
    z-index: 10;
    justify-content: space-between;
    align-items: center;
  }
  .tituloser{
    color: #fff;
    text-align: end;
  }
  /*.main{
    border-style:solid;
    border-color: #1453a0;
    margin-bottom: 30px;
  }*/
  .mainname{
    display:inline-block;
    text-align: center;
    width: 100%;
    padding-bottom: 20px;
  }
  .contact{
    display:flex;
    align-items: center;
    justify-content: space-between;
  }
  a{
    text-decoration: none;
    color: #2f2f2f;
  }
  .photo{
    height: 200px;
  }
  .nombre{
    font-family:'Montserrat', sans-serif;
    font-weight: 500;
    font-size: 40px;
    color:#1453a0;
    padding-bottom: 30px;
  }
  .details{
    font-size: 25px;
    color: #1453a0;
  }
</style>
</html>