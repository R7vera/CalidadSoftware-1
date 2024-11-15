<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ProveedorModelTest extends TestCase
{
    private $conn;
    private $proveedorModel;

    protected function setUp(): void
    {
        // Mock de la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->proveedorModel = new ProveedorModel($this->conn);
    }

    // Test para obtener todos los proveedores
    public function testGetProveedores()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'nombre' => 'Juan', 'razonsocial' => 'Comercial ABC'],
            ['id' => 2, 'nombre' => 'María', 'razonsocial' => 'Importadora XYZ']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $proveedores = $this->proveedorModel->getProveedores();
        $this->assertCount(2, $proveedores);
        $this->assertEquals('Juan', $proveedores[0]['nombre']);
    }

    // Test para registrar un nuevo proveedor
    public function testCrearProveedores()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        $resultado = $this->proveedorModel->crearProveedores(
            'Carlos',
            'Perez',
            'Gomez',
            '12345678',
            'DNI',
            'M',
            '987654321',
            'Empresa ABC',
            'Luis Soto',
            '987654321'
        );

        $this->assertEquals(1, $resultado);
    }

    // Test para editar un proveedor
    public function testEditarProveedor()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        $resultado = $this->proveedorModel->editarProveedor(1, 'Nueva Razón Social', 'Carlos Torres', '999888777');
        $this->assertEquals(1, $resultado);
    }

    // Test para modificar el estatus de un proveedor
    public function testModificarEstatusProveedor()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        $resultado = $this->proveedorModel->modificarEstatusProveedor(1, 'Inactivo');
        $this->assertTrue($resultado);
    }
}
