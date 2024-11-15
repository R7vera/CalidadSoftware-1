<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class CategoriaModelTest extends TestCase
{
    private $conn;
    private $categoriaModel;

    // Configuración antes de cada prueba
    protected function setUp(): void
    {
        // Simulamos la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->categoriaModel = new CategoriaModel($this->conn);
    }

    // Test para obtener todas las categorías
    public function testGetCategorias()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'nombre' => 'Categoría 1'],
            ['id' => 2, 'nombre' => 'Categoría 2']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y comprobamos que las categorías sean devueltas correctamente
        $categorias = $this->categoriaModel->getCategorias();
        $this->assertCount(2, $categorias);
        $this->assertEquals('Categoría 1', $categorias[0]['nombre']);
    }

    // Test para crear una categoría
    public function testCrearCategoria()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y verificamos que se haya creado correctamente
        $categoria_nombre = 'Nueva Categoría';
        $resultado = $this->categoriaModel->crearCategoria($categoria_nombre);
        $this->assertEquals(1, $resultado); // El ID de la nueva categoría
    }

    // Test para editar una categoría
    public function testEditarCategoria()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y verificamos que se haya editado correctamente
        $id = 1;
        $categoriaActual = 'Categoría Actual';
        $categoriaNuevo = 'Categoría Nueva';
        $estatus = 1;

        $resultado = $this->categoriaModel->editarCategoria($id, $categoriaActual, $categoriaNuevo, $estatus);
        $this->assertTrue($resultado);
    }

    // Test para eliminar una categoría
    public function testEliminarCategoria()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y verificamos que se haya eliminado correctamente
        $id = 1;
        $resultado = $this->categoriaModel->eliminarCategoria($id);
        $this->assertTrue($resultado);
    }
}
