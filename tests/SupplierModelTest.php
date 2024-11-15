<?php declare(strict_types=1);

require_once __DIR__ . '/../Ferreteria/app/utils/apiclient.php';
require_once __DIR__ . '/../Ferreteria/app/model/suppliermodel.php';

use PHPUnit\Framework\TestCase;

class SupplierModelTest extends TestCase
{
    private $supplierModel;
    private $apiClientMock;

    protected function setUp(): void
    {
        // Crear un mock de ApiClient
        $this->apiClientMock = $this->createMock(ApiClient::class);

        // Crear una instancia de SupplierModel
        $this->supplierModel = new SupplierModel();

        // Inyectar el mock en la propiedad privada usando Reflection
        $reflection = new ReflectionClass($this->supplierModel);
        $property = $reflection->getProperty('apiClient');
        $property->setAccessible(true);
        $property->setValue($this->supplierModel, $this->apiClientMock);
    }

    public function testGetSuppliersExitoso()
    {
        // Simular la respuesta de la API con datos de proveedores
        $mockResponse = [
            'data' => [
                ['proveedor_id' => 1, 'proveedor_razonsocial' => 'Proveedor 1'],
                ['proveedor_id' => 2, 'proveedor_razonsocial' => 'Proveedor 2']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/proveedores')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->supplierModel->getSuppliers();
        $this->assertEquals($mockResponse['data'], $result);
    }



    public function testGetSuppliersArrayExitoso()
    {
        // Simular la respuesta de la API con datos de proveedores
        $mockResponse = [
            'data' => [
                ['proveedor_id' => 1, 'proveedor_razonsocial' => 'Proveedor 1', 'proveedor_numcontacto' => '123456789']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/proveedores')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->supplierModel->getSuppliersArray();
        $this->assertCount(1, $result); // Verifica que la respuesta contiene 1 proveedor
        $this->assertEquals('Proveedor 1', $result[0]['proveedor_razonsocial']);
    }

    public function testGetSuppliersArrayCuandoNoHayDatos()
    {
        // Simular la respuesta de la API con datos vacíos
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/proveedores')
            ->willReturn(['data' => []]);

        // Ejecutar el método y verificar el resultado
        $result = $this->supplierModel->getSuppliersArray();
        $this->assertEmpty($result); // Debe devolver un array vacío
    }

    public function testRegisterSuppliersExitoso()
    {
        // Datos para registrar un proveedor
        $data = [
            'nombre' => 'Juan',
            'apepat' => 'Pérez',
            'apemat' => 'González',
            'ndocumento' => '12345678',
            'tdocumento' => 'DNI',
            'sexo' => 'M',
            'telefono' => '987654321',
            'razonsocial' => 'Proveedor SA',
            'nomcontacto' => 'Carlos',
            'numcontacto' => '987654321'
        ];

        // Configurar el comportamiento esperado del mock para el POST
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('POST', 'http://localhost/workspace/ferreteria/api/proveedores', $data)
            ->willReturn(['success' => true]);

        // Ejecutar el método y verificar el resultado
        $result = $this->supplierModel->registerSuppliers(
            $data['nombre'], $data['apepat'], $data['apemat'], $data['ndocumento'], $data['tdocumento'],
            $data['sexo'], $data['telefono'], $data['razonsocial'], $data['nomcontacto'], $data['numcontacto']
        );
        $this->assertTrue($result['success']);
    }

    public function testChangeStatusExitoso()
    {
        // Datos para cambiar el estado del proveedor
        $data = [
            'idproveedor' => 1,
            'estatus' => 'activo'
        ];

        // Configurar el comportamiento esperado del mock para el PATCH
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('PATCH', 'http://localhost/workspace/ferreteria/api/proveedores', $data)
            ->willReturn(['success' => true]);

        // Ejecutar el método y verificar el resultado
        $result = $this->supplierModel->changeStatus(1, 'activo');
        $this->assertTrue($result['success']);
    }
}
