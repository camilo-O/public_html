//Funciones para manejo de elementos del dom
function transformArray(originalArray, keysArray) {
    let formattedArray = [];
    for (let i = 0; i < originalArray.length; i++) {
        let originalElement = originalArray[i];
        let formattedElement
        if(originalElement[keysArray[1]]!=null){
            if(keysArray.length==2){
                formattedElement = {
                    value: originalElement[keysArray[0]],
                    label: originalElement[keysArray[1]],
                    selected: false
                };  
            }else{
                formattedElement = {
                    value: originalElement[keysArray[0]],
                    label: originalElement[keysArray[1]]+': '+originalElement[keysArray[2]],
                    selected: false
                };  
            }
                formattedArray.push(formattedElement);
        }
    }
    return formattedArray;
}
function setSelectedOptions(valuesArray, optionsArray) {
    for (let i = 0; i < optionsArray.length; i++) {
      let option = optionsArray[i];
      let selected = false;
      if(valuesArray){
        selected = valuesArray.includes(option.value);
      }
      option.selected = selected;
    }
    return optionsArray;
}
function setSelectedOptionsChosen(optionsArray, selectElement) {
    let selectedValues = $('#'+selectElement).val();
    let selectedOptions = setSelectedOptions(selectedValues, optionsArray);
    $('#'+selectElement).empty();
    for (let i = 0; i < selectedOptions.length; i++) {
        let option = selectedOptions[i];
        let newOption = $("<option>", {
            value: option.value,
            text: option.label,
            selected: option.selected
        });
        $('#'+selectElement).append(newOption);
    }
    $('#'+selectElement).trigger("chosen:updated");
}
function filterArray(selectId, array, key) {
    let selectedValues = $(`#${selectId} option:selected`).map(function() {
      return this.value;
    }).get();
    
    return array.filter(function(item) {
      return selectedValues.includes(item[key]);
    });
}
function fillSelect(selectElement, options, keys, filter=false, filterArr=[]){
    if(filter){
        options = filterArray(filterArr[0], options, filterArr[1] )
    }
    options = transformArray(options, keys)
    setSelectedOptionsChosen(options, selectElement)
}
function fillSelect2(arr, name){
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
function createMonthInput(parent, name, label, id=''){
    $(parent).append(
        $('<div/>',{
            id: name+'_div'+id
        }).append(
            $('<label/>',{
                for: name+id,
                text: label
            }),
            $('<input/>',{
                id: name+id,
                name: name+id,
                type: 'month',
                class: 'monthInput'
            })
        ),
    )
}
function createFileInput(parent, name, label, id=''){
    $(parent).append(
        $('<div/>',{
            id: name+'_div'+id
        }).append(
            $('<label/>',{
                for: name+id,
                text: label
            }),
            $('<input/>',{
                id: name+id,
                name: name+id,
                type: 'file',
                accept: 'application/pdf'
            })
        ),
    )
}
function createInput(parent, name, label, id='',typo, hide){
    $(parent).append(
        $('<div/>',{
            id: name+'_div'+id
        }).append(
            $('<label/>',{
                for: name+id,
                text: label
            }),
            $('<input/>',{
                id: name+id,
                name: name+id
            })
        ),
    )
    if(hide){
        $('#'+name+'_div'+id).hide()
    }
    if(typo){
        $('#'+name+'_div'+id).prop('type', typo)
    }
}
function createMultipleSelect(parent, name, label, id='', clas='', hide=false){
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
                    multiple: 'multiple'
                })
            )
        )
    )
    if(hide){
        $('#'+name+'_div'+id).prop('hidden', true)
    }
}
function createSelect(parent, name, label, id='', clas='', hide){
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
    if(hide){
        $('#'+name+'_div'+id).hide()
    }
}
function fillSelectWithData(data, keyArray, selectName, filterKey, filterValues, applyFilter = false) {
    let $select = $('#' + selectName);
  
    let selectedValues = [];
    if ($select.prop('multiple')) {
      selectedValues = $select.val();
    } else {
      selectedValues = [$select.val()];
    }

    $select.empty();
  
    let defaultOption = $('<option>', {
      text: 'Selecciona una Opción',
      value: '',
      disabled: true
    });
    $select.append(defaultOption);
  
    let optionsToAppend = data;
    if (applyFilter && filterValues.length > 0) {
      optionsToAppend = data.filter(element => filterValues.includes(element[filterKey]));
    }
    optionsToAppend.forEach(element => {
      let value, text;
      if (keyArray.length === 2) {
        value = element[keyArray[0]];
        text = element[keyArray[1]];
      } else if (keyArray.length === 3) {
        value = element[keyArray[0]];
        text = element[keyArray[1]] + ": " + element[keyArray[2]];
      }
      let option = $('<option>', {
        value: value,
        text: text
      });
      if (selectedValues && selectedValues.includes(value)) {
        option.prop('selected', true);
      }
      $select.append(option);
    });
    $select.trigger("chosen:updated");
}
function fillSelectExclude(options, keys, selectId, excludeKey, excludeValues) {
    let $select = $("#" + selectId);
    var selected = $select.val();
  
    $select.empty();
  
    for (let i = 0; i < options.length; i++) {
      let option = options[i];
      let exclude = false;
  
      let labelKeys = keys.slice(1);
      let label = labelKeys.map(function(key) {
        return option[key];
      }).join(": ");
  
      if (excludeKey && excludeValues.includes(option[excludeKey])) {
        exclude = true;
      }
  
      if (!exclude) {
        let $option = $("<option>").val(option[keys[0]]).text(label);
        $select.append($option);
      }
    }
  
    $select.val(selected);
    $select.trigger("chosen:updated");
}
function fillSelectClass(id, options, keys, classKey, exclude) {
    let select = $("#" + id);
    var selected = select.val();

    select.empty();
    for (let option of options) {
      let optionElement = document.createElement("option");
      let label = "";
      for (let key of keys) {
        if (keys.length === 3 && key === keys[keys.length - 2]) {
          label += option[key] + " ";
        } else if (keys.length === 3 && key === keys[keys.length - 1]) {
          label += option[key];
        } else {
          label = option[key];
        }
      }
      if (exclude && exclude.includes(option[keys[0]])) {
        continue;
      }
      optionElement.value = option[keys[0]];
      optionElement.innerHTML = label;
      if (classKey && option[classKey]) {
        optionElement.classList.add(option[classKey]);
      }
      select.append(optionElement);
    }
    select.val(selected)
    select.trigger("chosen:updated");
}

//Funciones de formulario de perfil de aplicante

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
            class: 'btn btn-danger fa fa-close',
            type: 'button'
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

//funciones de formulario de hvc


function nivelIdioma(selectedValues){
    $.each(selectedValues, function(i,item){
        $.each(habilidad_idioma,function(it, items){
            let val = $('#nivel_'+items+'_'+item).val()
            $('#nivel_'+items+'_'+item).empty()
            $.each(niveles_idioma, function(ni, nivel){
                $('#nivel_'+items+'_'+item).append(
                    $('<option>',{
                        value: nivel.value,
                        text: nivel.label
                    })
                )
            })
            $('#nivel_'+items+'_'+item).val(val)
            $('#nivel_'+items+'_'+item+' option[value="default"]').prop('disabled',true)
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
function escribir_exp(id){
    //creando formularios
    $('#experiencias').append(
        $('<div/>',{
            id: "exp_"+id
        })
    ) 
    createInput('#exp_'+id, 'nombre_cargo', 'Posición ocupada:  ', '_'+id,) 
    createInput('#exp_'+id, 'nombre_empresa', 'Empresa:  ', '_'+id,) 
    createMonthInput('#exp_'+id, 'fecha_inicio', 'Fecha de Inicio:  ', '_'+id) 
    $('#fecha_inicio'+id).rules('add', {
        maxDate: new Date(),
        messages: {
          maxDate: 'Please select a past date or today\'s date.'
        }
      });
    createMonthInput('#exp_'+id, 'fecha_salida', 'Fecha de Salida:  ', '_'+id) 
    createMultipleSelect('#exp_'+id, 'comp_lab_exp', 'Competencias laborales desarrolladas en este cargo:  ', '_'+id, 'chosen_select') 
    $('#comp_lab_exp_'+id).prop('required', false)
    createMultipleSelect('#exp_'+id, 'comp_per_exp', 'Competencias personales desarrolladas en este cargo:  ','_'+id, 'chosen_select') 
    $('#comp_per_exp_'+id).prop('required', false)
    createFileInput('#exp_'+id, 'cert_file_exp', 'Archivo de la certificación:  ', '_'+id) 
    $('#cert_file_'+id).attr('accept','application/pdf')
    fillComp('#comp_lab_exp_'+id, '#comp_per_exp_'+id)
    $('#exp_'+id).append(
        $('<span/>',{
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
function removeExp(id){
    if($('#exps_arr').val().includes(id)){
        var val =  $('#exps_arr').val().split(',') 
        const index = val.indexOf(''+id) 
        if (index > -1) { // only splice array when item is found
          val.splice(index, 1)  // 2nd parameter means remove one item only
        }
        $('#exps_arr').attr('value',val.join(',')) 
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
            if(comp_lab && comp_lab.includes(item['id_comp_l'])){
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
            if(comp_per && comp_per.includes(item['id'])){
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
    createSelect('#forma_div_'+id, 'tipo_forma', 'Tipo de Formación: ', '_'+id, null,false) 
    createSelect('#forma_div_'+id, 'nivel_forma', 'Nivel de Formación: ', '_'+id , 'chosen_select', true) 
    createSelect('#forma_div_'+id, 'inst_forma', 'Institución Educativa: ', '_'+id, 'chosen_select') 
    $('#inst_forma_div_'+id).hide()
    createSelect('#forma_div_'+id, 'prog_forma', 'Programa Académico: ', '_'+id, 'chosen_select', true) 
    createInput('#forma_div_'+id, 'col_forma', 'Institución Educativa en que se graduó: ', '_'+id, 'text', true) 
    createInput('#forma_div_'+id, 'nivel_otro_forma', 'Nivel de formación Obtenido: ', '_'+id, 'text', true) 
    createInput('#forma_div_'+id, 'inst_otro_forma', 'Institución Educativa en que se graduó: ', '_'+id, 'text', true) 
    createInput('#forma_div_'+id, 'prog_otro_forma', 'Titulo Obtenido: ', '_'+id, 'text', true) 
    createMultipleSelect('#forma_comp_div_'+id, 'comp_lab_forma', 'Competencias laborales desarrolladas en esta intitución: ', '_'+id, 'chosen_select') 
    createMultipleSelect('#forma_comp_div_'+id, 'comp_per_forma', 'Competencias personales desarrolladas en esta institución: ','_'+id, 'chosen_select') 
    createFileInput('#forma_comp_div_'+id, 'cert_file_forma', 'Archivo de la certificación: ', '_'+id)
    fillComp('#comp_lab_forma_'+id, '#comp_per_forma_'+id)
    $('#forma_comp_div_'+id).append(
        $('<span/>',{
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
    fillSelect2(tipo, '#tipo_forma_'+id) 
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
            fillSelect2(niveles, '#nivel_forma_'+id) 
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
        console.log(id)
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
        fillSelect2(instituciones, '#inst_forma_'+id) 
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
                disabled: true
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
function removeForma(id){
    if($('#formas_arr').val().includes(id)){
        var val =  $('#formas_arr').val().split(',') 
        const index = val.indexOf(''+id) 
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
            createSelect('#forma_div_'+forma, 'nivel_forma', 'Nivel de Formación', '_'+forma , 'chosen_select', true)
            createSelect('#forma_div_'+forma, 'inst_forma', 'Institución Educativa', '_'+forma, 'chosen_select', true) 
            createSelect('#forma_div_'+forma, 'prog_forma', 'Programa Académico', '_'+forma, 'chosen_select', true) 
            createInput('#forma_div_'+forma, 'nivel_otro_forma', 'Nivel de formación Obtenido', '_'+forma, 'text', true) 
            createInput('#forma_div_'+forma, 'inst_otro_forma', 'Institución Educativa en que se graduó', '_'+forma, 'text', true) 
            createInput('#forma_div_'+forma, 'prog_otro_forma', 'Titulo Obtenido', '_'+forma, 'text', true) 
        }else if(tipo=='Pregrado' || tipo=='Posgrado'){
            var nivel = nivelForma('#nivel_forma_'+forma,tipo, forma)
            var inst = instForma('#inst_forma_'+forma, nivel)
            progForma('#prog_forma_'+forma, nivel, inst)
            createInput('#forma_div_'+forma, 'col_forma', 'Institución Educativa en que se graduó', '_'+forma, 'text', true) 
            createInput('#forma_div_'+forma, 'nivel_otro_forma', 'Nivel de formación Obtenido', '_'+forma, 'text', true) 
            createInput('#forma_div_'+forma, 'inst_otro_forma', 'Institución Educativa en que se graduó', '_'+forma, 'text', true) 
            createInput('#forma_div_'+forma, 'prog_otro_forma', 'Titulo Obtenido', '_'+forma, 'text', true) 
        }else{
            createSelect('#forma_div_'+forma, 'nivel_forma', 'Nivel de Formación', '_'+forma , 'chosen_select', true) 
            createSelect('#forma_div_'+forma, 'inst_forma', 'Institución Educativa', '_'+forma, 'chosen_select', true) 
            createSelect('#forma_div_'+forma, 'prog_forma', 'Programa Académico', '_'+forma, 'chosen_select', true) 
            createInput('#forma_div_'+forma, 'col_forma', 'Institución Educativa en que se graduó', '_'+forma, 'text', true) 
        }
        $('#forma_comp_div_'+forma).append(
            $('<span>',{
                class: 'btn btn-danger fa fa-close'
            }).append(
                $('<a/>',{
                    text: 'Descartar este certificado',
                    id: 'remove_forma_'+forma
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
         
        var tipo=  [ 'Primaria', 'Bachillerato', 'Pregrado', 'Posgrado', 'Otro' ] 
        //fillSelect2(tipo, '#tipo_forma_'+forma) 
        var val_tipo 
        $('#tipo_forma_'+forma).change(function(){
            val_tipo = $('#tipo_forma_'+forma).val() 
            if(val_tipo == 'Primaria' || val_tipo == 'Bachillerato'){
                $('#col_forma_div_'+forma).show()
                $('#nivel_forma_div_'+forma).hide() 
                $('#inst_forma_div_'+forma).hide() 
                $('#prog_forma_div_'+forma).hide() 
                $('#nivel_otro_forma_div_'+forma).hide()
                $('#inst_otro_forma_div_'+forma).hide()
                $('#prog_otro_forma_div_'+forma).hide()
            }else if(val_tipo == 'Pregrado' || val_tipo == 'Posgrado'){
                $('#col_forma_div_'+forma).hide()
                $('#nivel_forma_div_'+forma).show() 
                $('#nivel_otro_forma_div_'+forma).hide()
                $('#inst_otro_forma_div_'+forma).hide()
                $('#prog_otro_forma_div_'+forma).hide()
                $('#nivel_forma_'+forma).empty() 
                var niveles = [] 
                $.each(programas_arr, function(i, item){
                    if(item['nivel'] == val_tipo){
                        niveles.push(item['formacion']) 
                    }
                })
                niveles = [...new Set(niveles)] 
                fillSelect2(niveles, '#nivel_forma_'+forma) 
                $('#nivel_forma_'+forma).trigger("chosen:updated") 
            }else{
                $('#nivel_otro_forma_div_'+forma).show()
                $('#inst_otro_forma_div_'+forma).show()
                $('#prog_otro_forma_div_'+forma).show()
                $('#col_forma_div_'+forma).hide()
                $('#nivel_forma_div_'+forma).hide() 
                $('#inst_forma_div_'+forma).hide() 
                $('#prog_forma_div_'+forma).hide() 
            }
        })
        var val_nivel 
        $('#nivel_forma_'+forma).change(function(){
            val_nivel = $('#nivel_forma_'+forma).val() 
            $('#inst_forma_'+forma).empty() 
            $('#inst_forma_div_'+forma).show() 
            var instituciones = [] 
            $.each(programas_arr, function(i, item){
                if(item['formacion'] == val_nivel){
                    instituciones.push(item['institucion']) 
                }
            })
            instituciones = [...new Set(instituciones)] 
            fillSelect2(instituciones, '#inst_forma_'+forma) 
            $('#inst_forma_'+forma).trigger("chosen:updated") 
        })
        var val_inst 
        $('#inst_forma_'+forma).change(function(){
            val_inst = $('#inst_forma_'+forma).val() 
            $('#prog_forma_'+forma).empty() 
            $('#prog_forma_div_'+forma).show() 
            var programas = [] 
            $.each(programas_arr, function(i, item){
                if(item['institucion'] == val_inst){
                    programas.push(item['programa']) 
                }
            })
            programas = [...new Set(programas)] 
            $('#prog_forma_'+forma).append(
                $('<option/>',{
                    value: 'default',
                    selected: 'selected',
                    disabled: true
                })
            ) 
            $.each(programas, function(i, item){
                $('#prog_forma_'+forma).append(
                    $('<option/>',{
                        value: item,
                        text: item
                    })
                ) 
            })
            $('#prog_forma_'+forma).trigger("chosen:updated") 
        })
        }) 
}
function tipoForma(index){
    var val_tipo = $(index).val() 
    var niveles_form = ['Primaria','Bachillerato','Pregrado','Posgrado', 'Otro']
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
        console.log(data)
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

//funciones necesitadas para el formulario de vacante


function fillCargos(cargos_arr){
    fillSelectClass('cargos', cargos_arr, ['id_cargo', 'nombre_cargo'], 'gran_grupo', '')
    fillSelectClass('rel_cargos', cargos_arr, ['id_cargo', 'nombre_cargo'], 'gran_grupo', $('#cargos').val())
    cargos=$('#rel_cargos').val()
    if(cargos!=null){
        cargos.push($('#cargos').val())
    }
}
function caracOrgan(carac_arr){
    fillSelect('bene_extr', carac_arr, ['id', 'bene_extr', 'desc_bene_extr'])
    fillSelect('jorn_labo_sema', carac_arr, ['id', 'jorn_labo_sema', 'desc_jorn_labo_sema'])
    fillSelect('jorn_labo_dia', carac_arr, ['id', 'jorn_labo_dia', 'desc_jorn_labo_dia'])
    fillSelect('mode_de_trab', carac_arr, ['id', 'mode_de_trab', 'desc_mode_de_trab'])
}
function escribir_idioma(id){
    //creando formularios
    var numId = parseInt(id)-1 
    var idioma = idiomas_arr[numId]['idioma'] 
    var niveles_text = ['hablado', 'escrito', 'leído'] 
    var niveles = ['hablado', 'escrito', 'leido'] 
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
            })
        ) 
        $('#div_idioma_'+id).append(
            $('<select/>',{
                class: 'cajas',
                name: 'nivel_'+item+'_'+id,
                id: 'nivel_'+item+'_'+id,
                style: 'width: 20%;'
            })
        ) 

        $.each(niveles_idioma, function(j,jtem){
            $('#nivel_'+item+'_'+id).append(
                $('<option/>',{
                    value: jtem.value,
                    text: jtem.label
                })
            ) 
        }) 
    }) 
}
function borrar_idioma(id){
    $('#label_div_idioma_'+id).remove()
    $('#div_idioma_'+id).remove() 
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
        var tarj = $('#tarj_prof').val() 
        if(tarj!=item){
            $('#tarj_prof').append(
                $('<option/>',{
                    value: item,
                    text: item
                })
            )
        }
    })
}
function initCompLab(){
    $('#comp_lab').empty()
    $.each(cargos, function(i, item){
        addCompLab(item)
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
function escribirCert(id){
    createInput('#cert_div', 'cert', 'Descripción del certificado:  ', '_'+id, 'false')
    $('#cert_div_'+id).append(
        $('<a/>',{
            id: 'remove_cert_'+id,
            text: 'Descartar',
            class: 'btn btn-danger alternative'
        }).click( function(){
            $('#cert_div_'+id).remove()
            var val =  $('#cert_arr').val().split(',') 
            const index = val.indexOf(id+'') 
            if (index > -1) { // only splice array when item is found
                val.splice(index, 1)  // 2nd parameter means remove one item only
            }
            val = val.join(',')
            $('#cert_arr').attr('value', val) 
        })
    )
    $('#cert_div_'+id).after('<br>')
    var val = $('#cert_arr').val();
    if(val!=''){
        val+=',' 
    }
    $('#cert_arr').attr('value', val+id) 
}
function addOtroCargo(){
    $('#cargos_div').append(
        $('<div/>',{
            id: 'otro_cargo_div'
        })
    )
    createInput('#otro_cargo_div', 'otro_cargo', 'Relacione el nombre del cargo ofrecido: ', '');
}
function addOtroGrupo(){
    $('#gran_grupo_div').append(
        $('<div/>',{
            id: 'otro_grupo_div'
        })
    )
    createInput('#otro_grupo_div','otro_grupo','Otra Area', '')
}
function addOtraCompLab(id){
    createInput('#otras_comp_lab_div', 'comp_lab', 'Nueva Competencia', '_'+id)
    $('#comp_lab_div_'+id).append(
        $('<a/>',{
            text: 'Descartar'
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
function compPer(){
    $('#comp_per').empty()
    $.get(uri+'descript_comp_p', function(data,status){
        data = JSON.parse(data) 
        data = data['results'] 
        $.each(data, function(i, item){
            if(comp_per.includes(item['id'])){
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
function addOtraCompPer(id){
    createInput('#otras_comp_per_div', 'comp_per', 'Competencia','_'+id)
    createInput('#comp_per_div_'+id, 'descript_comp_per', 'Descripción', '_'+id)
    $('#comp_per_div_'+id).append(
        $('<a/>',{
            text: 'Descartar'
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