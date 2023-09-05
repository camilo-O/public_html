<?php

require_once 'mercadopago/vendor/autoload.php';

$mp->setAccessToken('TU_ACCESS_TOKEN');

$item->title = 'Producto de ejemplo';
$item->quantity = 1;
$item->unit_price = 100.0;

$preference->items = array($item);
$preference->back_urls = array(
    "success" => "https://serenaccion.com.co/pago_exitoso",
    "failure" => "https://serenaccion.com.co/pago_fallido",
    "pending" => "https://serenaccion.com.co/pago_pendiente"
);

$preference->auto_return = "approved";

header('Location: ' . $preference->init_point);
exit();
?>