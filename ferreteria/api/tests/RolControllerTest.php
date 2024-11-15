<?php

use PHPUnit\Framework\TestCase;

class RolControllerTest extends TestCase
{
    private $db;
    private $controller;
    private $model;

    protected function setUp(): void
    {
        // Mock de la base de datos
        $this->db = $this->createMock(PDO::class);

        // Mock de la clase RolModel
        $this->model = $this->createMock(RolModel::class);

        // Inicializar el controlador
        $this->controller = new RolController($this->db);
    }


    public function testCrearRolConDatosInvalidos()
    {
        // Simulamos los datos incompletos
        $data = [];

        // Establecer la entrada del body como JSON simulado
        $this->injectInput($data);

        // Expectativa de salida JSON (error por datos incompletos)
        $this->expectOutputString(json_encode(['message' => 'Faltan datos requeridos']));

        // Llamar al método
        $this->controller->crearRol();
    }

   

    public function testEditarRolConDatosInvalidos()
    {
        // Simulamos los datos incompletos
        $data = [
            'id' => 1,
            'rolactual' => 'Administrador',
            // Faltan 'rolnuevo' y 'estatus'
        ];

        // Establecer la entrada del body como JSON simulado
        $this->injectInput($data);

        // Expectativa de salida JSON (error por datos incompletos)
        $this->expectOutputString(json_encode(['message' => 'Faltan datos requeridos']));

        // Llamar al método
        $this->controller->editarRol();
    }

    // Función para simular la entrada de datos JSON en la solicitud
    private function injectInput($data)
    {
        $_POST['data'] = json_encode($data);
        file_put_contents('php://input', json_encode($data));
    }
}
