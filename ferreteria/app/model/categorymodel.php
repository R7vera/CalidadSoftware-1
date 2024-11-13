<?php
include_once __DIR__ . '/../utils/apiclient.php';

class CategoryModel
{
  private $apiClient;
  private $url;
  public function __construct()
  {
    $this->apiClient = new ApiClient();
    $this->url = 'http://localhost/workspace/ferreteria/api/categorias';
  }

  public function getCategories()
  {
    $response = $this->apiClient->setRequest('GET', $this->url);
    if (isset($response['data']) && is_array($response['data'])) {
      return $response['data'];
    }
    return false;
  }

  public function getCategoriesArray()
  {
    $categoriesData = $this->getCategories();

    if ($categoriesData) {
      $categories = [];

      foreach ($categoriesData as $category) {
        $categories[] = [
          'categoria_id' => $category['categoria_id'],
          'categoria_nombre' => $category['categoria_nombre'],
          'categoria_fregistro' => $category['categoria_fregistro'],
          'categoria_estatus' => $category['categoria_estatus']
        ];
      }

      return $categories;
    }
    return [];
  }

  public function registerCategory($categoria_nombre)
  {
    $data = [
      'categoria_nombre' => $categoria_nombre
    ];

    return $this->apiClient->setRequest('POST', $this->url, $data);
  }

  public function changeStatus($id, $status)
  {
    $data = [
      'idproveedor' => $id,
      'estatus' => $status
    ];
    return $this->apiClient->setRequest('PATCH', $this->url, $data);
  }
}
