<?php declare(strict_types=1);

require_once __DIR__ . '/../Ferreteria/app/utils/apiclient.php';
require_once __DIR__ . '/../Ferreteria/app/model/categorymodel.php';

use PHPUnit\Framework\TestCase;

class CategoryModelTest extends TestCase
{
    private $categoryModel;
    private $apiClientMock;

    protected function setUp(): void
    {
        // Crear un mock de ApiClient
        $this->apiClientMock = $this->createMock(ApiClient::class);

        // Crear una instancia de CategoryModel
        $this->categoryModel = new CategoryModel();

        // Inyectar el mock en la propiedad privada usando Reflection
        $reflection = new ReflectionClass($this->categoryModel);
        $property = $reflection->getProperty('apiClient');
        $property->setAccessible(true);
        $property->setValue($this->categoryModel, $this->apiClientMock);
    }

    public function testGetCategoriesExitoso()
    {
        // Simular la respuesta de la API con datos de categorías
        $mockResponse = [
            'data' => [
                ['categoria_id' => 1, 'categoria_nombre' => 'Herramientas'],
                ['categoria_id' => 2, 'categoria_nombre' => 'Materiales']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/categorias')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->categoryModel->getCategories();
        $this->assertEquals($mockResponse['data'], $result);
    }

    public function testGetCategoriesArrayExitoso()
    {
        // Simular la respuesta de la API con datos de categorías
        $mockResponse = [
            'data' => [
                ['categoria_id' => 1, 'categoria_nombre' => 'Herramientas', 'categoria_fregistro' => '2024-01-01', 'categoria_estatus' => 'activo']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/categorias')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->categoryModel->getCategoriesArray();
        $this->assertCount(1, $result); // Verifica que la respuesta contiene 1 categoría
        $this->assertEquals('Herramientas', $result[0]['categoria_nombre']);
    }

    public function testGetCategoriesArrayCuandoNoHayDatos()
    {
        // Simular la respuesta de la API con datos vacíos
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/categorias')
            ->willReturn(['data' => []]);

        // Ejecutar el método y verificar el resultado
        $result = $this->categoryModel->getCategoriesArray();
        $this->assertEmpty($result); // Debe devolver un array vacío
    }

    public function testRegisterCategoryExitoso()
    {
        // Datos para registrar una categoría
        $data = ['categoria_nombre' => 'Electrónica'];

        // Configurar el comportamiento esperado del mock para el POST
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('POST', 'http://localhost/workspace/ferreteria/api/categorias', $data)
            ->willReturn(['success' => true]);

        // Ejecutar el método y verificar el resultado
        $result = $this->categoryModel->registerCategory($data['categoria_nombre']);
        $this->assertTrue($result['success']);
    }

    public function testChangeStatusExitoso()
    {
        // Datos para cambiar el estado de la categoría
        $data = [
            'idproveedor' => 1,
            'estatus' => 'activo'
        ];

        // Configurar el comportamiento esperado del mock para el PATCH
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('PATCH', 'http://localhost/workspace/ferreteria/api/categorias', $data)
            ->willReturn(['success' => true]);

        // Ejecutar el método y verificar el resultado
        $result = $this->categoryModel->changeStatus(1, 'activo');
        $this->assertTrue($result['success']);
    }
}
