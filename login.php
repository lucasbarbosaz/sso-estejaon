<?php
define('ROOT', __DIR__. '/');
require_once(ROOT. '/inc/system/config.php');

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Iniciar Sessão - <?php echo SITE_NAME; ?> </title>
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
          <text class="text-[28px] font-semibold mb-2">Inicie Sessão</text>
          <text id="s9nk" class="text-[15px] font-regular mb-2">Use a sua Conta EstejaON</text>
          <div id="b3jk" class="hidden flex border border-gray-400 rounded-full px-1 w-fit items-center my-2 cursor-pointer">
            <div class="flex icon">
              <svg aria-hidden="true" class="Qk3oof" fill="currentColor" focusable="false" width="24" height="24" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm6.36 14.83c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6z"></path>
              </svg>
            </div>
            <span class="text-[13px] font-medium px-2" id="skj2"></span>
            <div>
              <svg aria-hidden="true" class="Qk3oof u4TTuf" fill="currentColor" focusable="false" width="15px" height="15px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                <path d="M7 10l5 5 5-5z"></path>
              </svg>
            </div>
          </div>
        </div>
        <div class="relative flex flex-col my-2 w-full !z-10">
          <form method="POST" id="loginForm" class="block">
            <div class="relative my-1" id="s2jn">
              <input type="email" id="email" name="email" class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]" onfocus="document.getElementById('labelEmail').classList.add('!top-[-5px]', '!text-[#000131]')" onblur="if(this.value==''){document.getElementById('labelEmail').classList.remove('!top-[-5px]', '!text-[#000131]')}" required>
              <label for="email" id="labelEmail" class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">E-mail</label>
              <!-- Validation -->
              <div id="errorEmail" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1">Digite um e-mail válido!</div>
            </div>
            <div class="hidden relative my-1" id="s0jn">
              <input type="password" id="senha" name="senha" class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]" onfocus="document.getElementById('labelSenha').classList.add('!top-[-5px]', '!text-[#000131]')" onblur="if(this.value==''){document.getElementById('labelSenha').classList.remove('!top-[-5px]', '!text-[#000131]')}" required>
              <label for="senha" id="labelSenha" class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Senha</label>
              <!-- Validation -->
              <div id="errorSenha" class="select-none hidden text-red-500 font-medium text-[13px] px-1 my-1">Você precisa digitar um e-mail válido!</div>
            </div>
            <div class="flex flex-col px-1 my-2">
              <a href="" id="sjw0" class="mb-3 text-[13px] hover:bg-[#0001310a] w-fit rounded-lg cursor-pointer font-semibold select-none">Esqueceu sua senha?</a>
              <text class="text-gray-500 text-[13px] select-none">Este computador não é seu? Utilize o modo convidado para iniciar sessão de forma privada.</text>
            </div>
            <div class="flex gap-3 justify-end mt-4">
              <div id="createAccount" class="select-none text-[14px] px-4 text-center w-fit hover:bg-[#0001311a] text-[#000131] p-2 rounded-full font-medium hover:!text-[#000131] transition delay-75 duration-75 cursor-pointer"> Criar conta <div class="hidden absolute dropdown w-fit bg-[#c9c9e1] rounded-lg bottom-[-125px] right-[6.5rem] shadow-md">
                  <ul class="py-2 text-[14px]">
                    <li class="p-3 px-4 hover:bg-[#0001311a] font-medium cursor-pointer" id="usePessoal">Para uso pessoal</li>
                    <li class="p-3 px-4 hover:bg-[#0001311a] font-medium cursor-pointer" id="useBusiness">Para empresas</li>
                  </ul>
                </div>
              </div>
              <button type="button" id="next-btn" class="select-none text-[14px] px-4 w-fit bg-[#000131] text-white p-2 rounded-full font-medium border !border-[#000131] hover:bg-white hover:!text-[#000131] transition delay-75 duration-75">Seguinte</button>
            </div>
          </form>
          <!-- Formulário Registro Empresas -->
          <form method="POST" id="registerBusiness" class="hidden">
            <div class="block" id="j22jn">
              <div class="relative my-1 mb-3" id="s2jn">
                <input type="text" id="name" name="name" class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]" onfocus="document.getElementById('labelName').classList.add('!top-[-5px]', '!text-[#000131]')" onblur="if(this.value==''){document.getElementById('labelName').classList.remove('!top-[-5px]', '!text-[#000131]')}" required>
                <label for="email" id="labelName" class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Nome</label>
                <!-- Validation -->
                <div id="errorEmail" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1">Digite um e-mail válido!</div>
              </div>
              <div class="relative my-1 mb-3" id="s2jn">
                <input type="text" id="apelido" name="apelido" class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]" onfocus="document.getElementById('labelApelido').classList.add('!top-[-5px]', '!text-[#000131]')" onblur="if(this.value==''){document.getElementById('labelApelido').classList.remove('!top-[-5px]', '!text-[#000131]')}">
                <label for="email" id="labelApelido" class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Apelido (opcional)</label>
                <!-- Validation -->
                <div id="errorEmail" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1">Digite um e-mail válido!</div>
              </div>
              <button type="button" id="avanceBtn" class="select-none text-[14px] px-4 w-fit bg-[#000131] text-white p-2 rounded-full font-medium border !border-[#000131] hover:bg-white hover:!text-[#000131] transition delay-75 duration-75 float-right right-0">Avançar</button>
            </div>
            <div class="hidden" id="j23jn">
              <div class="flex flex-wrap gap-2 w-full">
                <div class="relative my-1 mb-3" id="s2jn">
                  <input type="text" id="birthdaydia" name="birthdaydia" class="w-full md:w-[144px] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]" onfocus="document.getElementById('labelDiaBirthday').classList.add('!top-[-5px]', '!text-[#000131]')" onblur="if(this.value==''){document.getElementById('labelDiaBirthday').classList.remove('!top-[-5px]', '!text-[#000131]')}" required>
                  <label for="birthdaydia" id="labelDiaBirthday" class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Dia</label>
                </div>
                <div class="relative my-1 mb-3" id="s2jn">
                  <select id="birthdaymes" name="birthdaymes" class="w-full md:w-[144px] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]" onfocus="document.getElementById('labelMesBirthday').classList.add('!top-[-5px]', '!text-[#000131]')" onblur="if(this.value==''){document.getElementById('labelMesBirthday').classList.remove('!top-[-5px]', '!text-[#000131]')}" required>
                    <option value="" disabled selected hidden></option>
                    <option value="01">Janeiro</option>
                    <option value="02">Fevereiro</option>
                    <option value="03">Março</option>
                    <option value="04">Abril</option>
                    <option value="05">Maio</option>
                    <option value="06">Junho</option>
                    <option value="07">Julho</option>
                    <option value="08">Agosto</option>
                    <option value="09">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                  </select>
                  <label for="birthdaymes" id="labelMesBirthday" class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Mês</label>
                </div>
                <div class="relative my-1 mb-3" id="s2jn">
                  <input type="text" id="birthdayano" name="birthdayano" class="w-full md:w-[144px] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]" onfocus="document.getElementById('labelAnoBirthday').classList.add('!top-[-5px]', '!text-[#000131]')" onblur="if(this.value==''){document.getElementById('labelAnoBirthday').classList.remove('!top-[-5px]', '!text-[#000131]')}" required>
                  <label for="birthdayano" id="labelAnoBirthday" class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Ano</label>
                </div>
              </div>
				<div class="relative my-1 mb-3" id="s2jn">
				 	<select id="gender" name="gender" class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]" onfocus="document.getElementById('labelGender').classList.add('!top-[-5px]', '!text-[#000131]')" onblur="if(this.value==''){document.getElementById('labelGender').classList.remove('!top-[-5px]', '!text-[#000131]')}" required>
						<option value="" disabled selected hidden></option>
						<option value="masculino">Masculino</option>
						<option value="feminino">Feminino</option>
						<option value="nao-binario">Não-binário</option>
						<option value="outro">Outro</option>
						<option value="prefiro-nao-dizer">Prefiro não dizer</option>
					</select>
					<label for="gender" id="labelGender" class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Gênero</label>
                </div>
				<button type="button" id="avanceBtn" class="select-none text-[14px] px-4 w-fit bg-[#000131] text-white p-2 rounded-full font-medium border !border-[#000131] hover:bg-white hover:!text-[#000131] transition delay-75 duration-75 float-right right-0">Concluir</button>
            </div>
          </form>
        </div>
        <div class="flex absolute bottom-0 left-0 z-0">
          <svg width="146" height="129" viewBox="0 0 146 129" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle opacity="1" cx="-3.5" cy="149.5" r="119.5" stroke="#000131" stroke-width="60" />
          </svg>
        </div>
      </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/assets/js/main.js?v=<?= time(); ?>"></script>
  </body>
</html>