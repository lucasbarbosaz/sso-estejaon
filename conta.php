<?php
require_once(__DIR__ . "/geral.php");

$Functions::Session("desconectado");
?>
<!DOCTYPE html>
<html>
<head>
	<title>EstejaON Conta</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 	integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> <!-- jQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script> <!-- jQuery InputMask -->
</head>
<style>
	body {
		font-family: "Inter", sans-serif;
	}
</style>
<body class="w-full h-full bg-gray-100">
	<main>
		<header>
			<nav class="navbar navbar-expand-lg bg-white shadow-md fixed-top">
				<div class="container-fluid p-2 !px-10">
					<a class="navbar-brand" href="#">
						<img src="./assets/img/logo.svg" width="120" height="40">
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					  <span class="navbar-toggler-icon"></span>
					</button>
					<div class="navbar-collapse justify-between" id="navbarText">
						<div class="navbar-nav mx-auto mb-2 mb-lg-0">
							<svg class="absolute m-[10px]" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.755 15.565 14.25 12.06a.84.84 0 0 0-.598-.247h-.573a7.28 7.28 0 0 0 1.547-4.5A7.31 7.31 0 0 0 7.313 0 7.31 7.31 0 0 0 0 7.313a7.31 7.31 0 0 0 7.313 7.313 7.27 7.27 0 0 0 4.5-1.547v.573c0 .225.088.44.246.598l3.506 3.505a.84.84 0 0 0 1.192 0l.995-.995c.33-.33.33-.865.003-1.195M7.313 11.813a4.5 4.5 0 0 1-4.5-4.5c0-2.486 2.01-4.5 4.5-4.5 2.486 0 4.5 2.01 4.5 4.5 0 2.486-2.01 4.5-4.5 4.5" fill="#a8a8ae"/></svg>
							<input type="text" class="form-control outline-none p-2.5 !px-[36px] lg:w-[350px] sm:w-[200px] text-[14px] border-none bg-[#f7f8fa]" placeholder="Pesquise em sua conta EstejaON">
						</div>
					  <div class="flex items-center gap-4">
						<div class="notification flex gap-2 items-center cursor-pointer">
							<svg width="20" height="23" viewBox="0 0 20 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 22.857A2.857 2.857 0 0 0 12.856 20H7.144A2.857 2.857 0 0 0 10 22.857m9.616-6.683c-.863-.927-2.477-2.321-2.477-6.888 0-3.469-2.432-6.246-5.711-6.927v-.93a1.428 1.428 0 1 0-2.856 0v.93c-3.28.681-5.711 3.458-5.711 6.927 0 4.567-1.614 5.96-2.477 6.888a1.4 1.4 0 0 0-.384.969 1.43 1.43 0 0 0 1.433 1.428h17.134A1.43 1.43 0 0 0 20 17.143a1.4 1.4 0 0 0-.384-.97" fill="#393C3F"/></svg>
							<div class="hidden nfQt px-2.5 bg-[#393C3F] text-white text-[14px] rounded-pill font-medium">5</div>
						</div>
						<div class="avatar w-9 cursor-pointer">
							<img src="https://i.pinimg.com/75x75_RS/b6/ef/b5/b6efb5cabfbb89935b1e9b02f3f9599c.jpg" class="rounded-full">
						</div>
					  </span>
					</div>
				</div>
			</nav>
		</header>
		<div class="lg:block hidden text-white h-full w-full flex-1 flex mt-20">
			<div class="lg:block hidden -translate-x-full min-h-screen fixed md:translate-x-0 z-50 md:w-[20rem] truncate duration-1000 md:block transition-all">
				<div class="py-5 px-4 flex flex-col">
					<button class="cursor-pointer m-2 text-[#8d8d95] text-[14px] !font-medium flex justify-between">
						<span>General</span>
					</button>
					<div class="flex flex-col gap-1">
						<a href="index.html" class="text-[#474a4d] hover:text-[#474a4d] hover:bg-[#e0e1e4] rounded-lg min-w-full py-1.5 px-2 flex gap-2 items-center opacity-75 hover:!opacity-100">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 0C4.476 0 0 4.476 0 10s4.476 10 10 10 10-4.476 10-10S15.524 0 10 0m0 3.871a3.548 3.548 0 1 1 0 7.097 3.548 3.548 0 0 1 0-7.097m0 13.87a7.73 7.73 0 0 1-5.907-2.75c.758-1.426 2.242-2.41 3.972-2.41q.145.001.286.044c.524.17 1.072.278 1.649.278s1.129-.109 1.65-.278a1 1 0 0 1 .285-.044c1.73 0 3.214.984 3.972 2.41A7.73 7.73 0 0 1 10 17.742" fill="#3D4043"/></svg>
							<span class="false font-medium text-[14px]">Página Inicial</span>
						</a>
						<a href="conta.html" class="text-[#474a4d] hover:text-[#474a4d] hover:bg-[#e0e1e4] rounded-lg min-w-full py-1.5 px-2 flex gap-2 items-center opacity-75 hover:!opacity-100">
							<svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.333 0H1.667C.747 0 0 .747 0 1.667v12.222c0 .92.747 1.667 1.667 1.667h16.666c.92 0 1.667-.747 1.667-1.667V1.667C20 .747 19.253 0 18.333 0m0 13.889H1.667V1.667h16.666zM7.223 7.778a2.224 2.224 0 0 0 2.221-2.222 2.224 2.224 0 0 0-2.222-2.223A2.224 2.224 0 0 0 5 5.556c0 1.225.997 2.222 2.222 2.222M4.11 12.222h6.222c.43 0 .778-.298.778-.666v-.667c0-1.104-1.045-2-2.333-2-.375 0-.65.278-1.556.278-.934 0-1.16-.278-1.555-.278-1.289 0-2.334.896-2.334 2v.667c0 .368.348.666.778.666M12.5 10h3.889a.28.28 0 0 0 .278-.278v-.555a.28.28 0 0 0-.278-.278H12.5a.28.28 0 0 0-.278.278v.555c0 .153.125.278.278.278m0-2.222h3.889a.28.28 0 0 0 .278-.278v-.556a.28.28 0 0 0-.278-.277H12.5a.28.28 0 0 0-.278.277V7.5c0 .153.125.278.278.278m0-2.222h3.889a.28.28 0 0 0 .278-.278v-.556a.28.28 0 0 0-.278-.278H12.5a.28.28 0 0 0-.278.278v.556c0 .153.125.278.278.278" fill="#393C3F"/></svg>
							<span class="false font-medium text-[14px]">Informações pessoais</span>
						</a>
						<a href="pagamentos.html" class="hidden text-[#474a4d] hover:text-[#474a4d] hover:bg-[#e0e1e4] rounded-lg min-w-full py-1.5 px-2 flex gap-2 items-center opacity-75 hover:!opacity-100">
							<svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.33 0H1.67C.747 0 0 .747 0 1.667v12.222c0 .92.747 1.667 1.67 1.667h16.66c.924 0 1.67-.747 1.67-1.667V1.667C20 .747 19.253 0 18.33 0M1.878 1.667h16.244c.114 0 .208.093.208.208v1.458H1.67V1.875c0-.115.094-.208.208-.208m16.244 12.222H1.878a.21.21 0 0 1-.208-.208V7.778h16.66v5.903a.21.21 0 0 1-.208.208M6.667 10.417v1.389a.42.42 0 0 1-.417.416h-2.5a.42.42 0 0 1-.417-.416v-1.39c0-.229.188-.416.417-.416h2.5c.23 0 .417.188.417.417m6.666 0v1.389a.417.417 0 0 1-.416.416H8.194a.42.42 0 0 1-.416-.416v-1.39c0-.229.187-.416.416-.416h4.723c.229 0 .416.188.416.417" fill="#292929"/></svg>
							<span class="false font-medium text-[14px]">Pagamentos e assinaturas</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="flex-1 lg:pl-[20rem] flex flex-col justify-between gap-4 lg:mt-0 sm:mt-20">
			<div class="flex flex-col mx-auto lg:max-w gap-5 w-full">
				<div class="w-full p-3">
					<div class="lg:w-[750px] w-full h-auto bg-white rounded-lg p-4 shadow-md">
						<div class="flex flex-col border-b border-gray-200 pb-3">
							<text class="font-semibold py-1 text-[25px]">Informações Pessoais</text>
							<text class="text-[15px] text-gray-500 font-medium">Alguns dados podem ser acessíveis a outros usuários da EstejaON.</text>
						</div>
						<div class="flex flex-col my-2 w-full">
							<div class="flex lg:flex-row flex-col justify-between gap-3 my-2.5">
								<div class="flex w-full items-center gap-3">
									<div class="img">
										<img src="https://i.pinimg.com/75x75_RS/b6/ef/b5/b6efb5cabfbb89935b1e9b02f3f9599c.jpg" class="rounded-full" width="60" height="60">
									</div>
									<div class="flex flex-col">
										<text class="text-[14px] font-medium">Profile Picture</text>
										<text class="text-[13px]">PNG, JPG, GIF max size 5MB</text>
									</div>
								</div>
							</div>
							<div class="flex lg:flex-row flex-col justify-between gap-3 my-2.5">
								<div class="flex flex-col w-full">
									<label class="text-[14px] pb-2 px-1 font-medium">Nome</label>
									<input type="text" class="form-control !outline-none py-2.5 text-[13px] text-[#47494d] font-medium shadow-none !rounded border-2 border-[#eceeef] focus:border-[#000131]" 
									value="<?= $usuario['nome'] ?>">
								</div>
								<div class="flex flex-col w-full">
									<label class="text-[14px] pb-2 px-1 font-medium">Apelido</label>
									<input type="text" class="form-control !outline-none py-2.5 text-[13px] text-[#47494d] font-medium shadow-none !rounded border-2 border-[#eceeef] focus:border-[#000131]" 
									value="<?= $usuario['apelido'] ?>">
								</div>
							</div>
							<div class="flex lg:flex-row flex-col justify-between gap-3 my-2.5">
								<div class="flex flex-col w-full">
									<label class="text-[14px] pb-2 px-1 font-medium">Data de nascimento</label>
									<input type="text" class="form-control !outline-none py-2.5 text-[13px] text-[#47494d] font-medium shadow-none !rounded border-2 border-[#eceeef] focus:border-[#000131]" 
									value="00/00/0000" id="aniversario">
								</div>
								<div class="flex flex-col w-full">
									<label class="text-[14px] pb-2 px-1 font-medium">Gênero</label>
									<select class="form-control !outline-none py-2.5 text-[13px] text-[#47494d] font-medium shadow-none !rounded border-2 border-[#eceeef] focus:border-[#000131]">
									<option value="1" selected>Feminino</option>
									<option value="2">Masculino</option>
									<option value="3">Prefiro não dizer</option>
									</select>
								</div>
							</div>
							<div class="flex lg:flex-row flex-col justify-between gap-3 my-2.5">
								<div class="flex flex-col w-full">
									<label class="text-[14px] pb-2 px-1 font-medium">CPF <span class="text-gray-600 text-[13px]">(Opcional)</span></label>
									<input type="text" class="form-control !outline-none py-2.5 text-[13px] text-[#47494d] font-medium shadow-none !rounded border-2 border-[#eceeef] focus:border-[#000131]" 
									value="000.000.000-00" id="cpf">
								</div>
								<div class="flex flex-col w-full">
									<label class="text-[14px] pb-2 px-1 font-medium">RG <span class="text-gray-600 text-[13px]">(Opcional)</span></label>
									<input type="text" class="form-control !outline-none py-2.5 text-[13px] text-[#47494d] font-medium shadow-none !rounded border-2 border-[#eceeef] focus:border-[#000131]" 
									value="00.000.000-0" id="rg">
								</div>
							</div>
							<div class="flex lg:flex-row flex-col justify-between gap-3 my-2.5">
								<div class="flex flex-col w-full">
									<label class="text-[14px] pb-2 px-1 font-medium">E-mail</label>
									<input type="email" class="form-control !outline-none py-2.5 text-[13px] text-[#47494d] font-medium shadow-none !rounded border-2 border-[#eceeef] focus:border-[#000131]" 
									value="marra@marra.in">
								</div>
							</div>
							<div class="flex lg:flex-row flex-col justify-between gap-3 my-2.5">
								<div class="flex flex-col w-full">
									<label class="text-[14px] pb-2 px-1 font-medium">Telefone</label>
									<input type="phone" class="form-control !outline-none py-2.5 text-[13px] text-[#47494d] font-medium shadow-none !rounded border-2 border-[#eceeef] focus:border-[#000131]" 
									value="(99) 99999-9999" id="phone">
								</div>
							</div>
							<div class="flex lg:flex-row flex-col justify-between gap-3 my-2.5 items-center">
								<div class="flex flex-row sm:flex-col w-full gap-4">
									<button class="hidden text-[15px] font-medium cursor-pointer">Alterar senha</button>
									<button class="btn text-[14px] text-red-400 !border-red-400 hover:!text-red-400 !rounded-[5px] px-4">Alterar para Empresarial</button>
								</div>
								<div class="flex flex-col w-full items-end">
									<button class="btn bg-[#000131] text-white w-max border hover:bg-white hover:!border-[#000131] hover:!text-[#000131] !rounded-[5px] px-4">Atualizar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 	integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 	crossorigin="anonymous"></script>
	<script src="./assets/js/inputmask.js"></script>
</body>
</html>