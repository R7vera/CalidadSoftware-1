<?php
require_once __DIR__ . '/../utils/apiclient.php';
class UsuarioModel
{
  private $user;
  private $apiClient;
  public function __construct($session)
  {
    $this->user = $session;
    $this->apiClient = new ApiClient();
  }

  public function getName()
  {
    return $this->user['usuario_nombre'] ?? null;
  }

  public function getRolId()
  {
    return $this->user['rol_id'] ?? null;
  }

  public function getPhoto(){
    return $this->user['usuario_imagen'] ?? null;
  }

  public function getRol()
  {
    $url = 'http://localhost/workspace/ferreteria/api/roles';
    $response = $this->apiClient->setRequest('GET', $url);
    $rol_id = $this->getRolId();
    $rolName = ".";

    if (isset($response['data'])) {
      foreach ($response['data'] as $rol) {
        if ($rol['rol_id'] == $rol_id) {
          $rolName = $rol['rol_nombre'];
          break;
        }
      }
    }

    return $rolName;
  }
}
