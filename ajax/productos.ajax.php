<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

header('Content-Type: application/json'); // Asegurar que la respuesta es JSON
ob_start(); // Inicia buffer para evitar salidas no deseadas

class AjaxProductos {

    /*=============================================
    GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
    =============================================*/
    public $idCategoria;

    public function ajaxCrearCodigoProducto() {
        $item = "id_categoria";
        $valor = $this->idCategoria;
        $orden = "id";

        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

        $this->sendJsonResponse($respuesta);
    }

    /*=============================================
    EDITAR PRODUCTO
    =============================================*/
    public $idProducto;
    public $traerProductos;
    public $nombreProducto;

    public function ajaxEditarProducto() {
        if ($this->traerProductos == "ok") {
            $item = null;
            $valor = null;
            $orden = "id";
        } else if (!empty($this->nombreProducto)) {
            $item = "descripcion";
            $valor = $this->nombreProducto;
            $orden = "id";
        } else {
            $item = "id";
            $valor = $this->idProducto;
            $orden = "id";
        }

        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
        $this->sendJsonResponse($respuesta);
    }

    /*=============================================
    FUNCIÓN PARA ENVIAR RESPUESTA JSON
    =============================================*/
    private function sendJsonResponse($data) {
        ob_end_clean(); // Evita espacios en blanco o errores antes del JSON
        header('Content-Type: application/json; charset=utf-8');

        // Depurar antes de enviar JSON
        if (!is_array($data) && !is_object($data)) {
            echo json_encode(["error" => "La respuesta no es un array ni un objeto", "data" => $data]);
            exit();
        }

        $json = json_encode($data);
        if ($json === false) {
            echo json_encode(["error" => "Error al convertir a JSON", "detalle" => json_last_error_msg()]);
            exit();
        }

        echo $json;
        exit();
    }

}

/*=============================================
  MANEJAR SOLICITUDES AJAX
=============================================*/
if (isset($_POST["idCategoria"])) {
    $codigoProducto = new AjaxProductos();
    $codigoProducto->idCategoria = $_POST["idCategoria"];
    $codigoProducto->ajaxCrearCodigoProducto();
}

if (isset($_POST["idProducto"])) {
    $editarProducto = new AjaxProductos();
    $editarProducto->idProducto = $_POST["idProducto"];
    $editarProducto->ajaxEditarProducto();
}

if (isset($_POST["traerProductos"])) {
    $traerProductos = new AjaxProductos();
    $traerProductos->traerProductos = $_POST["traerProductos"];
    $traerProductos->ajaxEditarProducto();
}

if (isset($_POST["nombreProducto"])) {
    $traerProductos = new AjaxProductos();
    $traerProductos->nombreProducto = $_POST["nombreProducto"];
    $traerProductos->ajaxEditarProducto();
}
