<?php
include_once __DIR__ . '/../utils/apiclient.php';

class ProductModel
{
  private $apiClient;
  private $url;
  public function __construct()
  {
    $this->apiClient = new ApiClient();
    $this->url = 'http://localhost/workspace/ferreteria/api/productos';
  }

  public function getProducts()
  {
    $response = $this->apiClient->setRequest('GET', $this->url);
    if (isset($response['data']) && is_array($response['data'])) {
      return $response['data'];
    }
    return false;
  }

  public function getProductsArray()
  {
    $productData = $this->getProducts();

    if ($productData) {
      $products = [];

      foreach ($productData as $product) {
        $products[] = [
          'producto_id' => $product['producto_id'],
          'producto_nombre' => $product['producto_nombre'],
          'producto_presentacion' => $product['producto_presentacion'],
          'producto_stock' => $product['producto_stock'],
          'categoria_id' => $product['categoria_id'],
          'unidad_id' => $product['unidad_id'],
          'producto_foto' => $product['producto_foto'],
          'producto_precioventa' => $product['producto_precioventa'],
          'producto_estatus' => $product['producto_estatus'],
          'unidad_nombre' => $product['unidad_nombre'],
          'categoria_nombre' => $product['categoria_nombre']
        ];
      }

      return $products;
    }
    return [];
  }

  public function registerProduct($producto, $presentacion, $categoria, $unidad, $precio, $ruta)
  {
    $data = [
      'producto' => $producto,
      'presentacion' => $presentacion,
      'categoria' => $categoria,
      'unidad' => $unidad,
      'precio' => $precio,
      'ruta' => $ruta
    ];

    var_dump($data);

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

  public function getComboCategory()
  {
    $url = $this->url . '/combo_categoria';
    $response = $this->apiClient->setRequest('GET', $url);
    if (isset($response['data']) && is_array($response['data'])) {
      return $response['data'];
    }
    return false;
  }

  public function getComboUnidad()
  {
    $url = $this->url . '/combo_unidad';
    $response = $this->apiClient->setRequest('GET', $url);
    if (isset($response['data']) && is_array($response['data'])) {
      return $response['data'];
    }
    return false;
  }
}
