<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ClienteModelTest extends TestCase
{
    private $conn;
    private $clienteModel;

    // Configuración antes de cada prueba
    protected function setUp(): void
    {
        // Simulamos la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->clienteModel = new ClienteModel($this->conn);
    }

    // Test para obtener todos los clientes
    public function testGetClientes()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['idcliente' => 1, 'nombre' => 'Juan'],
            ['idcliente' => 2, 'nombre' => 'María']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y comprobamos que los clientes sean devueltos correctamente
        $clientes = $this->clienteModel->getClientes();
        $this->assertCount(2, $clientes);
        $this->assertEquals('Juan', $clientes[0]['nombre']);
    }

    // Test para crear un cliente
    public function testCrearCliente()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y verificamos que el cliente se haya creado correctamente
        $nombre = 'Carlos';
        $apepat = 'Pérez';
        $apemat = 'Gómez';
        $ndocumento = '12345678';
        $tdocumento = 'DNI';
        $sexo = 'M';
        $telefono = '987654321';

        $resultado = $this->clienteModel->crearCliente($nombre, $apepat, $apemat, $ndocumento, $tdocumento, $sexo, $telefono);
        $this->assertEquals(1, $resultado); // Verificamos si se devuelve el ID del nuevo cliente
    }

    // Test para editar el estatus de un cliente
    public function testEditarCliente()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y verificamos que el estatus del cliente se haya editado correctamente
        $idcliente = 1;
        $estatus = 1;

        $resultado = $this->clienteModel->editarCliente($idcliente, $estatus);
        $this->assertTrue($resultado); // Verificamos si la operación fue exitosa
    }
}
