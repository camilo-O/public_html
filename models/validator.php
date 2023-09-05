<?php
  require_once('requester.php');
  class Validator{
    public function validate(String $token, String $id, String $next){
      $requester = new Requester();
      $cookies = [];
      //recibo cookies para verificar identidad
      $sufix = $_COOKIE['tipo'];
      $tabla = $sufix.'s';
      //request curl para verificar identidad
      $url = 'rest.serenaccion.com.co/'.$tabla.'?linkTo=id_'.$sufix.'&sufix='.$sufix.'&table='.$tabla.'&equalTo='.$id.'&token='.$token;
      $perfil = str_replace(array("\n", "[" , "]") , "", $requester->getFunction($url));
      $perfil = json_decode($perfil, true, 3);
      $status = $perfil['status'];
      //si se logra verificar la identidad del usuario
      if($status == "200"){//si tengo acceso
        $perfil = $perfil['results'];
        $token = $perfil['token_'.$sufix];
        $exp = $perfil['token_exp_'.$sufix];
        $email = $perfil['email_'.$sufix];
        if(isset($perfil['activo_aplicante'])){
          $visible = $perfil['activo_aplicante'];
        }
        if(isset($perfil['id_perfil_aplicante']) && $perfil['id_perfil_aplicante']!=NULL){
          $cookies['perfil'] = 'si';
        }else if(isset($perfil['id_aplicante'])){
          $cookies['perfil']='no';
        }
        if($exp<time()+30){
          $url = 'rest.serenaccion.com.co/'.$tabla.'?update=true&sufix='.$sufix;
          $data = array(
          'email_'.$sufix => $email
          );
          $perfil = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($data, $url));
          $perfil = json_decode($perfil, true, 3);
          $perfil = $perfil['results'];
          $exp = intval($perfil['token_exp_'.$sufix]);
          $token = $perfil['token_'.$sufix];
        }
        $cookies['exp'] = $exp;
        $cookies['token_'.$sufix] = $token;
        $cookies['id_'.$sufix] = $id;
        $cookies['next_page'] = $next;
        $requester->storeArrayAsCookies($cookies, 86400);
        $requester->storeCookie('tipo', $sufix, 604800);
        return $perfil;
      }else if(isset($next)){
        $requester->storeCookie('next_page', $next, 86400);
        setcookie('next_page', $next, time()+60*60*24, '/', '.serenaccion.com.co', true, true);
        echo "<script> window.location = '../login.php' </script>";
        return;
      }else{
        echo "<script> window.location = '../login.php' </script>";
      }
      return json_encode($perfil);
    } 


    function cambiarVisibilidad($visible, $id){
      $requester = new Requester();
      if(isset($_COOKIE['visible'])){
        $visibilidad = $_COOKIE['visible'];
        $url = 'rest.serenaccion.com.co/aplicantes?nameId=id_aplicante&id='.$id.'&token=no&except=dev_masabogalq';
        $put_data = 'activo_aplicante='.$visibilidad;
        $requester->putFunction($put_data, $url);
        $url = 'rest.serenaccion.com.co/perfiles?nameId=id_aplicante_perfil&id='.$id.'&token=no&except=dev_masabogalq';
        $put_data = 'activo_en_perfil='.$visibilidad;
        $url = 'rest.serenaccion.com.co/hvcs?nameId=id_aplicante_hvc&id='.$id.'&token=no&except=dev_masabogalq';
        $put_data = 'activa_hvc='.$visibilidad;
        $requester->putFunction($put_data, $url);
      }else{
        setcookie('visible', $visible, time()+3600, '/');
        $visibilidad = $visible;
        $url = 'rest.serenaccion.com.co/aplicantes?nameId=id_aplicante&id='.$id.'&token=no&except=dev_masabogalq';
        $put_data = 'activo_aplicante='.$visibilidad;
        $requester->putFunction($put_data, $url);
      }
    }


    public function mailPassword($email, $id, $token, $tipo){
      $path = 'serenaccion.com.co';
      $requester = new Requester();
      $subject = 'Solicitud de cambio de contraseña SerEnAccion';
      $body = 'Para cambiar su contraseña entre a <a href="https://'.$path.'/validaciones.php?solicitud=reset_pass_request&id='.$id.'&email='.$email.'&token='.$token.'&tipo='.$tipo.'">este enlace</a>';
      $mail = $requester->sendEmail($email, $subject, $body);
      if(!$mail->Send()) {
        return "Mailer Error: " . $mail->ErrorInfo;
      } else {
        return "Mensaje enviado correctamente";
      }
    }

    public function mailValidation($email, $token, $id, $sufix){
      $path = 'serenaccion.com.co';
      $requester = new Requester();
      $subject = 'Activación de su cuenta SerEnAccion';
      $body= 'Para activar su cuenta ingrese en <a href="https://'.$path.'/validaciones.php?solicitud=verificar_correo&token='.$token.'&id='.$id.'&tipo='.$sufix.'">este enlace</a>';
      $mail = $requester->sendEmail($email, $subject, $body);
      if(!$mail->Send()) {
        return "Mailer Error: " . $mail->ErrorInfo;
      } else {
        return "Mensaje enviado correctamente";
      }
    }

    public function activarCuenta($token, $id, $sufix){
      $requester = new Requester();
      $tabla = $sufix.'s';
      $url = 'rest.serenaccion.com.co/'.$tabla.'?linkTo=id_'.$sufix.'&sufix='.$sufix.'&table='.$tabla.'&equalTo='.$id.'&token='.$token;
      $perfil = str_replace(array("\n", "[" , "]") , "", $requester->getFunction($url));
      $perfil = json_decode($perfil, true, 3);
      $status = $perfil['status'];
      if($status=='200'){
        if(isset($perfil['results']['correo_verificado_aplicante']) && $perfil['results']['correo_verificado_aplicante'] == 'no'){
          $url = 'rest.serenaccion.com.co/aplicantes?nameId=id_aplicante&id='.$id.'&token=no&except=dev_masabogalq';
          $put_data = 'correo_verificado_aplicante=si';
          $requester->putFunction($put_data, $url);
          return 'activación completa';
        }else if($perfil['results']['correo_verificado_empresa']=='no'){
          $url = 'rest.serenaccion.com.co/empresas?nameId=id_empresa&id='.$id.'&token=no&except=dev_masabogalq';
          $put_data = 'correo_verificado_empresa=si';
          $requester->putFunction($put_data, $url);
          return 'activación completa';
        }
      }else{
        return 'incorrecto';
      }
    }

    public function resetPassword($email, $id, $pass, $tipo){
      $requester = new Requester();
      $url= 'rest.serenaccion.com.co/'.$tipo.'s?pass=true&sufix='.$tipo;
      $post_data = array(
        'email_'.$tipo => $email,
        'id_'.$tipo => $id,
        'password_'.$tipo => $pass
      );
      $perfil = str_replace(array("\n", "[" , "]") , "", $requester->postFunction($post_data, $url));
      $perfil = json_decode($perfil, true, 3);
      echo'<script>window.location="../login.php"</script>';
    }
  }
?>