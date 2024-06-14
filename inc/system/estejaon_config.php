<?php

/* configurações da EstejaON */
$site["nome"] = "EstejaON";
$site["url"] = "http://localhost"; //sem / no final
$site["url_login"] = "http://localhost/login";
$site["max_tentativa_login"] = 5;
$site["tempo_bloqueio_login"] = 300; //5 minutos

//Single Sign-on
$ssoConfig["jwt_secretkey"] = "#axPksmXajLPi%uAxaEw%xPçVvDohS"; //nosso token (n compartilhar)

//hCaptcha configurações
$hCaptcha["ativado"] = true;
$hCaptcha["site_key"] = "09d20fd6-1838-4cd6-80fa-9d6a0ce49484";
$hCaptcha["secret_key"] = "ES_12ee3e12a9d24a30b51d45f5b0c46e87";

/* configurações do envio de emails */
$emailConfig["mailServerHost"] = "smtp.gmail.com";
$emailConfig["mailServerPort"] = 587;
$emailConfig["SMTPSecure"] = "TLS";
$emailConfig["mailName"] = "EstejaON (Não responda)";
$emailConfig["mailUsername"] = "testeemaillocalhostt@gmail.com";
$emailConfig["mailPassword"] = "earjhisvdvtlrykt";
$emailConfig["recoveryPassword"] = "/inc/system/templates/esqueceuasenha.html";
?>