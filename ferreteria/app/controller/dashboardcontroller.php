<?php
require_once __DIR__ . '/../model/usuariomodel.php';
require_once __DIR__ . '/../utils/apiclient.php';

class DashboardController
{
  private $user;
  private $apiClient;
  public function __construct()
  {
    if (!isset($_SESSION['usuario'])) {
      header('Location: login');
      exit();
    } else {
      $this->user = new UsuarioModel($_SESSION['usuario']);
      $this->apiClient = new ApiClient();
    }
  }

  public function showDashboard()
  {
    $username = $this->user->getName();
    $rolname = $this->user->getRol();
    $userphoto = $this->user->getPhoto();

    $dateData = $this->handleDateRange();

    $total_ingresos = $dateData['total_ingreso'];
    $ingresos_realizados = $dateData['ingresos_realizados'];
    $total_ventas = $dateData['total_ventas'];
    $ventas_realizadas = $dateData['ventas_realizadas'];
    $error = $dateData['error'];
    require __DIR__ . '/../views/dashboard.php';
  }

  private function handleDateRange()
  {
    $total_ingreso = 0;
    $ingresos_realizados = 0;
    $total_ventas = 0;
    $ventas_realizadas = 0;
    $error = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filtrar'])) {
      $finicio = $_POST['finicio'];
      $ffin = $_POST['ffin'];

      $ingresos_response = $this->fetchData("http://localhost/workspace/ferreteria/api/ingresos/listarIngresos", ["finicio" => $finicio, "ffin" => $ffin]);
      if ($ingresos_response && isset($ingresos_response['data'])) {
        foreach ($ingresos_response['data'] as $ingreso) {
          $total_ingreso += floatval($ingreso['ingreso_total']);
          $ingresos_realizados++;
        }
      } else {
        $error = "No se encontraron ingresos para el rango de fechas seleccionado.";
      }

      $ventas_response = $this->fetchData("http://localhost/workspace/ferreteria/api/ventas/listarVentas", ["finicio" => $finicio, "ffin" => $ffin]);
      if ($ventas_response && isset($ventas_response['data'])) {
        foreach ($ventas_response['data'] as $venta) {
          $total_ventas += floatval($venta['venta_total']);
          $ventas_realizadas++;
        }
      } else {
        $error = "No se encontraron ventas para el rango de fechas seleccionado.";
      }
    }

    return [
      'total_ingreso' => $total_ingreso,
      'ingresos_realizados' => $ingresos_realizados,
      'total_ventas' => $total_ventas,
      'ventas_realizadas' => $ventas_realizadas,
      'error' => $error,
    ];
  }

  private function fetchData($url, $data)
  {
    return $this->apiClient->setRequest('POST', $url, $data);
  }

  public function showClientModule()
  {
    $username = $this->user->getName();
    $rolname = $this->user->getRol();
    require __DIR__ . '/../views/cliente.php';
  }
}
