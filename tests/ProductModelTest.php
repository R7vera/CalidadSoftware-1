<?php declare(strict_types=1);

require_once __DIR__ . '/../Ferreteria/app/utils/apiclient.php';
require_once __DIR__ . '/../Ferreteria/app/model/productmodel.php';

use PHPUnit\Framework\TestCase;

class ProductModelTest extends TestCase
{
    private $productModel;
    private $apiClientMock;

    protected function setUp(): void
    {
        // Crear un mock de ApiClient
        $this->apiClientMock = $this->createMock(ApiClient::class);

        // Crear una instancia de ProductModel
        $this->productModel = new ProductModel();

        // Inyectar el mock en la propiedad privada usando Reflection
        $reflection = new ReflectionClass($this->productModel);
        $property = $reflection->getProperty('apiClient');
        $property->setAccessible(true);
        $property->setValue($this->productModel, $this->apiClientMock);
    }

    public function testGetProductsExitoso()
    {
        // Simular la respuesta de la API con datos de productos
        $mockResponse = [
            'data' => [
                ['producto_id' => 1, 'producto_nombre' => 'Martillo', 'producto_presentacion' => 'Caja', 'producto_stock' => 50, 'categoria_id' => 1, 'unidad_id' => 1, 'producto_foto' => 'martillo.jpg', 'producto_precioventa' => 10.50, 'producto_estatus' => 'activo', 'unidad_nombre' => 'Unidad', 'categoria_nombre' => 'Herramientas'],
                ['producto_id' => 2, 'producto_nombre' => 'Destornillador', 'producto_presentacion' => 'Unidad', 'producto_stock' => 100, 'categoria_id' => 1, 'unidad_id' => 1, 'producto_foto' => 'destornillador.jpg', 'producto_precioventa' => 5.75, 'producto_estatus' => 'activo', 'unidad_nombre' => 'Unidad', 'categoria_nombre' => 'Herramientas']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/productos')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->productModel->getProducts();
        $this->assertEquals($mockResponse['data'], $result);
    }

    public function testGetProductsArrayExitoso()
    {
        // Simular la respuesta de la API con datos de productos
        $mockResponse = [
            'data' => [
                ['producto_id' => 1, 'producto_nombre' => 'Martillo', 'producto_presentacion' => 'Caja', 'producto_stock' => 50, 'categoria_id' => 1, 'unidad_id' => 1, 'producto_foto' => 'martillo.jpg', 'producto_precioventa' => 10.50, 'producto_estatus' => 'activo', 'unidad_nombre' => 'Unidad', 'categoria_nombre' => 'Herramientas']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/productos')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->productModel->getProductsArray();
        $this->assertCount(1, $result); // Verifica que la respuesta contiene 1 producto
        $this->assertEquals('Martillo', $result[0]['producto_nombre']);
    }



    public function testRegisterProductExitoso()
    {
        // Datos para registrar un producto
        $data = ['producto' => 'Sierra', 'presentacion' => 'Caja', 'categoria' => 1, 'unidad' => 1, 'precio' => 15.00, 'ruta' => 'sierra.jpg'];

        // Configurar el comportamiento esperado del mock para el POST
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('POST', 'http://localhost/workspace/ferreteria/api/productos', $data)
            ->willReturn(['success' => true]);

        // Ejecutar el método y verificar el resultado
        $result = $this->productModel->registerProduct($data['producto'], $data['presentacion'], $data['categoria'], $data['unidad'], $data['precio'], $data['ruta']);
        $this->assertTrue($result['success']);
    }

    public function testChangeStatusExitoso()
    {
        // Datos para cambiar el estado del producto
        $data = [
            'idproveedor' => 1,
            'estatus' => 'activo'
        ];

        // Configurar el comportamiento esperado del mock para el PATCH
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('PATCH', 'http://localhost/workspace/ferreteria/api/productos', $data)
            ->willReturn(['success' => true]);

        // Ejecutar el método y verificar el resultado
        $result = $this->productModel->changeStatus(1, 'activo');
        $this->assertTrue($result['success']);
    }

    public function testGetComboCategoryExitoso()
    {
        // Simular la respuesta de la API para obtener el combo de categorías
        $mockResponse = [
            'data' => [
                ['categoria_id' => 1, 'categoria_nombre' => 'Herramientas'],
                ['categoria_id' => 2, 'categoria_nombre' => 'Materiales']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/productos/combo_categoria')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->productModel->getComboCategory();
        $this->assertEquals($mockResponse['data'], $result);
    }

    public function testGetComboUnidadExitoso()
    {
        // Simular la respuesta de la API para obtener el combo de unidades
        $mockResponse = [
            'data' => [
                ['unidad_id' => 1, 'unidad_nombre' => 'Unidad'],
                ['unidad_id' => 2, 'unidad_nombre' => 'Caja']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/productos/combo_unidad')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->productModel->getComboUnidad();
        $this->assertEquals($mockResponse['data'], $result);
    }
}
