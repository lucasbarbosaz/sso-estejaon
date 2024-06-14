<?php
require_once(__DIR__ . "/geral.php");

$Functions::Session('conectado');

?>
<!DOCTYPE html>
<html>

<head>
	<title>Esqueci minha senha - <?= $site['nome'] ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.tailwindcss.com"></script>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<style>
	body {
		font-family: "Inter", sans-serif;
	}
</style>

<body class="w-full h-full bg-gray-100">
	<main class="flex w-full h-screen justify-center items-center">
		<div class="relative bg-white p-8 py-14 w-1/2 rounded-lg flex lg:flex-row flex-col shadow-md">
			<div class="relative flex flex-col my-2 w-full">
				<text class="text-[28px] font-semibold mb-2">Localizar o seu email</text>
				<text class="text-[15px] font-regular mb-2">Introduza o seu email de recuperação</text>
			</div>
			<div class="block relative flex flex-col w-full">
				<form method="POST">
					<div class="alert alert-success hidden" id="sendemailsuccess" role="alert"></div>
					<div id="s5jn" class="block">
						<div class="relative my-1 pb-9">
							<input type="email" id="email" name="email" class="w-full form-control !outline-none p-3 !py-[1.08rem] text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]" onfocus="document.getElementById('labelEmail').classList.add('top-2', '!text-[#000131]')" onblur="if(this.value==''){document.getElementById('labelEmail').classList.remove('top-2', '!text-[#000131]')}" required>
							<label for="email" id="labelEmail" class="absolute left-4 top-6 transform -translate-y-1 text-[13px] text-gray-400 transition-all duration-300 origin-0 select-none">E-mail</label>
							<!-- Validation -->
							<div id="errorEmail" class="select-none hidden text-red-500 font-medium text-[13px] px-1 my-1"></div>
							<?php
							if ($hCaptcha["ativado"]) { ?>
								?>
								</br>
								<div class="h-captcha" data-sitekey="<?= $hCaptcha['site_key'] ?>"></div>
							<?php } ?>
						</div>
						<div class="flex gap-3 justify-end mt-16 pt-1.5">
							<button type="button" id="nextForgot" class="select-none text-[14px] px-4 w-fit bg-[#000131] text-white p-2 rounded-full font-medium border !border-[#000131] hover:bg-white hover:!text-[#000131] transition delay-75 duration-75">Seguinte</button>
						</div>
					</div>
				</form>
			</div>
			<div class="flex absolute bottom-0 left-0">
				<svg width="146" height="129" viewBox="0 0 146 129" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle opacity="1" cx="-3.5" cy="149.5" r="119.5" stroke="#000131" stroke-width="60" />
				</svg>
			</div>
		</div>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="<?= $site["url"] ?>/assets/js/main.js?v<?= time(); ?>"></script>
	<script src="https://hcaptcha.com/1/api.js" async defer></script>
</body>

</html>