<?php declare(strict_types=1);

require_once __DIR__ . '/../Ferreteria/app/utils/apiclient.php';
require_once __DIR__ . '/../Ferreteria/app/model/clientemodel.php';

use PHPUnit\Framework\TestCase;

class ClienteModelTest extends TestCase
{
    private $clienteModel;
    private $apiClientMock;

    protected function setUp(): void
    {
        // Crear un mock de ApiClient
        $this->apiClientMock = $this->createMock(ApiClient::class);
        
        // Crear una instancia de ClienteModel
        $this->clienteModel = new ClienteModel();
        
        // Inyectar el mock en la propiedad privada usando Reflection
        $reflection = new ReflectionClass($this->clienteModel);
        $property = $reflection->getProperty('apiClient');
        $property->setAccessible(true);
        $property->setValue($this->clienteModel, $this->apiClientMock);
    }

    public function testObtenerClientesRetornaArregloExitoso()
    {
        // Datos de prueba
        $mockResponse = [
            'data' => [
                [
                    'persona' => 'Juan Pérez',
                    'persona_nrodocumento' => '12345678',
                    'persona_tipodocumento' => 'DNI',
                    'persona_sexo' => 'M',
                    'persona_telefono' => '123456789',
                    'cliente_fregistro' => '2024-03-15',
                    'cliente_estatus' => '1',
                    'persona_id' => '1',
                    'cliente_id' => '1'
                ]
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/clientes')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->clienteModel->getClients();
        $this->assertIsArray($result);
        $this->assertEquals($mockResponse['data'], $result);
    }

    public function testObtenerClientesRetornaFalsoEnError()
    {
        // Simular una respuesta fallida
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->willReturn(['error' => 'Error message']);

        $result = $this->clienteModel->getClients();
        $this->assertFalse($result);
    }

    public function testRegistrarClienteExitoso()
    {
        $mockResponse = [
            'status' => 'success',
            'message' => 'Cliente registrado correctamente'
        ];

        $testData = [
            'nombre' => 'Juan',
            'apepat' => 'Pérez',
            'apemat' => 'García',
            'ndocumento' => '12345678',
            'tdocumento' => 'DNI',
            'sexo' => 'M',
            'telefono' => '123456789'
        ];

        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('POST', 'http://localhost/workspace/ferreteria/api/clientes', $testData)
            ->willReturn($mockResponse);

        $result = $this->clienteModel->registerClient(
            $testData['nombre'],
            $testData['apepat'],
            $testData['apemat'],
            $testData['ndocumento'],
            $testData['tdocumento'],
            $testData['sexo'],
            $testData['telefono']
        );

        $this->assertEquals($mockResponse, $result);
    }

    public function testCambiarEstadoExitoso()
    {
        $mockResponse = [
            'status' => 'success',
            'message' => 'Estado actualizado correctamente'
        ];

        $clienteId = 1;
        $newStatus = 0;

        $expectedData = [
            'idcliente' => $clienteId,
            'estatus' => $newStatus
        ];

        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('PUT', 'http://localhost/workspace/ferreteria/api/clientes', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->clienteModel->changeStatus($clienteId, $newStatus);
        $this->assertEquals($mockResponse, $result);
    }

    public function testObtenerArregloClientesExitoso()
    {
        $mockApiResponse = [
            'data' => [
                [
                    'persona' => 'Juan Pérez',
                    'persona_nrodocumento' => '12345678',
                    'persona_tipodocumento' => 'DNI',
                    'persona_sexo' => 'M',
                    'persona_telefono' => '123456789',
                    'cliente_fregistro' => '2024-03-15',
                    'cliente_estatus' => '1',
                    'persona_id' => '1',
                    'cliente_id' => '1'
                ]
            ]
        ];

        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->willReturn($mockApiResponse);

        $result = $this->clienteModel->getClientesArray();
        
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals($mockApiResponse['data'][0]['persona'], $result[0]['persona']);
    }

    public function testObtenerArregloClientesRetornaArregloVacioEnError()
    {
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->willReturn(['error' => 'Error message']);

        $result = $this->clienteModel->getClientesArray();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}