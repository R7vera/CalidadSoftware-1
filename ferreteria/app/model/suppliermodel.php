<?php
include_once __DIR__ . '/../utils/apiclient.php';

class SupplierModel
{
  private $apiClient;
  private $url;
  public function __construct()
  {
    $this->apiClient = new ApiClient();
    $this->url = 'http://localhost/workspace/ferreteria/api/proveedores';
  }

  public function getSuppliers()
  {
    $response = $this->apiClient->setRequest('GET', $this->url);
    if (isset($response['data']) && is_array($response['data'])) {
      return $response['data'];
    }
    return false;
  }

  public function getSuppliersArray()
  {
    $suppliersData = $this->getSuppliers();

    if ($suppliersData) {
      $suppliers = [];

      foreach ($suppliersData as $supplier) {
        $suppliers[] = [
          'proveedor_numcontacto' => $supplier['proveedor_numcontacto'],
          'proveedor_contacto' => $supplier['proveedor_contacto'],
          'persona' => $supplier['persona'],
          'persona_nrodocumento' => $supplier['persona_nrodocumento'],
          'persona_tipodocumento' => $supplier['persona_tipodocumento'],
          'persona_sexo' => $supplier['persona_sexo'],
          'persona_id' => $supplier['persona_id'],
          'proveedor_id' => $supplier['proveedor_id'],
          'proveedor_estatus' => $supplier['proveedor_estatus'],
          'proveedor_razonsocial' => $supplier['proveedor_razonsocial']
        ];
      }

      return $suppliers;
    }
    return [];
  }


  public function registerSuppliers($nombre, $apepat, $apemat, $ndocumento, $tdocumento, $sexo, $telefono, $razonsocial, $nomcontacto, $numcontacto)
  {
    $data = [
      'nombre' => $nombre,
      'apepat' => $apepat,
      'apemat' => $apemat,
      'ndocumento' => $ndocumento,
      'tdocumento' => $tdocumento,
      'sexo' => $sexo,
      'telefono' => $telefono,
      'razonsocial' => $razonsocial,
      'nomcontacto' => $nomcontacto,
      'numcontacto' => $numcontacto
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
