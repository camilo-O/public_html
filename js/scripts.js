var uri = 'https://get.serenaccion.com.co/serenacc_dictionaries/'
//variables para perfil de aplicante
var id_perfil = $('#id_perfil').text()
var id_hvc = $('#id_hvc').text()
var visible
//variables para el formulario de perfil
const li = document.querySelectorAll('.li')
const bloque = document.querySelectorAll('.bloque')
var cargos 
var comp_lab 
var comp_per
var cc
var comp_lab_count
var comp_per_count
//variables para el formulario de hvc
var sexo 
var niveles_form 
var niveles_idioma
var habilidad_idioma 
var exp_q 
var forma_q  
var sino
var idiomas_sel
var idiomas_arr 
var programas_arr 
var sectores
$(document).ready(function(){
    //inicialización para perfil de aplicante
    if($('#location').val()=='reg_aplicante'){
        $(".chosen_select").chosen({search_contains: 'true', width: '100%'})
        $.validator.addMethod("allow_symbol", function(value, element) {
            return this.optional(element) || value === "NA" ||
                value.match(/[0-9,-]/);
        }, "Please enter a valid number, or 'NA'");
        $("form[name='reg_aplicante']").validate({
            rules:{
                "cemail":{
                    equalTo: '#email'
                },
                "cpass":{
                    equalTo: '#pass'
                }
            },messages: {
                "cemail": {
                    equalTo: "Confirme con la misma dirección de correo"
                },
                'email': {
                    email: "Introduzca una dirección de correo valida"
                },
                "cpass": {
                    equalTo: "Las Contraseñas no se parecen"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }, lang: 'es'
        });
        ciudades(null) 
    }else if($('#location').val()=='update_aplicante'){
        $(".chosen_select").chosen({search_contains: 'true', width: '100%'})
        $.validator.addMethod("allow_symbol", function(value, element) {
            return this.optional(element) || value === "NA" ||
                value.match(/[0-9,-]/);
        }, "Please enter a valid number, or 'NA'");
        $("form[name='reg_aplicante']").validate({
            rules:{
                "cemail":{
                    equalTo: '#email'
                },
                "cpass":{
                    equalTo: '#pass'
                }
            },messages: {
                "cemail": {
                    equalTo: "Confirme con la misma dirección de correo"
                },
                'email': {
                    email: "Introduzca una dirección de correo valida"
                },
                "cpass": {
                    equalTo: "Las Contraseñas no se parecen"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }, lang: 'es'
        });
        ciudades($('#ciudad_select').val()) 
    }else if($('#location').val()=='reg_empresa'){
        $(".chosen_select").chosen({search_contains: 'true', width: '100%'})
        sectores = ['Transporte', 'Financiero','Comercio','Construcción','Minero Energético','Comunicaciones','Educación','Salud','Servicios Tecnológicos','Servicios Profesionales','Turismo','Alimentos', 'Otro']
        $.validator.addMethod("allow_symbol", function(value, element) {
            return this.optional(element) || value === "NA" ||
                value.match(/[0-9,-]/);
        }, "Please enter a valid number, or 'NA'");
        $("form[name='reg_empresa']").validate({
            rules:{
                "nit":{
                    allow_symbol: 'true'
                },
                "cemail_rep":{
                    equalTo: '#email_rep'
                },
                "cemail_rec":{
                    equalTo: '#email_rec'
                },
                "cpass":{
                    equalTo: '#pass'
                }
            },messages: {
                "cemail_rep": {
                    equalTo: "Confirme con la misma dirección de correo de representante"
                },
                "cemail_rec": {
                    equalTo: "Confirme con la misma dirección de correo de aplicante"
                },
                'email_rep_empresa': {
                    email: "Introduzca una dirección de correo valida"
                },
                'email_rec_empresa': {
                    email: "Introduzca una dirección de correo valida"
                },
                "cpass": {
                    equalTo: "Las Contraseñas no se parecen"
                },
            },
            submitHandler: function(form) {
                form.submit();
            }, lang: 'es'
        });
        caracOrgan() 
        sectoresProd() 
        ciudades(null) 
    }else if($('#location').val()=='update_empresa'){
        $(".chosen_select").chosen({search_contains: 'true', width: '100%'})
        sectores = ['Transporte', 'Financiero','Comercio','Construcción','Minero Energético','Comunicaciones','Educación','Salud','Servicios Tecnológicos','Servicios Profesionales','Turismo','Alimentos']
        $.validator.addMethod("allow_symbol", function(value, element) {
            return this.optional(element) || value === "NA" ||
                value.match(/[0-9,-]/);
        }, "Please enter a valid number, or 'NA'");
        $("form[name='reg_empresa']").validate({
            rules:{
                "nit":{
                    allow_symbol: 'true'
                },
                "cemail_rep":{
                    equalTo: '#email_rep'
                },
                "cemail_rec":{
                    equalTo: '#email_rec'
                },
                "cpass":{
                    equalTo: '#pass'
                }
            },messages: {
                "cemail_rep": {
                    equalTo: "Confirme con la misma dirección de correo de representante"
                },
                "cemail_rec": {
                    equalTo: "Confirme con la misma dirección de correo de aplicante"
                },
                'email_rep_empresa': {
                    email: "Introduzca una dirección de correo valida"
                },
                'email_rec_empresa': {
                    email: "Introduzca una dirección de correo valida"
                },
                "cpass": {
                    equalTo: "Las Contraseñas no se parecen"
                },
            },
            submitHandler: function(form) {
                form.submit();
            }, lang: 'es'
        });
        caracOrgan() 
        sectoresProd() 
        ciudades($('#ciudad_select').val()) 
    }else if($('#location').val()=='aplicante'){
        visible = Cookies.get('visible')
    }else if($('#location').val()=='perfil'){
        $(".chosen_select").chosen({search_contains: 'true', width: '100%'})
        cargos = []
        comp_lab = []
        comp_per = []
        cc = ''

        comp_per_count = 0
        comp_lab_count = 0
        comp_per = $('#comp_per').val();
        /*=================================================
            rellena primera pagina
        =================================================*/
        //cargos
        cargos=$('#cargos').val()
        if(cargos!=null){
            cargo('#cargos', cargos, null)
            $('.chosen_select').trigger("chosen:updated")
        }else{
            $.get(uri+'cargos', function(data, status){
                data = JSON.parse(data)
                data = data['results']
                $.each(data, function(i, item){
                    $('#cargos').append(
                        $('<option/>',{
                            value: item['id_cargo'],
                            text: item['nombre_cargo']
                        })
                    )
                })
                $('.chosen_select').trigger("chosen:updated")
            })
        }
        //comp lab
        comp_lab=$('#comp_lab').val()
        $('#comp_lab').empty()
        if(cargos!=null){
            cargos.push('2')
            $('#comp_lab').empty()
            $.each(cargos, function(i, item){
                $.get(uri+'descript_comp_l?linkTo=cod_fam_group&equalTo='+item, function(data, status){
                    data = JSON.parse(data)
                    data = data['results']
                    fillSelect1(data,'#comp_lab', 'descript', 'id_comp_l', comp_lab)
                    $('.chosen_select').trigger("chosen:updated")
                })
            })
            cargos.splice(-1, 1)
        }
        //comp per
        compPer(comp_per)
        /*=================================================
            rellena caracteristicas organizacionales
        =================================================*/
        caracOrgan()
    }else if($('#location').val()=='hvc'){
        $(".chosen_select").chosen({search_contains: 'true', width: '100%'})
        $('#main').hide()
        sexo = ['Masculino', 'Femenino', 'Otro']
        niveles_form = ['Primaria','Bachillerato','Pregrado','Posgrado', 'Otro']
        niveles_idioma = ['Bajo','Intermedio','Alto','Nativo'] 
        habilidad_idioma = ['hablado', 'escrito','leido']
        sino = ['SI', 'NO'] 
        idiomas_sel = [] 
        comp_lab = $('#comp_lab').val() 
        comp_per = $('#comp_per').val() 
        $("#idiomas_select").data("placeholder","Escoja una o mas ocupaciones").chosen()
        $.get(uri+"idiomas", function(data, status){
            data = JSON.parse(data) 
            idiomas_arr = data['results'] 
        }) 
        $.get(uri+"programas", function(data, status){
            data = JSON.parse(data) 
            programas_arr = data['results'] 
        }) 
        /*================================================================
                        Rellenar opciones sexo
        ================================================================*/
        var sex = $('#sex').val() 
        $.each(sexo, function(i, item){
            if(sex!=item){
                $('#sex').append(
                    $('<option/>',{
                        value: item,
                        text: item
                    })
                )
            }
        }) 
        /*================================================================
                        Rellenar opciones experiencias pasadas
        ================================================================*/
        var exps = $('#exps_arr').val().split(',') 
        if(exps!=''){
            fillExps(exps) 
            exp_q = parseInt(exps[exps.length-1]) +1 
        }else{
            exp_q = 0 
        }
        /*================================================================
                        Rellenar opciones formaciones
        ================================================================*/
        var formas = $('#formas_arr').val().split(',') 
        if(formas!=''){
            fillFormas(formas)
            forma_q = parseInt(formas[formas.length-1]) +1 
        }else{
            forma_q = 0 
        }
        /*================================================================
                        Rellenar opciones idiomas
        ================================================================*/
        var idiomas_q = $('#idiomas_q').val() 
        if(idiomas_q!=null){
            var idiomas_selected = $('#idiomas_select').val() 
            $.each(idiomas_selected, function(i,item){
                idiomas_sel.push(item) 
            })
            idiomas (idiomas_selected) 
            nivelIdioma(idiomas_selected) 
        }else{
            idiomas(null) 
        }
        /*================================================================
                        Rellenar ciudades
        ================================================================*/
        var ciudad = $('#ciudad_select').val()
        ciudades(ciudad) 
        siNoF() 
        $('#main').show() 
    }

})
//boton de visible para el perfil de aplicante
$('#visible').click(function(){
    if(id_perfil!='' && id_hvc!=''){
      if(visible=='si'){
        visible = 'no'
      }else{
        visible =  'si'
      }
      if(confirm('desea cambiar la visibilidad de su perfil?')){
        setCookie('visible',visible,15)
        window.location = 'aplicante.php'
        window.location.reload(true)
      }
    }else{
      alert('Completa tu perfil para hacerlo visible para las empresas')
    }
})
function cargo(index, value, exclude){
    $(index).empty()
    $(index).append(
        $('<option>',{
            value: 'default',
            disabled: 'disabled',
            selected: 'selected',
            text: ''
        })
    )
    $.get(uri+"cargos", function(data, status){
        data = JSON.parse(data) 
        data = data['results'] 
        fillSelect1(data, index, 'nombre_cargo', 'id_cargo', value, exclude)
        $(index).trigger("chosen:updated") 
    }) 
}
function caracOrgan(){
    $.get(uri+"carac_organ", function(data, status){
        data = JSON.parse(data)
        carac_organ = data['results']
        var value = []
        value['tipo_gest_emp'] = $('#tipo_gest_emp').val()
        $('#tipo_gest_emp').empty()
        value['esti_de_lide'] = $('#esti_de_lide').val()
        $('#esti_de_lide').empty()
        value['esti_comu_inte'] = $('#esti_comu_inte').val()
        $('#esti_comu_inte').empty()
        value['bene_extr'] = $('#bene_extr').val()
        $('#bene_extr').empty()
        value['jorn_labo_sema'] = $('#jorn_labo_sema').val()
        $('#jorn_labo_sema').empty()
        value['jorn_labo_dia'] = $('#jorn_labo_dia').val()
        $('#jorn_labo_dia').empty()
        value['mode_de_trab'] = $('#mode_de_trab').val()
        $('#mode_de_trab').empty()
        $.each(carac_organ, function (i, item) {
            $.each(Object.keys(item), function(k, ktem){
                if(ktem!='id'){
                    fillCaracs('#'+ktem, item['id'], value[ktem],item[ktem], item['desc_'+ktem] )
                }
            })
        })
        $('.chosen_select').trigger("chosen:updated")
    })
}
$('a').click(function(){
    var id = $(this).attr('id')
    if(id==undefined){
        return
    }else if(id == 'add_otra_comp_lab'){
        addOtraCompLab(comp_lab_count)
        comp_lab_count += 1
    }else if(id == 'add_otra_comp_per'){
        addOtraCompPer(comp_per_count)
        comp_per_count += 1
    }else if(id.includes('remove_forma')){
        id = id.split('_')[2] 
        $('#forma_div_'+id).remove() 
    }else if(id.includes('add_forma')){
        escribir_formacion(forma_q)
    }else if(id.includes('add_exp')){
        escribir_exp(exp_q) 
    }else if(id.includes('remove_exp')){
        id = id.split('_')[2] 
        $('#exp_'+id).remove() 
        removeExp(id) 
    }else if(id=='aTratDatos'){
        acepto('#TratDatos')
    }else if(id=='aTermnCond'){
        acepto('#TermnCond')
    }else if(id == 'cancel'){
        window.location='perfil.php'
    }else if(id == 'perfil_incompleto'){
        if(confirm('Completa primero tu Hoja de Vida SER EN ACCIÓN para registrar tus competencias bajo nuestro modelo')){
            window.location="formulario.php?form=perfil";
        }
    }else if(id == 'right'){
        document.getElementById('bloque_comp').classList.remove('activo')
        document.getElementById('li_comp').classList.remove('activo')
        document.getElementById('bloque_inte').classList.add('activo')
        document.getElementById('li_inte').classList.add('activo')
        window.location='#'
    }else if(id == 'left'){
        document.getElementById('bloque_inte').classList.remove('activo')
        document.getElementById('li_inte').classList.remove('activo')
        document.getElementById('bloque_comp').classList.add('activo')
        document.getElementById('li_comp').classList.add('activo')
        window.location='#'
    }
})
$("#cargos").change(function () {
    var cargos_val = $('#cargos').val()
    comp_lab = $('#comp_lab').val()
    if(cargos_val!=null && cargos!=null && cargos_val.length>cargos.length){
        if(diferenciaDeArreglos(cargos_val, cargos)[0] == '1'){
            addOtroCargo()
        }
        addCompLab(diferenciaDeArreglos(cargos_val, cargos)[0])
    }else if(cargos_val!=null && cargos==null){
        if(cargos_val[0] == '1'){
            addOtroCargo()
        }
        addCompLab(cargos_val[0])
    }else if(cargos_val!=null && cargos_val.length<cargos.length){
        if(!cargos_val.includes('1')){
            $('#otro_cargo_div').remove()
        }
        remCompLab(cargos_val)
    }else if(cargos_val==null){
        $('#otro_cargo_div').remove()
        $('#comp_lab').empty()
    }
    $('.chosen_select').trigger("chosen:updated")
    cargos = cargos_val    
})
$('select').change(function(){
    var id = $(this).attr('id') 
    if(id==undefined){
        return
    }else if(id.includes('tipo_forma')){
        id = id.split('_')[2] 
        var val_tipo = $('#tipo_forma_'+id).val() 
        if(val_tipo == 'Primaria' || val_tipo == 'Bachillerato'){
            $('#col_forma_div_'+id).show()
            $('#nivel_forma_div_'+id).hide() 
            $('#inst_forma_div_'+id).hide() 
            $('#prog_forma_div_'+id).hide() 
            $('#nivel_otro_forma_div_'+id).hide()
            $('#inst_otro_forma_div_'+id).hide()
            $('#prog_otro_forma_div_'+id).hide()
        }else if(val_tipo == 'Pregrado' || val_tipo == 'Posgrado'){
            $('#col_forma_div_'+id).hide()
            $('#nivel_forma_div_'+id).show() 
            $('#nivel_otro_forma_div_'+id).hide()
            $('#inst_otro_forma_div_'+id).hide()
            $('#prog_otro_forma_div_'+id).hide()
            $('#nivel_forma_'+id).empty() 
            nivelForma('#nivel_forma_'+id, val_tipo, id)
            var niveles = [] 
            $.each(programas_arr, function(i, item){
                if(item['nivel'] == val_tipo){
                    niveles.push(item['formacion']) 
                }
            })
            niveles = [...new Set(niveles)] 
            fillSelect(niveles, '#nivel_forma_'+id) 
            $('#nivel_forma_'+id).trigger("chosen:updated") 
        }else{
            $('#nivel_otro_forma_div_'+id).show()
            $('#inst_otro_forma_div_'+id).show()
            $('#prog_otro_forma_div_'+id).show()
            $('#col_forma_div_'+id).hide()
            $('#nivel_forma_div_'+id).hide() 
            $('#inst_forma_div_'+id).hide() 
            $('#prog_forma_div_'+id).hide() 
        }
    }else if(id.includes('nivel_forma')){
        id = id.split('_')[2] 
        var val_nivel = $('#nivel_forma_'+id).val() 
        instForma('#inst_forma_'+id, val_nivel) 
        $('#inst_forma_div_'+id).show() 
    }else if(id.includes('inst_forma')){
        id = id.split('_')[2] 
        var val_inst = $('#inst_forma_'+id).val() 
        progForma('#prog_forma_'+id, val_inst) 
        $('#prog_forma_div_'+id) 
    }else if(id == 'idiomas_select'){
        var idiomas_sels = $('#idiomas_select').val() 
        if(idiomas_sels==null){
            idiomas_sels =[] 
        }
        if(idiomas_sel.length<idiomas_sels.length){
            escribir_idioma(diferenciaDeArreglos(idiomas_sels, idiomas_sel)) 
        }else if(idiomas_sel.length>idiomas_sels.length){
            borrar_idioma(diferenciaDeArreglos(idiomas_sel, idiomas_sels)) 
        }
        idiomas_sel = idiomas_sels 
    }
})
function acepto(index){
    val = $(index).val()
    if(val=='acepto'){
        $(index).attr('value', 'false')
    }else{
        $(index).attr('value', 'acepto')
    }
}
function addCompLab(cargo){
    $.get(uri+'descript_comp_l?linkTo=cod_fam_group&equalTo='+cargo, function(data, status){
        data = JSON.parse(data)
        data = data['results']
        $.each(data, function(i, item){
            $('#comp_lab').append(
                $('<option/>',{
                    value: item['id_comp_l'],
                    text: item['descript']
                })
            )
        })
        $('.chosen_select').trigger("chosen:updated")
    })
}
function remCompLab(cargos){
    $.each(cargos, function(c,cargo){
        $.get(uri+'descript_comp_l?linkTo=cod_fam_group&equalTo='+cargo, function(data, status){
            data = JSON.parse(data)
            data = data['results']
            $('#comp_lab').empty()
            $.each(data, function(i, item){
                if(comp_lab!=null && comp_lab.includes(item['id_comp_l'])){
                    $('#comp_lab').append(
                        $('<option/>',{
                            value: item['id_comp_l'],
                            text: item['descript'],
                            selected: 'selected'
                        })
                    )
                }else{
                    $('#comp_lab').append(
                        $('<option/>',{
                            value: item['id_comp_l'],
                            text: item['descript']
                        })
                    )
                }
            })
            $('.chosen_select').trigger("chosen:updated")
        })
    })
}
function diferenciaDeArreglos(arr1, arr2){
    var arr = []
    if(arr1.length>arr2.length){
        $.each(arr1, function(i, item){
            if(arr2.indexOf(item)==-1){
                arr.push(item)
            }
        })
    }else{
        $.each(arr2, function(i, item){
            if(arr1.indexOf(item)==-1){
                arr.push(item)
            }
        })
    }
    return arr
}
function fillCaracs(selector, id, value, text, desc){
    if(text!=null){
        if(id==value){
            $(selector).append(
                $('<option/>',{
                    value: id,
                    text: text+': '+desc,
                    selected: 'selected'
                })
            )
        }else{
            $(selector).append(
                $('<option/>',{
                    value: id,
                    text: text+': '+desc
                })
            )
        }
    }
}
function compPer(selected){
    $('#comp_per').empty()
    $.get(uri+'descript_comp_p', function(data,status){
        data = JSON.parse(data) 
        data = data['results'] 
        $.each(data, function(i, item){
            if(selected != null && selected.includes(item['id'])){
                $('#comp_per').append(
                    $('<option/>',{
                        value: item['id'],
                        text: item['comp']+': '+item['descript'],
                        selected: 'selected'
                    })
                )
            }else{
                $('#comp_per').append(
                    $('<option/>',{
                        value: item['id'],
                        text: item['comp']+': '+item['descript']
                    })
                )
            }
        })
        $('#comp_per').trigger("chosen:updated") 
    })
}
function addOtroCargo(){
    $('#cargos_div').append(
        $('<div/>',{
            id: 'otro_cargo_div'
        })
    )
    createInput('#otro_cargo_div', 'otro_cargo', 'Relacione el nombre del cargo con el que mejor se identifica: ', '')
}
function addOtraCompLab(id){
    createInput('#otras_comp_lab_div', 'comp_lab', 'Nueva Competencia: ', '_'+id)
    $('#comp_lab_div_'+id).append(
        $('<button/>',{
            class: 'btn btn-danger fa fa-close',
            type: 'button'
        }).click(function(){
            $('#comp_lab_div_'+id).remove()
            removeOtraCompLab(id)
        })
    )
    var val = $('#comp_lab_arr').val()
    if($('#comp_lab_arr').val()!=''){
        val += ','
    }
    $('#comp_lab_arr').attr('value', val+id)
}
function removeOtraCompLab(id){
    var val =  $('#comp_lab_arr').val().split(',') 
    const index = val.indexOf(id+'') 
    if (index > -1) { // only splice array when item is found
        val.splice(index, 1)  // 2nd parameter means remove one item only
    }
    $('#comp_lab_arr').attr('value',val.join(','))
}
function addOtraCompPer(id){
    createInput('#otras_comp_per_div', 'comp_per', 'Competencia','_'+id)
    createInput('#comp_per_div_'+id, 'descript_comp_per', 'Descripción', '_'+id)
    $('#comp_per_div_'+id).append(
        $('<a/>',{
            text: ''
        }).click(function(){
            $('#comp_per_div_'+id).remove()
            removeOtraCompPer(id)
        })
    )
    var val = $('#comp_per_arr').val()
    if($('#comp_per_arr').val()!=''){
        val += ','
    }
    $('#comp_per_arr').attr('value', val+id)
}
function removeOtraCompPer(id){
    var val =  $('#comp_per_arr').val().split(',') 
    const index = val.indexOf(id+'') 
    if (index > -1) { // only splice array when item is found
        val.splice(index, 1)  // 2nd parameter means remove one item only
    }
    $('#comp_per_arr').attr('value',val.join(','))
}
function tipoForma(index){
    var val_tipo = $(index).val() 
    $(index).empty() 
    $.each(niveles_form, function(i,item){
        if(val_tipo==item){
            $(index).append(
                $('<option/>',{
                    value: item,
                    text: item, 
                    selected: 'selected'
                })
            )
        }else{
            $(index).append(
                $('<option/>',{
                    value: item,
                    text: item
                })
            )}
    }) 
    return(val_tipo) 
}
function nivelForma(index, val_tipo, id){
    var nivel = $('#nivel_forma_'+id)
    $.get(uri+'programas', function(data, status){
        data = JSON.parse(data) 
        data = data['results'] 
        var niveles = [] 
        $.each(data, function(i, item){
            if(item['nivel'] == val_tipo){
                niveles.push(item['formacion']) 
            }
        })
        niveles = [...new Set(niveles)] 
        $.each(niveles, function(i, item){
            $(index).append(
                $('<option/>',{
                    value: item,
                    text: item
                })
            ) 
            $('.chosen_select').trigger("chosen:updated") 
        })
    }) 
    return nivel;
}
function instForma(index, val_nivel){
    var inst = $(index).val() 
    $.get(uri+'programas', function(data, status){
        data = JSON.parse(data) 
        data = data['results'] 
        var instituciones = [] 
        $.each(data, function(i, item){
            if(item['formacion'] == val_nivel){
                instituciones.push(item['institucion']) 
            }
        })
        instituciones = [...new Set(instituciones)] 
        $.each(instituciones, function(i, item){
            if(item!=inst){
                $(index).append(
                    $('<option/>',{
                        value: item,
                        text: item
                    })
                ) 
            }
        }) 
        $(index).trigger("chosen:updated") 
    }) 
    return inst 
}
function progForma(index, val_nivel, val_inst){
    var prog = $(index).val() 
    $.get(uri+'programas', function(data, status){
        data = JSON.parse(data) 
        data = data['results'] 
        var programas = [] 
            $.each(data, function(i, item){
                if(item['institucion'] == val_inst && item['formacion'] == val_nivel){
                    programas.push(item['programa']) 
                }
            })
            programas = [...new Set(programas)] 
            $.each(programas, function(i, item){
                if(item!=prog){
                    $(index).append(
                        $('<option/>',{
                            value: item,
                            text: item
                        })
                    ) 
                }
            })
            $(index).trigger("chosen:updated") 
    })
}
function idiomas(idiomas_selected){
    $('#idiomas_select').empty() 
    $.get(uri+"idiomas", function(data, status){
        data = JSON.parse(data) 
        data = data['results'] 
        $.each(data, function (i, item) {
            if(idiomas_selected!=null){
                if(!idiomas_selected.includes(item['id'])){
                    $('#idiomas_select').append(
                        $('<option/>',{
                            value: item['id'],
                            text: item['idioma']
                        })
                    ) 
                }else{
                    $('#idiomas_select').append(
                        $('<option/>',{
                            value: item['id'],
                            text: item['idioma'],
                            selected: 'selected'
                        })
                    ) 
                }
            }else{
                $('#idiomas_select').append(
                    $('<option/>',{
                        value: item['id'],
                        text: item['idioma']
                    })
                ) 
            }
        }) 
        $('#idiomas_select').trigger("chosen:updated") 
    }) 
}
function nivelIdioma(idiomas_selected){
    $.get(uri+"idiomas", function(data, status){
        data = JSON.parse(data) 
        data = data['results'] 
        $.each(data, function(i,item){
            if(idiomas_selected.includes(item['id'])){
                $('#label_div_idioma_'+item['id']).remove() 
                $('#div_idioma_'+item['id']).before(
                    $('<label/>',{
                        id: 'label_div_idioma_'+item['id'],
                        text: item['idioma']
                    })
                ) 
            }
        })
    }) 
    $.each(idiomas_selected, function(i,item){
        $.each(habilidad_idioma,function(it, items){
            $.each(niveles_idioma, function(j, jtem){
                var val = $('#nivel_'+items+'_'+item).val()
                if(val!=jtem){
                    $('#nivel_'+items+'_'+item).append(
                        $('<option/>',{
                            value: jtem,
                            text: jtem
                        })
                    )
                }
            })
        })
    })
}
function ciudades(ciudad){
    if(ciudad!=null){
        $('#ciudad_select').empty() 
    }
    $.get(uri+"municipios", function(data, status){
        data = JSON.parse(data) 
        data = data['results'] 
        $.each(data, function (i, item) {
            if(ciudad!=undefined && item['id']==ciudad){
                $('#ciudad_select').append($('<option/>', { 
                    value: item['id'],
                    text : item['municipio']+', '+item['departamento'],
                    selected: 'selected'
                })) 
            }else{
                $('#ciudad_select').append($('<option/>', { 
                    value: item['id'],
                    text : item['municipio']+', '+item['departamento']
                })) 
            }
        }) 
        $('#ciudad_select').trigger("chosen:updated")  
    }) 
}
function siNoF(){
    $.each(sino, function(i,item){
        var pase = $('#pase_conducir').val() 
        if(pase!=item){
            $('#pase_conducir').append(
                $('<option/>',{
                    value: item,
                    text: item
                })
            )
        }
        var traslado = $('#traslado').val() 
        if(traslado!=item){
            $('#traslado').append(
                $('<option/>',{
                    value: item,
                    text: item
                })
            )
        }
        var viaje = $('#viajar').val() 
        if(viaje!=item){
            $('#viajar').append(
                $('<option/>',{
                    value: item,
                    text: item
                })
            )
        }
    })
}
function escribir_exp(id){
    //creando formularios
    $('#experiencias').append(
        $('<div/>',{
            id: "exp_"+id
        })
    ) 
    createInput('#exp_'+id, 'nombre_cargo', 'Posición ocupada: ', '_'+id,) 
    createInput('#exp_'+id, 'nombre_empresa', 'Empresa: ', '_'+id,) 
    createInput('#exp_'+id, 'fecha_inicio', 'Fecha de Inicio: ', '_'+id, 'month') 
    createInput('#exp_'+id, 'fecha_salida', 'Fecha de Salida: ', '_'+id, 'month') 
    createMultipleSelect('#exp_'+id, 'comp_lab_exp', 'Competencias laborales desarrolladas en este cargo: ', '_'+id, 'chosen_select') 
    createMultipleSelect('#exp_'+id, 'comp_per_exp', 'Competencias personales desarrolladas en este cargo: ','_'+id, 'chosen_select') 
    createInput('#exp_'+id, 'cert_file_exp', 'Archivo de la certificación: ', '_'+id, 'file') 
    $('#cert_file_'+id).attr('accept','application/pdf')
    fillComp('#comp_lab_exp_'+id, '#comp_per_exp_'+id)
    $('#exp_'+id).append(
        $('<button/>',{
            class: 'btn btn-danger'
        }).append(
            $('<a/>',{
                id: 'remove_exp_'+id,
                class: 'remove_exp fa fa-close',
                text: 'Descartar esta certificación laboral'
            }).click(function(){
                $('#exp_'+id).remove() 
                if($('#exps_arr').val().includes(id)){
                    removeExp(id);
                }
            })
        )
    )
    var val = $('#exps_arr').val()
    if(val!=''){
        val= val+',' 
    }
    $('#exps_arr').attr('value', val+id) 
    exp_q = parseInt(exp_q) + 1 

}
function escribir_idioma(id){
    //creando formularios
    var numId = parseInt(id)-1 
    var idioma = idiomas_arr[numId]['idioma'] 
    var niveles_text = ['hablado', 'escrito', 'leído'] 
    var niveles = ['hablado', 'escrito', 'leido'] 
    var nivel = ['Bajo', 'Intermedio', 'Alto', 'Nativo']
    $('#idiomas_div').append(
        '<label id="label_div_idioma_'+id+'" for="div_idioma_'+id+'">'+idioma+'</label>'
    ) 
    $('#idiomas_div').append(
        '<div id="div_idioma_'+id+'"></div>'
    ) 
    //llenando formularios
    $.each(niveles, function(i, item){
        $('#div_idioma_'+id).append(
            $('<label/>',{
                for: 'nivel_'+item+'_'+id,
                text: 'Nivel '+niveles_text[i]
            }),
            $('<select/>',{
                class: 'cajas',
                name: 'nivel_'+item+'_'+id,
                id: 'nivel_'+item+'_'+id,
                required: 'required'
            }).append(
                $('<option/>',{
                    value: 'default',
                    selected: 'selected',
                    disabled: 'disabled'
                })
            )
        ) 
        $.each(nivel, function(j,jtem){
            $('#nivel_'+item+'_'+id).append(
                '<option value="'+jtem+'">'+jtem+'</option>'
            ) 
        }) 
    }) 
}
function borrar_idioma(id){
    $('#label_div_idioma_'+id).remove() 
    $('#div_idioma_'+id).remove() 
}
function diferenciaDeArreglos(arr1, arr2){
    var arr = [] 
    $.each(arr1, function(i, item){
        if(arr2.indexOf(item)==-1){
            arr.push(item) 
        }
    })
    return arr 
}
function escribir_formacion(id){
    //creando formularios
    $('#formaciones').append(
        $('<div/>',{
            id: 'forma_div_'+id
        }),
        $('<div/>',{
            id: 'forma_comp_div_'+id
        })
    ) 
    createSelect('#forma_div_'+id, 'tipo_forma', 'Tipo de Formación: ', '_'+id, null,'false') 
    createSelect('#forma_div_'+id, 'nivel_forma', 'Nivel de Formación: ', '_'+id , 'chosen_select', 'true') 
    createSelect('#forma_div_'+id, 'inst_forma', 'Institución Educativa: ', '_'+id, 'chosen_select', 'true') 
    createSelect('#forma_div_'+id, 'prog_forma', 'Programa Académico: ', '_'+id, 'chosen_select', 'true') 
    createInput('#forma_div_'+id, 'col_forma', 'Institución Educativa en que se graduó: ', '_'+id, 'text', 'true') 
    createInput('#forma_div_'+id, 'nivel_otro_forma', 'Nivel de formación Obtenido: ', '_'+id, 'text', 'true') 
    createInput('#forma_div_'+id, 'inst_otro_forma', 'Institución Educativa en que se graduó: ', '_'+id, 'text', 'true') 
    createInput('#forma_div_'+id, 'prog_otro_forma', 'Titulo Obtenido: ', '_'+id, 'text', 'true') 
    createMultipleSelect('#forma_comp_div_'+id, 'comp_lab_forma', 'Competencias laborales desarrolladas en esta intitución: ', '_'+id, 'chosen_select') 
    createMultipleSelect('#forma_comp_div_'+id, 'comp_per_forma', 'Competencias personales desarrolladas en esta institución: ','_'+id, 'chosen_select') 
    createInput('#forma_comp_div_'+id, 'cert_file_forma', 'Archivo de la certificación: ', '_'+id, 'file')
    fillComp('#comp_lab_forma_'+id, '#comp_per_forma_'+id)
    $('#forma_comp_div_'+id).append(
        $('<button/>',{
            type: 'button',
            class: 'btn btn-danger'
        }).append(
            $('<a/>',{
                id: 'remove_forma_'+id,
                class: 'remove_forma fa fa-close',
                text: 'Descartar este Certificado'
            }).click(function(){
                $('#forma_div_'+id).remove() 
                $('#forma_comp_div_'+id).remove() 
                if($('#formas_arr').val().includes(id)){
                    removeForma(id);
                }
            })
        )
    )
    //llenando los formularios
    $('.chosen_select').chosen({
        width: '100%'
    }) 
    var tipo=  [ 'Primaria', 'Bachillerato', 'Pregrado', 'Posgrado', 'Otro' ] 
    fillSelect(tipo, '#tipo_forma_'+id) 
    var val_tipo 
    $('#tipo_forma_'+id).change(function(){
        val_tipo = $('#tipo_forma_'+id).val() 
        if(val_tipo == 'Primaria' || val_tipo == 'Bachillerato'){
            $('#col_forma_div_'+id).show()
            $('#nivel_forma_div_'+id).hide() 
            $('#inst_forma_div_'+id).hide() 
            $('#prog_forma_div_'+id).hide() 
            $('#nivel_otro_forma_div_'+id).hide()
            $('#inst_otro_forma_div_'+id).hide()
            $('#prog_otro_forma_div_'+id).hide()
        }else if(val_tipo == 'Pregrado' || val_tipo == 'Posgrado'){
            $('#col_forma_div_'+id).hide()
            $('#nivel_forma_div_'+id).show() 
            $('#nivel_otro_forma_div_'+id).hide()
            $('#inst_otro_forma_div_'+id).hide()
            $('#prog_otro_forma_div_'+id).hide()
            $('#nivel_forma_'+id).empty() 
            var niveles = [] 
            $.each(programas_arr, function(i, item){
                if(item['nivel'] == val_tipo){
                    niveles.push(item['formacion']) 
                }
            })
            niveles = [...new Set(niveles)] 
            fillSelect(niveles, '#nivel_forma_'+id) 
            $('#nivel_forma_'+id).trigger("chosen:updated") 
        }else{
            $('#nivel_otro_forma_div_'+id).show()
            $('#inst_otro_forma_div_'+id).show()
            $('#prog_otro_forma_div_'+id).show()
            $('#col_forma_div_'+id).hide()
            $('#nivel_forma_div_'+id).hide() 
            $('#inst_forma_div_'+id).hide() 
            $('#prog_forma_div_'+id).hide() 
        }
    })
    var val_nivel 
    $('#nivel_forma_'+id).change(function(){
        val_nivel = $('#nivel_forma_'+id).val() 
        $('#inst_forma_'+id).empty() 
        $('#inst_forma_div_'+id).show() 
        var instituciones = [] 
        $.each(programas_arr, function(i, item){
            if(item['formacion'] == val_nivel){
                instituciones.push(item['institucion']) 
            }
        })
        instituciones = [...new Set(instituciones)] 
        fillSelect(instituciones, '#inst_forma_'+id) 
        $('#inst_forma_'+id).trigger("chosen:updated") 
    })
    var val_inst 
    $('#inst_forma_'+id).change(function(){
        val_inst = $('#inst_forma_'+id).val() 
        $('#prog_forma_'+id).empty() 
        $('#prog_forma_div_'+id).show() 
        var programas = [] 
        $.each(programas_arr, function(i, item){
            if(item['institucion'] == val_inst){
                programas.push(item['programa']) 
            }
        })
        programas = [...new Set(programas)] 
        $('#prog_forma_'+id).append(
            $('<option/>',{
                value: 'default',
                selected: 'selected',
                disabled: 'true'
            })
        ) 
        $.each(programas, function(i, item){
            $('#prog_forma_'+id).append(
                $('<option/>',{
                    value: item,
                    text: item
                })
            ) 
        })
        $('#prog_forma_'+id).trigger("chosen:updated") 
    })
    var val = $('#formas_arr').val()
    if(val!=''){
        val = val +','
    }
    $('#formas_arr').attr('value',val+id)
    forma_q = parseInt(forma_q)+1
}
function createMultipleSelect(parent, name, label, id='', clas='', hide){
    if(hide=='true') {
        $(parent).append(
            $('<div/>',{
                id: name+'_div'+id,
                hidden: hide
            }).append(
                $('<label/>',{
                    for: name+id,
                    text: label
                }).append(
                    $('<select/>',{
                        id: name+id,
                        name: name+id+'[]',
                        class: clas,
                        multiple: 'multiple'
                    })
                )
            )
        )
    }else{
        $(parent).append(
            $('<div/>',{
                id: name+'_div'+id
            }).append(
                $('<label/>',{
                    for: name+id,
                    text: label
                }).append(
                    $('<select/>',{
                        id: name+id,
                        name: name+id+'[]',
                        class: clas,
                        multiple: 'multiple',
                        required: 'required'
                    })
                )
            )
        )
    }
}
function fillComp(index_lab, index_per, comp_lab_exp=null, comp_per_exp=null){
    $(index_lab).empty()
    $(index_lab).append(
        $('<option/>',{
            value: 'default',
            disabled: 'disabled'
        })
    )
    $('.chosen_select').chosen({width: '100%'}) 
    $.get(uri+"descript_comp_l", function(data, status){
        data = JSON.parse(data) 
        data = data['results'] 
        $.each(data, function(i,item){
            if(comp_lab.includes(item['id_comp_l'])){
                if(comp_lab_exp!=null && comp_lab_exp.includes(item['id_comp_l'])){
                    $(index_lab).append(
                        $('<option/>',{
                            value: item['id_comp_l'],
                            text: item['descript'],
                            selected: 'selected'
                        })
                    )
                }else {
                    $(index_lab).append(
                        $('<option/>',{
                            value: item['id_comp_l'],
                            text: item['descript']
                        })
                    )
                }
            }
        })
        $('.chosen_select').trigger("chosen:updated") 
    }) 
    $(index_per).empty()
    $(index_per).append(
        $('<option/>',{
            value: 'default',
            disabled: 'disabled'
        })
    )
    $('.chosen_select').chosen({width: '100%'}) 
    $.get(uri+"descript_comp_p", function(data, status){
        data = JSON.parse(data) 
        data = data['results'] 
        $.each(data, function(i,item){
            if(comp_per.includes(item['id'])){
                if(comp_per_exp!=null && comp_per_exp.includes(item['id'])){
                    $(index_per).append(
                        $('<option/>',{
                            value: item['id'],
                            text: item['comp']+': '+item['descript'],
                            selected: 'selected'
                        })
                    )
                }else{
                    $(index_per).append(
                        $('<option/>',{
                            value: item['id'],
                            text: item['comp']+': '+item['descript'],
                        })
                    )
                }
            }
        })
        $('.chosen_select').trigger("chosen:updated") 
    }) 
}
function fillExps(exps){
    $.each(exps, function(i, id){
        var comp_lab_exp = $('#comp_lab_exp_'+id).val() 
        $('#comp_lab_'+id).empty()
        var comp_per_exp = $('#comp_per_exp_'+id).val() 
        $('#comp_per_'+id).empty()  
        fillComp('#comp_lab_exp_'+id, '#comp_per_exp_'+id, comp_lab_exp, comp_per_exp) 
    })    
}
function removeExp(id){
    if($('#exps_arr').val().includes(id)){
        var val =  $('#exps_arr').val().split(',') 
        const index = val.indexOf(id) 
        if (index > -1) { // only splice array when item is found
          val.splice(index, 1)  // 2nd parameter means remove one item only
        }
        $('#exps_arr').attr('value',val.join(',')) 
    }
}
function removeForma(id){
    if($('#formas_arr').val().includes(id)){
        var val =  $('#formas_arr').val().split(',') 
        const index = val.indexOf(id) 
        if (index > -1) { // only splice array when item is found
          val.splice(index, 1)  // 2nd parameter means remove one item only
        }
        $('#formas_arr').attr('value',val.join(',')) 
    }
}
function fillFormas(formas){
    $.each(formas, function(f, forma){
        var tipo = tipoForma('#tipo_forma_'+forma)
        if(tipo=='Primaria' || tipo=='Bachillerato'){
            createSelect('#forma_div_'+forma, 'nivel_forma', 'Nivel de Formación', '_'+forma , 'chosen_select', 'true') 
            createSelect('#forma_div_'+forma, 'inst_forma', 'Institución Educativa', '_'+forma, 'chosen_select', 'true') 
            createSelect('#forma_div_'+forma, 'prog_forma', 'Programa Académico', '_'+forma, 'chosen_select', 'true') 
            createInput('#forma_div_'+forma, 'nivel_otro_forma', 'Nivel de formación Obtenido', '_'+forma, 'text', 'true') 
            createInput('#forma_div_'+forma, 'inst_otro_forma', 'Institución Educativa en que se graduó', '_'+forma, 'text', 'true') 
            createInput('#forma_div_'+forma, 'prog_otro_forma', 'Titulo Obtenido', '_'+forma, 'text', 'true') 
        }else if(tipo=='Pregrado' || tipo=='Posgrado'){
            var nivel = nivelForma('#nivel_forma_'+forma,tipo, forma)
            var inst = instForma('#inst_forma_'+forma, nivel)
            progForma('#prog_forma_'+forma, nivel, inst)
            createInput('#forma_div_'+forma, 'col_forma', 'Institución Educativa en que se graduó', '_'+forma, 'text', 'true') 
            createInput('#forma_div_'+forma, 'nivel_otro_forma', 'Nivel de formación Obtenido', '_'+forma, 'text', 'true') 
            createInput('#forma_div_'+forma, 'inst_otro_forma', 'Institución Educativa en que se graduó', '_'+forma, 'text', 'true') 
            createInput('#forma_div_'+forma, 'prog_otro_forma', 'Titulo Obtenido', '_'+forma, 'text', 'true') 
        }else{
            createSelect('#forma_div_'+forma, 'nivel_forma', 'Nivel de Formación', '_'+forma , 'chosen_select', 'true') 
            createSelect('#forma_div_'+forma, 'inst_forma', 'Institución Educativa', '_'+forma, 'chosen_select', 'true') 
            createSelect('#forma_div_'+forma, 'prog_forma', 'Programa Académico', '_'+forma, 'chosen_select', 'true') 
            createInput('#forma_div_'+forma, 'col_forma', 'Institución Educativa en que se graduó', '_'+forma, 'text', 'true') 
        }
        $('#forma_comp_div_'+forma).append(
            $('<button>',{
                class: 'btn btn-danger fa fa-close'
            }).append(
                $('<a/>',{
                    text: 'Descartar este certificado',
                    id: 'remove_exp_'+forma
                }).click(function(){
                    $('#forma_div_'+forma).remove();
                    $('#forma_comp_div_'+forma).remove();
                    removeForma(forma)
                })
            )
        )
        var comp_lab_exp = $('#comp_lab_forma_'+forma).val() 
        $('#comp_lab_forma_'+forma).empty() 
        var comp_per_exp = $('#comp_per_forma_'+forma).val() 
        $('#comp_per_forma_'+forma).empty() 
        fillComp('#comp_lab_forma_'+forma, '#comp_per_forma_'+forma, comp_lab_exp, comp_per_exp) 
    }) 
}
function sectoresProd(){
    var value = $('sector_empresa').val()
    if(value!='default'){
        $('#sector_empresa').empty()
    }
    $.each(sectores, function(i, item){
        if(value = item){
            $('#sector_empresa').append(
                $('<option/>',{
                    value: item,
                    text: item,
                    selected: 'selected'
                })
            )
        }else{
            $('#sector_empresa').append(
                $('<option/>',{
                    value: item,
                    text: item
                })
            )
        }
    })
}
//miscelaneo para funcion de visible
function setCookie(cname, cvalue, minutes){
    const d = new Date()
    d.setTime(d.getTime() + (minutes * 60 * 1000))
    let expires = "expires="+d.toUTCString()
    document.cookie = cname + "=" + cvalue
}
//miescelaneo general
function createInput(parent, name, label, id='', hide='false'){
    $(parent).append(
        $('<div/>',{
            id: name+'_div'+id,
            hidden: hidden,
            class: 'caja'
        }).append(
            $('<label/>',{
                for: name+id,
                text: label
            }).append(
                $('<input/>',{
                    id: name+id,
                    name: name+id,
                    type: 'text'
                })
            )
        ),
    )
}
function createSelect(parent, name, label, id='', clas='', hide){
    if(hide=='true') {
        $(parent).append(
            $('<div/>',{
                id: name+'_div'+id,
                hidden: hide
            }).append(
                $('<label/>',{
                    for: name+id,
                    text: label
                }).append(
                    $('<select/>',{
                        id: name+id,
                        name: name+id,
                        class: clas
                    })
                )
            )
        )
    }else{
        $(parent).append(
            $('<div/>',{
                id: name+'_div'+id
            }).append(
                $('<label/>',{
                    for: name+id,
                    text: label
                }).append(
                    $('<select/>',{
                        id: name+id,
                        name: name+id,
                        class: clas
                    })
                )
            )
        )
    }
}
function fillSelect1(arr, index, text, value, sel_value=null, exclude){
    $(index).append(
        $('<option/>',{
            value: 'default',
            disabled: 'true',
            selected: 'selected'
        })
    )
    $.each(arr, function(i, item){
        if(sel_value!=null && sel_value.includes(item[value])){
            $(index).append(
                $('<option/>',{
                    text: item[text],
                    value: item[value],
                    selected: 'selected'
                })
            )
        }else if(exclude==null || !exclude.includes(item[value])){
            $(index).append(
                $('<option/>',{
                    text: item[text],
                    value: item[value]
                })
            )
        }
    })
}
function fillSelect(arr, name){
    $(name).append(
        $('<option/>',{
            value: 'default',
            disabled: 'true',
            selected: 'selected'
        })
    )
    $.each(arr, function(i, item){
        $(name).append(
            $('<option/>',{
                text: item,
                value: item
            })
        )
    })
}
function createSelect(parent, name, label, id='', clas='', hide){
    if(hide=='true') {
        $(parent).append(
            $('<div/>',{
                id: name+'_div'+id,
            }).append(
                $('<label/>',{
                    for: name+id,
                    text: label
                }).append(
                    $('<select/>',{
                        id: name+id,
                        name: name+id,
                        class: clas
                    })
                )
            )
        )
        $('#'+name+'_div'+id).hide()
    }else{
        $(parent).append(
            $('<div/>',{
                id: name+'_div'+id
            }).append(
                $('<label/>',{
                    for: name+id,
                    text: label
                }).append(
                    $('<select/>',{
                        id: name+id,
                        name: name+id,
                        class: clas
                    })
                )
            )
        )
    }
}
function createInput(parent, name, label, id='',typo='text', hide){
    if(hide=='true'){
        $(parent).append(
            $('<div/>',{
                id: name+'_div'+id,
            }).append(
                $('<label/>',{
                    for: name+id,
                    text: label
                }).append(
                    $('<input/>',{
                        id: name+id,
                        name: name+id,
                        type: typo
                    })
                )
            ),
        )
        $('#'+name+'_div'+id).hide()
    }else{
        $(parent).append(
            $('<div/>',{
                id: name+'_div'+id
            }).append(
                $('<label/>',{
                    for: name+id,
                    text: label
                }).append(
                    $('<input/>',{
                        id: name+id,
                        name: name+id,
                        type: typo
                    })
                )
            ),
        )
    }
}
/*==============================
    Añadiendo pestañas 
===============================*/
li.forEach( ( cadaLi , i )=>{
    li[i].addEventListener('click',()=>{

        li.forEach( ( cadaLi , i )=>{
            li[i].classList.remove('activo')
            bloque[i].classList.remove('activo')
        })
        li[i].classList.add('activo')
        bloque[i].classList.add('activo')

    })
})