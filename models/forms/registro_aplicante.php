<br>
<br>
<div id="pnl_1">
    <div>
        <form name="reg_aplicante" class="form" enctype="multipart/form-data" action="../controlers/submit.php" method="POST">
            <div id="contenedor">
                <?php  
                    if(isset($perfil['id_aplicante'])){
                        echo'<input type="text" id="location" name="location" value="update_aplicante" hidden/>
                             <input type="text" name="update_aplicante" value="true" hidden/>
                             <input type="text" name="id_aplicante" value="'.$perfil['id_aplicante'].'" hidden/>
                             ';
                    }else{
                        echo '<input type="text" name="reg_aplicante" value="true" hidden/>
                              <input type="text" id="location" name="location" value="reg_aplicante" hidden/>';
                    }
                ?>
                <div>
                    <label for="foto_aplicante">Foto</label>
                    <br>
                    <?php
                        if(isset($perfil['foto_aplicante'])){
                            $constructor->imageEdit($perfil['foto_aplicante'], 'width="40%"', 'aplicante');
                        }else{
                            $constructor->singleFileElement('foto_aplicante', 'foto_aplicante', 'cajas', 'file', 'Foto', 'image/*');
                        }
                    ?>
                </div>
                <div></div>
                <div>
                    <label for="nombre_aplicante">Nombre</label>
                    <?php
                        if(isset($perfil['nombre_aplicante'])){
                            $constructor->singleInputElement('nombre_aplicante', 'nombre_aplicante', 'cajas', 'text', 'Nombre', $perfil['nombre_aplicante']);
                        }else if(isset($_COOKIE['nombre_aplicante'])){
                            $constructor->singleInputElement('nombre_aplicante', 'nombre_aplicante', 'cajas', 'text', 'Nombre', $_COOKIE['nombre_aplicante']);
                        }else{
                            $constructor->singleInputElement('nombre_aplicante', 'nombre_aplicante', 'cajas', 'text', 'Nombre', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="apellido_aplicante">Apellidos</label>
                    <?php
                        if(isset($perfil['apellido_aplicante'])){
                            $constructor->singleInputElement('apellido_aplicante', 'apellido_aplicante', 'cajas', 'text', 'Apellidos', $perfil['apellido_aplicante']);
                        }else if(isset($_COOKIE['apellido_aplicante'])){
                            $constructor->singleInputElement('apellido_aplicante', 'apellido_aplicante', 'cajas', 'text', 'Nombre', $_COOKIE['apellido_aplicante']);
                        }else{
                            $constructor->singleInputElement('apellido_aplicante', 'apellido_aplicante', 'cajas', 'text', 'Apellidos', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="tipo_nuip_aplicante">Tipo de identificación</label>
                    <select name="tipo_nuip_aplicante" class="cajas" required placeholder="Tipo de documento">
                        <?php
                            $options = ['Registro civil nacimiento', 'Cédula de ciudadanía', 'Tarjeta de extranjería', 'Cédula de extranjería', 'Pasaporte', 'Doc. de identifiación extranjero'];
                            if(isset($perfil['tipo_nuip_aplicante'])){
                                foreach($options as $opt){
                                    if($opt == $perfil['tipo_nuip_aplicante']){
                                        echo '<option value="'.$opt.'" selected>'.$opt.'</option>';
                                    }else{
                                        echo '<option value="'.$opt.'">'.$opt.'</option>';
                                    }
                                }
                            }else if(isset($_COOKIE['tipo_nuip_aplicante'])){
                                foreach($options as $opt){
                                    if($opt == $_COOKIE['tipo_nuip_aplicante']){
                                        echo '<option value="'.$opt.'" selected>'.$opt.'</option>';
                                    }else{
                                        echo '<option value="'.$opt.'">'.$opt.'</option>';
                                    }
                                }
                            }else{
                                echo'<option disabled selected>Selecciona una opción</option>';
                                foreach($options as $opt){
                                    echo '<option value="'.$opt.'">'.$opt.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="nuip_aplicante">Número de documento</label>
                    <?php
                        if(isset($perfil['nuip_aplicante'])){
                            $constructor->singleInputElement('nuip_aplicante', 'nuip_aplicante', 'cajas', 'number', 'Número de identifiación', $perfil['nuip_aplicante']);
                        }else if(isset($_COOKIE['nuip_aplicante'])){
                            $constructor->singleInputElement('nuip_aplicante', 'nuip_aplicante', 'cajas', 'number', 'Número de identifiación', $_COOKIE['nuip_aplicante']);
                        }else{
                            $constructor->singleInputElement('nuip_aplicante', 'nuip_aplicante', 'cajas', 'number', 'Número de identifiación', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="ciudad_aplicante">Ciudad de residencia</label>
                    <select name="ciudad_aplicante" id="ciudad_select" class="cajas chosen_select" placeholder="Ciudad" required>
                        <?php
                            if(isset($perfil['ciudad_aplicante'])){
                                echo '<option value="'.$perfil['ciudad_aplicante'].'">'.$perfil['ciudad_aplicante'].'</option>';
                            }else if(isset($_COOKIE['ciudad_aplicante'])){
                                echo '<option value="'.$_COOKIE['ciudad_aplicante'].'">'.$_COOKIE['ciudad_aplicante'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="calular_aplicante">Celular de contacto</label>
                    <?php
                        if(isset($perfil['celular_aplicante'])){
                            $constructor->singleInputElement('celular_aplicante', 'celular_aplicante', 'cajas', 'number', 'Celular', $perfil['celular_aplicante']);
                        }else if(isset($_COOKIE['celular_aplicante'])){
                            $constructor->singleInputElement('celular_aplicante', 'celular_aplicante', 'cajas', 'number', 'Celular', $_COOKIE['celular_aplicante']);
                        }else{
                            $constructor->singleInputElement('celular_aplicante', 'celular_aplicante', 'cajas', 'number', 'Celular', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="telefono_aplicante">Teléfono de contacto</label>
                    <?php
                        if(isset($perfil['telefono_aplicante'])){
                            $constructor->singleInputElement('telefono_aplicante', 'telefono_aplicante', 'cajas', 'number', 'Teléfono', $perfil['telefono_aplicante']);
                        }else if(isset($_COOKIE['telefono_aplicante'])){
                            $constructor->singleInputElement('telefono_aplicante', 'telefono_aplicante', 'cajas', 'number', 'Teléfono', $_COOKIE['telefono_aplicante']);
                        }else{
                            $constructor->singleInputElement('telefono_aplicante', 'telefono_aplicante', 'cajas', 'number', 'Teléfono', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="direccion_aplicante">Dirección</label>
                    <?php
                        if(isset($perfil['direccion_aplicante'])){
                            $constructor->singleInputElement('direccion_aplicante', 'direccion_aplicante', 'cajas', 'text', 'Dirección', $perfil['direccion_aplicante']);
                        }else if(isset($_COOKIE['direccion_aplicante'])){
                            $constructor->singleInputElement('direccion_aplicante', 'direccion_aplicante', 'cajas', 'text', 'Dirección', $perfil['direccion_aplicante']);
                        }else{
                            $constructor->singleInputElement('direccion_aplicante', 'direccion_aplicante', 'cajas', 'text', 'Dirección', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="email_aplicante">Dirección de correo electrónico</label>
                    <?php
                        if(isset($perfil['email_aplicante'])){
                            $constructor->singleInputElement('email_aplicante', 'email_aplicante', 'cajas', 'email', 'Email', $perfil['email_aplicante']);
                        }else if(isset($_COOKIE['email_aplicante'])){
                            $constructor->singleInputElement('email_aplicante', 'email_aplicante', 'cajas', 'email', 'Email', $_COOKIE['email_aplicante']);
                        }else{
                            $constructor->singleInputElement('email_aplicante', 'email_aplicante', 'cajas', 'email', 'Email', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="cemail">Confirmar correo</label>
                    <?php
                        if(isset($perfil['email_aplicante'])){
                            $constructor->singleInputElement('cemail', 'cemail', 'cajas', 'email', 'Confirmar Email', $perfil['email_aplicante']);
                        }else if(isset($_COOKIE['email_aplicante'])){
                            $constructor->singleInputElement('cemail', 'cemail', 'cajas', 'email', 'Confirmar Email', $_COOKIE['email_aplicante']);
                        }else{
                            $constructor->singleInputElement('cemail', 'cemail', 'cajas', 'email', 'Confirmar Email', '');
                        }
                    ?>
                </div>
                <div>
                    <?php
                        if(!isset($perfil['email_aplicante'])){
                            echo'<label for="password">Contraseña</label>';
                            $constructor->singleInputElement('password_aplicante', 'password_aplicante', 'cajas', 'password', 'Contraseña', '');
                        }
                    ?>
                </div>
                <div>
                    <?php
                        if(!isset($perfil['email_aplicante'])){
                            echo'<label for="cpass">Confirmar contraseña</label>';
                            $constructor->singleInputElement('cpass', 'cpass', 'cajas', 'password', 'Contraseña', '');
                        }
                    ?>
                </div>
                <div>
                    <?php
                        if(!isset($perfil['email_aplicante'])){
                            echo'
                            <a id="apolitica_tratamiento_datos_aceptada_aplicante"><label><input id="politica_tratamiento_datos_aceptada_aplicante" name="politica_tratamiento_datos_aceptada_aplicante" type="checkbox" required/>Acepto  <a href="https://serenaccion.com.co/Pol_trat_dat.html">Politica de tratamiento de datos</a></label></a>
                            <br>
                            <a id="aterminos_y_condiciones_aceptadas_aplicante"><label><input id="terminos_y_condiciones_aceptadas_aplicante" name="terminos_y_condiciones_aceptadas_aplicante" type="checkbox" required/> Acepto  <a href="https://serenaccion.com.co/Term_Cond.html">Terminos y Condiciones</label></a>';
                        }
                    ?>
                </div>
                <div>
                    <button type="submit">Finalizar</button>
                </div>
            </div>
        </form>
        <div class="volver">
        <button onClick="history.go(-1);">VOLVER ATRÁS</button>
        </div>	
    </div>
</div>
<style>
    .volver{
    position: fixed;
    right: 50px;
    bottom: 50px;
}

/*INPUTS*/
input {
    background: transparent;
    border: 0;
    outline: 0;
    border-bottom: 2px solid #959595;
    font-size: 14px;
    color: #959595;
    padding: 8px 0;
}
input:focus {
    border-bottom: 2px solid #1453a0;
    color: #1453a0;
}

/*BUTTONS*/
button {
    background: #1453a0;
    cursor: pointer;
    padding: 10px 16px;
    width: auto;
    font-weight: 600;
    text-transform:  uppercase;
    font-size: 14px;
    color: #fff;
    line-height: 16px;
    letter-spacing: 0.5px;
    border-radius: 2px;
    border: 0;
    outline: 0;
    margin: 15px 15px 15px 0;
    transition: all 0.25s;
} 
button:hover {
    background: #1453a0;
    box-shadow: 0 4px 7px rgba(0,0,0,0.1), 0 3px 6px rgba(0,0,0,0.1);
}
.alternative {
    background: none;
    color: #1453a0;
    box-shadow: none;
}
.alternative:hover {
    background: #eee;
    color: #1453a0;
}
.cancel {
    background: #e52860;
    color: #fff;
    box-shadow: none;
}
.cancel:hover{
    background: #e52860;
    color: #fff;
}
.image {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.text {
  background-color: #1453a0;
  color: white;
  font-size: 10px;
  padding: 16px 32px;
}

.imageContainer {
  position: relative;
  width: 50%;
}

.imageContainer:hover .image {
  opacity: 0.3;
}

.imageContainer:hover .middle {
  opacity: 1;
}

/*SELECTS*/
select {
    cursor: pointer;
    padding: 9px 16px;
    width: auto;
    font-weight: 600;
    font-size: 14px;
    color: #959595;
    border: 1px solid #959595;
    line-height: 16px;
    letter-spacing: 0.5px;
    border-radius: 2px;
}
select:focus {
    cursor: pointer;
    padding: 9px 16px;
    width: auto;
    font-weight: 600;
    font-size: 14px;
    color: #1453a0;
    line-height: 16px;
    letter-spacing: 0.5px;
    border-radius: 2px;
}

select::after:focus {
    cursor: pointer;
    padding: 9px 16px;
    width: auto;
    font-weight: 600;
    font-size: 14px;
    border: 0;
    line-height: 16px;
    letter-spacing: 0.5px;
    border-radius: 2px;
}

/*CHECKBOX*/
[type="checkbox"]:not(:checked),
[type="checkbox"]:checked {
    left: 0;
}
[type="checkbox"]:not(:checked),
[type="checkbox"]:checked{
    padding-left: 2.3em;
    font-size: 1.05em;
    line-height: 1.7;
    cursor: pointer;
}
[type="checkbox"]:not(:checked),
[type="checkbox"]:checked {
    content: '';
    left: 0;
    top: 0;
    width: 1.4em;
    height: 1.4em;
    border: 1px solid #aaa;
    background: #FFF;
    border-radius: .2em;
    -webkit-transition: all .275s;
    transition: all .275s;
}
[type="checkbox"]:checked{
    opacity: 1;
    -webkit-transform: scale(1) rotate(0);
    transform: scale(1) rotate(0);
}
[type="checkbox"]:disabled:not(:checked),
[type="checkbox"]:disabled:checked{
    box-shadow: none;
    border-color: #bbb;
    background-color: #e9e9e9;
}
[type="checkbox"]:disabled:checked {
    color: #777;
}
[type="checkbox"]:disabled {
    color: #aaa;
}

/**/
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src='js/messages_es.js'></script>
<script src="js/scripts.js"></script>