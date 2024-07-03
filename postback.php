<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET)) {
  $tipo = $_GET['type'];
  $ref = $_GET['ref'];

  if ($tipo == "package") {
    $body   = json_decode(file_get_contents('php://input'));

    if (isset($body->data->id)) {

      $id = $body->data->id;

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/' . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Authorization: Bearer TEST-553454966659450-062619-e11170e12868a533976f6d33771546c7-1499191859'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);

      $payment = json_decode($response);

      if (isset($payment->id)) {

        //abaixo crie uma conexão com banco de dados com pdo
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dicasdaqui";

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $conn->prepare("UPDATE package_purchased_history SET status = ? WHERE ref = ?")->execute([$payment->status, $ref]);
        } catch (PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
      }
    }
  }
}
