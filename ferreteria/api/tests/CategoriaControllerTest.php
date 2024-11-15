<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class CategoriaControllerTest extends TestCase
{
    private $db;
    private $categoriaController;
    private $categoriaModelMock;

    protected function setUp(): void
    {
        // Mock del modelo de la categoría
        $this->categoriaModelMock = $this->createMock(CategoriaModel::class);
        // Mock de la conexión a la base de datos
        $this->db = $this->createMock(PDO::class);
        // Inyectar el modelo mockeado en el controlador
        $this->categoriaController = new CategoriaController($this->db);
    }

    // Test para obtener categorías
    // Test para datos incompletos al crear una categoría
    public function testCrearCategoriaDatosIncompletos()
    {
        $data = json_decode('{"categoria_nombre": ""}'); // No se pasa nombre

        // Capturar la salida de la función
        ob_start();
        $this->categoriaController->crearCategoria();
        $output = ob_get_clean();

        // Validar la respuesta JSON
        $expected = json_encode([
            'message' => 'Datos incompletos'
        ]);
        $this->assertEquals($expected, $output);
    }

    // Test para datos incompletos al editar una categoría
    public function testEditarCategoriaDatosIncompletos()
    {
        $data = json_decode('{"id": 1, "categoria_actual": "", "categoria_nueva": "Categoria Z", "categoria_estatus": "activo"}'); // Falta categoria_actual

        // Capturar la salida de la función
        ob_start();
        $this->categoriaController->editarCategoria();
        $output = ob_get_clean();

        // Validar la respuesta JSON
        $expected = json_encode([
            'message' => 'Datos incompletos'
        ]);
        $this->assertEquals($expected, $output);
    }

    // Test para datos incompletos al eliminar una categoría
    public function testEliminarCategoriaDatosIncompletos()
    {
        $data = json_decode('{}'); // No se pasa ID

        // Capturar la salida de la función
        ob_start();
        $this->categoriaController->eliminarCategoria();
        $output = ob_get_clean();

        // Validar la respuesta JSON
        $expected = json_encode([
            'message' => 'ID de categoría no proporcionado'
        ]);
        $this->assertEquals($expected, $output);
    }
}
