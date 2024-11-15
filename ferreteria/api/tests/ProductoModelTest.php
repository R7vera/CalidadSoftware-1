<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ProductoModelTest extends TestCase
{
    private $conn;
    private $productoModel;

    protected function setUp(): void
    {
        // Mock de la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->productoModel = new ProductoModel($this->conn);
    }

    // Test para obtener todos los productos
    public function testGetProductos()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'producto' => 'Laptop', 'precio' => 1500],
            ['id' => 2, 'producto' => 'Mouse', 'precio' => 25]
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $productos = $this->productoModel->getProductos();
        $this->assertCount(2, $productos);
        $this->assertEquals('Laptop', $productos[0]['producto']);
    }

    // Test para registrar un nuevo producto
    public function testCrearProductos()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        $resultado = $this->productoModel->crearProductos(
            'Monitor',
            'Caja',
            'Electrónica',
            'Unidad',
            200.50,
            '/images/monitor.jpg'
        );

        $this->assertEquals(1, $resultado);
    }

    // Test para editar la foto de un producto
    public function testEditarFotoProducto()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        $resultado = $this->productoModel->editarFotoProducto(1, '/images/new_photo.jpg');
        $this->assertTrue($resultado);
    }

    // Test para listar las categorías disponibles
    public function testListarComboCategoria()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'categoria' => 'Electrónica'],
            ['id' => 2, 'categoria' => 'Hogar']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $categorias = $this->productoModel->listar_combo_categoria();
        $this->assertCount(2, $categorias);
        $this->assertEquals('Electrónica', $categorias[0]['categoria']);
    }

    // Test para listar las unidades disponibles
    public function testListarComboUnidad()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'unidad' => 'Caja'],
            ['id' => 2, 'unidad' => 'Paquete']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $unidades = $this->productoModel->listar_combo_unidad();
        $this->assertCount(2, $unidades);
        $this->assertEquals('Caja', $unidades[0]['unidad']);
    }
}
