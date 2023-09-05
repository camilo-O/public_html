<?php
include_once('../models/submit_model.php');
$submitModel = new SubmitModel();
    //Activación de cuenta y login
    if(isset($_POST['email']) && isset($_POST['password'])){
        if(isset($_POST['activar']) && $_POST['activar'] == 'true'){
            $submitModel ->activarRequest($_POST['email'], $_POST['password'], $_POST['tipo']);
        }else{
            $submitModel ->submitLogin($_POST['email'], $_POST['password'], $_POST['tipo']);
        }
    }
    //Logout
    if(isset($_GET['action']) && $_GET['action'] == 'logout' ){
        $submitModel ->submitLogout($_GET['tipo']);
    }
    //Perfil de Aplicante
    if(isset($_POST['perfil_comp']) && isset($_COOKIE['tipo']) && isset($_COOKIE['token_'.$_COOKIE['tipo']])){
        $submitModel ->submitPerfilAplicante();
    }
    //Hoja de vida Común
    if(isset($_POST['hvc_comp']) && isset($_COOKIE['tipo']) && isset($_COOKIE['token_'.$_COOKIE['tipo']])){
        $submitModel ->submitHVC();
    }
    //Registro de aplicante
    if(isset($_POST['reg_aplicante']) && $_POST['reg_aplicante']=='true'){
        $submitModel ->regAplicante($_POST['nombre_aplicante'], $_POST['apellido_aplicante'], $_POST['ciudad_aplicante'], $_POST['celular_aplicante'], $_POST['telefono_aplicante'], $_POST['direccion_aplicante'], $_POST['email_aplicante'], $_POST['password_aplicante'], $_POST['tipo_nuip_aplicante'], $_POST['nuip_aplicante'], $_POST['terminos_y_condiciones_aceptadas_aplicante'], $_POST['politica_tratamiento_datos_aceptada_aplicante']);
    }
    //Actualizar información de contacto de aplicante
    if(isset($_POST['update_aplicante']) && $_POST['update_aplicante']=='true'){
        $submitModel ->updateAplicante($_POST['nombre_aplicante'], $_POST['apellido_aplicante'], $_POST['ciudad_aplicante'], $_POST['celular_aplicante'], $_POST['telefono_aplicante'], $_POST['direccion_aplicante'], $_POST['email_aplicante'], $_POST['tipo_nuip_aplicante'], $_POST['nuip_aplicante'], $_POST['id_aplicante']);
    }
    //Registro de empresa
    if(isset($_POST['reg_empresa']) && !isset($_POST['update_empresa'])){
        $email_drh_empresa='';
        if(isset($_POST['email_reclutador_empresa'])){
            $email_drh_empresa = $_POST['email_drh_empresa'];
        }else{
            $email_drh_empresa = $_POST['email_empresa'];
        }
        $sector_empresa = '';
        $sector_empresa=$_POST['sector_empresa'];
        $submitModel ->regEmpresa($_POST['nombre_empresa'], $_POST['ciudad_empresa'], $_POST['telefono_empresa'], $_POST['drh_empresa'], $_POST['reclutador_empresa'], $_POST['email_empresa'], $email_drh_empresa, $_POST['password_empresa'], $_POST['nit_empresa'], $_POST['direccion_empresa'], $_POST['celular_empresa'], $sector_empresa, $_POST['telefono_reclutador_empresa'], $_POST['numero_empleados_empresa'], $_POST['esti_de_lide_empresa'], $_POST['tipo_gest_emp_empresa'], $_POST['esti_comu_inte_empresa'], $_POST['bene_extr_empresa'], $_POST['jorn_labo_sema_empresa'], $_POST['jorn_labo_dia_empresa'], $_POST['mode_de_trab_empresa'], $_POST['terminos_y_condiciones_aceptadas_empresa'], $_POST['politica_tratamiento_datos_aceptada_empresa']);
    }
    //Actualizar información de contacto de empresa
    if(isset($_POST['update_empresa']) && $_POST['update_empresa']=='true'){
        $email_drh_empresa='';
        if(isset($_POST['email_drh_empresa'])){
            $email_drh_empresa = $_POST['email_drh_empresa'];
        }else{
            $email_drh_empresa = $_POST['email_empresa'];
        }
        $sector_empresa = '';
        if($_POST['sector_empresa']!='Otro'){
            $sector_empresa=$_POST['sector_empresa'];
        }else{
            $sector_empresa=$_POST['cual'];
        }
        $submitModel ->updateEmpresa($_POST['nombre_empresa'], $_POST['ciudad_empresa'], $_POST['telefono_empresa'], $_POST['drh_empresa'], $_POST['reclutador_empresa'], $_POST['email_empresa'], $email_drh_empresa, $_POST['nit_empresa'], $_POST['direccion_empresa'], $_POST['celular_empresa'], $sector_empresa, $_POST['telefono_reclutador_empresa'], $_POST['numero_empleados_empresa'], $_POST['esti_de_lide_empresa'], $_POST['tipo_gest_emp_empresa'], $_POST['esti_comu_inte_empresa'], $_POST['bene_extr_empresa'], $_POST['jorn_labo_sema_empresa'], $_POST['jorn_labo_dia_empresa'], $_POST['mode_de_trab_empresa'], $_POST['id_empresa']);
    }
    //Reset password, request inicial para enviar correo
    if(isset($_POST['reset']) && $_POST['reset'] == 'noauth'){
        $submitModel ->resetPassNoauth($_POST['email'], $_POST['tipo']);
    }
    //Reset password, request final para cambiar la contraseña en database
    if(isset($_POST['reset']) && $_POST['reset'] == 'auth'){
        $submitModel ->resetPassAuth($_POST['email'], $_POST['id'], $_POST['new_password'], $_POST['tipo']);
    }
    //Postuklar vacante
    if(isset($_POST['vacante_comp']) && $_POST['vacante_comp']=='true' && isset($_COOKIE['tipo']) && isset($_COOKIE['token_'.$_COOKIE['tipo']])){
        $submitModel ->submitVacante();
    }
    //Descartar una Vacante
    if(isset($_GET['id']) && isset($_GET['cancel_vacante']) && $_GET['cancel_vacante']=='true'){
        $submitModel-> discardVacante();
    }
    //Rescatar una Vacante
    if(isset($_GET['id']) && isset($_GET['cancel_vacante']) && $_GET['cancel_vacante']=='false'){
        $submitModel-> reinstallVacante();
    }
    if(isset($_POST['id_aplicante']) && isset($_POST['id_cargo']) && isset($_POST['porc_comp_lab'])){
        $submitModel-> generateHTML($_POST['id_aplicante'],$_POST['id_cargo'],$_POST['porc_comp_lab'],$_POST['porc_comp_per'],$_POST['porc_carac_orga']);
    }
    if(isset($_POST['visible']) && isset($_POST['cambiar_visibilidad']) && $_POST['cambiar_visibilidad'] == 'TRUE'){
        $submitModel -> cambiarVisibilidad($_POST['visible'], $_COOKIE['id_aplicante']);
    }

?>