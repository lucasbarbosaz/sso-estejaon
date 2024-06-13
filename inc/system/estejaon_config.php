<?php

/* configurações da EstejaON */
$site["nome"] = "EstejaON";
$site["url"] = "http://localhost"; //sem / no final
$site["url_login"] = "http://localhost/login";
$site["max_tentativa_login"] = 5;
$site["tempo_bloqueio_login"] = 300; //5 minutos

//Single Sign-on
$ssoConfig["jwt_secretkey"] = "#axPksmXajLPi%uAxaEw%xPçVvDohS"; //nosso token (n compartilhar)


/* configurações do envio de emails */
$emailConfig["mailServerHost"] = "smtp.gmail.com";
$emailConfig["mailServerPort"] = 587;
$emailConfig["SMTPSecure"] = "TLS";
$emailConfig["mailName"] = "EstejaON (Não responda)";
$emailConfig["mailUsername"] = "testeemaillocalhostt@gmail.com";
$emailConfig["mailPassword"] = "earjhisvdvtlrykt";
$emailConfig["recoveryPassword"] = "/inc/system/templates/esqueceuasenha.html";
?>