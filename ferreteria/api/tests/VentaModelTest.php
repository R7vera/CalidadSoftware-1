<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class VentaModelTest extends TestCase
{
    private $conn;
    private $ventaModel;

    protected function setUp(): void
    {
        // Mock de la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->ventaModel = new VentaModel($this->conn);
    }

    // Test para obtener ventas en un rango de fechas
    public function testGetVentas()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'total' => 100.00, 'cliente' => 'Cliente A'],
            ['id' => 2, 'total' => 200.00, 'cliente' => 'Cliente B']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $result = $this->ventaModel->getVentas('2024-01-01', '2024-01-31');
        $this->assertCount(2, $result);
        $this->assertEquals('Cliente A', $result[0]['cliente']);
        $this->assertEquals(200.00, $result[1]['total']);
    }

    // Test para registrar una venta
    public function testRegistrarVenta()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        $result = $this->ventaModel->registrarVenta(1, 1, 'Factura', 'A001', '12345', 500.00, 50.00, 10);
        $this->assertEquals(1, $result);
    }

    // Test para anular una venta
    public function testAnularVenta()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        $result = $this->ventaModel->anularVenta(1);
        $this->assertTrue($result);
    }

    // Test para obtener clientes del combo
    public function testListarComboCliente()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'nombre' => 'Cliente A'],
            ['id' => 2, 'nombre' => 'Cliente B']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $result = $this->ventaModel->listarComboCliente();
        $this->assertCount(2, $result);
        $this->assertEquals('Cliente A', $result[0]['nombre']);
    }

    // Test para obtener productos del combo
    public function testListarComboProducto()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'nombre' => 'Producto A'],
            ['id' => 2, 'nombre' => 'Producto B']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $result = $this->ventaModel->listarComboProducto();
        $this->assertCount(2, $result);
        $this->assertEquals('Producto B', $result[1]['nombre']);
    }

    // Test para registrar los detalles de una venta
    public function testRegistrarVentaDetalle()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        $result = $this->ventaModel->registrarVentaDetalle(1, [1, 2], [2, 3], [100, 150]);
        $this->assertTrue($result);
    }
}
