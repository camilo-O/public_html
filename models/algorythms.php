<?php
    class Algorythms {
        function buscarAplicantes($Vacante){
            include_once('requester.php');
            $requester = new Requester();
            $resPersonales= array();
            $resLaborales= array();
            $PorPersonal=array();
            $PorLaboral=array();
            $resOrganizacionales=array();
            $PorOrganizacional=array();
            $arrayident=array();
        
            $cargo_buscar=explode(',', $Vacante["cargos_perfil"])[0];
            $url = 'rest.serenaccion.com.co/aplicantes?token=no&except=web_algorythm&cargo='.$cargo_buscar;
        
            $response = str_replace(array("\n") , "", $requester->getFunction($url));
            $response = json_decode($response, true, 6);
            if($response['status']==200){
        
                $aplicantes=$response;
        
                $nro_aplicantes=$aplicantes["total"];
                for($i=0;$i<$nro_aplicantes;$i++){
                $resLaborales[$i]=0;
                $resPersonales[$i]=0;
                $PorLaboral[$i]=0;
                $PorPersonal[$i]=0;
                $resOrganizacionales[$i]=0;
                $PorOrganizacional[$i]=0;
                }
                $comPersonales=$Vacante["comp_per_perfil"];
                $comLaborales=$Vacante["comp_lab_perfil"];
                $comOrganizacionales1=$Vacante["tipo_gest_emp_perfil"];
                $comOrganizacionales2=$Vacante["esti_de_lide_perfil"];
                $comOrganizacionales3=$Vacante["esti_comu_inte_perfil"];
                $comOrganizacionales4=$Vacante["bene_extr_perfil"];
                $comOrganizacionales5=$Vacante["jorn_labo_sema_perfil"];
                $comOrganizacionales6=$Vacante["jorn_labo_dia_perfil"];
                $comOrganizacionales7=$Vacante["mode_de_trab_perfil"];
                $separador=",";
                $comPersonales=explode($separador,$comPersonales);
                $comLaborales=explode($separador,$comLaborales);
                $countPersonales=count($comPersonales);
                $countLaborales=count($comLaborales);
                $countOrganizacionales=7;
                for($k=0;$k<$nro_aplicantes;$k++){
                $cargo=explode($separador,$aplicantes["results"][$k]["perfil"]["cargos_perfil"]);
                $numeroCargos=count($cargo);
        
                for($h=0;$h<$numeroCargos;$h++){
                    if($cargo_buscar==$cargo[$h]){
                    $comPersonalesA=explode($separador,$aplicantes["results"][$k]["perfil"]["comp_per_perfil"]);
                    $comLaboralesA=explode($separador,$aplicantes["results"][$k]["perfil"]["comp_lab_perfil"]);
                    $countLaboralesA=count($comLaboralesA);
                    $countPersonalesA=count($comPersonalesA);
        
        
                    for($i=0;$i<$countPersonalesA;$i++){
                        for($j=0;$j<$countPersonales;$j++){
                        if($comPersonalesA[$i]==$comPersonales[$j]){
                            $resPersonales[$k]=$resPersonales[$k]+1;
                        }
                        else{
                            $resPersonales[$k]=$resPersonales[$k];
                        }
        
                        }
                    }
        
                    for($i=0;$i<$countLaboralesA;$i++){
                        for($j=0;$j<$countLaborales;$j++){
                        if($comLaboralesA[$i]==$comLaborales[$j]){
                            $resLaborales[$k]=$resLaborales[$k]+1;
                        }
                        else{
                            $resLaborales[$k]=$resLaborales[$k];
                        }
                        }
                    }
        
        
        
                    if($comOrganizacionales1==$aplicantes["results"][$k]["perfil"]["tipo_gest_emp_perfil"]){
                        $resOrganizacionales[$k]=$resOrganizacionales[$k]+1;
                    }
                    if($comOrganizacionales2==$aplicantes["results"][$k]["perfil"]["esti_de_lide_perfil"]){
                        $resOrganizacionales[$k]=$resOrganizacionales[$k]+1;
                    }
                    if($comOrganizacionales3==$aplicantes["results"][$k]["perfil"]["esti_comu_inte_perfil"]){
                        $resOrganizacionales[$k]=$resOrganizacionales[$k]+1;
                    }
                    if($comOrganizacionales4==$aplicantes["results"][$k]["perfil"]["bene_extr_perfil"]){
                        $resOrganizacionales[$k]=$resOrganizacionales[$k]+1;
                    }
                    if($comOrganizacionales5==$aplicantes["results"][$k]["perfil"]["jorn_labo_sema_perfil"]){
                        $resOrganizacionales[$k]=$resOrganizacionales[$k]+1;
                    }
                    if($comOrganizacionales6==$aplicantes["results"][$k]["perfil"]["jorn_labo_dia_perfil"]){
                        $resOrganizacionales[$k]=$resOrganizacionales[$k]+1;
                    }
                    if($comOrganizacionales7==$aplicantes["results"][$k]["perfil"]["mode_de_trab_perfil"]){
                        $resOrganizacionales[$k]=$resOrganizacionales[$k]+1;
                    }
                    $PorPersonal[$k]=round(($resPersonales[$k]/$countPersonales)*100,2);
                    $PorLaboral[$k]=round(($resLaborales[$k]/$countLaborales)*100,2);
                    $PorOrganizacional[$k]=round(($resOrganizacionales[$k]/$countOrganizacionales)*100,2);
                    $arrayident[$k]=$aplicantes["results"][$k]["perfil"]["id_aplicante_perfil"];
                    }
                }
                }
                $output = [];
                $count = 0;
                $output['status'] = 200;
                foreach($arrayident as $item){
                $output['results'][$count] = array(
                    'id_aplicante' => $item,
                    'comp_per_porc_aplicante' => $PorPersonal[$count],
                    'comp_lab_porc_aplicante' => $PorLaboral[$count],
                    'carac_orga_porc_aplicante' => $PorOrganizacional[$count],
                    'aplicante' => $aplicantes['results'][$count]
                );
                $count++;
                }
                return $output;
            }else{
                return $response;
            }
        }

        function buscarAplicantes2($id_vacante){
            include_once('requester.php');
            $requester = new Requester();
            $vacante = [];
            $data = 'rest.serenaccion.com.co/vacantes?linkTo=id_vacante&equalTo='.$id_vacante.'&token=no&except=dev_masabogalq&table=vacantes&sufix=vacante';
            $data = str_replace(array("\n", "[" , "]") , "", $requester->getFunction($data));
            $data = json_decode($data, true, 3)['results'];
            $vacante['cargos'] = explode(',', $data['cargos_vacante']);
            $vacante['comp_per'] = explode(',', $data['comp_per_vacante']);
            $vacante['comp_lab'] = explode(',',$data['comp_lab_vacante']);
            $carac_organ = ['tipo_gest_emp', 'esti_de_lide', 'esti_comu_inte', 'bene_extr', 'jorn_labo_sema', 'jorn_labo_dia' , 'mode_de_trab'];
            $vacante['carac_organ'] = [];
            foreach($carac_organ as $carac){
                $vacante['carac_organ'][$carac] = $data[$carac .  '_vacante'];
            }
        }
    }
?>