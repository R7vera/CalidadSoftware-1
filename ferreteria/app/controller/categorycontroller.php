<?php
require_once __DIR__ . '/../model/categorymodel.php';
require_once __DIR__ . '/../model/usuariomodel.php';
class CategoryController
{
    private $categoryModel;
    private $userModel;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UsuarioModel($_SESSION['usuario']);
    }

    public function getCategories()
    {
        $username = $this->userModel->getName();
        $rolname = $this->userModel->getRol();
        $userphoto = $this->userModel->getPhoto();

        $categories = $this->categoryModel->getCategoriesArray();

        if (empty($categories)) {
            $category = [];
        }

        require __DIR__ . '/../views/categorias.php';
    }

    public function registerCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryName = $_POST['nombre'];
            if ($this->categoryModel->registerCategory(
                $categoryName
            )) {
                header("Location: categorias");
                exit();
            }
        }
    }
}
