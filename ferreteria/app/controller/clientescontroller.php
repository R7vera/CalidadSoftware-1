<?php
require_once __DIR__ . '/../model/clientemodel.php';
require_once __DIR__ . '/../model/usuariomodel.php';
class ClienteController
{
  private $clientModel;
  private $userModel;
  public function __construct()
  {
    $this->clientModel = new ClienteModel();
    $this->userModel = new UsuarioModel($_SESSION['usuario']);
  }

  public function getClients()
  {
    $username = $this->userModel->getName();
    $rolname = $this->userModel->getRol();
    $userphoto = $this->userModel->getPhoto();

    $clientes = $this->clientModel->getClientesArray();

    if (empty($clientes)) {
      $clientes = [];
    }

    require __DIR__ . '/../views/cliente.php';
  }

  public function registerCliente()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $clientName = $_POST['nombre'];
      $clientLastName = $_POST['apellido_paterno'];
      $clientMaternalSurname = $_POST['apellido_materno'];
      $clientDocument = $_POST['nro_documento'];
      $selectDocument = $_POST['tipo_documento'];
      $selectSex = $_POST['sexo'];
      $phoneNumber = $_POST['telefono'];
      $documentTipe = '';
      $sex = '';
      $documentTipe = $selectDocument;
      $sex = $selectSex;
      if ($this->clientModel->registerClient(
        $clientName,
        $clientLastName,
        $clientMaternalSurname,
        $clientDocument,
        $documentTipe,
        $sex,
        $phoneNumber
      )) {
        header("Location: clientes");
        exit();
      }
      echo $documentTipe;
    }
  }

  public function changeStatus()
  {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $status = isset($_GET['action']) ? $_GET['action'] : null;
    if ($id) {
      if ($this->clientModel->changeStatus($id, $status)) {
        header("Location: clientes");
        exit();
      } else {
        echo "Error al cambiar de estado";
      }
    }
  }
}
