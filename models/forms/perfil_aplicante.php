<?php
    include_once('form_elements/elementor.php');
    $constructor = new Elementor();
    $requester = new Requester();
    $perfil_aplicante = NULL;
    if($perfil['id_perfil_aplicante']!=NULL){
        $id_perfil = '';
        $url = 'rest.serenaccion.com.co/perfiles?token=no&except=dev_masabogalq&linkTo=id_perfil&equalTo='.$perfil['id_perfil_aplicante'];
        $perfil_aplicante = str_replace(array("\n") , "", $requester->getFunction($url));
        $perfil_aplicante = json_decode($perfil_aplicante, true, 4);
        $status = $perfil_aplicante['status'];
        if($status==200){
            $perfil_aplicante = $perfil_aplicante['results'][0];
            $id_perfil = $perfil_aplicante['id_perfil'];
        }
    }
?>
<div>
    <form id="box" name="perfil_form" class="form" action="../controlers/submit.php" method="POST">
        <input id="location" value="perfil" hidden></input>
        <?php
        if(isset($id_perfil) && isset($id_perfil) && $id_perfil!=''){
        echo '<input name="id_perfil" value="'.$id_perfil.'" hidden/>';
        }
        ?>
        <h5> Esta es la oportunidad de mostrar tus competencias adquiridas y por las que quieres ser contratado en el trabajo que serás feliz. Igual, expresa el tipo de empresa en la que quisieras desempeñarte</h5>
        <div class="contenedorpestañas">
            <ul class="ul">
                <li id="li_comp" class="li activo">Competencias Laborales y Personales</li>
                <li id="li_inte" class="li">Intereses organizacionales</li>
            </ul>
            <div class= "subcontenedor">
                <div id="bloque_comp" class ="bloque activo">
                    <input name="perfil_comp" type="hidden" required>
                    <h4>Competencias Laborales y Personales</h4>
                    <br>
                    <h6>
                    De acuerdo a las experiencias desarrolladas, registra los cargos y las competencias laborales y personales que quieres desempeñar. Puedes seleccionar y registrar todos los cargos que has desempeñado. Seguido, registra las competencias laborales y personales adquiridas en los cargos señalados.</h6>
                    <?php
                        
                        $constructor->selectElement('cargos', 'cargos[]', 'Cargos en los que te has desempeñado', $perfil_aplicante?$perfil_aplicante['cargos_perfil']:'','Cargos','caja','','chosen_select','multiple','required','');
                        $constructor->selectElement('comp_lab', 'comp_lab[]', 'Tus Competencias Laborales', $perfil_aplicante?$perfil_aplicante['comp_lab_perfil']:'','Tus Competencias Laborales','caja','','chosen_select','multiple','required','');
                    ?>
                    <div>
                        <h6>¿Tienes competencias certificadas que no están listadas?</h6>
                        <p>Si tienes competencias laborales que no esten enlistadas? añadelas en el siguiente botón</p>
                        <div id="otras_comp_lab_div"></div>
                        <a id="add_otra_comp_lab"><button type="button">Añade una nueva competencia laboral</button></a>
                        <input hidden id="comp_lab_arr" name="comp_lab_arr" value=''/>
                    </div></br>
                    <?php
                        $constructor->selectElement('comp_per', 'comp_per[]', 'Tus Competencias Personales', $perfil_aplicante?$perfil_aplicante['comp_per_perfil']:'','Tus Competencias Personales','caja','','chosen_select','multiple','required','');
                    ?>
                    <div>
                        <h6>¿Has desarrollado competencias personales certificadas que no están listadas?</h6>
                        <p>Si tienes competencias personales que no esten enlistadas? añadelas en el siguiente botón</p>
                        <div id="otras_comp_per_div"></div>
                        <a id="add_otra_comp_per"><button type="button">Añade una nueva competencia personal</button></a>
                        <input hidden id="comp_per_arr" name="comp_per_arr" value=''/>
                    </div>
                    <a id="cancel"><button class="cancel" type="button">Cancelar y Regresar</button></a>
                    <a id="right" href='#box'><button class="alternative" type="button">Ir a Intereses Organizacionales</button></a>
                </div>
                <div id="bloque_inte" class="bloque">
                    <h4>Intereses organizacionales</h4>
                    <h5>
                    Es la oportunidad de definir las características organizacionales en las que te sientes productivo y te permite tu mejor desempeño. Esta descripción te permitirá encontrar la empresa ideal. Lee los apartados y selecciona con el que más cómodo te sientes.
                    </h5>
                    <?php
                        $constructor->selectElement('tipo_gest_emp', 'tipo_gest_emp', 'Tipo de Gestión Empresarial', $perfil_aplicante?$perfil_aplicante['tipo_gest_emp_perfil']:'','Tipo de Gestión Empresarial','caja','','chosen_select','','required','');
                        $constructor->selectElement('esti_de_lide', 'esti_de_lide', 'Estilo de Liderazgo', $perfil_aplicante?$perfil_aplicante['esti_de_lide_perfil']:'','Estilo de Liderazgo','caja','','chosen_select','','required','');
                        $constructor->selectElement('esti_comu_inte', 'esti_comu_inte', 'Estilo de Comunicación Interna', $perfil_aplicante?$perfil_aplicante['esti_comu_inte_perfil']:'','Estilo de Comunicación Interna','caja','','chosen_select','','required','');
                        $constructor->selectElement('bene_extr', 'bene_extr', 'Beneficios Extra', $perfil_aplicante?$perfil_aplicante['bene_extr_perfil']:'','Beneficios Extra','caja','','chosen_select','','required','');
                        $constructor->selectElement('jorn_labo_sema', 'jorn_labo_sema', 'Jornada Laboral Semanal', $perfil_aplicante?$perfil_aplicante['jorn_labo_sema_perfil']:'','Jornada Laboral Semanal','caja','','chosen_select','','required','');
                        $constructor->selectElement('jorn_labo_dia', 'jorn_labo_dia', 'Jornada Laboral Diaria', $perfil_aplicante?$perfil_aplicante['jorn_labo_dia_perfil']:'','Jornada Laboral Diaria','caja','','chosen_select','','required','');
                        $constructor->selectElement('mode_de_trab', 'mode_de_trab', 'Modelo de Trabajo', $perfil_aplicante?$perfil_aplicante['mode_de_trab_perfil']:'','Modelo de Trabajo','caja','','chosen_select','','required','');
                    ?>
                    <a><button class="btn btn-lg" type="submit">Guardar</button></a>
                    <a id="cancel"><button class="cancel" type="button">Cancelar y Regresar</button></a>
                    <a  id="left" href='#box'><button class="alternative" type="button">Ir a Competencias</button></a>
                </div>
            </div>
        </div>
    </form>
</div>
<!--scripts-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<script type = "text/javascript" src="../js/functions.js"></script> 
<script type = "text/javascript" src="../js/formulario_perfil.js"></script> 
