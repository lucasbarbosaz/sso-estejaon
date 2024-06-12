<?php
	require_once('phpmailer/PHPMailer.php');
	require_once('phpmailer/SMTP.php');
	require_once('phpmailer/Exception.php');

	class Email {

		public static function enviarEmail($destinatario, $assunto, $corpo) {
			global $emailConfig;

			try {

				$mail = new PHPMailer\PHPMailer\PHPMailer();
				// Configurações do servidor
				$mail->SMTPDebug = 0;										// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
				$mail->isSMTP();											// Define mailer para usar SMTP
				$mail->Host = 'smtp.gmail.com';								// Especifica o servidor SMTP principal
				$mail->SMTPAuth = true;										// Ativa autenticação SMTP
				$mail->Username = $emailConfig['mailUsername'];					// Nome de usuário SMTP
				$mail->Password = $emailConfig['mailPassword'];					// Senha SMTP
				$mail->SMTPSecure = $emailConfig['SMTPSecure'];					// Ativa criptografia TLS, também aceita `ssl`
				$mail->Port = $emailConfig['mailServerPort'];						// Porta TCP para conectar
				$mail->setLanguage('pt_br');

				// Remetente
				$mail->setFrom($emailConfig['mailUsername'], $emailConfig['mailName']);	// E-mail do Rementente, Nome do Remetente (opcional)

				// Destinatário(s)
				$mail->addAddress($destinatario);							// Adiciona um destinatário (pode ter mais de um)
				
				// Conteúdo
				$mail->isHTML(true);										// Define o formato do e-mail como HTML
				$mail->CharSet = 'UTF-8';									// Define o CharSet como UTF-8
				$mail->Subject = $assunto;									// Assunto do e-mail que será enviado
				$mail->Body	= $corpo;										// Corpo do e-mail que será enviado
				
				$mail->send();												// Por fim, envia o e-mail
				return true;												// Tudo deu certo, retorna true
			} catch (Exception $e) {
				echo false;													// Algo deu errado, retorna false
			}
		}

	}
?>