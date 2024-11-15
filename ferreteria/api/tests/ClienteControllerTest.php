<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ClienteControllerTest extends TestCase
{
    private $db;
    private $clienteController;
    private $clienteModelMock;

    protected function setUp(): void
    {
        // Mock del modelo de cliente
        $this->clienteModelMock = $this->createMock(ClienteModel::class);
        // Mock de la conexión a la base de datos
        $this->db = $this->createMock(PDO::class);
        // Inyectar el modelo mockeado en el controlador
        $this->clienteController = new ClienteController($this->db);
    }

    // Test para obtener clientes


    // Test para crear cliente

    // Test para datos incompletos al crear un cliente
    public function testCrearClienteDatosIncompletos()
    {
        $data = json_decode('{
            "nombre": "Carlos",
            "apepat": "Martinez",
            "apemat": "",
            "ndocumento": "11223344",
            "tdocumento": "DNI",
            "sexo": "M",
            "telefono": "987654321"
        }'); // Falta apemat

        // Capturar la salida de la función
        ob_start();
        $this->clienteController->crearCliente();
        $output = ob_get_clean();

        // Validar la respuesta JSON
        $expected = json_encode([
            'message' => 'Datos incompletos'
        ]);
        $this->assertEquals($expected, $output);
    }

    // Test para editar cliente
  

    // Test para datos incompletos al editar un cliente
    public function testEditarClienteDatosIncompletos()
    {
        $data = json_decode('{
            "idcliente": "",
            "estatus": "activo"
        }'); // Falta idcliente

        // Capturar la salida de la función
        ob_start();
        $this->clienteController->editarCliente();
        $output = ob_get_clean();

        // Validar la respuesta JSON
        $expected = json_encode([
            'message' => 'Datos incompletos'
        ]);
        $this->assertEquals($expected, $output);
    }

    // Test para error al crear un cliente

    // Test para error al editar un cliente
}
