<br>
<br>
<div id="pnl_2">
    <div>
        <form name="reg_empresa" class="form" enctype="multipart/form-data" action="controlers/submit.php" method="POST">
            <div id="contenedor">
                <?php
                    if(isset($perfil['id_empresa'])){
                        echo'<input type="text" id="location" name="location" value="update_empresa" hidden/>
                             <input type="text" name="update_empresa" value="true" hidden/>
                             <input type="text" name="id_empresa" value="'.$perfil['id_empresa'].'" hidden/>';
                    }else{
                        echo '<input type="text" name="reg_empresa" value="true" hidden/>
                              <input type="text" id="location" name="location" value="reg_empresa" hidden/>';
                    }
                ?>
                <div>
                    <label for="foto_empresa">Foto</label>
                    <br>
                    <?php
                        if(isset($perfil['foto_empresa'])){
                            $constructor->imageEdit($perfil['foto_empresa'], 'width="40%"', 'empresa');
                        }else{
                            $constructor->singleFileElement('foto_empresa', 'foto_empresa', 'cajas', 'file', 'Foto', 'image/*');
                        }
                    ?>
                </div>
                <div></div>
                <div>
                    <label for="nombre_empresa">Nombre de la empresa</label>
                    <?php
                        if(isset($perfil['nombre_empresa'])){
                            $constructor->singleInputElement('nombre_empresa', 'nombre_empresa', 'cajas', 'text', 'Nombre de la Empresa', $perfil['nombre_empresa']);
                        }else if(isset($_COOKIE['nombre_empresa'])){
                            $constructor->singleInputElement('nombre_empresa', 'nombre_empresa', 'cajas', 'text', 'Nombre de la Empresa', $_COOKIE['nombre_empresa']);
                        }else{
                            $constructor->singleInputElement('nombre_empresa', 'nombre_empresa', 'cajas', 'text', 'Nombre de la Empresa', '');
                        }
                    ?>
                </div>

                <div>
                    <label for="nit">Nit</label>
                    <?php
                        if(isset($perfil['nit_empresa'])){
                            $constructor->singleInputElement('nit_empresa', 'nit_empresa', 'cajas', '', 'Nit de la Empresa (Sin código de verificación)', $perfil['nit_empresa']);
                        }else if(isset($_COOKIE['nit_empresa'])){
                            $constructor->singleInputElement('nit_empresa', 'nit_empresa', 'cajas', '', 'Nit de la Empresa (Sin código de verificación)', $_COOKIE['nit_empresa']);
                        }else{
                            $constructor->singleInputElement('nit_empresa', 'nit_empresa', 'cajas', '', 'Nit de la Empresa', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="tipo_gest_emp_empresa">Tipo de gestión empresarial</label>
                    <select id="tipo_gest_emp" name="tipo_gest_emp_empresa" class="cajas chosen_select" required>
                        <?php
                            if(isset($perfil['tipo_gest_emp_empresa'])){
                                echo'<option value="'.$perfil['tipo_gest_emp_empresa'].'" selected>'.$perfil['tipo_gest_emp_empresa'].'</option>';
                            }else if(isset($_COOKIE['tipo_gest_emp_empresa'])){
                                echo'<option value="'.$_COOKIE['tipo_gest_emp_empresa'].'" selected>'.$_COOKIE['tipo_gest_emp_empresa'].'</option>';
                            }else{
                                echo'<option value="default" disabled selected>Escoja su opción preferida</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="esti_de_lide_empresa">Estilo de liderazgo de la compañía</label>
                    <select id="esti_de_lide" name="esti_de_lide_empresa" class="cajas chosen_select" required>
                        <?php
                            if(isset($perfil['esti_de_lide_empresa'])){
                                echo'<option value="'.$perfil['esti_de_lide_empresa'].'" selected>'.$perfil['esti_de_lide_empresa'].'</option>';
                            }else if(isset($_COOKIE['esti_de_lide_empresa'])){
                                echo'<option value="'.$_COOKIE['esti_de_lide_empresa'].'" selected>'.$_COOKIE['esti_de_lide_empresa'].'</option>';
                            }else{
                                echo'<option value="default" disabled selected>Escoja su opción preferida</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="esti_comu_inte_empresa">Estilo de comunicación interna</label>
                    <select id="esti_comu_inte" name="esti_comu_inte_empresa" class="cajas chosen_select" required>
                        <?php
                            if(isset($perfil['esti_comu_inte_empresa'])){
                                echo'<option value="'.$perfil['esti_comu_inte_empresa'].'" selected>'.$perfil['esti_comu_inte_empresa'].'</option>';
                            }elseif(isset($_COOKIE['esti_comu_inte_empresa'])){
                                echo'<option value="'.$_COOKIE['esti_comu_inte_empresa'].'" selected>'.$_COOKIE['esti_comu_inte_empresa'].'</option>';
                            }else{
                                echo'<option value="default" disabled selected>Escoja su opción preferida</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="bene_extr_empresa">Beneficion Extra</br></label>
                    <select id="bene_extr" name="bene_extr_empresa" class="cajas chosen_select" required>
                        <?php
                            if(isset($perfil['bene_extr_empresa'])){
                                echo'<option value="'.$perfil['bene_extr_empresa'].'" selected>'.$perfil['bene_extr_empresa'].'</option>';
                            }else if(isset($_COOKIE['bene_extr_empresa'])){
                                echo'<option value="'.$_COOKIE['bene_extr_empresa'].'" selected>'.$_COOKIE['bene_extr_empresa'].'</option>';
                            }else{
                                echo'<option value="default" disabled selected>Escoja su opción preferida</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="jorn_labo_sema_empresa">Jornada Laboral Semanal</br></label>
                    <select id="jorn_labo_sema" name="jorn_labo_sema_empresa" class="cajas chosen_select" required>
                        <?php
                            if(isset($perfil['jorn_labo_sema_empresa'])){
                                echo'<option value="'.$perfil['jorn_labo_sema_empresa'].'" selected>'.$perfil['jorn_labo_sema_empresa'].'</option>';
                            }else if(isset($_COOKIE['jorn_labo_sema_empresa'])){
                                echo'<option value="'.$_COOKIE['jorn_labo_sema_empresa'].'" selected>'.$_COOKIE['jorn_labo_sema_empresa'].'</option>';
                            }else{
                                echo'<option value="default" disabled selected>Escoja su opción preferida</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="jorn_labo_dia_empresa">Jornada Laboral Diaria</br></label>
                    <select id="jorn_labo_dia" name="jorn_labo_dia_empresa" class="cajas chosen_select" required>
                        <?php
                            if(isset($perfil['jorn_labo_dia_empresa'])){
                                echo'<option value="'.$perfil['jorn_labo_dia_empresa'].'" selected>'.$perfil['jorn_labo_dia_empresa'].'</option>';
                            }else if(isset($_COOKIE['jorn_labo_dia_empresa'])){
                                echo'<option value="'.$_COOKIE['jorn_labo_dia_empresa'].'" selected>'.$_COOKIE['jorn_labo_dia_empresa'].'</option>';
                            }else{
                                echo'<option value="default" disabled selected>Escoja su opción preferida</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="mode_de_trab_empresa">Modelo de Trabajo</br></label>
                    <select id="mode_de_trab" name="mode_de_trab_empresa" class="cajas chosen_select" required >
                        <?php
                            if(isset($perfil['mode_de_trab_empresa'])){
                                echo'<option value="'.$perfil['mode_de_trab_empresa'].'" selected>'.$perfil['mode_de_trab_empresa'].'</option>';
                            }else if(isset($_COOKIE['mode_de_trab_empresa'])){
                                echo'<option value="'.$_COOKIE['mode_de_trab_empresa'].'" selected>'.$_COOKIE['mode_de_trab_empresa'].'</option>';
                            }else{
                                echo'<option value="default" disabled selected>Escoja su opción preferida</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="numero_empleados_empresa">Número de empleados</label>
                    <?php
                        if(isset($perfil['numero_empleados_empresa'])){
                            $constructor->singleInputElement('numero_empleados_empresa', 'numero_empleados_empresa', 'cajas', 'number', 'Número de Empleados', $perfil['numero_empleados_empresa']);
                        }else if(isset($_COOKIE['numero_empleados_empresa'])){
                            $constructor->singleInputElement('numero_empleados_empresa', 'numero_empleados_empresa', 'cajas', 'number', 'Número de Empleados', $_COOKIE['numero_empleados_empresa']);
                        }else{
                            $constructor->singleInputElement('numero_empleados_empresa', 'numero_empleados_empresa', 'cajas', 'number', 'Número de Empleados', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="ciudad_empresa">Ciudad</label>
                    <select name="ciudad_empresa" id="ciudad_select" class="cajas chosen_select" maxlength="30" required type="text" placeholder="Ciudad" required>
                        <?php
                            if(isset($perfil['ciudad_empresa'])){
                                echo'<option value="'.$perfil['ciudad_empresa'].'">'.$perfil['ciudad_empresa'].'</option>';
                            }else if(isset($_COOKIE['ciudad_empresa'])){
                                echo'<option value="'.$_COOKIE['ciudad_empresa'].'">'.$_COOKIE['ciudad_empresa'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="direccion_empresa">Dirección</label>
                    <?php
                        if(isset($perfil['direccion_empresa'])){
                            $constructor->singleInputElement('direccion_empresa', 'direccion_empresa', 'cajas', 'text', 'Dirección de la Empresa', $perfil['direccion_empresa']);
                        }else if(isset($_COOKIE['direccion_empresa'])){
                            $constructor->singleInputElement('direccion_empresa', 'direccion_empresa', 'cajas', 'text', 'Dirección de la Empresa', $_COOKIE['direccion_empresa']);
                        }else{
                            $constructor->singleInputElement('direccion_empresa', 'direccion_empresa', 'cajas', 'text', 'Dirección de la Empresa', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="telefono_empresa">Teléfono de contacto</label>
                    <?php
                        if(isset($perfil['telefono_empresa'])){
                            $constructor->singleInputElement('telefono_empresa', 'telefono_empresa', 'cajas', 'text', 'Teléfono de la Empresa', $perfil['telefono_empresa']);
                        }else if(isset($_COOKIE['telefono_empresa'])){
                            $constructor->singleInputElement('telefono_empresa', 'telefono_empresa', 'cajas', 'text', 'Teléfono de la Empresa', $_COOKIE['telefono_empresa']);
                        }else{
                            $constructor->singleInputElement('telefono_empresa', 'telefono_empresa', 'cajas', 'text', 'Teléfono de la Empresa', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="celular_empresa">Celular</label>
                    <?php
                        if(isset($perfil['celular_empresa'])){
                            $constructor->singleInputElement('celular_empresa', 'celular_empresa', 'cajas', 'number', 'Celular de la Empresa', $perfil['celular_empresa']);
                        }else if(isset($_COOKIE['celular_empresa'])){
                            $constructor->singleInputElement('celular_empresa', 'celular_empresa', 'cajas', 'number', 'Celular de la Empresa', $_COOKIE['celular_empresa']);
                        }else{
                            $constructor->singleInputElement('celular_empresa', 'celular_empresa', 'cajas', 'number', 'Celular de la Empresa', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="drh_empresa">Nombre del director de Recursos Humanos de la empresa</label>
                    <?php
                        if(isset($perfil['drh_empresa'])){
                            $constructor->singleInputElement('drh_empresa', 'drh_empresa', 'cajas', 'text', 'Nombre', $perfil['drh_empresa']);
                        }else if(isset($_COOKIE['drh_empresa'])){
                            $constructor->singleInputElement('drh_empresa', 'drh_empresa', 'cajas', 'text', 'Nombre', $_COOKIE['drh_empresa']);
                        }else{
                            $constructor->singleInputElement('drh_empresa', 'drh_empresa', 'cajas', 'text', 'Nombre', '');
                        }
                    ?>
                </div>
                <div id="sector_empresa_div">
                    <label for="sector_empresa">Sector al que pertenece</label>
                    <select id="sector_empresa" name="sector_empresa" class="cajas" required>
                        <?php
                            if(isset($perfil['sector_empresa'])){
                                echo'<option value="'.$perfil['sector_empresa'].'" selected>'.$perfil['sector_empresa'].'</option>';
                            }else if(isset($_COOKIE['sector_empresa'])){
                                echo'<option value="'.$_COOKIE['sector_empresa'].'" selected>'.$_COOKIE['sector_empresa'].'</option>';
                            }else{
                                echo'<option value="default" disabled selected>Escoja el sector al que pertenece la empresa</option>';
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="reclutador_empresa">Nombre del reclutador</label>
                    <?php
                        if(isset($perfil['reclutador_empresa'])){
                            $constructor->singleInputElement('reclutador_empresa', 'reclutador_empresa', 'cajas', 'text', 'Nombre', $perfil['reclutador_empresa']);
                        }else if(isset($_COOKIE['reclutador_empresa'])){
                            $constructor->singleInputElement('reclutador_empresa', 'reclutador_empresa', 'cajas', 'text', 'Nombre', $_COOKIE['reclutador_empresa']);
                        }else{
                            $constructor->singleInputElement('reclutador_empresa', 'reclutador_empresa', 'cajas', 'text', 'Nombre', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="telefono_reclutador_empresa">Número telefónico del reclutador</label>
                    <?php
                        if(isset($perfil['telefono_reclutador_empresa'])){
                            $constructor->singleInputElement('telefono_reclutador_empresa', 'telefono_reclutador_empresa', 'cajas', 'number', 'Teléfono', $perfil['telefono_reclutador_empresa']);
                        }else if(isset($_COOKIE['telefono_reclutador_empresa'])){
                            $constructor->singleInputElement('telefono_reclutador_empresa', 'telefono_reclutador_empresa', 'cajas', 'number', 'Teléfono', $_COOKIE['telefono_reclutador_empresa']);
                        }else{
                            $constructor->singleInputElement('telefono_reclutador_empresa', 'telefono_reclutador_empresa', 'cajas', 'number', 'Teléfono', '');
                        }
                    ?>
                </div>
                <div>
                    <h5>Este es el correo que usará la compañía para iniciar sesión en nuestra plataforma</h5>
                    <label for="email_empresa">Dirección de correo electrónico Reclutador</label>
                    <?php
                        if(isset($perfil['email_empresa'])){
                            $constructor->singleInputElement('email_empresa', 'email_empresa', 'cajas', 'email', 'Email', $perfil['email_empresa']);
                        }else{
                            $constructor->singleInputElement('email_empresa', 'email_empresa', 'cajas', 'email', 'Email', '');
                        }
                    ?>
                </div>
                
                <div>
                    <label for="cemail_empresa">Confirmar correo Reclutador</label>
                    <?php
                        if(isset($perfil['email_empresa'])){
                            $constructor->singleInputElement('cemail_empresa', 'cemail_empresa', 'cajas', 'email', 'Email', $perfil['email_empresa']);
                        }else{
                            $constructor->singleInputElement('cemail_empresa', 'cemail_empresa', 'cajas', 'email', 'Email', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="email_drh_empresa">Dirección de correo electrónico Director de RH</label>
                    <?php
                        if(isset($perfil['email_drh_empresa'])){
                            $constructor->singleInputElement('email_drh_empresa', 'email_drh_empresa', 'cajas', 'email', 'Email', $perfil['email_drh_empresa']);
                        }else{
                            $constructor->singleInputElement('email_drh_empresa', 'email_drh_empresa', 'cajas', 'email', 'Email', '');
                        }
                    ?>
                </div>
                <div>
                    <label for="cemail_drh">Confirmar correo Director RH</label>
                    <?php
                        if(isset($perfil['email_drh_empresa'])){
                            $constructor->singleInputElement('cemail_drh_empresa', 'cemail_drh_empresa', 'cajas', 'email', 'Email', $perfil['email_drh_empresa']);
                        }else{
                            $constructor->singleInputElement('cemail_drh_empresa', 'cemail_drh_empresa', 'cajas', 'email', 'Email', '');
                        }
                    ?>
                </div>
                <div>
                    <?php
                        if(!isset($perfil['email_empresa'])){
                            echo'
                                <label for="password">Contraseña</label>
                                <input name="password_empresa" id="pass" class="cajas" maxlength="30" required type="password" placeholder="Contraseña" />
                            ';
                        }
                    ?>
                </div>
                <div>
                    <?php
                        if(!isset($perfil['email_empresa'])){
                            echo'
                                <label for="confirm_pass">Confirmar contraseña</label>
                                <input name="cpass" id="confirm_pass" class="cajas" maxlength="30" required type="password" placeholder="Confirmar contraseña" />
                            ';
                        }
                    ?>
                </div>
                <div>
                    <?php
                        if(!isset($perfil['email_empresa'])){
                            echo'
                                <label><input id="politica_tratamiento_datos_aceptada_empresa" name="politica_tratamiento_datos_aceptada_empresa" type="checkbox" value="false" />Acepto <a href="https://serenaccion.com.co/Pol_trat_dat.html">Politica de tratamiento de datos</a></label>
                                <br>
                                <label><input id="terminos_y_condiciones_aceptadas_empresa" name="terminos_y_condiciones_aceptadas_empresa" type="checkbox" value="false" />Acepto <a href="https://serenaccion.com.co/Term_Cond.html">Terminos y Condiciones</a></label>
                            ';
                        }
                    ?>
                    <br>
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
<script src="js/scripts.js"></script>
<script src='js/messages_es.js'></script>
