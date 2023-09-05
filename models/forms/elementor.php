<?php

class Elementor{

    function loginForm($tipo, $email, $warning){
        $id='';
        if($email!=''){
            setcookie('Email', $email, time()+60, '/');
        }
        if($tipo=='aplicante'){
            $id='tipoAplicante';
        }else if($tipo=='empresa'){
            $id='tipoEmpresa';
        }
        echo '
            <div class="form-group" id="login_form_'.$tipo.'">
                <input type="email" placeholder="E-mail" name="email" value="'.$email.'" required/>
                <input type="password" placeholder="Contraseña" name="password" required/>
                <input name="tipo" value="'.$tipo.'" id="'.$id.'" hidden>
            </div>
            <button>Iniciar Sesión</button>
        ';
            if($warning=='wrong_credentials'){
                echo '<h6 class="message">Usuario o Contraseña incorrecto(a)</h6>';
            }else if($warning=='no_active'){
                echo '<h6 class="message">Esta cuenta aún no está activa <a href="validaciones.php?solicitud=activar_cuenta&tipo='.$tipo.'&email='.$email.'">Solicita la Activación por correo</a></h6>';
            }
        echo'
            <p class="message">No tiene cuenta? <a href="registro.php?tipo='.$tipo.'&reg=true">Registrese</a></p>
            <p class="message"><a href="validaciones.php?solicitud=reset_pass&tipo='.$tipo.'">Olvidó su contraseña?</a></p>
        ';
    }

    function loginFormConfirm($tipo, $email){
        $id='';
        if($tipo=='aplicante'){
            $id='tipoAplicante';
        }else if($tipo=='empresa'){
            $id='tipoEmpresa';
        }
        echo '
            <div class="form-group" id="login_form_'.$tipo.'">
                <input type="email" placeholder="E-mail" name="email" value="'.$email.'" required/>
                <input type="password" placeholder="Contraseña" name="password" required/>
                <input name="tipo" value="'.$tipo.'" id="'.$id.'" hidden>
            </div>
            <button>Confirmar</button>
        ';
    }

    function inputElement(  $id, 
                            $name, 
                            $label, 
                            $type, 
                            $value, 
                            $placeholder, 
                            $div_class, 
                            $label_class, 
                            $input_class, 
                            $required, 
                            $index){        
        echo'<div id="'.$id.'_div'.$index.'" class="'.$div_class.'">
            <label for="'.$name.'" class="'.$label_class.'">'.$label.'</label>
            <input type="'.$type.'" class="'.$input_class.'" placeholder="'.$placeholder.'" value="'.$value.'" id="'.$id.$index.'" name="'.$name.'" '.$required.'/>
        </div>';
    }

    function selectElement( $id, 
                            $name, 
                            $label, 
                            $value, 
                            $placeholder, 
                            $div_class, 
                            $label_class, 
                            $select_class, 
                            $multiple, 
                            $required, 
                            $index){

        echo'
        <div id="'.$id.'_div'.$index.'" class="'.$div_class.'">
            <label for="'.$name.'" class="'.$label_class.'">'.$label.'</label>
            <select id="'.$id.$index.'" name="'.$name.'" class="'.$select_class.'" placeholder="'.$placeholder.'" '.$required.' '.$multiple.'>';

                if($value!=''){
                    $value = explode(',' , $value);
                    foreach($value as $val){
                        echo '<option value="'.$val.'" selected>'.$val.'</option>';
                    }
                    
                }else{
                    echo '<option disabled selected>Selecciona una opción</option>';
                }
                
           echo' </select>
        </div>';
    }

    function singleInputElement($id, 
                                $name, 
                                $class, 
                                $typo, 
                                $placeholder, 
                                $value){
        echo'<input id="'.$id.'" name="'.$name.'" class="'.$class.'" type="'.$typo.'" required placeholder="'.$placeholder.'" value="'.$value.'" />';
    }

    function singleFileElement($id, 
                                $name, 
                                $class, 
                                $typo, 
                                $placeholder, 
                                $accept){
        echo'<input id="'.$id.'" name="'.$name.'" class="'.$class.'" type="'.$typo.'" placeholder="'.$placeholder.'" accept="'.$accept.'" />';
    }

    function imageEdit($url, $arguments, $tipo){
        echo'<div id="imageContainer" class="imageContainer">
                <img src="'.$url.'" '.$arguments.' class="image"/>
                <div class="middle">
                    <a class="btn" id="edit_foto_'.$tipo.'"><div class="text">Cambiar</div></a>
                </div>
            </div>';
            echo'<div id="foto_'.$tipo.'">
                    <input name="foto_'.$tipo.'" class="cajas" type="file" accept="image/*" placeholder="foto_'.$tipo.'" accept="image/*"/>
                    <a class="btn" id="cancel_foto_'.$tipo.'">Cancelar</a>
                </div>';
    }
}

?>