<?php
require_once __DIR__ . '/../model/suppliermodel.php';
require_once __DIR__ . '/../model/usuariomodel.php';
class SupplierController
{
  private $supplierModel;
  private $userModel;
  public function __construct()
  {
    $this->supplierModel = new SupplierModel();
    $this->userModel = new UsuarioModel($_SESSION['usuario']);
  }

  public function getSuppliers()
  {
    $username = $this->userModel->getName();
    $rolname = $this->userModel->getRol();
    $userphoto = $this->userModel->getPhoto();

    $suppliers = $this->supplierModel->getSuppliersArray();

    if (empty($suppliers)) {
      $suppliers = [];
    }

    require __DIR__ . '/../views/proveedores.php';
  }

  public function registerSupplier()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $supplierName = $_POST['nombre'];
      $supplierLastName = $_POST['apellido_paterno'];
      $supplierMaternalSurname = $_POST['apellido_materno'];
      $supplierDocument = $_POST['nro_documento'];
      $selectDocument = $_POST['tipo_documento'];
      $selectSex = $_POST['sexo'];
      $phoneNumber = $_POST['telefono'];
      $razonsocial = $_POST['razon_social'];
      $contactName = $_POST['nombre_contacto'];
      $contactNumber = $_POST['nro_contacto'];

      if ($this->supplierModel->registerSuppliers(
        $supplierName,
        $supplierLastName,
        $supplierMaternalSurname,
        $supplierDocument,
        $selectDocument,
        $selectSex,
        $phoneNumber,
        $razonsocial,
        $contactName,
        $contactNumber
      )) {
        header("Location: proveedores");
        exit();
      }
    }
  }

  public function changeStatus()
  {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $status = isset($_GET['action']) ? $_GET['action'] : null;
    if ($id) {
      if ($this->supplierModel->changeStatus($id, $status)) {
        header("Location: proveedores");
        exit();
      } else {
        echo "Error al cambiar de estado";
      }
    }
  }
}
