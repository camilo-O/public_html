<!--style css-->
<html>
  <head>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!--PENDIENTE-->
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" /> <!--PENDIENTE-->
    <!--iconspack fontawesome-->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/matriz.css">
  </head>
  <body>
    <div class="header">
      <div class="logo_ser">
        <a href="../login.html"><img src="icon/SER_logo.png" alt="Logo_SER" height="100"></br></a>
      </div>
      <div class="titulo_pag">
        <br>MATRIZ DE</br><br>CONGRUENCIA</br></a>
      </div>
    </div>
    <br>
    <br>
    <h3 id='cargo'><?php
      include_once('../models/requester.php');
      include_once('../models/algorythms.php');
      $requester = new Requester();
      $algorythms = new Algorythms();
      $url = 'rest.serenaccion.com.co/vacantes?linkTo=id_vacante&equalTo='.$_GET['id'].'&token=no&except=dev_masabogalq&table=vacantes&sufix=vacante';
      $vacante_data = str_replace(array("\n", "[" , "]") , "", $requester -> getFunction($url));
      $vacante_data = json_decode($vacante_data, true, 3)['results'];
      $cargo = explode(',',$vacante_data['cargos_vacante']);
      echo($cargo[0]);
    ?></h3>
    <table class="content-table">
      <div class="caja">
        <thead>
          <tr>
            <th>Código</th>
            <th>% de competencia <br> laboral</th>
            <th>% de competencia <br> personal</th>
            <th>% de caracteristicas <br> organizacionales</th>
            <th>Resultado total</th>
            <th>Comprar</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $Vacante =[
                "cargos_perfil"=>$vacante_data['cargos_vacante'],
                "comp_per_perfil"=>$vacante_data['comp_per_vacante'],
                "comp_lab_perfil"=>$vacante_data['comp_lab_vacante'],
                "tipo_gest_emp_perfil"=>$vacante_data['tipo_gest_emp_vacante'],
                "esti_de_lide_perfil"=>$vacante_data['esti_de_lide_vacante'],
                "esti_comu_inte_perfil"=>$vacante_data['esti_comu_inte_vacante'],
                "bene_extr_perfil"=>$vacante_data['bene_extr_vacante'],
                "jorn_labo_sema_perfil"=>$vacante_data['jorn_labo_sema_vacante'],
                "jorn_labo_dia_perfil"=>$vacante_data['jorn_labo_dia_vacante'],
                "mode_de_trab_perfil"=>$vacante_data['mode_de_trab_vacante'],
            ];
            $aplicantes = $algorythms -> buscarAplicantes($Vacante);
            if($aplicantes['status']==200){
              $aplicantes = $aplicantes['results'];
              foreach($aplicantes as $aplicante){
                echo '
                <form method="POST" action="../controlers/submit.php">
                  <tr>
                    <td>'.$aplicante['id_aplicante'].'</td>
                    <td>'.round($aplicante['comp_lab_porc_aplicante'],2).' %</td>
                    <td>'.round($aplicante['comp_per_porc_aplicante'],2).' %</td>
                    <td>'.round($aplicante['carac_orga_porc_aplicante'],2).' %</td>';
                    $total = (intval($aplicante['comp_lab_porc_aplicante'])+intval($aplicante['comp_per_porc_aplicante'])+intval($aplicante['carac_orga_porc_aplicante']))/3;
                    echo '<td>'.round($total,2).' %</td>';
                    echo '<input hidden name="id_aplicante" value="'.$aplicante['id_aplicante'].'"></input>';
                    echo '<input hidden name="id_cargo" value="'.$cargo[0].'"></input>';
                    echo '<input hidden name="porc_comp_lab" value="'.$aplicante['comp_lab_porc_aplicante'].'"></input>';
                    echo '<input hidden name="porc_comp_per" value="'.$aplicante['comp_per_porc_aplicante'].'"></input>';
                    echo '<input hidden name="porc_carac_orga" value="'.$aplicante['carac_orga_porc_aplicante'].'"></input>';
                    echo '<td><button>Comprar</button></td>
                  </tr>
                </form>';
                
              }
            }
          ?>
        </tbody>
      </div>
    </table>
      <?php
        echo'<label hidden> ____Aplicantes____ :'.json_encode($aplicantes).'</label>';
        echo'<label hidden> ____Vacante____ :'.json_encode($vacante_data).'</label>';
      ?>
    <a class='btn btn-info' id='cerrar_vacante'>Cerrar esta Vacante</a>
    <a class='btn btn-primary' id='cancel'>Volver</a>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script>
    var uri = 'https://get.serenaccion.com.co/serenacc_dictionaries/';
    $(document).ready(function(){
      $.get(uri+'cargos', function(data1, status1){
        data1 = JSON.parse(data1);
        data1 = data1['results'];
        var cargo = $('#cargo').text()
        cargo = data1.find(Element => Element.id_cargo == cargo)['nombre_cargo'];
        $('#cargo').text(cargo);
      })
      $('a').click(function(){
        var id = $(this).attr('id')
        if(id=='cancel'){
          window.opener.location.reload()
          window.close()
        }else if(id=='cerrar_vacante'){
          let id_vacante = window.location.href
          id_vacante = id_vacante.split('=')[1]
          cerrarVacante(1)
        }
      })
    })
    function cerrarVacante(id){
      if(confirm('Seguro que desea cerrar esta vacante? Puede reabrirla mas adelante')){
        window.opener.location = '../controlers/submit.php?cancel_vacante=true&id='+id
        window.close()
      }
    }
  </script>
</html>