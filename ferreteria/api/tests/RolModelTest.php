<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class RolModelTest extends TestCase
{
    private $conn;
    private $rolModel;

    protected function setUp(): void
    {
        // Mock de la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->rolModel = new RolModel($this->conn);
    }

    // Test para obtener todos los roles
    public function testGetRoles()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'rol' => 'Administrador'],
            ['id' => 2, 'rol' => 'Usuario']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $roles = $this->rolModel->getRoles();
        $this->assertCount(2, $roles);
        $this->assertEquals('Administrador', $roles[0]['rol']);
    }

    // Test para crear un nuevo rol
    public function testCrearRol()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        $resultado = $this->rolModel->crearRol('Editor');
        $this->assertEquals(1, $resultado);
    }

    // Test para editar un rol
    public function testEditarRol()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmt);

        $resultado = $this->rolModel->editarRol(1, 'Usuario', 'Moderador', 'Activo');
        $this->assertTrue($resultado);
    }
}
