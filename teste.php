<?php
$api_url = 'http://localhost/api/change-password';
$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE3MTg1MTcyOTAsImV4cCI6MTcyMTEwOTI5MCwic3ViIjoyfQ.NycAoSX4fqPkyb9SLRrRdlAEIw1ZQnWB3uiwZpPwLNA";

$data = array(
   'user_id' => "1",
   'old_password' => "123456",
   'new_password' => "123456"
);

// Configurar a requisição cURL
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   'Content-Type: application/json',
   'Authorization: Bearer ' . $token
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Depuração: exibir as opções do cURL
curl_setopt($ch, CURLOPT_VERBOSE, true);

// Executar a requisição e obter a resposta
$response = curl_exec($ch);
curl_close($ch);

?>
