var uri = 'https://get.serenaccion.com.co/serenacc_dictionaries/'
let sexo = [
    {value:'default', label:'Selecciona Una Opción'},
    {value:'M', label:'Masculino'},
    {value:'F', label:'Femenino'},
    {value:'O', label:'Otro'}
]
let niveles_idioma = [
    {value: 'default', label:'Selecciona una Opción'},
    {value: 1, label: 'Bajo'},
    {value: 2, label: 'Intermedio'},
    {value: 3, label: 'Alto'},
    {value: 4, label: 'Nativo'}
]
let sino = [
    {value: 'no', label: 'No'},
    {value: 'si', label: 'Si'}
]
niveles_form = ['Primaria','Bachillerato','Pregrado','Posgrado', 'Otro']
let habilidad_idioma = ['hablado', 'escrito','leido']
let idiomas_sel = []
let idiomas_arr = []
let exp_q = 0
let forma_q = 0
let comp_lab = $('#comp_lab').val() 
let comp_per = $('#comp_per').val() 
let val_tipo = ''
$(document).ready(function(){

    $.validator.addMethod("pastDate", function(value, element) {
        // Get the current date
        var today = new Date();
      
        // Convert the input value to a date object
        var inputDate = new Date(value);
      
        // Check if the input date is in the past or present
        return inputDate <= today;
      }, "Ingrese una fecha valida");
      
      // Add a custom rule for the mm/yyyy format
      $.validator.addMethod("mmYyyy", function(value, element) {
        return this.optional(element) || /^\d{2}\/\d{4}$/.test(value);
      }, "Ingrese una fecha valida en el formato mm/AAAA");
      
      // Set the rules for the date input
      $("form").validate({
        rules:{
            'input [type="month"]':{
                mmYYYY: true,
                pastDate: true
            }
        }
      })

    $(".chosen_select").chosen({search_contains: true, width: '100%'})
    fillSelect('sex', sexo, ['value', 'label'])
    $('#sex option[value="default"]').prop('disabled', true);
    var promise1 = $.get(uri+'idiomas', function(data, status){
        data = JSON.parse(data)
        console.log(data)
        idiomas_arr = data['results']
        selected = $('#idiomas_select').val()
        if(selected){
            $.each(selected, function(i, item){
                idioma = idiomas_arr.find(obj => obj.id === item)
                $('#label_div_idioma_'+item).text(idioma['idioma'])
            })
        }
        fillSelect('idiomas_select', idiomas_arr, ['id', 'idioma'])
    })
    let idiomas_q = $('#idiomas_q').val()
    if(idiomas_q!=null){
        idiomas_sel = $('#idiomas_select').val()
        nivelIdioma(idiomas_sel)
    }
    var promise2 = $.get(uri+'municipios', function(data, status){
        console.log(data)
        data = JSON.parse(data)
        data = data['results']
        fillSelect('ciudad_select', data, ['id', 'municipio', 'departamento'])
    })
    fillSelect('traslado', sino, ['value', 'label'])
    fillSelect('viajar', sino, ['value', 'label'])
    var exps = $('#exps_arr').val().split(',') 
    if(exps!=''){
        fillExps(exps) 
        exp_q = parseInt(exps[exps.length-1]) +1 
    }
    var promise3 = $.get(uri+"programas", function(data, status){
        console.log(data)
        data = JSON.parse(data) 
        programas_arr = data['results'] 
    }) 
    var formas = $('#formas_arr').val().split(',') 
    if(formas!=''){
        fillFormas(formas)
        forma_q = parseInt(formas[formas.length-1]) +1 
    }
    $.when(promise1, promise2, promise3).then(function(){
        $('#loader').fadeOut(1000)
        $('.container').fadeIn(1000)
    })
    $('a').click(function(){
        var id = $(this).attr('id')
        if(id==undefined){
            return
        }else if(id.includes('add_exp')){
            escribir_exp(exp_q) 
        }else if(id.includes('remove_exp')){
            id = id.split('_')[2] 
            $('#exp_'+id).remove() 
            removeExp(id) 
        }else if(id.includes('add_forma')){
            escribir_formacion(forma_q)
        }else if(id.includes('remove_forma')){
            id = id.split('_')[2] 
            removeForma(id)
            $('#forma_div_'+id).remove() 
        }else if(id == 'cancel'){
            window.location='perfil.php'
        }else if(id.includes('edit_file_exp')){
            id = id.split('_')[3]
            editExpFile(id)
        }else if(id.includes('edit_file_forma')){
            id = id.split('_')[3]
            editFormaFile(id)
        }
    })
})
$('select').change(function(){
    var id = $(this).attr('id')
    selectChange(id)
})
function selectChange(id){
    if(id==undefined){
        return
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
    }else if(id.includes('tipo_forma')){
        id = id.split('_')[2] 
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
            nivelForma('#nivel_forma_'+id, val_tipo, id)
            var niveles = [] 
            $.each(programas_arr, function(i, item){
                if(item['nivel'] == val_tipo){
                    niveles.push({"value":item['formacion']}) 
                }
            })
            niveles = [...new Set(niveles)] 
            fillSelect('nivel_forma_'+id, niveles,['value']) 
            $('#nivel_forma_'+id).trigger("chosen:updated") 
        }else if(val_tipo=='Otro'){
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
    }
}

function editExpFile(id){
    if(confirm('Seguro que deseas cambiar el archivo? esto es irreversible')){
        $("#cert_file_exp_div_"+id).remove()
        $('#edit_file_exp_'+id).remove()
        createFileInput('#exp_'+id, 'cert_file_exp', 'Archivo de la certificación:  ', '_'+id) 
    }
}

function editFormaFile(id){
    if(confirm('Seguro que deseas cambiar el archivo? esto es irreversible')){
        $("#cert_file_forma_div_"+id).remove()
        $('#edit_file_forma_'+id).remove()
        createFileInput('#forma_comp_div_'+id, 'cert_file_forma', 'Archivo de la certificación: ', '_'+id)
    }
}

function AlertaGuardado(){
    swal('', 'Su informacion se guardó exitosamente', 'success');
}
