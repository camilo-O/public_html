<?php
    require_once('validator.php');
    require_once('requester.php');
    class SubmitModel{
      public $validator;
      function submitLogin($email, $password, $tipo){
        $requester = new Requester();
        $sufix = $tipo;
        $tabla = $tipo.'s';
        $url = 'rest.serenaccion.com.co/'.$tabla.'?login=true&sufix='.$sufix;
        $data = array(
            'email_'.$sufix => $email,
            'password_'.$sufix => $password
        );
        
        $perfil = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($data, $url));
        $perfil = json_decode($perfil, true, 3);
        if(isset($perfil['status']) && $perfil["status"] === 200){
          if($perfil['results']['correo_verificado_'.$sufix]=='si'){
            if(isset($_COOKIE['next_page']) && $_COOKIE['next_page']!=''){
                $next = $_COOKIE['next_page'];
            }else{
                $next = 'perfil.php';
            }
            $token = $perfil["results"]["token_".$sufix];
            $exp = $perfil["results"]["token_exp_".$sufix];
            $id = $perfil["results"]["id_".$sufix];
            if(isset($perfil['results']['activo_'.$sufix])){
                $visible = $perfil['results']['activo_'.$sufix];
                setcookie("visible", $visible, time()+900, '/');
            }
            setcookie("token_".$sufix, $token, time()+900, '/');
            setcookie("id_".$sufix, $id, time()+900, '/');
            setcookie("tipo", $sufix, time()+900, '/');
            setcookie("next_page", $next, time()+900, '/');
            setcookie("exp", $exp, time()+900, '/');
            setcookie("Email", $email, time()+3600);
            echo "<script>window.location = '../".$sufix."/".$next."'</script>";
          }else{
            setcookie("tipo", $sufix, time()+60, '/');
            setcookie("error","no_active",time()+60, '/');
            setcookie("Email", $email, time()+60, '/');
            echo "<script>window.location = '../login.php'</script>";
          }
        }else {
          setcookie("tipo", $sufix, time()+60*60*24*7, '/');
          setcookie("error","wrong_credentials",time()+60, '/');
          setcookie("Email", $email, time()+60, '/');
          echo "<script>window.location = '../login.php'</script>";
        }
      }
      function activarRequest($email, $password, $tipo){
        $requester = new Requester();
        $validator = new Validator();
        $sufix = $tipo;
        $tabla = $tipo.'s';
        $url = 'rest.serenaccion.com.co/'.$tabla.'?login=true&sufix='.$sufix;
        $data = array(
            'email_'.$sufix => $email,
            'password_'.$sufix => $password
        );
        
        $perfil = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($data, $url));
        $perfil = json_decode($perfil, true, 3);
        if(isset($perfil['status']) && $perfil["status"] === 200){
            $token = $perfil["results"]["token_".$sufix];
            $id = $perfil["results"]["id_".$sufix];
            $mail_status = $validator->mailValidation($email, $token, $id, $sufix);
            if($mail_status == 'Mensaje enviado correctamente'){
              echo "<script>window.location = '../login.php?warning=correo_activar'</script>";
            }else{
              echo "<script>window.location = '../validaciones.php?solicitud=activar_cuenta&tipo=".$tipo."&email=".$email."&error=wrong_credentials'</script>";
            }
        }else {
          echo "<script>window.location = '../login.php'</script>";
        }
      }

      function submitLogout($sufix){
          setcookie("token_".$sufix, '', time()+1, '/');
          setcookie("id_".$sufix, '', time()+1, '/');
          setcookie("next_page", '', time()+1, '/');
          setcookie("exp", '', time()+1, '/');
          setcookie('Email', '', time()+1, '/');
          if(isset($_COOKIE['perfil'])){
            setcookie('perfil', '', time()+1, '/');
          }
          if(isset($_COOKIE['visible'])){
            setcookie('visible', '', time()+1, '/');
          }
          echo '<script> window.location = "../index.php"</script>';
      }

      function submitPerfilAplicante(){
        $validator = new Validator();
        $requester = new Requester();
        $sufix = $_COOKIE['tipo'];
        $token = $_COOKIE['token_'.$sufix];
        $id = $_COOKIE['id_'.$sufix];
        $perfil_data = $validator->validate($token, $id, '');
        $cargos = '';
        $cod_fam_group = '2';
        if(!empty($_POST['cargos'])) {
          foreach($_POST['cargos'] as $check){
            if($cargos!=''){
              $cod_fam_group = $check;
              $cargos .= ',';
            }
            $cargos .= $check;
          }
        }
        $cargos = explode(',', $cargos);
        if(($otro = array_search('1', $cargos)) == 0 && isset($_POST['otro_cargo'])){
          array_splice($cargos, $otro, 1);
          $url = 'get.serenaccion.com.co/serenacc_dictionaries/cargos?token=no&except=dev_masabogalq';
          $post_data = array(
            'nombre_cargo' => $_POST['otro_cargo'],
            'gran_grupo' => '12'
          );
          $response = str_replace(array("\n", "[" , "]") , "", $requester->postFormulario($post_data, $url));
          $response = json_decode($response, true, 3);
          array_push($cargos, $response['results']['Last ID']);
        }
        $cargos = implode(',', $cargos);
        $comp_lab = '';
        if(!empty($_POST['comp_lab'])) {
          foreach($_POST['comp_lab'] as $check){
            if($comp_lab!=''){
              $comp_lab .= ',';
            }
            $comp_lab .= $check;
          }
        }
        if(isset($_POST['comp_lab_arr'])&& $_POST['comp_lab_arr']!=''){
          foreach(explode(',', $_POST['comp_lab_arr']) as $check){
            $url = 'get.serenaccion.com.co/serenacc_dictionaries/descript_comp_l?token=no&except=dev_masabogalq';
            $post_data = array(
              'descript' => $_POST['comp_lab_'.$check],
              'gran_grupo' => '12',
              'cod_fam_group' => $cod_fam_group
            );
            $response = str_replace(array("\n", "[" , "]") , "", $requester->postFormulario($post_data, $url));
            $response = json_decode($response, true, 3);
            if($comp_lab != ''){
              $comp_lab .= ',';
            }
            $comp_lab .= $response['results']['Last ID'];
          }
        }
        $comp_per = '';
        if(!empty($_POST['comp_per'])) {
        foreach($_POST['comp_per'] as $check){
            if($comp_per!=''){
            $comp_per .= ',';
            }
            $comp_per .= $check;
        }
        }
        if(isset($_POST['comp_per_arr']) && $_POST['comp_per_arr']!=''){
        foreach(explode(',', $_POST['comp_per_arr']) as $check){
            $url = 'get.serenaccion.com.co/serenacc_dictionaries/descript_comp_p?token=no&except=dev_masabogalq';
            $post_data = array(
            'comp' => $_POST['comp_per_'.$check],
            'descript' => $_POST['descript_comp_per_'.$check]
            );
            $response = str_replace(array("\n", "[" , "]") , "", $requester->postFormulario($post_data, $url));
            $response = json_decode($response, true, 3);
            if($comp_per!=''){
            $comp_per .= ',';
            }
            $comp_per .= $response['results']['Last ID'];
        }
        }
        
        $tipo_gest_emp = $_POST['tipo_gest_emp'];
        $esti_de_lide = $_POST['esti_de_lide'];
        $bene_extr = $_POST['bene_extr'];
        $jorn_labo_sema = $_POST['jorn_labo_sema'];
        $jorn_labo_dia = $_POST['jorn_labo_dia'];
        $esti_comu_inte = $_POST['esti_comu_inte'];
        $mode_de_trab = $_POST['mode_de_trab'];
        if(isset($_POST['id_perfil'])){
          $put_data = 'id_aplicante_perfil='.$id.
                      '&cargos_perfil='.$cargos.
                      '&comp_per_perfil='.$comp_per.
                      '&comp_lab_perfil='.$comp_lab.
                      '&tipo_gest_emp_perfil='.$tipo_gest_emp.
                      '&esti_de_lide_perfil='.$esti_de_lide.
                      '&bene_extr_perfil='.$bene_extr.
                      '&jorn_labo_sema_perfil='.$jorn_labo_sema.
                      '&jorn_labo_dia_perfil='.$jorn_labo_dia.
                      '&esti_comu_inte_perfil='.$esti_comu_inte.
                      '&mode_de_trab_perfil='.$mode_de_trab.
                      '&activo_en_perfil='.'si';
          $url = 'rest.serenaccion.com.co/perfiles?nameId=id_perfil&id='.$_POST['id_perfil'].'&token=no&except=dev_masabogalq';
          $response = str_replace(array("\n", "[" , "]") , "", $requester->putFunction($put_data, $url));
          $response = json_decode($response, true, 3);
        }else{
          $post_data = array(
            'id_aplicante_perfil' => $id,
            'cargos_perfil' => $cargos,
            'comp_per_perfil' => $comp_per,
            'comp_lab_perfil' => $comp_lab,
            'tipo_gest_emp_perfil' => $tipo_gest_emp,
            'esti_de_lide_perfil' => $esti_de_lide,
            'bene_extr_perfil' => $bene_extr,
            'jorn_labo_sema_perfil' => $jorn_labo_sema,
            'jorn_labo_dia_perfil' => $jorn_labo_dia,
            'esti_comu_inte_perfil' => $esti_comu_inte,
            'mode_de_trab_perfil' => $mode_de_trab,
            'activo_en_perfil' => 'si'
          );
          $url = 'rest.serenaccion.com.co/perfiles?token=no&table=perfiles&sufix=perfil&except=dev_msabogalq';
          $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($post_data, $url));
          $response = json_decode($response, true, 3);
        }
        if($response['status'] == 200){
          if(isset($response['results']['Last ID'])){
            $put_data = 'id_perfil_aplicante='.$response['results']['Last ID'];
            $url = 'rest.serenaccion.com.co/aplicantes?nameId=id_aplicante&id='.$id.'&token=no&except=dev_masabogalq';
            $putResponse = str_replace(array("\n", "[" , "]") , "", $requester->putFunction($put_data, $url));
            $putResponse = json_decode($putResponse, true, 3);
          }
          if($perfil_data['id_hvc_aplicante']!=NULL){
            $validator->cambiarVisibilidad('si', $perfil_data['id_aplicante']);
          }
          echo('<script>window.location="../aplicante/perfil.php"</script>');
        }else{
          echo('<script>window.location="../aplicante/formulario.php?form=perfil"</script>');
        }
      }

      function submitHVC(){
        $requester = new Requester();
        $validator = new Validator();
        $target_dir = realpath($_SERVER["DOCUMENT_ROOT"]).'/'.'uploads/';
        $sufix = $_COOKIE['tipo'];
        $token = $_COOKIE['token_'.$sufix];
        $id = $_COOKIE['id_'.$sufix];
        $perfil_data = $validator->validate($token, $id, '');
        $id_hvc = '';
        $response = '';
        if(!isset($_POST['id_hvc'])){
            $post_data = [];
            $url = 'rest.serenaccion.com.co/hvcs?token=no&table=hvcs&sufix=hvc&except=dev_msabogalq';
            $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($post_data, $url));
            $response = json_decode($response, true, 3);
            $id_hvc = $response['results']['Last ID'];
        }else{
            $id_hvc = $_POST['id_hvc'];
        }
        $ids_exps = '';
        $experiencias = explode(',', $_POST['exps_arr']);
        if(isset($_POST['exps_arr']) && $_POST['exps_arr'] != ''){
            $url = 'rest.serenaccion.com.co/exps?except=dev_masabogalq&token=no&linkTo=id_hvc_exp&equalTo='.$id_hvc;
            $exps = str_replace(array("\n") , "", $requester->getFunction($url));
            $exps = json_decode($exps, true, 4);
            if($exps['status']==200){
                $exps = $exps['results'];
                foreach($exps as $exp){
                    if(isset($_POST['nombre_empresa_'.$exp['id_exp']])){
                        $comp_lab_exp = implode(',',$_POST['comp_lab_exp_'.$exp['id_exp']]);
                        $comp_per_exp = implode(',',$_POST['comp_per_exp_'.$exp['id_exp']]);
                        $put_data = 
                            'id_hvc_exp='. $id_hvc.
                            '&nombre_empresa_exp='. $_POST['nombre_empresa_'.$exp['id_exp']].
                            '&fecha_inicio_exp='. $_POST['fecha_inicio_'.$exp['id_exp']].
                            '&fecha_salida_exp='. $_POST['fecha_salida_'.$exp['id_exp']].
                            '&cargo_exp='. $_POST['nombre_cargo_'.$exp['id_exp']].
                            '&comp_lab_exp='. $comp_lab_exp.
                            '&comp_per_exp='. $comp_per_exp;
                        if($_FILES!=NULL && isset($_FILES['cert_file_exp'.$exp['id_exp']]) && $_FILES['cert_file_exp'.$exp['id_exp']]['name']!=NULL){
                            $target_file = $target_dir . $id_hvc . '/' . $exp['id_exp'] . '/' .  basename($_FILES["cert_file_exp".$exp['id_exp']]["name"]);
                            move_uploaded_file($_FILES["cert_file_exp".$exp['id_exp']]["tmp_name"], $target_file);
                            $put_data.='cert_file_exp='.$target_file;
                        }
                        $url = 'rest.serenaccion.com.co/exps?nameId=id_exp&id='.$exp['id_exp'].'&token=no&except=dev_masabogalq';
                        $requester->putFunction($put_data, $url);
                        if ( in_array($exp['id_exp'], $experiencias)) {
                            $key = array_search($exp['id_exp'], $experiencias);
                            unset($experiencias[$key]);
                        }
                        if($ids_exps!=''){
                            $ids_exps.=',';
                        }
                        $ids_exps.=$exp['id_exp'];
                    }
                }
            }
            foreach($experiencias as $exp){
                if(isset($_POST['nombre_empresa_'.$exp])){
                    $comp_lab_exp = implode(',',$_POST['comp_lab_exp_'.$exp]);
                    $comp_per_exp = implode(',',$_POST['comp_per_exp_'.$exp]);
                    $post_data = array(
                        'id_hvc_exp' => $id_hvc,
                        'nombre_empresa_exp' => $_POST['nombre_empresa_'.$exp],
                        'fecha_inicio_exp' => $_POST['fecha_inicio_'.$exp],
                        'fecha_salida_exp' => $_POST['fecha_salida_'.$exp],
                        'cargo_exp' => $_POST['nombre_cargo_'.$exp],
                        'comp_lab_exp' => $comp_lab_exp,
                        'comp_per_exp' => $comp_per_exp
                    );
                    $url = 'rest.serenaccion.com.co/exps?token=no&table=exps&sufix=exp&except=dev_msabogalq';
                    $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($post_data, $url));
                    $response = json_decode($response, true, 3);
                    if (!file_exists($target_dir . $id_hvc . '/' . $response['results']['Last ID'] )) {     
                        mkdir($target_dir . $id_hvc . '/' . $response['results']['Last ID'] , 0777, true); 
                    }
                    $target_file = $target_dir . $id_hvc . '/' . $response['results']['Last ID'] . '/' .  basename($_FILES["cert_file_exp_".$exp]["name"]);
                    move_uploaded_file($_FILES["cert_file_exp_".$exp]["tmp_name"], $target_file);
                    $url = 'rest.serenaccion.com.co/exps?nameId=id_exp&id='.$response['results']['Last ID'].'&token=no&except=dev_masabogalq';
                    $put_data = 'cert_file_exp='.$target_file;
                    $requester->putFunction($put_data, $url);
                    if($ids_exps!=''){
                        $ids_exps.=',';
                    }
                    $ids_exps.=$response['results']['Last ID'];
                }
            }
        }
    
        $ids_formas = '';
        $formaciones = explode(',',$_POST['formas_arr']);
        if(isset($_POST['formas_arr']) && $_POST['formas_arr']!=''){
            $url = 'rest.serenaccion.com.co/formas?except=dev_masabogalq&token=no&linkTo=id_hvc_forma&equalTo='.$id_hvc;
            $formas = str_replace(array("\n") , "", $requester->getFunction($url));
            $formas = json_decode($formas, true, 4);
            if($formas['status']==200){
                $formas = $formas['results'];
                foreach($formas as $forma){
                    if(isset($_POST['tipo_forma_'.$forma['id_forma']])){
                        $comp_lab_forma = implode(',',$_POST['comp_lab_forma_'.$forma['id_forma']]);
                        $comp_per_forma = implode(',',$_POST['comp_per_forma'.$forma['id_forma']]);
                        if($_POST['tipo_forma_'.$forma['id_forma']]=='Primaria' || $_POST['tipo_forma_'.$forma['id_forma']]=='Bachillerato'){
                            $put_data = 
                                'id_hvc_forma=' .$id_hvc.
                                '&tipo_forma=' .$_POST['tipo_forma_'.$forma['id_forma']].
                                '&colegio_forma=' .$_POST['col_forma_'.$forma['id_forma']];
                        }else if($_POST['tipo_forma_'.$forma['id_forma']]=='Pregrado' || $_POST['tipo_forma_'.$forma['id_forma']]=='Posgrado'){
                            $put_data =
                                'id_hvc_forma=' .$id_hvc.
                                '&tipo_forma=' .$_POST['tipo_forma_'.$forma['id_forma']].
                                '&nivel_forma=' .$_POST['nivel_forma_'.$forma['id_forma']].
                                '&inst_forma=' .$_POST['inst_forma_'.$forma['id_forma']].
                                '&prog_forma=' .$_POST['prog_forma_'.$forma['id_forma']];
                        }else{
                            $put_data =
                                'id_hvc_forma=' .$id_hvc.
                                '&tipo_forma=' .$_POST['tipo_forma_'.$forma['id_forma']][0].
                                '&nivel_otro_forma=' .$_POST['nivel_otro_forma_'.$forma['id_forma']].
                                '&inst_otro_forma=' .$_POST['inst_otro_forma_'.$forma['id_forma']].
                                '&prog_otro_forma=' .$_POST['prog_otro_forma_'.$forma['id_forma']];                    
                        }
                        $put_data.=
                                '&comp_lab_forma='. $comp_lab_forma.
                                '&comp_per_forma='. $comp_per_forma;
                        if($_FILES!=NULL && $_FILES["cert_file_forma_".$forma['id_forma']]['name']!=NULL){
                            $target_file = $target_dir . $id_hvc . '/' . $forma['id_forma'] . '/' .  basename($_FILES["cert_file_forma_".$forma['id_forma']]["name"]);
                            move_uploaded_file($_FILES["cert_file_forma_".$forma['id_forma']]["tmp_name"], $target_file);
                            $put_data.='cert_file_forma='.$target_file;
                        }
                        $url = 'rest.serenaccion.com.co/formas?nameId=id_forma&id='.$forma['id_forma'].'&token=no&except=dev_masabogalq';
                        $requester->putFunction($put_data, $url);
                        if (in_array($forma['id_forma'],$formaciones)){
                            $key = array_search($forma['id_forma'], $formaciones);
                            unset($formaciones[$key]);
                        }
                        if($ids_formas!=''){
                            $ids_formas.=',';
                        }
                        $ids_formas.=$forma['id_forma'];
                    }
                }
            }
            foreach($formaciones as $forma){
                if(isset($_POST['tipo_forma_'.$forma])){
                    $comp_lab_forma = implode(',',$_POST['comp_lab_forma_'.$forma]);
                    $comp_per_forma = implode(',',$_POST['comp_per_forma_'.$forma]);
                    if($_POST['tipo_forma_'.$forma]=='Primaria' || $_POST['tipo_forma_'.$forma]=='Bachillerato'){
                        $post_data = array(
                            'id_hvc_forma' => $id_hvc,
                            'tipo_forma' => $_POST['tipo_forma_'.$forma],
                            'colegio_forma' => $_POST['col_forma_'.$forma]
                        );
                    }else if($_POST['tipo_forma_'.$forma]=='Pregrado' || $_POST['tipo_forma_'.$forma]=='Posgrado'){
                        $post_data = array(
                            'id_hvc_forma' => $id_hvc,
                            'tipo_forma' => $_POST['tipo_forma_'.$forma],
                            'nivel_forma' => $_POST['nivel_forma_'.$forma],
                            'inst_forma' => $_POST['inst_forma_'.$forma],
                            'prog_forma' => $_POST['prog_forma_'.$forma]
                        );
                    }else{
                        $post_data = array(
                            'id_hvc_forma' => $id_hvc,
                            'tipo_forma' => $_POST['tipo_forma_'.$forma],
                            'nivel_otro_forma' => $_POST['nivel_otro_forma_'.$forma],
                            'inst_otro_forma' => $_POST['inst_otro_forma_'.$forma],
                            'prog_otro_forma' => $_POST['prog_otro_forma_'.$forma]
                        );
                    }
                    $post_data['comp_lab_forma'] = $comp_lab_forma;
                    $post_data['comp_per_forma'] = $comp_per_forma;
                    $url = 'rest.serenaccion.com.co/formas?token=no&table=formas&sufix=forma&except=dev_msabogalq';
                    $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($post_data, $url));
                    $response = json_decode($response, true, 3);
                    if (!file_exists($target_dir . $id_hvc . '/' . $response['results']['Last ID'] )) {     
                        mkdir($target_dir . $id_hvc . '/' . $response['results']['Last ID'] , 0777, true); 
                    }
                    $target_file = $target_dir . $id_hvc . '/' . $response['results']['Last ID'] . '/' .  basename($_FILES["cert_file_forma_".$forma]["name"]);
                    move_uploaded_file($_FILES["cert_file_forma_".$forma]["tmp_name"], $target_file);
                    $url = 'rest.serenaccion.com.co/formas?nameId=id_forma&id='.$response['results']['Last ID'].'&token=no&except=dev_masabogalq';
                    $put_data = 'cert_file_forma'.$target_file;
                    $requester->putFunction($put_data, $url);
                    if($ids_formas!=''){
                        $ids_formas.=',';
                    }
                    $ids_formas.=$response['results']['Last ID'];
                }
            }
        }
        
        $url = 'rest.serenaccion.com.co/idiomas?nameId=id_hvc_idioma&id='.$id_hvc.'&token='.$token;
        $requester->deleteFunction($url);
        $ids_idiomas = '';
        if(isset($_POST['idiomas_select']) && !empty($_POST['idiomas_select'])){
            $url = 'rest.serenaccion.com.co/idiomas?token=no&table=idiomas&sufix=idioma&except=dev_msabogalq';
            foreach($_POST['idiomas_select'] as $value){
                $post_data= array(
                    'id_hvc_idioma' => $id_hvc,
                    'idioma_idioma' =>$value,
                    'nivel_hablado_idioma' => $_POST['nivel_hablado_'.$value],
                    'nivel_escrito_idioma' => $_POST['nivel_escrito_'.$value],
                    'nivel_leido_idioma' => $_POST['nivel_leido_'.$value]
                );
                $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($post_data, $url));
                $response = json_decode($response, true, 3);
                if($ids_idiomas != ''){
                    $ids_idiomas.=',';
                }
                $ids_idiomas.=$response['results']['Last ID'];
            }
        }
        $put_data = 'id_aplicante_hvc='.$id.
                    '&ids_idiomas_hvc='.$ids_idiomas.
                    '&sexo_hvc='.$_POST['sex'].
                    '&edad_hvc='.$_POST['edad'].
                    '&ciudad_hvc='.$_POST['ciudad_select'].
                    '&traslado_hvc='.$_POST['traslado'].
                    '&viaje_hvc='.$_POST['viajar'].
                    '&ids_experiencias_hvc='.$ids_exps.
                    '&ids_formaciones_hvc='.$ids_formas;
        $url = 'rest.serenaccion.com.co/hvcs?nameId=id_hvc&id='.$id_hvc.'&token=no&except=dev_masabogalq';
        $response = str_replace(array("\n", "[" , "]") , "", $requester->putFunction($put_data, $url));
        $response = json_decode($response, true, 3);
        
        if($response['status'] == 200){
          $put_data = 'id_hvc_aplicante='.$id_hvc;
          $url = 'rest.serenaccion.com.co/aplicantes?nameId=id_aplicante&id='.$id.'&token=no&except=dev_masabogalq';
          $response = str_replace(array("\n", "[" , "]") , "", $requester->putFunction($put_data, $url));
          $response = json_decode($response, true, 3);
          setcookie('next_page', 'aplicante', time()+60, '/');
          if($perfil_data['id_perfil_aplicante']!=NULL){
            $validator->cambiarVisibilidad('si', $perfil_data['id_aplicante']);
          }
          echo('<script>window.location="../aplicante/perfil.php"</script>');
        }else{
          echo('<script>window.location="../aplicante/formulario.php?form=hvc"</script>');
        }
      }
      
      function regAplicante(
        $nombre_aplicante,
        $apellidos_aplicante,
        $ciudad_aplicante,
        $celular_aplicante,
        $telefono_aplicante,
        $direccion_aplicante,
        $email_aplicante,
        $password_aplicante,
        $tipo_nuip_aplicante,
        $nuip_aplicante,
        $TermCond,
        $TratDatos
      ){
        $requester = new Requester();
        $validator = new Validator();
        $data = array(
            'nombre_aplicante' => $nombre_aplicante,
            'apellido_aplicante' => $apellidos_aplicante,
            'tipo_nuip_aplicante' => $tipo_nuip_aplicante,
            'nuip_aplicante' => $nuip_aplicante,
            'ciudad_aplicante' => $ciudad_aplicante,
            'apellido_aplicante' => $apellidos_aplicante,
            'email_aplicante' => $email_aplicante,
            'celular_aplicante' => $celular_aplicante,
            'telefono_aplicante' => $telefono_aplicante,
            'direccion_aplicante' => $direccion_aplicante,
            'password_aplicante' => $password_aplicante,
            'terminos_y_condiciones_aceptadas_aplicante' => $TermCond,
            'politica_tratamiento_datos_aceptada_aplicante' => $TratDatos
        );

        $url = 'rest.serenaccion.com.co/aplicantes?reg=true&sufix=aplicante';

        $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($data, $url));
        $response = stripslashes($response);
        $response = json_decode($response, true, 3);
        if(isset($response['status']) && $response["status"] === 200 ){
          $token = $response["results"]["token_aplicante"];
          $id = $response["results"]["id_aplicante"];
          $email = $response['results']['email_aplicante'];
          $mail_status = $validator->mailValidation($email, $token, $id, 'aplicante');
          if($mail_status == 'Mensaje enviado correctamente'){
            echo "<script>window.location = '../login.php?warning=registro&tipo=aplicante'</script>";
          }else{
            $requester->storeArrayAsCookies($data);
            echo "<script>window.location = 'error.php?error=failed_mail'</script>";
          }
        }else{

          echo "<script>window.location = '../../registro.php?tipo=aplicante&error=repeated'</script>";
        }
      }

      function updateAplicante(
        $nombre_aplicante,
        $apellidos_aplicante,
        $ciudad_aplicante,
        $celular_aplicante,
        $telefono_aplicante,
        $direccion_aplicante,
        $email_aplicante,
        $tipo_nuip_aplicante,
        $nuip_aplicante,
        $id_aplicante
      ){
        $requester = new Requester();
        $validator = new Validator();
        $data = 
            'nombre_aplicante='.$nombre_aplicante.
            '&apellido_aplicante='.$apellidos_aplicante.
            '&tipo_nuip_aplicante='.$tipo_nuip_aplicante.
            '&nuip_aplicante='.$nuip_aplicante.
            '&ciudad_aplicante='.$ciudad_aplicante.
            '&apellido_aplicante='.$apellidos_aplicante.
            '&email_aplicante='.$email_aplicante.
            '&celular_aplicante='.$celular_aplicante.
            '&telefono_aplicante='.$telefono_aplicante.
            '&direccion_aplicante='.$direccion_aplicante;

        $url = 'rest.serenaccion.com.co/aplicantes?nameId=id_aplicante&id='.$id_aplicante.'&token=no&except=dev_masabogalq';
        $response = str_replace(array("\n", "[" , "]") , "", $requester->putFunction($data, $url));
        $response = stripslashes($response);
        $response = json_decode($response, true, 3);
        if(isset($response['status']) && $response["status"] === 200 ){
          echo "<script>window.location = '../aplicante/perfil.php'</script>";
        }else{
          echo "<script>window.location = 'registro.php?tipo=aplicante'</script>";
        }
      }

      function regEmpresa(
        $nombre_empresa,
        $ciudad_empresa,
        $telefono_empresa,
        $nombre_rep_empresa,
        $nombre_rec_empresa,
        $email_rep_empresa,
        $email_rec_empresa,
        $password_empresa,
        $nit_empresa,
        $direccion_empresa,
        $celular_empresa,
        $sector_empresa,
        $tel_rec_empresa,
        $numero_empleados_empresa,
        $esti_de_lide_empresa,
        $tipo_gest_emp_empresa,
        $esti_comu_inte_empresa,
        $bene_extr,
        $jorn_labo_sema,
        $jorn_labo_dia,
        $mode_de_trab,
        $TermCond,
        $TratDatos
      ){
        $data = array(
          'nombre_empresa' => $nombre_empresa,
          'nit_empresa' => $nit_empresa,
          'ciudad_empresa' => $ciudad_empresa,
          'direccion_empresa' => $direccion_empresa,
          'telefono_empresa' => $telefono_empresa,
          'celular_empresa' => $celular_empresa,
          'representante_empresa' => $nombre_rep_empresa,
          'sector_empresa' => $sector_empresa,
          'reclutador_empresa' => $nombre_rec_empresa,
          'telefono_reclutador_empresa' => $tel_rec_empresa,
          'email_empresa' => $email_rep_empresa,
          'email_reclutador_empresa' => $email_rec_empresa,
          'password_empresa' => $password_empresa,
          'numero_empleados_empresa' => $numero_empleados_empresa,
          'esti_de_lide_empresa' => $esti_de_lide_empresa,
          'esti_comu_inte_empresa' => $esti_comu_inte_empresa,
          'tipo_gest_emp_empresa' => $tipo_gest_emp_empresa,
          'bene_extr_empresa' => $bene_extr,
          'jorn_labo_sema_empresa' => $jorn_labo_sema,
          'jorn_labo_dia_empresa' => $jorn_labo_dia,
          'mode_de_trab_empresa' => $mode_de_trab,
          'terminos_y_condiciones_aceptadas_empresa' => $TermCond,
          'politica_tratamiento_datos_aceptada_empresa' => $TratDatos
        );
        $requester = new Requester();
        $validator = new Validator();
        $url = 'rest.serenaccion.com.co/empresas?reg=true&sufix=empresa';

        $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($data, $url));
        $response = stripslashes($response);
        $response = json_decode($response, true, 3);
        if(isset($response['status']) && $response["status"] === 200 ){
          $token = $response["results"]["token_empresa"];
          $id = $response["results"]["id_empresa"];
          $email = $response['results']['email_empresa'];
          $mail_status = $validator->mailValidation($email, $token, $id, 'empresa');
          if($mail_status == 'Mensaje enviado correctamente'){
            echo "<script>window.location = '../login.php?warning=registro&tipo=empresa'</script>";
          }else{
            echo "<script>window.location = 'registro.php?tipo=empresa&error=failed_mail'</script>";
          }
        }else{
            $requester->storeArrayAsCookies($data);
            echo "<script>window.location = '../../registro.php?tipo=empresa&error=repeated'</script>";
        }
      }

      function updateEmpresa(
        $nombre_empresa,
        $ciudad_empresa,
        $telefono_empresa,
        $nombre_rep_empresa,
        $nombre_rec_empresa,
        $email_rep_empresa,
        $email_rec_empresa,
        $nit_empresa,
        $direccion_empresa,
        $celular_empresa,
        $sector_empresa,
        $tel_rec_empresa,
        $numero_empleados_empresa,
        $esti_de_lide_empresa,
        $tipo_gest_emp_empresa,
        $esti_comu_inte_empresa,
        $bene_extr,
        $jorn_labo_sema,
        $jorn_labo_dia,
        $mode_de_trab,
        $id_empresa
      ){
        $requester = new Requester();
        $validator = new Validator();
        $data =
          '&nombre_empresa='.$nombre_empresa.
          '&nit_empresa='.$nit_empresa.
          '&ciudad_empresa='.$ciudad_empresa.
          '&direccion_empresa='.$direccion_empresa.
          '&telefono_empresa='.$telefono_empresa.
          '&celular_empresa='.$celular_empresa.
          '&representante_empresa='.$nombre_rep_empresa.
          '&sector_empresa='.$sector_empresa.
          '&reclutador_empresa='.$nombre_rec_empresa.
          '&telefono_reclutador_empresa='.$tel_rec_empresa.
          '&email_empresa='.$email_rep_empresa.
          '&email_reclutador_empresa='.$email_rec_empresa.
          '&numero_empleados_empresa='.$numero_empleados_empresa.
          '&esti_de_lide_empresa='.$esti_de_lide_empresa.
          '&esti_comu_inte_empresa='.$esti_comu_inte_empresa.
          '&tipo_gest_emp_empresa='.$tipo_gest_emp_empresa.
          '&bene_extr_empresa='.$bene_extr.
          '&jorn_labo_sema_empresa='.$jorn_labo_sema.
          '&jorn_labo_dia_empresa='.$jorn_labo_dia.
          '&mode_de_trab_empresa='.$mode_de_trab;

        $url = 'rest.serenaccion.com.co/empresas?nameId=id_empresa&id='.$id_empresa.'&token=no&except=dev_masabogalq';

        $response = str_replace(array("\n", "[" , "]") , "", $requester->putFunction($data, $url));
        $response = stripslashes($response);
        $response = json_decode($response, true, 3);
        if(isset($response['status']) && $response["status"] === 200 ){
            echo "<script>window.location = '../empresa/perfil.php'</script>";
        }else{
            echo "<script>window.location = '../../registro.php?tipo=empresa'</script>";
        }
      }

      function resetPassNoauth($email, $tipo){
        $requester = new Requester();
        $validator = new Validator();
        $url = 'rest.serenaccion.com.co/'.$tipo.'s?update=true&sufix='.$tipo;
        $data = array(
        'email_'.$tipo => $email
        );
        $perfil = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($data, $url));
        $perfil = json_decode($perfil, true, 3);
        if(isset($perfil['status']) && $perfil['status']=='200'){
          $perfil = $perfil['results'];
          $result = $validator->mailPassword($perfil['email_'.$tipo], $perfil['id_'.$tipo], $perfil['token_'.$tipo], $tipo);
          if($result == 'Mensaje enviado correctamente'){
            echo '<script>window.location="../login.php?warning=correo_password"</script>';
          }
        }else{
          echo "<script>window.location = '../validaciones.php?solicitud=reset_pass&error=wrong_email&tipo=".$tipo."'</script>";
        }
      }

      function resetPassAuth($email, $id, $password, $tipo){
        $validator = new Validator();
        $validator->resetPassword($email, $id, $password, $tipo);
      }

      function submitVacante(){
        $requester = new Requester();
        $sufix = $_COOKIE['tipo'];
        $id = $_COOKIE['id_'.$sufix];
        $cargos = $_POST['cargos'];
        $gran_grupo = $_POST['gran_grupo'];
        if(!isset($_POST['id_vacante'])){
          $post_data = [];
          $url = 'rest.serenaccion.com.co/vacantes?token=no&table=vacantes&sufix=vacante&except=dev_msabogalq';
          $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($post_data, $url));
          $response = json_decode($response, true, 3);
          $id_vacante = $response['results']['Last ID'];
        }else{
            $id_vacante = $_POST['id_vacante'];
        }
        if(isset($_POST['otro_grupo'])){
          $url = 'get.serenaccion.com.co/serenacc_dictionaries/gran_grupo?token=no&except=dev_masabogalq';
          $post_data = array(
            'nombre_gran_grupo' => $_POST['otro_grupo']
          );
          $response = str_replace(array("\n", "[" , "]") , "", $requester->postFormulario($post_data, $url));
          $response = json_decode($response, true, 3);
          $gran_grupo = $response['results']['Last ID'];
        }
        if(isset($_POST['otro_cargo'])){
          $url = 'get.serenaccion.com.co/serenacc_dictionaries/cargos?token=no&except=dev_masabogalq';
          $post_data = array(
            'nombre_cargo' => $_POST['otro_cargo'],
            'gran_grupo' => $gran_grupo
          );
          $response = str_replace(array("\n", "[" , "]") , "", $requester->postFormulario($post_data, $url));
          $response = json_decode($response, true, 3);
          $cargos = $response['results']['Last ID'];
        }
        $rel_cargos = $_POST['rel_cargos'];
        $cargos=[$cargos];
        foreach($rel_cargos as $cargo){
          array_push($cargos, $cargo);
        }
        $cargos = join(',', $cargos);
        $ids_idiomas = '';
        if(isset($_POST['idiomas_select']) && !empty($_POST['idiomas_select'])){
            $url = 'rest.serenaccion.com.co/idiomas?token=no&table=idiomas&sufix=idioma&except=dev_msabogalq';
            foreach($_POST['idiomas_select'] as $value){
                $post_data= array(
                    'id_vacante_idioma' => $id_vacante,
                    'idioma_idioma' =>$value,
                    'nivel_hablado_idioma' => $_POST['nivel_hablado_'.$value],
                    'nivel_escrito_idioma' => $_POST['nivel_escrito_'.$value],
                    'nivel_leido_idioma' => $_POST['nivel_leido_'.$value]
                );
                $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($post_data, $url));
                $response = json_decode($response, true, 3);
                if($ids_idiomas != ''){
                    $ids_idiomas.=',';
                }
                $ids_idiomas.=$response['results']['Last ID'];
            }
        }
        $comp_lab = '';
        if(!empty($_POST['comp_lab'])) {
          foreach($_POST['comp_lab'] as $check){
            if($comp_lab!=''){
              $comp_lab .= ',';
            }
            $comp_lab .= $check;
          }
        }
        $comp_per= '';
        if(isset($_POST['comp_lab_arr']) && !empty($_POST['comp_lab_arr'])){
          foreach($_POST['comp_lab_arr'] as $check){
            $url = 'get.serenaccion.com.co/serenacc_dictionaries/descript_comp_p?token=no&except=dev_masabogalq';
            $post_data = array(
              'descript' => $_POST['comp_lab_'.$check],
              'gran_grupo' => $gran_grupo
            );
            if(isset($_POST['otro_cargo'])){
              $post_data['cod_fam_group'] = $_POST['otro_cargo'];
            }else{
              $post_data['cod_fam_group'] = $_POST['cargos'];
            }
            $response = str_replace(array("\n", "[" , "]") , "", $requester->postFormulario($post_data, $url));
            $response = json_decode($response, true, 3);
            if($comp_per != ''){
              $comp_per .= ',';
            }
            $comp_per .= $response['results']['Last ID'];
          }
        }
        $comp_per = '';
        if(!empty($_POST['comp_per'])) {
          foreach($_POST['comp_per'] as $check){
            if($comp_per!=''){
              $comp_per .= ',';
            }
            $comp_per .= $check;
          }
        }
        if(isset($_POST['comp_per_arr']) && $_POST['comp_per_arr']!=''){
          $comps = explode(',', $_POST['comp_per_arr']);
          foreach($comps as $check){
            $url = 'get.serenaccion.com.co/serenacc_dictionaries/descript_comp_p?token=no&except=dev_masabogalq';
            $post_data = array(
              'comp' => $_POST['comp_per_'.$check],
              'descript' => $_POST['descript_comp_per_'.$check]
            );
            $response = str_replace(array("\n", "[" , "]") , "", $requester->postFormulario($post_data, $url));
            $response = json_decode($response, true, 3);
            if($comp_per!=''){
              $comp_per .= ',';
            }
            $comp_per .= $response['results']['Last ID'];
          }
        }
        $ids_cert = '';
        if(isset($_POST['cert_arr']) && $_POST['cert_arr'] != ''){
          $cert_arr = explode(',',$_POST['cert_arr']);
          foreach($cert_arr as $cert){
            $post_data = array(
              'id_vacante_cert' =>$id_vacante,
              'descript_cert' => $_POST['cert_'.$cert]
            );
            $url = 'rest.serenaccion.com.co/certs?token=no&table=certs&sufix=cert&except=dev_msabogalq';
            $response = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($post_data, $url));
            $response = json_decode($response, true, 3);
            if($ids_cert!=''){
              $ids_cert.= ',';
            }
            $ids_cert.= $response['results']['Last ID'];
          }
        }
        $viajar = $_POST['viajar'];
        $traslado = $_POST['traslado'];
        $put_data = 'id_empresa_vacante='.$id
                    .'&ciudad_residencia_vacante='.$_POST['ciudad_residencia_vacante']
                    .'&viajar_vacante='.$viajar
                    .'&traslado_vacante='.$traslado
                    .'&gran_grupo_vacante='.$gran_grupo
                    .'&cargos_vacante='.$cargos
                    .'&comp_lab_vacante='.$comp_lab
                    .'&comp_per_vacante='.$comp_per
                    .'&bene_extr_vacante='.$_POST['bene_extr']
                    .'&jorn_lab_sema_vacante='.$_POST['jorn_labo_sema']
                    .'&jorn_lab_dia_vacante='.$_POST['jorn_labo_dia']
                    .'&mode_de_trab_vacante='.$_POST['mode_de_trab']
                    .'&esti_de_lide_vacante='.$_POST['esti_de_lide']
                    .'&esti_comu_inte_vacante='.$_POST['esti_comu_inte']
                    .'&tipo_gest_emp_vacante='.$_POST['tipo_gest_emp']
                    .'&ids_cert_vacante='.$ids_cert
                    .'&tarj_prof_vacante='.$_POST['tarj_prof']
                    .'&ids_idiomas_vacante='.$ids_idiomas
                    .'&activa_vacante=SI';
        $url = 'rest.serenaccion.com.co/vacantes?nameId=id_vacante&id='.$id_vacante.'&token=no&except=dev_masabogalq';
        $response = str_replace(array("\n", "[" , "]") , "", $requester->putFunction($put_data, $url));
        $response = json_decode($response, true, 3);
        if($response['status'] == 200){
          $url = 'rest.serenaccion.com.co/vacantes?linkTo=activa_vacante,id_empresa_vacante&equalTo=SI,'.$id.'&token=no&except=dev_masabogalq&table=vacantes&sufix=vacante&select=id_vacante,id_empresa_vacante';
          $response = str_replace(array("\n") , "", $requester->getFunction($url));
          $response = json_decode($response, true, 4)['results'];
          $id_vacante_empresa = '';
          foreach($response as $item){
            if($id_vacante_empresa!=''){
              $id_vacante_empresa .=','.$item['id_vacante'];
            }
            else{
              $id_vacante_empresa .= $item['id_vacante'];
            } 
          }
          $put_data = 'id_vacante_empresa='.$id_vacante_empresa;
          $url = 'rest.serenaccion.com.co/empresas?nameId=id_empresa&id='.$id.'&token=no&except=dev_masabogalq';
          $response = str_replace(array("\n", '[',']') , "", $requester->putFunction($put_data, $url));
          $response = json_decode($response, true, 3);
          setcookie('next_page', 'perfil.php', time()+60, '/');
          echo('<script>window.location="../empresa/perfil.php"</script>');
        }else{
          echo('<script>window.location="../empresa/perfil.php"</script>');
        }
      }
    }
?>