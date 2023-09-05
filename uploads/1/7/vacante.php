<div>
    <form id="box" name="vacante" class="form" action="../controlers/submit.php" method="POST">
        <input id="vacante_comp" name="vacante_comp" value="false" hidden/>
        <div class="contenedorpestañas">
        <ul class="ul">
            <li class="li activo" id='li1'>Competencias Laborales y Personales para la vacante</li>
            <li class="li" id='li2'>Lugar donde se ubicará la vacante</li>
            <li class="li" id='li3'>Detalles de la vacante</li>
            <li class="li" id='li4'>Habilidades y Experiancia para la vacante</li>
        </ul>
        <div class= "subcontenedor">
            <div class="bloque activo" id='bl1'>
                <h5>Para describir las características de tu vacante, debes iniciar por buscar el nombre del cargo que buscas o palabras claves en el primer campo y puedes seleccionar otro posible cargo en el segundo campo. Con esta selección, en el tercer campo te van a salir la lista de competencias del o los cargos definidos para que selecciones las competencias que requieres para tu vacante.</h5>
                <?php
                    include_once('form_elements/elementor.php');
                    $vacante= NULL;
                    if(isset($_GET['update']) && $_GET['update']=='true'){
                        $url =  'rest.serenaccion.com.co/vacantes?linkTo=id_vacante&equalTo='.$_GET['id'].'&token=no&except=dev_masabogalq&table=vacantes&sufix=vacante';
                        $vacante = str_replace(array("\n", "[" , "]") , "", $requester->getFunction($url));
                        $vacante = json_decode($vacante, true, 3)['results'];
                        $cargo = explode(',', $vacante['cargos_vacante'])[0];
                        echo'<input name="id_vacante" hidden value="'.$vacante['id_vacante'].'"/>';
                    }
                    $constructor = new Elementor();
                    $constructor->selectElement('cargos', 'cargos', '<h6>Escoja el cargo que ocupará su vacante</h6>', $vacante?$cargo:'','Cargos','caja','','chosen_select','','required','');
                    $constructor->selectElement('gran_grupo', 'gran_grupo', '<h6>Escoja el sector de su vacante (opcional)</h6>', $vacante?$vacante['gran_grupo_vacante']:'', 'Gran Grupo', 'caja', '', 'chosen_select', '', '', '' );
                    $label = '<h6>Escoja los cargos que se relacionan con su vacante </h6> Escoger cargos relacionados al que ofrece le ayuda a ver competencias que otras compañías han relacionado con estos cargos';
                    if($vacante){
                        $cargos = explode(',', $vacante['cargos_vacante']);
                        unset($cargos[0]);
                        $cargos = join(',', $cargos);
                    }
                    
                    $constructor->selectElement('rel_cargos', 'rel_cargos[]', $label, $vacante?$cargos:'', 'Cargos Relacionados', 'caja', '', 'chosen_select', 'multiple', '', '' );
                    $label = '<h6>Escoja las Competencias Laborales que requiere en el cargo</h6> De nuestras Competencias guardadas';
                    $constructor->selectElement('comp_lab', 'comp_lab[]', $label, $vacante?$vacante['comp_lab_vacante']:'', 'Competencias Laborales', 'caja', '', 'chosen_select', 'multiple', 'required', '' );
                ?>
                    <div class="caja">
                        <label for="otras_comp_lab_div">Si requiere una competencia laboral adicional a las señaladas en el listado, puede registrarla a continuación</label>
                        <div id="otras_comp_lab_div">
                        </div>
                        <a id="add_otra_comp_lab" class='alternative btn btn-info'>Añadir una competencia laboral personalizada</a>
                        <input hidden name="comp_lab_arr" id="comp_lab_arr" value=''/>
                    </div>
                <?php
                    $label='<h6>Escoja las Competencias Personales que requiere en el cargo</h6> De nuestras Competencias guardadas';
                    $constructor->selectElement('comp_per', 'comp_per[]', $label, $vacante?$vacante['comp_per_vacante']:'', 'Competencias Personales', 'caja', '', 'chosen_select', 'multiple', 'required', '' );
                ?>
                <div class='caja'>
                    <label for="otras_comp_per_div">Si requiere una competencia personal adicional a las señaladas en el listado, puede registrarla a continuación</label>
                    <div id="otras_comp_per_div">

                    </div>
                    <a id="add_otra_comp_per" class='alternative btn btn-info'>Añadir una competencia personal personalizada</a>
                    <input hidden name="comp_per_arr" id="comp_per_arr" value=''/>
                </div>
                <a href="perfil.php" id="cancel" class='btn btn-danger'>Cancelar y Regresar</a>
                <a id="right" href='#' class='btn alternative btn-info'>Siguiente >></a>
            </div>
            
            <div class ="bloque" id='bl2'>
                <!--Lugar de trabajo-->
                <?php
                    $constructor->selectElement('ciudad_select', 'ciudad_residencia_vacante', '<h6>Ciudad de Residencia</h6>', $vacante?$vacante['ciudad_residencia_vacante']:$empresa['ciudad_empresa'], 'Ciudad de Residencia', 'caja', '', 'chosen_select', '', 'required', '');
                ?>
                <h6>¿Requiere que su vacante tenga la capacidad de viajar?</h6>
                <div class="caja">
                    <label for="viajar">Capacidad de viajar</label>
                    <select class="cajas" name="viajar" id="viajar" placeholder="Seleccione una respuesta" required>
                        <?php
                        if($vacante){
                            echo'<option selected value="'.$vacante['viajar_vacante'].'">'.$vacante['viajar_vacante'].'</option>';
                        }else{
                            echo'<option disabled selected>Selecciona una opción</option>';
                        }
                        ?>
                    </select>
                </div>
                <h6>¿Requiere que su vacante tenga la capacidad de traslado?</h6>
                <div class="caja">
                    <label for="traslado">Capacidad de traslado</label>
                    <select class="cajas" name="traslado" id="traslado" placeholder="Seleccione una respuesta" required>
                    <?php
                        if($vacante){
                            echo'<option value="'.$vacante['traslado_vacante'].'" selected>'.$vacante['traslado_vacante'].'</option>';
                        }else{
                            echo'<option disabled selected>Selecciona una opción</option>';
                        }
                        ?>
                    </select>
                </div>
                <a id="left_1" href='#' class='btn alternative btn-info'><< Anterior</a>
                <a href="perfil.php" id="cancel_1" class='btn btn-danger'>Cancelar y Regresar</a>
                <a id="right_1" href='#' class='btn alternative btn-info'>Siguiente >></a>
            </div>
            
            <div class="bloque" id='bl3'>
                <h5>Ya ha escogido las caracteristicas de su organización antes, si su vacante tiene diferentes beneficios puede cambiarlos acá</h5>
                <?php
                    $constructor->selectElement('bene_extr', 'bene_extr', '<h6>Escoja los beneficios Extralegales que trandrá su vacante</h6>', $vacante?$vacante['bene_extr_vacante']:$empresa['bene_extr_empresa'], 'Beneficios Extralegales', 'caja', '', 'chosen_select', '', 'required', '');
                    $constructor->selectElement('jorn_labo_sema', 'jorn_labo_sema', '<h6>Escoja el tipo de jornada laboral (por días a la semana) que tendrá su vacante</h6>', $vacante?$vacante['jorn_lab_sema_vacante']:$empresa['jorn_labo_sema_empresa'],'Jornada Laboral Semanal', 'caja', '', 'chosen_select', '', 'required', '');
                    $constructor->selectElement('jorn_labo_dia', 'jorn_labo_dia', '<h6>Escoja la jornada laboral que tendrá su vacante</h6>', $vacante?$vacante['jorn_lab_dia_vacante']:$empresa['jorn_labo_dia_empresa'],'Jornada Laboral Diaria', 'caja', '', 'chosen_select', '', 'required', '');
                    $constructor->selectElement('mode_de_trab', 'mode_de_trab', '<h6>Escoja el modelo de trabajo que tendrá su vacante</h6>', $vacante?$vacante['mode_de_trab_vacante']:$empresa['mode_de_trab_empresa'], 'Modelo de Trabajo', 'caja', '', 'chosen_select', '', 'required', '')
                ?>
                <a id="left_2" href='#' class='btn alternative btn-info'><< Anterior</a>
                <a href="perfil.php" id="cancel_2" class='btn btn-danger'>Cancelar y Regresar</a>
                <a id="right_2" href='#' class='btn alternative btn-info'>Siguiente >></a>
            </div>

            <div class="bloque" id='bl4'>
                <h6>¿Prefiere que su nuevo empleado tenga alguna certificación?</h6>
                <div id="cert_div">
                    <?php
                        if(isset($vacante['ids_cert_vacante'])){
                            $url = 'rest.serenaccion.com.co/certs?token=no&except=dev_masabogalq&linkTo=id_vacante_cert&equalTo='.$vacante['id_vacante'];
                            $certs = str_replace(array("\n") , "", $requester ->getFunction($url));
                            $certs = json_decode($certs, true, 4)['results'];
                            $cert_arr = '';
                            $cert_q=0;
                            foreach($certs as $cert){
                                echo'
                                    <div id="cert_div_'.$cert['id_cert'].'">
                                    <label for="cert_'.$cert['id_cert'].'">Descripción del certificado:  </label>
                                    <input id="cert_'.$cert['id_cert'].'" name="cert_'.$cert['id_cert'].'" value="'.$cert['descript_cert'].'"/>
                                    <a id="remove_cert_'.$cert['id_cert'].'" class="btn btn-danger alternative">Descartar</a>
                                    </div>
                                ';
                                if($cert_arr!=''){
                                    $cert_arr.=',';
                                }
                                $cert_arr.=$cert['id_cert'];
                                $cert_q=$cert['id_cert'];
                            }
                            echo'<input id="cert_arr" name="cert_arr" value="'.$cert_arr.'" hidden/>';
                            echo'<input id="cert_q" value="'.$cert_q.'" hidden/>';
                        }else{
                            echo'<input id="cert_arr" name="cert_arr" value="" hidden/>';
                        }
                    ?>
                </div>
                <div id="cert_btn_div">
                    <a id="add_cert_btn" class="alternative btn btn-info">Añadir certificación</a>
                </div>
                <p>¿Prefiere que su vacante tenga alguna tarjeta profesional?</p>
                    <div id="tarj_prof_div">
                        <select id="tarj_prof" name="tarj_prof">
                            <?php
                                if($vacante){
                                    echo'<option selected value="'.$vacante['tarj_prof_vacante'].'">'.$vacante['tarj_prof_vacante'].'</option>';
                                }else{
                                    echo'
                                        <option value="NO" selected>No</option>
                                        <option value="SI">Si</option>
                                    ';
                                }
                            ?>
                        </select>
                    </div>
                <p>¿Requiere algún idioma para su vacante?</p>
                <div id="idiomas_select_div">
                    <label for="idiomas_select">Idiomas</label>
                    <select name="idiomas_select[]" multiple class="cajas chosen_select" placeholder="Selecccione un idioma" id="idiomas_select">
                        <option disabled selected>Selecciona un idioma</option>
                        <?php
                        if(isset($vacante['ids_idiomas_vacante'])){
                            $url = 'rest.serenaccion.com.co/idiomas?token=no&except=dev_masabogalq&linkTo=id_vacante_idioma&equalTo='.$vacante['id_vacante'];
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
                                <label id="label_div_idioma_'.$idioma['idioma_idioma'].'" for="div_idioma_'.$idioma['idioma_idioma'].'" >'.$idioma['idioma_idioma'].'</label>
                                <div id="div_idioma_'.$idioma['idioma_idioma'].'">';
                                    foreach($niveles as $nivel){
                                        echo '
                                            <label id="label_nivel_'.$nivel.'_'.$idioma['idioma_idioma'].'" for="nivel_'.$nivel.'_'.$idioma['idioma_idioma'].'">Nivel '.$nivel.'</label>
                                            <select id="nivel_'.$nivel.'_'.$idioma['idioma_idioma'].'" name="nivel_'.$nivel.'_'.$idioma['idioma_idioma'].'" style="width: 20%;">
                                            <option selected value="'.$idioma['nivel_'.$nivel.'_idioma'].'">'.$idioma['nivel_'.$nivel.'_idioma'].'</option>
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
                <a  id="left_3" href='#' class="btn alternative btn-info"><< Anterior</a>
                <a href="perfil.php" id="cancel_3" class="btn btn-danger">Cancelar y Regresar</a>
                <a class="btn btn-confirm alternative"><button type="submit">Guardar</button></a>
            </div>
        </div>
        <?php
            echo '<input hidden value="'.$empresa['esti_de_lide_empresa'].'" id ="esti_de_lide" name="esti_de_lide"/>';
            echo '<input hidden value="'.$empresa['tipo_gest_emp_empresa'].'" id ="tipo_gest_emp" name="tipo_gest_emp"/>';
            echo '<input hidden value="'.$empresa['esti_comu_inte_empresa'].'" id ="esti_comu_inte" name="esti_comu_inte"/>';
        ?>

        <!--Añadir estos botones-->


    </form>
    <!--scripts-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<script type = "text/javascript" src="../js/functions.js"></script>
<script type = "text/javascript" src="../js/vacante.js"></script>
</div>