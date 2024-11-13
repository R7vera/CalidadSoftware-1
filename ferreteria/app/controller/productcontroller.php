<?php
require_once __DIR__ . '/../model/productmodel.php';
require_once __DIR__ . '/../model/usuariomodel.php';
class ProductController
{
    private $productModel;
    private $userModel;
    private $categoryModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->userModel = new UsuarioModel($_SESSION['usuario']);
    }

    public function getProducts()
    {
        $username = $this->userModel->getName();
        $rolname = $this->userModel->getRol();
        $userphoto = $this->userModel->getPhoto();
        $categories = $this->productModel->getComboCategory();

        $products = $this->productModel->getProductsArray();
        $unidades = $this->productModel->getComboUnidad();

        if (empty($products)) {
            $products = [];
        }

        if (empty($categories)) {
            $categories = [];
        }

        if (empty($unidades)) {
            $unidades = [];
        }

        require __DIR__ . '/../views/productos.php';
    }

    public function registerProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productName = $_POST['producto_nombre'];
            $productPresentation = $_POST['producto_presentacion'];
            $categoryId = $_POST['categoria_id'];
            $unitId = $_POST['unidad_id'];
            $productPrice = $_POST['producto_precio'];

            $imgRute = null;
            if (isset($_FILES['producto_imagen']) && $_FILES['producto_imagen']['error'] === UPLOAD_ERR_OK) {
                $imgPath = __DIR__ . '/../img/' . basename($_FILES['producto_imagen']['name']);

                if (move_uploaded_file($_FILES['producto_imagen']['tmp_name'], $imgPath)) {

                    $imgRute = '/ferreteria/app/img/' . basename($_FILES['producto_imagen']['name']);
                } else {
                    echo "Error al mover el archivo subido.";
                    return;
                }
            }
            if ($this->productModel->registerProduct($productName, $productPresentation, $categoryId, $unitId, $productPrice, $imgRute)) {
                header("Location: productos");
                exit();
            } else {
                echo "Error al registrar el producto.";
            }
        }
    }
}
