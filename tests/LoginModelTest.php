<?php declare(strict_types=1);

require_once __DIR__ . '/../Ferreteria/app/utils/apiclient.php';
require_once __DIR__ . '/../Ferreteria/app/model/loginmodel.php';

use PHPUnit\Framework\TestCase;

class LoginModelTest extends TestCase
{
    private $loginModel;
    private $apiClientMock;

    protected function setUp(): void
    {
        // Crear un mock de ApiClient
        $this->apiClientMock = $this->createMock(ApiClient::class);
        
        // Crear una instancia de LoginModel
        $this->loginModel = new LoginModel();
        
        // Inyectar el mock en la propiedad privada usando Reflection
        $reflection = new ReflectionClass($this->loginModel);
        $property = $reflection->getProperty('apiClient');
        $property->setAccessible(true);
        $property->setValue($this->loginModel, $this->apiClientMock);
    }

    public function testValidarUsuarioExitoso()
    {
        // Datos de prueba
        $username = 'usuario_prueba';
        $password = 'password123';
        
        $mockResponse = [
            'status' => 'success',
            'message' => 'Usuario validado correctamente'
        ];

        // Configurar el comportamiento esperado del mock
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('POST', 'http://localhost/workspace/ferreteria/api/usuarios/verificar', [
                'usuario' => $username,
                'password' => $password
            ])
            ->willReturn($mockResponse);

        // Ejecutar el método y verificar el resultado
        $result = $this->loginModel->validateUser($username, $password);
        $this->assertEquals($mockResponse, $result);
    }

    public function testValidarUsuarioFalla()
    {
        // Datos de prueba
        $username = 'usuario_incorrecto';
        $password = 'password_incorrecta';
        
        // Simular una respuesta de error
        $this->apiClientMock->expects($this->once())
            ->method('setRequest')
            ->with('POST', 'http://localhost/workspace/ferreteria/api/usuarios/verificar', [
                'usuario' => $username,
                'password' => $password
            ])
            ->willReturn(['error' => 'Credenciales incorrectas']);

        // Ejecutar el método y verificar el resultado
        $result = $this->loginModel->validateUser($username, $password);
        $this->assertEquals(['error' => 'Credenciales incorrectas'], $result);
    }
}
