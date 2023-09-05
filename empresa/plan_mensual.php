<?php
    require_once("../models/validator.php");
    $validator = new Validator();
    $requester = new Requester();
    if(isset($_COOKIE['token_empresa']) && isset($_COOKIE['id_empresa'])){
        $perfil = $validator ->validate($_COOKIE['token_empresa'], $_COOKIE['id_empresa'], 'perfil.php');
    }else{
        echo'<script>window.location="../login.php";</script>';
    }
    $id = $perfil['id_empresa'];
    $nombre = $perfil['nombre_empresa'];
    $nit = $perfil['nit_empresa'];
    $ciudad = $perfil['ciudad_empresa'];
    $sector = $perfil['sector_empresa'];
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>