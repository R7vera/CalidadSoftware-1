<?php

class ApiClient{
  public function setRequest($method, $endpoint, $data = null){
    $opt = [
      'http' => [
        'header' => "Content-type: application/json\r\n",
        'method' => $method,
        'content' => $data ? json_encode($data) : null, 
      ],
    ];
    $context = stream_context_create($opt);
    $result = @file_get_contents($endpoint, false, $context);

    if ($result === false) {
      return ["Error" => "Error al realizar la solicitud a la API"];
    }

    return json_decode($result, true);
  }
}

?>
