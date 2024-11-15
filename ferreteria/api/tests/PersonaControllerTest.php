<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class PersonaControllerTest extends TestCase
{
    private $db;
    private $controller;

    protected function setUp(): void
    {
        // Mock de la base de datos
        $this->db = $this->createMock(PDO::class); 
        $this->controller = new PersonaController($this->db);
    }



    public function testCrearPersonaMissingData()
    {
        $inputData = json_encode([
            'nombre' => 'Carlos',
            'apepat' => 'Martínez',
            // Otros datos faltantes
        ]);

        // Simulamos la llamada al controlador con datos incompletos
        ob_start();
        $this->controller->crearPersona();
        $output = ob_get_clean();

        // Verificamos que la respuesta es la de error por datos incompletos
        $response = json_decode($output, true);
        $this->assertEquals('Datos incompletos', $response['message']);
    }


    public function testEditarPersonaMissingData()
    {
        $inputData = json_encode([
            'id' => 1,
            'nombre' => 'Carlos',
            // Otros datos faltantes
        ]);

        // Simulamos la llamada al controlador con datos incompletos
        ob_start();
        $this->controller->editarPersona();
        $output = ob_get_clean();

        // Verificamos que la respuesta es la de error por datos incompletos
        $response = json_decode($output, true);
        $this->assertEquals('Datos incompletos', $response['message']);
    }
}


