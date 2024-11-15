<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class UsuarioModelTest extends TestCase
{
    private $conn;
    private $usuarioModel;

    // Configuración antes de cada prueba
    protected function setUp(): void
    {
        // Simulamos la conexión a la base de datos
        $this->conn = $this->createMock(PDO::class);
        $this->usuarioModel = new UsuarioModel($this->conn);
    }

    // Test para verificar si un usuario existe
    public function testVerificarUsuario()
    {
        // Simulamos el resultado de la consulta
        $usuario = 'testuser';
        $password = 'password123';
        
        // Mock de la base de datos para la función SP_VERIFICAR_USUARIO
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetch')->willReturn(['usuario_password' => password_hash($password, PASSWORD_DEFAULT)]);
        
        $this->conn->method('prepare')->willReturn($stmt);

        // Comprobamos que se devuelve el resultado esperado
        $resultado = $this->usuarioModel->verificarUsuario($usuario, $password);
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('usuario_password', $resultado);
    }

    // Test para obtener todos los usuarios
    public function testGetUsuarios()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn([
            ['id' => 1, 'usuario' => 'testuser1'],
            ['id' => 2, 'usuario' => 'testuser2']
        ]);
        
        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y comprobamos que los usuarios sean devueltos correctamente
        $usuarios = $this->usuarioModel->getUsuarios();
        $this->assertCount(2, $usuarios);
        $this->assertEquals('testuser1', $usuarios[0]['usuario']);
    }

    // Test para crear un nuevo usuario
    public function testCrearUsuario()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);
        
        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y verificamos que se haya registrado correctamente
        $usuario = 'newuser';
        $pass = 'newpassword123';
        $idpersona = 1;
        $email = 'newuser@example.com';
        $idrol = 2;
        $ruta = '/images/avatar.png';
        
        $resultado = $this->usuarioModel->crearUsuario($usuario, $pass, $idpersona, $email, $idrol, $ruta);
        $this->assertEquals(1, $resultado); // El ID del nuevo usuario
    }

    // Test para editar un usuario
    public function testEditarUsuario()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);
        
        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y verificamos que se haya editado correctamente
        $id = 1;
        $idpersona = 1;
        $emailnuevo = 'newemail@example.com';
        $idrol = 2;
        $estatus = 1;
        
        $resultado = $this->usuarioModel->editarUsuario($id, $idpersona, $emailnuevo, $idrol, $estatus);
        $this->assertEquals(1, $resultado); // Verificamos si la columna fue modificada
    }

    // Test para editar la foto del usuario
    public function testEditarFoto()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);
        
        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y verificamos que se haya editado correctamente la foto
        $id = 1;
        $ruta = '/images/new_avatar.png';
        
        $resultado = $this->usuarioModel->editarFoto($id, $ruta);
        $this->assertEquals(1, $resultado); // Verificamos si la foto fue actualizada
    }

    // Test para actualizar la contraseña
    public function testActualizarContra()
    {
        // Simulamos la respuesta de la consulta
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('bindParam')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('rowCount')->willReturn(1);
        
        $this->conn->method('prepare')->willReturn($stmt);

        // Llamamos al método y verificamos que la contraseña fue actualizada
        $id = 1;
        $contranueva = 'newpassword123';
        
        $resultado = $this->usuarioModel->actualizarContra($id, $contranueva);
        $this->assertTrue($resultado); // Se debe devolver true si la actualización fue exitosa
    }
}
