var uri = 'https://get.serenaccion.com.co/serenacc_dictionaries/' 
const li = document.querySelectorAll('.li')
const bloque = document.querySelectorAll('.bloque')
let liIndex = 0
$('.chosen_select').chosen({width: '100%'}) 
let niveles_idioma = [
    {value: 'default', label:'Selecciona una Opción'},
    {value: 1, label: 'Bajo'},
    {value: 2, label: 'Intermedio'},
    {value: 3, label: 'Alto'},
    {value: 4, label: 'Nativo'}
]
let habilidad_idioma = ['hablado', 'escrito','leido']
sino = ['SI', 'NO']
var cert_q
var idiomas_sel = [] 
var idiomas_arr 
var cargos_arr
var cargos= [] 
var sel=[] 
var otros_cargos
var gran_grupo
var comp_lab_count
var comp_per_count
var comp_lab
$(document).ready(function(){
    cert_q = $('#cert_q').val()
    if(cert_q==undefined){
        cert_q=0
    }else{
        cert_q = +$('#cert_q').val()+1
    }
    otros_cargos = 0 
    gran_grupo = true
    comp_lab_count = 0
    comp_per_count = 0
    /*================================================================
                    Inicializar menus
    ================================================================*/
    var promise1 = $.get(uri+'cargos', function(data, status){
        data = JSON.parse(data)
        cargos_arr = data['results']
        fillCargos(cargos_arr)
    })
    var promise2 = $.get(uri+'gran_grupo', function(data, status){
        data = JSON.parse(data)
        data = data['results']
        fillSelect('gran_grupo', data, ['id_gran_grupo', 'nombre_gran_grupo'])
    })
    var promise3 = $.get(uri+'descript_comp_l', function(data, status){
        data = JSON.parse(data)
        comp_lab_arr = data['results']
        cargos=$('#rel_cargos').val()
        if(cargos!=null){
            cargos.push($('#cargos').val())
        }else{
            cargos=[$('#cargos').val()]
        }
        if(cargos!=null){
            fillSelectWithData(comp_lab_arr, ['id_comp_l', 'descript'], 'comp_lab', 'cod_fam_group', cargos, true)
        }
    })
    var promise4 = $.get(uri+'descript_comp_p', function(data, status){
        data = JSON.parse(data)
        data = data['results']
        fillSelectWithData(data, ['id', 'comp', 'descript'], 'comp_per')
    })
    var promise5 = $.get(uri+'municipios', function(data, status){
        data = JSON.parse(data)
        data = data['results']
        fillSelect('ciudad_select', data, ['id', 'municipio', 'departamento'])
    })
    var promise6 = $.get(uri+'idiomas', function(data, status){
        data = JSON.parse(data)
        idiomas_arr = data['results']
        selected = $('#idiomas_select').val()
        $.each(selected, function(i, item){
            idioma = idiomas_arr.find(obj => obj.id === item)
            $('#label_div_idioma_'+item).text(idioma['idioma'])
        })
        fillSelect('idiomas_select', idiomas_arr, ['id', 'idioma'])
    })
    var promise7 = $.get(uri+'carac_organ', function(data, status){
        data = JSON.parse(data)
        carac_arr = data['results']
        caracOrgan(carac_arr)
    })
    $.when(promise1,promise2,promise3,promise4,promise5,promise6,promise7).then(function(){
        $('#loader').fadeOut(1000)
        $('.container').fadeIn(1000)
    })
    siNoF()
    let idiomas_q = $('#idiomas_q').val()
    if(idiomas_q!=null){
        idiomas_sel = $('#idiomas_select').val()
        nivelIdioma(idiomas_sel)
    } 
})

$('select').change(function(){
    var id = $(this).attr('id') 
    if(id==undefined){
        return
    }else if(id=='cargos'){
        fillSelectClass('rel_cargos', cargos_arr, ['id_cargo', 'nombre_cargo'], 'gran_grupo', $('#cargos').val())
        cargos=$('#rel_cargos').val()
        if(cargos!=null){
            cargos.push($('#cargos').val())
        }else{
            cargos=[$('#cargos').val()]
        }
        fillSelectWithData(comp_lab_arr, ['id_comp_l', 'descript'], 'comp_lab', 'cod_fam_group', cargos, true)
        var val = $('#cargos :selected').attr('class')
        if(gran_grupo){
            $('#gran_grupo').chosen("destroy").val(val).chosen({width: '100%'}) 
        }if(val=='11'){
            addOtroCargo()
        }else{
            $('#otro_cargo_div').remove()
        }
    }else if(id=='rel_cargos'){
        cargos=$('#rel_cargos').val()
        if($('#cargos').val()!=null){
            cargos.push($('#cargos').val())
        }
        fillSelectWithData(comp_lab_arr, ['id_comp_l','descript'], 'comp_lab', 'cod_fam_group', cargos, true)
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
    }else if(id == 'gran_grupo'){
        if($('#gran_grupo').val()=='11'){
            addOtroGrupo()
            gran_grupo = false
        }else{
            $('#otro_grupo_div').remove()
            gran_grupo =true
        }
    }
})
$('a').click(function(){
    var id = $(this).attr('id') 
    if(id==undefined){
        return;
    }else if(id.includes('add_cert_btn')){
        escribirCert(cert_q) 
        cert_q += 1 
    }else if(id == 'add_otra_comp_lab'){
        addOtraCompLab(comp_lab_count)
        comp_lab_count += 1
    }else if(id == 'add_otra_comp_per'){
        addOtraCompPer(comp_per_count)
        comp_per_count += 1
    }else if(id.includes('right')){
        liIndex+=1
        li[liIndex].click()
    }else if(id.includes('left')){
        liIndex-=1
        li[liIndex].click()
    }else if(id.includes('remove_cert')){
        id= id.split('_')[2]
        console.log(id)
        $('#cert_div_'+id).remove()
        var val =  $('#cert_arr').val().split(',') 
        const index = val.indexOf(id+'') 
        if (index > -1) { // only splice array when item is found
            val.splice(index, 1)  // 2nd parameter means remove one item only
        }
        val = val.join(',')
        $('#cert_arr').attr('value', val) 
    }else if(id == 'submit'){
        $('#vacante_comp').val('true')
        $("#box").submit();
    }
})
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