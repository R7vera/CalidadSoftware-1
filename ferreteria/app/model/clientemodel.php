<?php
require_once __DIR__ . '/../utils/apiclient.php';
class ClienteModel
{
    private $apiClient;
    private $url;
    public $persona;
    public $persona_nrodocumento;
    public $persona_tipodocumento;
    public $persona_sexo;
    public $persona_telefono;
    public $cliente_fregistro;
    public $cliente_estatus;
    public $persona_id;
    public $cliente_id;
    public function __construct()
    {
        $this->apiClient = new ApiClient();
        $this->url = 'http://localhost/workspace/ferreteria/api/clientes';
    }

    public function getClients()
    {

        $response = $this->apiClient->setRequest('GET', $this->url);

        if (isset($response['data']) && is_array($response['data'])) {
            return $response['data'];
        }
        return false;
    }

    public function getClientesArray()
    {
        $clientesData = $this->getClients();

        if ($clientesData) {
            $clientes = [];

            foreach ($clientesData as $cliente) {
                $clientes[] = [
                    'persona' => $cliente['persona'],
                    'persona_nrodocumento' => $cliente['persona_nrodocumento'],
                    'persona_tipodocumento' => $cliente['persona_tipodocumento'],
                    'persona_sexo' => $cliente['persona_sexo'],
                    'persona_telefono' => $cliente['persona_telefono'],
                    'cliente_fregistro' => $cliente['cliente_fregistro'],
                    'cliente_estatus' => $cliente['cliente_estatus'],
                    'persona_id' => $cliente['persona_id'],
                    'cliente_id' => $cliente['cliente_id']
                ];
            }

            return $clientes;
        }
        return [];
    }

    public function registerClient($nombre, $apepat, $apemat, $ndocumento, $tdocumento, $sexo, $telefono)
    {
        $data = [
            'nombre' => $nombre,
            'apepat' => $apepat,
            'apemat' => $apemat,
            'ndocumento' => $ndocumento,
            'tdocumento' => $tdocumento,
            'sexo' => $sexo,
            'telefono' => $telefono
        ];
        return $this->apiClient->setRequest('POST', $this->url, $data);
    }

    public function changeStatus($id, $status)
    {
        $data = [
            'idcliente' => $id,
            'estatus' => $status
        ];
        return $this->apiClient->setRequest('PUT', $this->url, $data);
    }


    public function getPersona()
    {
        return $this->persona;
    }

    public function getNroDocumento()
    {
        return $this->persona_nrodocumento;
    }

    public function getTipoDocumento()
    {
        return $this->persona_tipodocumento;
    }

    public function getSexo()
    {
        return $this->persona_sexo;
    }

    public function getTelefono()
    {
        return $this->persona_telefono;
    }

    public function getFechaRegistro()
    {
        return $this->cliente_fregistro;
    }

    public function getEstatus()
    {
        return $this->cliente_estatus;
    }

    public function getPersonaId()
    {
        return $this->persona_id;
    }

    public function getClienteId()
    {
        return $this->cliente_id;
    }
}
