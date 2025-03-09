<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class TablaProductosVentas {

    /*=============================================
     MOSTRAR LA TABLA DE PRODUCTOS
    =============================================*/

    public function mostrarTablaProductosVentas() {

        header('Content-Type: application/json'); // Asegura que la respuesta es JSON

        $item = null;
        $valor = null;
        $orden = "id";

        $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

        if (count($productos) == 0) {
            echo json_encode(["data" => []]);
            return;
        }

        $datosJson = ["data" => []];

        foreach ($productos as $i => $producto) {

            /*=============================================
            TRAEMOS LA IMAGEN
            =============================================*/
            $imagen = "<img src='".$producto["imagen"]."' width='40px'>";

            /*=============================================
            STOCK
            =============================================*/
            if ($producto["stock"] <= 10) {
                $stock = "<button class='btn btn-danger'>".$producto["stock"]."</button>";
            } elseif ($producto["stock"] > 10 && $producto["stock"] <= 15) {
                $stock = "<button class='btn btn-warning'>".$producto["stock"]."</button>";
            } else {
                $stock = "<button class='btn btn-success'>".$producto["stock"]."</button>";
            }

            /*=============================================
            TRAEMOS LAS ACCIONES
            =============================================*/
            $botones = "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$producto["id"]."'>Agregar</button></div>";

            // Agregar los datos en el formato correcto
            $datosJson["data"][] = [
                ($i + 1),
                $imagen,
                $producto["codigo"],
                $producto["descripcion"],
                $stock,
                $botones
            ];
        }

        // Convertimos el array a JSON
        echo json_encode($datosJson);
    }
}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/
$activarProductosVentas = new TablaProductosVentas();
$activarProductosVentas->mostrarTablaProductosVentas();
