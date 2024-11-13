<?php

class VentaController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/ventamodel.php';
        $this->model = new VentaModel($db);
    }

    public function listarVentas()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $finicio = $datos['finicio'] ?? null;
        $ffin = $datos['ffin'] ?? null;

        if ($finicio && $ffin) {
            $ventas = $this->model->getVentas($finicio, $ffin);
            echo json_encode(['data' => $ventas]);
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function crearVenta()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $idcliente = $datos['idcliente'] ?? null;
        $idusuario = $datos['idusuario'] ?? null;
        $tipo = $datos['tipo'] ?? null;
        $serie = $datos['serie'] ?? null;
        $ncomprobante = $datos['ncomprobante'] ?? null;
        $total = $datos['total'] ?? null;
        $impuesto = $datos['impuesto'] ?? null;
        $porcentaje = $datos['porcentaje'] ?? null;

        if ($idcliente && $idusuario && $tipo && $serie && $ncomprobante && $total && $impuesto && $porcentaje) {
            $result = $this->model->registrarVenta($idcliente, $idusuario, $tipo, $serie, $ncomprobante, $total, $impuesto, $porcentaje);

            if ($result) {
                echo json_encode(['message' => 'Venta registrada correctamente', 'id' => $result]);
            } else {
                echo json_encode(['message' => 'Error al registrar venta']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function anularVenta()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $idventa = $datos['idventa'] ?? null;

        if ($idventa) {
            $result = $this->model->anularVenta($idventa);
            if ($result) {
                echo json_encode(['message' => 'Venta anulada correctamente']);
            } else {
                echo json_encode(['message' => 'Error al anular venta']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function listarComboCliente()
    {
        $clientes = $this->model->listarComboCliente();
        echo json_encode(['data' => $clientes]);
    }

    public function listarComboProducto()
    {
        $productos = $this->model->listarComboProducto();
        echo json_encode(['data' => $productos]);
    }

    public function registrarVentaDetalle()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $id = $datos['id'] ?? null;
        $array_producto = $datos['array_producto'] ?? null;
        $array_cantidad = $datos['array_cantidad'] ?? null;
        $array_precio = $datos['array_precio'] ?? null;

        if ($id && $array_producto && $array_cantidad && $array_precio) {
            $result = $this->model->registrarVentaDetalle($id, $array_producto, $array_cantidad, $array_precio);

            if ($result) {
                echo json_encode(['message' => 'Detalles de venta registrados correctamente']);
            } else {
                echo json_encode(['message' => 'Error al registrar detalles de venta']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }
}
