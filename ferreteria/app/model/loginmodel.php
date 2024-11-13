<?php
require_once __DIR__ . '/../utils/apiclient.php';

class LoginModel
{
  private $endPoint;
  private $apiClient;

  public function __construct()
  {
    $this->endPoint = 'http://localhost/workspace/ferreteria/api/usuarios/';
    $this->apiClient  = new ApiClient();
  }

  public function validateUser($username, $password)
  {
    $url = $this->endPoint . 'verificar';
    $data = [
      'usuario' => $username,
      'password' => $password,
    ];

    return $this->apiClient->setRequest('POST', $url, $data);
  }
}
