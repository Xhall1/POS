<?php

require_once "conexion.php";

class ModeloVentas{

    /*=============================================
    MOSTRAR VENTAS
    =============================================*/
    static public function mdlMostrarVentas($tabla, $item, $valor){

        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor ORDER BY id ASC");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /*=============================================
    REGISTRO DE VENTA
    =============================================*/
    static public function mdlIngresarVenta($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago) 
		VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago)");

        foreach ($datos as $key => $value) {
            $stmt->bindParam(":".$key, $datos[$key]);
        }

        return $stmt->execute() ? "ok" : "error";
    }

    /*=============================================
    EDITAR VENTA
    =============================================*/
    static public function mdlEditarVenta($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago WHERE codigo = :codigo");

        foreach ($datos as $key => $value) {
            $stmt->bindParam(":".$key, $datos[$key]);
        }

        return $stmt->execute() ? "ok" : "error";
    }

    /*=============================================
    ELIMINAR VENTA
    =============================================*/
    static public function mdlEliminarVenta($tabla, $id){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute() ? "ok" : "error";
    }

    /*=============================================
    RANGO DE FECHAS
    =============================================*/
    static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){

        if($fechaInicial == null){

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } else if($fechaInicial == $fechaFinal){

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha LIKE :fecha");
            $fecha = "%$fechaFinal%";
            $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN :fechaInicial AND :fechaFinal");
            $stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
            $stmt->bindParam(":fechaFinal", $fechaFinal, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /*=============================================
    SUMAR EL TOTAL DE VENTAS
    =============================================*/
    static public function mdlSumaTotalVentas($tabla){

        $stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
