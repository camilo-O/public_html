var uri = 'https://get.serenaccion.com.co/serenacc_dictionaries/';
var cargos_arr
$(document).ready(function(){
    var ids_vacs = $('#ids_vacs').val()
    var ids_vacs_closed = $('#ids_vacs_closed').val()
    $.get(uri+'cargos', function(data, status1){
        data = JSON.parse(data);
        cargos_arr = data['results'];
        
    }).then(function(){
        if(ids_vacs!=undefined){
            ids_vacs = ids_vacs.split(',')
            ids_vacs.forEach(element => {
                var cargo = $('#cargo_'+element).text()
                cargo = cargo.split(',')[0]
                console.log(cargo)
                cargo = cargos_arr.find(obj => obj.id_cargo == cargo)['nombre_cargo'];
                console.log(cargo)
                $('#cargo_'+element).text(cargo);
            });
        }
        if(ids_vacs_closed!=undefined){
            ids_vacs_closed = ids_vacs_closed.split(',')
            ids_vacs_closed.forEach(element =>{
                var cargo = $('#cargo_'+element).text()
                cargo = cargos_arr.find(obj => obj.id_cargo == cargo)['nombre_cargo'];
                $('#cargo_'+element).text(cargo);
            })
        }
    })
})
$('a').click(function(){
    var select_id = $(this).attr('id')
    if(select_id.includes('ventana')){
        select_id = select_id.split('_')
        var url =  'matriz.php?id='+select_id[1]
    }else if(select_id == 'postular_vacante'){
        alert('Esta Funciòn aún no ha sido habilitada.\nEspera informaciòn sobre el lanzamiento.')
        window.reload(true)
    }else{
        return
    }
    window.open(url, "_blank", "toolbar=1, scrollbars=1, resizable=1, width=" + 1200 + ", height=" + 800);
})