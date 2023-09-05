
$(document).ready(function(){
  tipo = $('#tipo_previo').val()
  if(tipo!=undefined && tipo=='empresa'){
    $('#slideBox').animate({
      'marginLeft' : '0'
    });
    $('.topLayer').animate({
      'marginLeft' : '100%'
    });
  }else if(tipo!=undefined && tipo=='aplicante'){
    $('#slideBox').animate({
      'marginLeft' : '50%'
    });
    $('.topLayer').animate({
      'marginLeft': '0'
    });
  }
  $('#goRight').on('click', function(){
    $('#slideBox').animate({
      'marginLeft' : '0'
    });
    $('.topLayer').animate({
      'marginLeft' : '100%'
    });
  });
  $('#goLeft').on('click', function(){
    $('#slideBox').animate({
      'marginLeft' : '50%'
    });
    $('.topLayer').animate({
      'marginLeft': '0'
    });
  });

  $.validator.addMethod("password", function(value, element) {
    // The password must contain at least one uppercase letter, one special character, one number, and be at least 8 characters long
    return this.optional(element) || /^(?=.*[A-Z])(?=.*\d)(?=.*\W)[a-zA-Z0-9\S]{8,}$/.test(value);
  }, "Su contrasña debe terner al menos 8 caracteres, un número, una letra en mayúscula y un símbolo");
$("form").validate({
    rules:{
        "email":{
            email: true
        },
        "password":{
            password: true
        }
    },messages: {
        'email': {
            email: "Introduzca una dirección de correo valida"
        }
    },
    submitHandler: function(form) {
        form.submit();
    }, lang: 'es'
});
}); 


$('a').click(function(){
  var id = $(this).attr('id')
  console.log(id)
  if(id=='candidato'){
      window.location = 'login.php?tipo=aplicante'
  }else{
      window.location = 'login.php?tipo=empresa'
  }
})