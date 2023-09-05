var uri = 'https://get.serenaccion.com.co/serenacc_dictionaries/'
const li = document.querySelectorAll('.li')
const bloque = document.querySelectorAll('.bloque')
var optionsCompLab = []
var liIndex = 0
var comp_lab_count = 0
var comp_per_count = 0

$(document).ready(function(){
    $(".chosen_select").chosen({search_contains: 'true', width: '100%'})
    var promise1 = $.get(uri+'cargos', function(data, status){
        data = JSON.parse(data)
        data = data['results']
        fillSelect('cargos', data, ['id_cargo', 'nombre_cargo'])
        console.log('cargos')
    })
    var promise2 = $.get(uri+'descript_comp_l', function(data, status){
        data = JSON.parse(data)
        optionsCompLab = data['results']
        fillSelect('comp_lab', optionsCompLab, ['id_comp_l', 'descript'], filter=true, ['cargos', 'cod_fam_group'])
        console.log('comp l')
    })
    var promise3 = $.get(uri+'descript_comp_p', function(data, status){
        data = JSON.parse(data)
        data = data['results']
        fillSelect('comp_per', data, ['id','comp', 'descript'])
        console.log('comp_p')
    })
    var promise4 = $.get(uri+'carac_organ', function(data, status){
        data = JSON.parse(data)
        data = data['results']
        keys = Object.keys(data[0])
        for(i=1; i<keys.length; i+=2){
            fillSelect(keys[i], data, ['id', keys[i], keys[i+1]])
        }
        console.log('carac')
    })
    $.when(promise1,promise2,promise3,promise4).then(function(){
        $('#loader').fadeOut(500)
        $('.container').fadeIn(500)
    })
    $('select').change(function(){
        var id = $(this).attr('id')
        if(id=='undefined') {
            return;
        }else if(id=='cargos'){
            fillSelect('comp_lab', optionsCompLab, ['id_comp_l', 'descript'], filter=true, ['cargos', 'cod_fam_group'])
        }
    })
    $('a').click(function(){
        var id = $(this).attr('id')
        if(id==undefined){
            return
        }else if(id=='right'){
            liIndex+=1
            li[liIndex].click()
        }else if(id=='left'){
            liIndex-=1
            li[liIndex].click()
        }else if(id == 'add_otra_comp_lab'){
            addOtraCompLab(comp_lab_count)
            comp_lab_count += 1
        }else if(id == 'add_otra_comp_per'){
            addOtraCompPer(comp_per_count)
            comp_per_count += 1
        }else if(id == 'cancel'){
            window.location='perfil.php'
        }
    })
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
})