<?php

class Router
{
  public static function route($url)
  {
    switch ($url) {
      case 'login':
        require __DIR__ . '/../app/controller/logincontroller.php';
        $method = new LoginController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $method->login();
        } else {
          $method->loginForm();
        }
        break;
      case 'dashboard':
        require __DIR__ . '/../app/controller/dashboardcontroller.php';
        $method = new DashboardController();
        $method->showDashboard();
        break;
      case 'logout':
        if (isset($_SESSION['usuario'])) {
          require __DIR__ . '/../app/controller/logincontroller.php';
          $method = new LoginController();
          $method->logout();
        }
        break;
      case 'clientes':
        require __DIR__ . '/../app/controller/clientescontroller.php';
        $method = new ClienteController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $method->registerCliente();
        } elseif (isset($_GET['id'])) {
          $method->changeStatus();
        } else {
          $method->getClients();
        }
        break;
      case 'proveedores':
        require __DIR__ . '/../app/controller/supplierscontroller.php';
        $method = new SupplierController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $method->registerSupplier();
        } elseif (isset($_GET['id'])) {
          $method->changeStatus();
        } else {
          $method->getSuppliers();
        }
        break;
      case 'categorias':
        if (isset($_SESSION['usuario'])) {
          require __DIR__ . '/../app/controller/categorycontroller.php';
          $method = new CategoryController();
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $method->registerCategory();
          } elseif (isset($_GET['id'])) {
            //$method->changeStatus();
          } else {
            $method->getCategories();
          }
        }
        break;
      case 'productos':
        if (isset($_SESSION['usuario'])) {
          require __DIR__ . '/../app/controller/productcontroller.php';
          $method = new ProductController();
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $method->registerProduct();
          } elseif (isset($_GET['id'])) {
            //$method->changeStatus();
          } else {
            $method->getProducts();
          }
        }
        break;
      default:
        echo "404";
        break;
    }
  }
}
