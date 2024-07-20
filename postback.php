  <?php

  require_once 'lib/vendor/autoload.php';

  use MercadoPago\MercadoPagoConfig;
  use MercadoPago\Client\Payment\PaymentClient;

  $access_token = "TEST-553454966659450-062619-e11170e12868a533976f6d33771546c7-1499191859";
  MercadoPagoConfig::setAccessToken($access_token);


  $body = json_decode(file_get_contents('php://input'));

  if (isset($body->data->id)) {
    $id      = $body->data->id;

    $client  = new PaymentClient();

    $payment = $client->get($id);

    if (isset($payment->id)) {
      if ($payment->status) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dicasdaqui";


        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $ref = $payment->external_reference;
          $status = $payment->status;

          $conn->prepare("UPDATE package_purchased_history SET status = ? WHERE ref = ?")->execute([$status, $ref]);
        } catch (PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
      }

      $payment_class->setStatusPayment($payment->status);
    }
  }
