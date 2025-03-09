<?php

require_once "controladores/ventas.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/productos.controlador.php";

$item = null;
$valor = null;
$orden = "id";

$ventas = ControladorVentas::ctrSumaTotalVentas();

$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
$totalCategorias = count($categorias);

$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
$totalClientes = count($clientes);

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
$totalProductos = count($productos);
?>
