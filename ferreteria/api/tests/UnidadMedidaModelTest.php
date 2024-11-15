<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class UnidadMedidaModelTest extends TestCase
{
    private $conn;
    private $unidadMedidaModel;

    protected function setUp(): void
    {
        // Mock de la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->unidadMedidaModel = new UnidadMedidaModel($this->conn);
    }

    // Test para obtener todas las unidades de medida
    public function testGetUnidadesMedida()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'unidad' => 'Kilogramo', 'abreviatura' => 'kg'],
            ['id' => 2, 'unidad' => 'Litro', 'abreviatura' => 'L']
        ]);

        $this->conn->method('prepare')->willReturn($stmt);

        $result = $this->unidadMedidaModel->getUnidadesMedida();
        $this->assertCount(2, $result);
        $this->assertEquals('Kilogramo', $result[0]['unidad']);
        $this->assertEquals('L', $result[1]['abreviatura']);
    }

    // Test para crear una nueva unidad de medida
    public function testCrearUnidadMedida()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        $result = $this->unidadMedidaModel->crearUnidadMedida('Metro', 'm');
        $this->assertEquals(1, $result);
    }

    // Test para editar una unidad de medida
    public function testEditarUnidadMedida()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->conn->method('prepare')->willReturn($stmt);

        $result = $this->unidadMedidaModel->editarUnidadMedida(1, 'Metro', 'Metro Nuevo', 'mN', 'Activo');
        $this->assertEquals(1, $result);
    }
}
