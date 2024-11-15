<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class ProductoControllerTest extends TestCase
{
    private $db;
    private $controller;

    protected function setUp(): void
    {
        // Mock de la base de datos
        $this->db = $this->createMock(PDO::class); 
        $this->controller = new ProductoController($this->db);
    }



    public function testCrearProductoMissingData()
    {
        $inputData = json_encode([
            'producto' => 'Producto 1',
            'presentacion' => 'Caja',
            // Otros datos faltantes
        ]);

        // Simulamos la llamada al controlador con datos incompletos
        ob_start();
        $this->controller->crearProducto();
        $output = ob_get_clean();

        // Verificamos que la respuesta es la de error por datos incompletos
        $response = json_decode($output, true);
        $this->assertEquals('Datos incompletos', $response['message']);
    }
   
    public function testEditarFotoProductoMissingData()
    {
        $inputData = json_encode([
            'id' => 1
            // Ruta faltante
        ]);

        // Simulamos la llamada al controlador con datos incompletos
        ob_start();
        $this->controller->editarFotoProducto();
        $output = ob_get_clean();

        // Verificamos que la respuesta es la de error por datos incompletos
        $response = json_decode($output, true);
        $this->assertEquals('Datos incompletos', $response['message']);
    }
   
}


