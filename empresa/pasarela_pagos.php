<?php
require_once("../models/validator.php");
$validator = new Validator();
$requester = new Requester();
//segun validator pactar un tiempo de caducacion de la sesion
if(isset($_COOKIE['token_empresa']) && isset($_COOKIE['id_empresa'])){
    $perfil = $validator ->validate($_COOKIE['token_empresa'], $_COOKIE['id_empresa'], 'perfil.php');
}else{
    echo'<script>window.location="../login.php";</script>';
}

//validacion de datos para inicio de sesion 
$id = $perfil['id_empresa'];
$nombre = $perfil['nombre_empresa'];
$nit = $perfil['nit_empresa'];
$ciudad = $perfil['ciudad_empresa'];
$sector = $perfil['sector_empresa'];

//Integracion del chekout de mercado pago NO SIRVE
// require __DIR__ . '../../vendor/autoload.php';
// $access_token="TEST-699536358091527-090116-0ec5b8e6ebb4350912e874a455b09147-694919318";
//   MercadoPago\SDK::setAccessToken($access_token);
// $preference=new MercadoPago\Preference();

$preference->back_urls=array(
  "succes"=>"http://localhost/public_html/empresa/pasarela_pagos.php",
  "failure"=>"http://localhost/public_html/empresa/failure.php"
);

//item de prueba para compra de prueba

$plan=[];
$item=new MercadoPago\Item();
$item->title="Plan Mensual Serenaccion";
$item->unit_price=680.800;
array_push($plan, $item);

$preference->items=$plan;
$preference->save();

//query para datos de compra
include ('../conection.php');
$query = "SELECT * FROM planes_de_pago" ;
$result = mysqli_query($conn, $query);

$query = "SELECT codigo_promocional FROM codigos_promocionales";
$resultado = mysqli_query($conn, $query);

if($resultado){
$fila = mysqli_fetch_assoc($resultado);
$codigo_promocional_bd=$fila['codigo_promocional'];
mysqli_free_result($resultado);

$codigo_ingresado = $_POST['codigo'];
}

$resultado_codigo= 680673 - 250000;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Ser en Accion</title>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

</head>
<body>
    <div class="info_inicial">
    <h1>
        Haz parte de uno de nuestros planes y disfruta de todos sus beneficios
    </h1>
    </div>
    <div class="container">
        <div class="item">
        <h4>
        Plan mensual
        </h4>
        </div>
        <div class="item">
        <h4>
        Plan trimestral
        </h4>
        </div>
        <div class="item">
        <h4>
        Plan anual
        </h4>
        </div>
    </div>

    <div class="planes">

        <div class="plan">
        
        <h2>
        Precio sin IVA: $680.800
        </h2>
        <ul class="list-group">
      <li class="list-group-item">Créditos incluidos: 20</li>
      <li class="list-group-item">Opción de adquirir hojas de vida adicionales por $50.000 cada una durante la vigencia del plan.</li>

    </ul>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  consigue el plan
</button>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Resumen de compra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <h2>
          680.673$
        </h2>
        <div class="detalle">
          <!--<img src="../empresa/images/compras.png" alt=""> -->     
          
          <div class="valor-detalle">
                      <h4 class="plan_detalle">
                      Plan mensual Ser en Accion
                      </h4>
                      <h4 class="valor-plan">
                        680.672$
                      </h4>
          </div>
          <hr>
          <div class="subtotal-detalle">
            <h4 class="subtotal">
            subtotal
            </h4>
            <h4 class="valor_subtotal">
            680.673$
            </h4>
          </div>
          <hr>
          <form class="check-codigo" method="POST">
          <label for="codigo">Ingrese el código promocional:</label>
        <input type="text" id="codigo" name="codigo" required>
        <input type="submit" name="submit" value="Verificar">
          </form>
          <div class="IVA-detalle">
            <h4 class="IVA">
              IVA
            </h4>
            <h4 class="IVA_total">
            0$
            </h4>
          </div>
          <hr>
          <div class="total-pago">
            <h4 class="total">
            total a pagar
            </h4>
            <h4 class="total_pagar">
            <?php 
            if ($codigo_ingresado === $codigo_promocional_bd){
              echo "$".$resultado_codigo;
            }else{
              echo "$680.673";
            }
            ?>
            
            </h4>
          </div>
          <hr>
        </div>
        <h1 class="titulo-metodos">
          Seleccionar modo de pago
        </h1>
        <div class="contenedor-btn"></div>
        <script src="https://sdk.mercadopago.com/js/v2"></script>
        <script>
          var public_key='TEST-c684bd0d-d451-454b-afc2-ac755405c5d9';
          const mp = MercadoPago(public_key, {
            locale: 'es-COP'
          })
          const checkout = mp.checkout({
            preference :{
              id: '<?php echo $preference->id;?>'
            }, 
            render: {
            container: 'contenedor-btn',
            label: 'Pagar'
            }
          });
        </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancelar compra</button>
        <button type="submit" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
        </div>
        <div class="plan">
        
        <h2>
        Precio sin IVA: $1.680.673
        </h2>
        <ul class="list-group">
      <li class="list-group-item">Créditos incluidos: 50</li>
      <li class="list-group-item">Opción de adquirir hojas de vida adicionales por $48.000 cada una durante la vigencia del plan.</li>
    </ul>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
  consigue el plan
</button>
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Resumen de compra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <h2>
         $1.680.673
        </h2>
        <div class="detalle">
          <!--<img src="../empresa/images/compras.png" alt=""> -->     
          
          <div class="valor-detalle">
                      <h4 class="plan_detalle">
                      Plan mensual Ser en Accion
                      </h4>
                      <h4 class="valor-plan">
                        680.672$
                      </h4>
          </div>
          <hr>
          <div class="subtotal-detalle">
            <h4 class="subtotal">
            subtotal
            </h4>
            <h4 class="valor_subtotal">
            $680.673
            </h4>
          </div>
          <hr>
          <form class="check-codigo" method="POST">
          <label for="codigo">Ingrese el código promocional:</label>
        <input type="text" id="codigo" name="codigo" required>
        <input type="submit" name="submit" value="Verificar">
          </form>
          <div class="IVA-detalle">
            <h4 class="IVA">
              IVA
            </h4>
            <h4 class="IVA_total">
            0$
            </h4>
          </div>
          <hr>
          <div class="total-pago">
            <h4 class="total">
            total a pagar
            </h4>
            <h4 class="total_pagar">
            $1.680.673
            </h4>
          </div>
          <hr>
        </div>
        <h1 class="titulo-metodos">
          Seleccionar modo de pago
        </h1>
        <div class="modos_pago">
          <div class="card-modo"> 
      <a class="card card-body" href="https://api.mercadopago.com" role="button">
      <img src="../empresa/images/mercadopago.png" alt="">
      <span class="nombre-modo">Mercado pago</span>
      </a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancelar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
</div>
        <div class="plan">
        <h2>
        Precio sin IVA: $6.722.689
        </h2>
        <ul class="list-group">
      <li class="list-group-item">Créditos incluidos: 200</li>
      <li class="list-group-item">Opción de adquirir hojas de vida adicionales por $45.000 cada una durante la vigencia del plan.</li>
    </ul>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
  consigue el plan
</button>
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <h4>
          Resumen de compra
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <h2>
         $6.722.689
        </h2>
        <div class="detalle">
          <!--<img src="../empresa/images/compras.png" alt=""> -->     
          
          <div class="valor-detalle">
                      <h4 class="plan_detalle">
                      Plan mensual Ser en Accion
                      </h4>
                      <h4 class="valor-plan">
                      $6.722.689
                      </h4>
          </div>
          <hr>
          <div class="subtotal-detalle">
            <h4 class="subtotal">
            subtotal
            </h4>
            <h4 class="valor_subtotal">
            $6.722.689
            </h4>
          </div>
          <hr>
          <form class="check-codigo" method="POST">
          <label for="codigo">Ingrese el código promocional:</label>
        <input type="text" id="codigo" name="codigo" required>
        <input type="submit" name="submit" value="Verificar">
          </form>  
          <div class="IVA-detalle">
            <h4 class="IVA">
              IVA
            </h4>
            <h4 class="IVA_total">
            0$
            </h4>
          </div>
          <hr>
          <div class="total-pago">
            <h4 class="total">
            total a pagar
            </h4>
            <h4 class="total_pagar">
            $6.722.689
            </h4>
          </div>
          <hr>
        </div>
        <h1 class="titulo-metodos">
          Seleccionar modo de pago
        </h1>
        <div class="modos_pago">
          <div class="card-modo"> 
      <a class="card card-body" href="https://api.mercadopago.com" role="button">
      <img src="../empresa/images/mercadopago.png" alt="">
      <span class="nombre-modo">Mercado pago</span>
      </a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancelar compra</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
        </div>
    </div>

    <div class="info-final">
        <h4>
            Por que deberias hacerte premium?
        </h4>
        <p>
            Accede a grandes beneficios, optimiza la busqueda de personal calificado para tu empresa
        <br>
            Accede a un gigantezco numero de hojas de vida
        <br>
            Obten creditos
        </p>
        <img src="../img/hvc pago.png" alt="">
    </div>
</body>

<style>
    body{
    background-color: #F1F1F1 ;
    }


    .info_inicial{
        padding: 40px;
        
    }
    .info_inicial h1{
    font-family:'Montserrat', sans-serif;
    text-align: center;
    font-size: 50px;
    padding: 12px;
    box-shadow: 7px 5px 10px rgba(0, 0, 0, 0.3);
    border-radius: 30px;
    }
    .container{
    display: flex;
    flex-direction: row;
    align-self: center;
    margin-left: 1.5%;
    overflow: hidden;
    }
    .container .item {
    font-family:'Montserrat', sans-serif;
    padding-left: 10px;
    padding-right: 10px;
    border: 1px solid black;
    border-radius: 50px;
    padding-top: 10px;
    background-color: white;
    margin-left: 200px;
    transition: background-color 0.8s ;
    }
    .container :hover{
    background-color:#0036FF;
    transition: background-color 0.5s ;
    }
    .container .item:hover{
    color: white;
    }
    .planes{
    display: flex;
    flex-direction: row;
    align-self: center;
    overflow: hidden;
    margin-left: 10%;
    margin-top: 20px;
    ;
    
    }

    .planes .plan{
    border: 0.5px solid black;
    padding: 50px;
    border-radius: 40px;
    margin-left: 10px;
    width: 350px;
    background-color: white;
    transition: background-color 0.6s;
    box-shadow: 7px 5px 10px rgba(0, 0, 0, 0.3)
    }

    .planes .plan:hover{
    background-color: #EDF1FF;
    }

     .planes .plan h4 {
    padding-bottom:10px;
    }

    .planes .plan h2{
    padding-bottom: 10px;
    color: #0036FF;
    }

    .planes .plan .btn{
    margin-top: 20px;
    margin-left: 20%;
    }

    .info-final{
    background-color: white;
    padding: 40px;
    margin-top: 70px;
    flex-direction: row;
    display: flex;
    flex-wrap: wrap;
    }

    .info-final h4{
        font-size: 35px;
        color: blue;
    }

    .info-final p{
        font-size: 18px;
    }

    .info-final img{
    width: 200px;
    height: 200px;
    margin-left: 200px;
    margin-top: -60px;
    }

    .modos_pago img{
    width: 40px;
    height: 40px;
    }

    .detalle{
    padding: 60px;
    position: relative;
    }


    .detalle img{
    width: 40px;
    height: 40px;
    position: absolute;
    right: 55px;
    bottom: 80px;
    }

    .modal-body h2{
      position: relative;
    top: 10px;
    left: 60px ;
    }


    .modal-body .titulo-metodos{
    margin-left: 120px;
    font-size: 20px;
    color: #0036FF;
    }


/* detalles del plan */
    .detalle .valor-detalle{
    display: flex;
    }

    .detalle .valor-detalle .plan_detalle{
    position: absolute;
    font-size: 15px;
    top: 20px;
  }

    .detalle .valor-detalle .valor-plan{
    position: absolute;
    left: 305px;
    top: 10px;
    }
/* detalles del subtotal */
    .detalle .subtotal-detalle{
    display: flex;
    }
    .detalle .subtotal-detalle .subtotal{
    position: relative;
      font-size: 15px;
    top: 20px;
    }
    .detalle .subtotal-detalle .valor_subtotal{
      position: relative;
      left: 190px;
    top: 10px;
    }
/* detalles del checkbox */
    .detalle .check-codigo{
    display: flex;
    }
    .detalle .check-codigo label{
      position: relative;
      font-size: 15px;
    top: 20px;
    }
    .detalle .check-codigo input{
      position: relative;
      left: 45px;
    top: 20px;
    }
/* detalles del IVA */
    .detalle .IVA-detalle{
    display: flex;
    }
    .detalle .IVA-detalle .IVA{
      position: relative;
      font-size: 15px;
    top: 90px;
    }
    .detalle .IVA-detalle .IVA_total{
      position: relative;
      left: 295px;
    top: 90px;
    }
/* detalles del total */
    .detalle .total-pago{
    display: flex;
    }
    .detalle .total-pago .total{
    position: relative;
      font-size: 15px;
    top: 90px;
    }

    .detalle .total-pago .total_pagar{
      position: relative;
      left: 160px;
    top: 80px;
    }

    .modos_pago{
      position: relative;
    top: 10px;
    }
    .modos_pago .card-modo{
      margin-left: 50px;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .modos_pago .card-modo a{
    display:inline;
    text-decoration:none;
  }



</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

// SDK MercadoPago.js
</html>