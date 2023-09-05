<?php
    include_once('form_elements/elementor.php');
    $constructor = new Elementor();
    $requester = new Requester();
    $hvc=NULL;
    if($perfil['id_hvc_aplicante']!=NULL){
        $id_hvc = $perfil['id_hvc_aplicante'];
        $token = $perfil['token_aplicante'];
        $url = 'rest.serenaccion.com.co/hvcs?token='.$token.'&linkTo=id_hvc&equalTo='.$id_hvc;
        $hvc = str_replace(array("\n") , "", $requester ->getFunction($url));
        $hvc = json_decode($hvc, true, 4);
        $status = $hvc['status'];
        if($status==200){
            $hvc = $hvc['results'][0];
            $id_hvc = $hvc['id_hvc'];
        }
    }
    $url = 'rest.serenaccion.com.co/perfiles?token='.$perfil['token_aplicante'].'&linkTo=id_aplicante_perfil&equalTo='.$perfil['id_aplicante'];
    $perfil = str_replace(array("\n") , "", $requester ->getFunction($url));
    $perfil = json_decode($perfil, true, 4);
    $pstatus = $perfil['status'];
    if($pstatus==200){
        $perfil = $perfil['results'][0];
        $id_perfil = $perfil['id_perfil'];
        echo'<select name="comp_lab[]" id="comp_lab" multiple hidden>';
        $comp_lab = explode(',',$perfil['comp_lab_perfil']);
        foreach($comp_lab as $comp){
            echo '<option value="'.$comp.'" selected>'.$comp.'</option>';
        }
        echo'</select>';
        echo'<select name="comp_per[]" id="comp_per" multiple hidden>';
        $comp_per = explode(',',$perfil['comp_per_perfil']);
        foreach($comp_per as $comp){
            echo '<option value="'.$comp.'" selected>'.$comp.'</option>';
        }
        echo'</select>';
    }
?>
<div class="contenedorpestañas">
    <div class= "subcontenedor">
        <div class ="bloque activo">
            <form id="completar_hvc" enctype="multipart/form-data" name="completar_hvc" class="form" action="../controlers/submit.php" method="POST">
                <input id="location" value="hvc" hidden></input>
                <div id="contenedor">
                    <?php
                        if(isset($hvc['id_hvc'])){
                            echo '<input name="id_hvc" id="id_hvc" value="'.$id_hvc.'" hidden/>';
                        }
                    ?>
                    <input hidden name="hvc_comp" value="hvc_comp"></input>
                    <h4>INFORMACIÓN PERSONAL</h4>
                    <?php 
                        $constructor->selectElement('sex', 'sex', 'Sexo', $hvc?$hvc['sexo_hvc']:'','Sexo','','','','','required', '');
                        $constructor->inputElement('edad', 'edad', 'Edad', 'number', $hvc?$hvc['edad_hvc']:'', 'Edad', '', '', '', 'required', '');
                    ?>
                    <h4>HABILIDADES</h4><!--SECCION HABILIDADES-->
                    <div>
                        <div id="idiomas_select_div">
                            <label for="idiomas_select">Idiomas</label>
                            <select name="idiomas_select[]" class="cajas chosen_select" multiple placeholder="Selecccione un idioma" id="idiomas_select">
                                <?php
                                    if(isset($hvc['ids_idiomas_hvc'])){
                                        $url = 'rest.serenaccion.com.co/idiomas?token=no&except=dev_masabogalq&linkTo=id_hvc_idioma&equalTo='.$id_hvc;
                                        $idiomas = str_replace(array("\n") , "", $requester ->getFunction($url));
                                        $idiomas = json_decode($idiomas, true, 4);
                                        $idioma_status = $idiomas['status'];
                                        if($idioma_status == 200){
                                            $idiomas = $idiomas['results'];
                                            $id = 0;
                                            foreach($idiomas as $idioma){
                                                echo '<option value="'.$idioma['idioma_idioma'].'" selected>Idiomas Seleccionados</option>';
                                            }
                                        }
                                    }else{
                                        echo '<option disabled selected>Selecciona un idioma</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div id="idiomas_div">
                            <?php
                                if(isset($idioma_status) && $idioma_status == 200){
                                    $id = 0;
                                    foreach($idiomas as $idioma){
                                        echo '
                                            <div id="idioma_div_'.$idioma['idioma_idioma'].'">';
                                            $niveles = array('hablado','escrito','leido');
                                            echo '
                                            <label id="labe_div_idioma_'.$idioma['idioma_idioma'].'" for="div_idioma_'.$idioma['idioma_idioma'].'" ></label>
                                            <div id="div_idioma_'.$idioma['idioma_idioma'].'">';
                                                foreach($niveles as $nivel){
                                                    echo '
                                                        <label id="label_nivel_'.$nivel.'_'.$idioma['idioma_idioma'].'" for="nivel_'.$nivel.'_'.$idioma['idioma_idioma'].'">Nivel '.$nivel.'</label>
                                                        <select id="nivel_'.$nivel.'_'.$idioma['idioma_idioma'].'" name="nivel_'.$nivel.'_'.$idioma['idioma_idioma'].'" style="width: 20%;">
                                                        <option value="'.$idioma['nivel_'.$nivel.'_idioma'].'" selected>'.$idioma['nivel_'.$nivel.'_idioma'].'</option>
                                                        </select>';
                                                }
                                            echo '</div>
                                            </div>';
                                        $id+=1;
                                    }
                                    echo '<input hidden id="idiomas_q" value="'.$id.'">';
                                }
                            ?>
                        </div>
                    </div>
                    <h4>LUGAR DE TRABAJO</h4><!--SECCION LUGAR DE TRABAJO-->
                    <?php
                        $constructor->selectElement('ciudad_select', 'ciudad_select', 'Ciudad de residencia', $hvc?$hvc['ciudad_hvc']:'','Ciudad de residencia','','','chosen_select','','required', '');
                        $constructor->selectElement('traslado', 'traslado', 'Capacidad de traslado', $hvc?$hvc['traslado_hvc']:'','Capacidad de traslado','','','cajas','','required', '');
                        $constructor->selectElement('viajar', 'viajar', 'Capacidad de viajar', $hvc?$hvc['viaje_hvc']:'','Capacidad de viajar','','','cajas','','required', '');
                    ?>
                    <h4>CERTIFICACIÓN DE TUS COMPETENCIAS</h4>
                    <div>
                        <h5>Certificaciones Laborales</h5>
                            <h6>Registra tu hoja de vida pero desde las posiciones laborales ocupadas, anexando en lo posible la certificación de funciones que demuestre las competencias que registraste.</h6>
                        <div id="experiencias">
                            <?php
                                $exps_arr = '';
                                if(isset($hvc['ids_experiencias_hvc']) && $hvc['ids_experiencias_hvc']!=''){
                                    $url = 'rest.serenaccion.com.co/exps?token=no&except=dev_masabogalq&linkTo=id_hvc_exp&equalTo='.$hvc['id_hvc'];
                                    $exps = str_replace(array("\n") , "", $requester ->getFunction($url));
                                    $exps = json_decode($exps, true, 4)['results'];
                                    foreach($exps as $exp){
                                        if( in_array($exp['id_exp'], explode(',', $hvc['ids_experiencias_hvc']))){
                                            echo'<div id="exp_'.$exp['id_exp'].'">';
                                                $constructor->inputElement('nombre_cargo', 'nombre_cargo_'.$exp['id_exp'], 'Posición ocupada', 'text', $exp['cargo_exp']?$exp['cargo_exp']:'', 'Posición ocupada: ', 'caja', '', '', 'required', '_'.$exp['id_exp']);
                                                $constructor->inputElement('nombre_empresa', 'nombre_empresa_'.$exp['id_exp'], 'Empresa', 'text', $exp['nombre_empresa_exp']?$exp['nombre_empresa_exp']:'', 'Empresa: ', 'caja', '', '', 'required', '_'.$exp['id_exp']);
                                                $constructor->inputElement('fecha_inicio', 'fecha_inicio_'.$exp['id_exp'], 'Fecha de Inicio', 'month', $exp['fecha_inicio_exp']?$exp['fecha_inicio_exp']:'', 'Fecha de Inicio: ', 'caja', '', 'monthInput', 'required', '_'.$exp['id_exp']);
                                                $constructor->inputElement('fecha_salida', 'fecha_salida_'.$exp['id_exp'], 'Fecha de salida', 'month', $exp['fecha_salida_exp']?$exp['fecha_salida_exp']:'', 'Fecha de salida: ', 'caja', '', 'monthInput', 'required', '_'.$exp['id_exp']);
                                                echo'<div id="comps_exp_'.$exp['id_exp'].'">';    
                                                    $constructor->selectElement('comp_lab_exp', 'comp_lab_exp_'.$exp['id_exp'].'[]', 'Competencias laborales desarrolladas en este cargo', $exp['comp_lab_exp']?$exp['comp_lab_exp']:'','Competencias laborales desarrolladas en este cargo: ','caja','','chosen_select','multiple','', '_'.$exp['id_exp']);
                                                    $constructor->selectElement('comp_per_exp', 'comp_per_exp_'.$exp['id_exp'].'[]', 'Competencias personales desarrolladas en este cargo', $exp['comp_per_exp']?$exp['comp_per_exp']:'','Competencias personales desarrolladas en este cargo: ','caja','','chosen_select','multiple','', '_'.$exp['id_exp']);
                                                echo'</div>';
                                                $file = explode('/', $exp['cert_file_exp']);
                                                $constructor->inputElement('cert_file_exp', 'cert_file_exp_'.$exp['id_exp'], 'Archivo de la certificación', 'text', $exp['cert_file_exp']?end($file):'', 'Archivo de la certificación: ', 'caja', '', '', '', '_'.$exp['id_exp']); 
                                                echo' <a id="edit_file_exp_'.$exp['id_exp'].'" class=""alternative btn btn-info><button type="button">Editar archivo</button></a>';
                                                echo '<input hidden  id="cert_file_exp_loc_'.$exp['id_exp'].'" name="cert_file_exp_loc_'.$exp['id_exp'].'" value="'.$exp['cert_file_exp'].'"/>';
                                                echo'<span class="btn btn-danger"><a class="fa fa-close" id="remove_exp_'.$exp['id_exp'].'">Descartar esta certificación laboral</a></span>';
                                            echo'</div>';
                                            if($exps_arr!=''){
                                            $exps_arr.=',';
                                            }
                                            $exps_arr.=$exp['id_exp'];
                                        }
                                    }
                                    }
                                    if($exps_arr!=''){
                                    echo '
                                    <input hidden name="exps_arr" id="exps_arr" value="'.$exps_arr.'" />
                                    ';
                                }else{
                                    echo '
                                        <input hidden name="exps_arr" id="exps_arr" value=""/>
                                    ';
                                }
                            ?>                                    
                        </div>
                        <div>
                            <a id="add_exp"><button type="button">Añadir Certificación Laboral</button></a>
                        </div>
                    </div>
                    <div>
                        <h4>Certificaciones Académicas</h4>
                        <div id="formaciones">
                            <?php
                            $formas_arr = '';
                            if(isset($hvc['ids_formaciones_hvc']) && $hvc['ids_formaciones_hvc']!=''){
                                $url = 'rest.serenaccion.com.co/formas?token=no&except=dev_masabogalq&linkTo=id_hvc_forma&equalTo='.$hvc['id_hvc'];
                                $formas = str_replace(array("\n") , "", $requester ->getFunction($url));
                                $formas = json_decode($formas, true, 4)['results'];
                                foreach($formas as $forma){
                                    if( in_array($forma['id_forma'], explode(',', $hvc['ids_formaciones_hvc']))){
                                        echo'<div id="forma_div_'.$forma['id_forma'].'">';
                                            $constructor->selectElement('tipo_forma', 'tipo_forma_'.$forma['id_forma'].'[]', 'Tipo de Formación: ', $forma['tipo_forma']?$forma['tipo_forma']:'','Tipo de Formación','caja','','','','required', '_'.$forma['id_forma']);
                                            if($forma['tipo_forma']=='Primaria' || $forma['tipo_forma']=='Bachillerato'){
                                                $constructor->inputElement('col_forma', 'col_forma_'.$forma['id_forma'], 'Institución Educativa: ', 'text', $forma['colegio_forma']?$forma['colegio_forma']:'', 'Institución Educativa', 'caja', '', '', 'required', '_'.$forma['id_forma']);
                                            }else if($forma['tipo_forma']=='Pregrado' || $forma['tipo_forma']=='Posgrado'){
                                                $constructor->selectElement('nivel_forma', 'nivel_forma_'.$forma['id_forma'].'[]', 'Nivel de Formación: ', $forma['nivel_forma']?$forma['nivel_forma']:'','Nivel de Formación','caja','','chosen_select','','required', '_'.$forma['id_forma']);
                                                $constructor->selectElement('inst_forma', 'inst_forma_'.$forma['id_forma'].'[]', 'Institución Educativa: ', $forma['inst_forma']?$forma['inst_forma']:'','Institución Educativa','caja','','chosen_select','','required', '_'.$forma['id_forma']);
                                                $constructor->selectElement('prog_forma', 'prog_forma_'.$forma['id_forma'].'[]', 'Programa Académico: ', $forma['prog_forma']?$forma['prog_forma']:'','Programa Académico','caja','','chosen_select','','required', '_'.$forma['id_forma']);
                                            }else{
                                                $constructor->inputElement('nivel_otro_forma', 'nivel_otro_forma_'.$forma['id_forma'], 'Nivel de Formación Obtenido', 'text', $forma['nivel_otro_forma']?$forma['nivel_otro_forma']:'', 'Nivel de Formación Obtenido: ', 'caja', '', '', 'required', '_'.$forma['id_forma']);
                                                $constructor->inputElement('inst_otro_forma', 'inst_otro_forma_'.$forma['id_forma'], 'Institución Educativa', 'text', $forma['inst_otro_forma']?$forma['inst_otro_forma']:'', 'Institución Educativa: ', 'caja', '', '', 'required', '_'.$forma['id_forma']);
                                                $constructor->inputElement('prog_otro_forma', 'prog_otro_forma_'.$forma['id_forma'], 'Titulo Obtenido', 'text', $forma['prog_otro_forma']?$forma['prog_otro_forma']:'', 'Titulo Obtenido: ', 'caja', '', '', 'required', '_'.$forma['id_forma']);
                                            }
                                            echo '
                                            <input hidden  id="cert_file_forma_loc_'.$forma['id_forma'].'" name="cert_file_forma_loc_'.$forma['id_forma'].'" value="'.$forma['cert_file_forma'].'"/>
                                        </div>
                                        <div id="forma_comp_div_'.$forma['id_forma'].'">';
                                            $constructor->selectElement('comp_lab_forma', 'comp_lab_forma_'.$forma['id_forma'].'[]', 'Competencias laborales desarrolladas en este cargo', $forma['comp_lab_forma']?$forma['comp_lab_forma']:'','Competencias laborales desarrolladas en este cargo','caja','','chosen_select','multiple','', '_'.$forma['id_forma']);
                                            $constructor->selectElement('comp_per_forma', 'comp_per_forma'.$forma['id_forma'].'[]', 'Competencias personales desarrolladas en este cargo', $forma['comp_per_forma']?$forma['comp_per_forma']:'','Competencias personales desarrolladas en este cargo','caja','','chosen_select','multiple','', '_'.$forma['id_forma']);
                                            $file = explode('/', $forma['cert_file_forma']);
                                            $constructor->inputElement('cert_file_forma', 'cert_file_forma_'.$forma['id_forma'], 'Archivo de la certificación', 'text', $forma['cert_file_forma']?end($file):'', 'Archivo de la certificación', 'caja', '', '', '', '_'.$forma['id_forma']);
                                           echo' <a id="edit_file_forma_'.$forma['id_forma'].'" class=""alternative btn btn-info><button type="button">Editar Archivo</button></a>';
                                        echo '</div>
                                        ';
                                        if($formas_arr!=''){
                                            $formas_arr.=',';
                                        }
                                        $formas_arr.=$forma['id_forma'];
                                    }
                                }
                            }
                            if($formas_arr!=''){
                                echo '
                                <input hidden name="formas_arr" id="formas_arr" value="'.$formas_arr.'" />
                                ';
                            }else{
                                echo '
                                <input hidden name="formas_arr" id="formas_arr" value=""/>
                                ';
                            }
                            ?>
                        </div>
                        <div>
                            <a id="add_forma"><button type="button">Añadir Certificación Académica o Tarjeta Profesional</button></a>
                        </div>
                    </div>
                </div>
                    <a id="cancel"><button class="cancel" type="button">Cancelar y Regresar</button></a>
                    <a><button type="submit" onclick="AlertaGuardado()">Guardar</button></a>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<script src="../js/jquery.validate.js"></script>
<script type = "text/javascript" src="../js/functions.js?v=<?php echo time(); ?>"></script>
<script type = "text/javascript" src="../js/formulario_hvc.js?v=<?php echo time(); ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

