<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class IngresoModelTest extends TestCase
{
    private $conn;
    private $ingresoModel;

    // Configuración antes de cada prueba
    protected function setUp(): void
    {
        // Simulamos la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->ingresoModel = new IngresoModel($this->conn);
    }

    // Test para obtener ingresos por rango de fechas
    public function testGetIngresos()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['idingreso' => 1, 'total' => 100.50],
            ['idingreso' => 2, 'total' => 200.75],
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $finicio = '2024-01-01';
        $ffin = '2024-12-31';

        $ingresos = $this->ingresoModel->getIngresos($finicio, $ffin);
        $this->assertCount(2, $ingresos);
        $this->assertEquals(100.50, $ingresos[0]['total']);
    }

    // Test para crear un ingreso
    public function testCrearIngreso()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        $idproveedor = 1;
        $idusuario = 1;
        $tipo = 'Factura';
        $serie = 'F001';
        $ncomprobante = '123456';
        $total = 500.00;
        $impuesto = 90.00;
        $porcentaje = 18.0;

        $resultado = $this->ingresoModel->crearIngreso($idproveedor, $idusuario, $tipo, $serie, $ncomprobante, $total, $impuesto, $porcentaje);
        $this->assertEquals(1, $resultado);
    }

    // Test para anular un ingreso
    public function testAnularIngreso()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        $idingreso = 1;
        $resultado = $this->ingresoModel->anularIngreso($idingreso);
        $this->assertTrue($resultado);
    }

    // Test para listar proveedores en el combo
    public function testListarComboProveedor()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['idproveedor' => 1, 'nombre' => 'Proveedor A'],
            ['idproveedor' => 2, 'nombre' => 'Proveedor B'],
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $proveedores = $this->ingresoModel->listarComboProveedor();
        $this->assertCount(2, $proveedores);
        $this->assertEquals('Proveedor A', $proveedores[0]['nombre']);
    }

    // Test para registrar detalle de ingreso
    public function testRegistrarIngresoDetalle()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        $id = 1;
        $array_producto = json_encode([1, 2]);
        $array_cantidad = json_encode([10, 5]);
        $array_precio = json_encode([100.00, 50.00]);

        $resultado = $this->ingresoModel->registrarIngresoDetalle($id, $array_producto, $array_cantidad, $array_precio);
        $this->assertTrue($resultado);
    }
}
