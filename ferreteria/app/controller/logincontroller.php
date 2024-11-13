<?php
require_once __DIR__ . '/../model/loginmodel.php';
class LoginController
{
  private $loginModel;
  public function __construct()
  {
    $this->loginModel = new LoginModel();
  }

  public function loginForm()
  {
    if (isset($_SESSION['usuario'])) {
      header('Location: dashboard');
      exit();
    }
    require __DIR__ . '/../views/login.php';
  }


  public function login()
  {
    if (isset($_POST['username']) && isset($_POST['password'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $response =  $this->loginModel->validateUser($username, $password);

      if (isset($response['message']) && $response['message'] === 'Usuario verificado') {
        $_SESSION['usuario'] = [
          'usuario_id' => $response['data']['usuario_id'],
          'usuario_nombre' => $response['data']['usuario_nombre'],
          'usuario_email' => $response['data']['usuario_email'],
          'rol_id' => $response['data']['rol_id'],
          'usuario_imagen' => $response['data']['usuario_imagen'],
        ];
        header('Location: dashboard');
        exit();
      } else {
        $error = $response['message'] ?? 'Usuario no valido';
        require __DIR__ . '/../views/login.php';
      }
    } else {
      header('Location: login');
      exit();
    }
  }

  public function logout()
  {
    session_unset();
    session_destroy();
    header('Location: login');
    exit();
  }
}
