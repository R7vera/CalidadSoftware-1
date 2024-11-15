<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PersonaModelTest extends TestCase
{
    private $conn;
    private $personaModel;

    // Configuración antes de cada prueba
    protected function setUp(): void
    {
        // Simula la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->personaModel = new PersonaModel($this->conn);
    }

    // Test para obtener todas las personas
    public function testGetPersonas()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'nombre' => 'Juan', 'apepat' => 'Perez', 'apemat' => 'Gomez'],
            ['id' => 2, 'nombre' => 'Maria', 'apepat' => 'Lopez', 'apemat' => 'Diaz']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $personas = $this->personaModel->getPersonas();
        $this->assertCount(2, $personas);
        $this->assertEquals('Juan', $personas[0]['nombre']);
    }

    // Test para crear una nueva persona
    public function testCrearPersona()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        $nombre = 'Ana';
        $apepat = 'Sanchez';
        $apemat = 'Lopez';
        $ndocumento = '12345678';
        $tdocumento = 'DNI';
        $sexo = 'F';
        $telefono = '987654321';

        $resultado = $this->personaModel->crearPersona($nombre, $apepat, $apemat, $ndocumento, $tdocumento, $sexo, $telefono);
        $this->assertEquals(1, $resultado);
    }

    // Test para editar una persona
    public function testEditarPersona()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        $id = 1;
        $nombre = 'Luis';
        $apepat = 'Castro';
        $apemat = 'Rojas';
        $ndocumentoactual = '87654321';
        $ndocumentonuevo = '87654322';
        $tdocumento = 'DNI';
        $sexo = 'M';
        $telefono = '987654322';
        $estatus = 'Activo';

        $resultado = $this->personaModel->editarPersona($id, $nombre, $apepat, $apemat, $ndocumentoactual, $ndocumentonuevo, $tdocumento, $sexo, $telefono, $estatus);
        $this->assertTrue($resultado);
    }
}
