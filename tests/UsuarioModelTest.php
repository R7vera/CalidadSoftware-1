<?php declare(strict_types=1);

require_once __DIR__ . '/../Ferreteria/app/utils/apiclient.php';
require_once __DIR__ . '/../Ferreteria/app/model/usuariomodel.php';

use PHPUnit\Framework\TestCase;

class UsuarioModelTest extends TestCase
{
    private $usuarioModel;
    private $apiClientMock;
    private $mockSession;

    protected function setUp(): void
    {
        // Simular los datos de la sesión
        $this->mockSession = [
            'usuario_nombre' => 'Juan Pérez',
            'rol_id' => 1,
            'usuario_imagen' => 'imagen_perfil.jpg',
        ];

        // Crear un mock de ApiClient
        $this->apiClientMock = $this->createMock(ApiClient::class);
        
        // Crear una instancia de UsuarioModel
        $this->usuarioModel = new UsuarioModel($this->mockSession);
        
        // Inyectar el mock en la propiedad privada usando Reflection
        $reflection = new ReflectionClass($this->usuarioModel);
        $property = $reflection->getProperty('apiClient');
        $property->setAccessible(true);
        $property->setValue($this->usuarioModel, $this->apiClientMock);
    }

    public function testGetName()
    {
        // Verificar que el nombre de usuario se obtiene correctamente desde la sesión
        $result = $this->usuarioModel->getName();
        $this->assertEquals('Juan Pérez', $result);
    }

    public function testGetRolId()
    {
        // Verificar que el ID de rol se obtiene correctamente desde la sesión
        $result = $this->usuarioModel->getRolId();
        $this->assertEquals(1, $result);
    }

    public function testGetPhoto()
    {
        // Verificar que la foto del usuario se obtiene correctamente desde la sesión
        $result = $this->usuarioModel->getPhoto();
        $this->assertEquals('imagen_perfil.jpg', $result);
    }

    public function testGetRolExitoso()
    {
        // Simular la respuesta de la API con los roles
        $mockResponse = [
            'data' => [
                ['rol_id' => 1, 'rol_nombre' => 'Administrador'],
                ['rol_id' => 2, 'rol_nombre' => 'Usuario']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/roles')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->usuarioModel->getRol();
        $this->assertEquals('Administrador', $result);
    }

    public function testGetRolRetornaPuntoCuandoNoSeEncuentraRol()
    {
        // Simular la respuesta de la API con roles
        $mockResponse = [
            'data' => [
                ['rol_id' => 2, 'rol_nombre' => 'Usuario']
            ]
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/roles')
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->usuarioModel->getRol();
        $this->assertEquals('.', $result); // Si no se encuentra el rol, debe retornar "."
    }

    public function testGetRolCuandoNoHayDatosEnLaAPI()
    {
        // Configurar el comportamiento esperado del mock cuando no se devuelvan datos
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('GET', 'http://localhost/workspace/ferreteria/api/roles')
            ->willReturn(['data' => []]);

        // Ejecutar el método y verificar el resultado
        $result = $this->usuarioModel->getRol();
        $this->assertEquals('.', $result); // Si no se encuentran roles, debe retornar "."
    }
}
