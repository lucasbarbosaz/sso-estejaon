<?php
require_once (__DIR__ . "/geral.php");

$Functions::Session("conectado");

$confirmeLogin = false;
$mensagem = "";

if (isset($_GET['params'])) {
  $encryptedParams = $_GET['params'];
  $decryptedParams = decryptParameter($encryptedParams);

  if ($decryptedParams !== false) {
    $params = json_decode($decryptedParams, true);

    if (json_last_error() === JSON_ERROR_NONE) {

      $tempo_atual = time();
      $tempo_expiracao = 300; //5 minutos para essa url expirar

      if (isset($params['t']) && ($tempo_atual - $params['t']) < $tempo_expiracao) {
        if ($params['r'] == "senha_atualizada") {
          $confirmeLogin = true;
          $mensagem = $params['m'];
        }
      } else {
        Redirect("/");
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Iniciar Sessão - <?php echo SITE_NAME; ?> </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<style>
  body {
    font-family: "Inter", sans-serif;
  }

  .input-field-cpf {
    display: none;
  }

  .input-field-cnpj {
    display: none;
  }
</style>

<body class="w-full h-full bg-gray-100">
  <main class="flex w-full h-screen justify-center items-center">
    <div class="relative bg-white p-8 py-14 w-1/2 rounded-lg flex lg:flex-row flex-col shadow-md">
      <div class="relative flex flex-col my-2 w-full">
        <text class="text-[28px] font-semibold mb-2">Inicie Sessão</text>
        <text id="s9nk" class="text-[15px] font-regular mb-2">Use a sua Conta EstejaON</text>
        <div id="b3jk"
          class="hidden flex border border-gray-400 rounded-full px-1 w-fit items-center my-2 cursor-pointer">
          <div class="flex icon">
            <svg aria-hidden="true" class="Qk3oof" fill="currentColor" focusable="false" width="24" height="24"
              viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm6.36 14.83c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6z">
              </path>
            </svg>
          </div>
          <span class="text-[13px] font-medium px-2" id="skj2"></span>
          <div>
            <svg aria-hidden="true" class="Qk3oof u4TTuf" fill="currentColor" focusable="false" width="15px"
              height="15px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
              <path d="M7 10l5 5 5-5z"></path>
            </svg>
          </div>
        </div>
      </div>
      <div class="relative flex flex-col my-2 w-full !z-10">
        <form method="POST" id="loginForm" class="block">
          <?php if ($confirmeLogin) { ?>
            <div class="alert alert-success" id="resetpasswordsuccess" role="alert">
              <?= $mensagem; ?>
            </div>
          <?php } ?>


          
          <div class="relative my-1" id="s2jn">

            <input type="email" id="email-login" name="email-login"
              class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
              onfocus="document.getElementById('labelEmail').classList.add('!top-[-5px]', '!text-[#000131]')"
              onblur="if(this.value==''){document.getElementById('labelEmail').classList.remove('!top-[-5px]', '!text-[#000131]')}"
              required>
            <label for="email" id="labelEmail"
              class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">E-mail</label>
            <!-- Validation -->
            <div id="errorEmail-login" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>


          </div>
          <div class="hidden relative my-1" id="s0jn">
            <input type="password" id="senha-login" name="senha-login"
              class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
              onfocus="document.getElementById('labelSenha').classList.add('!top-[-5px]', '!text-[#000131]')"
              onblur="if(this.value==''){document.getElementById('labelSenha').classList.remove('!top-[-5px]', '!text-[#000131]')}"
              required>
            <label for="senha" id="labelSenha"
              class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Senha</label>
            <!-- Validation -->

            <div id="errorSenha-login" class="select-none hidden text-red-500 font-medium text-[13px] px-1 my-1">Você
              precisa digitar um e-mail válido!</div>


          </div>
          <div class="flex flex-col px-1 my-2">
            <a href="/esqueceu.php" id="sjw0"
              class="mb-3 text-[13px] hover:bg-[#0001310a] w-fit rounded-lg cursor-pointer font-semibold select-none">Esqueceu
              sua senha?</a>
            <text class="text-gray-500 text-[13px] select-none">Este computador não é seu? Utilize o modo convidado para
              iniciar sessão de forma privada.</text>
          </div>
          <div class="flex gap-3 justify-end mt-4">
            <div id="createAccount"
              class="select-none text-[14px] px-4 text-center w-fit hover:bg-[#0001311a] text-[#000131] p-2 rounded-full font-medium hover:!text-[#000131] transition delay-75 duration-75 cursor-pointer">
              Criar conta <div
                class="hidden absolute dropdown w-fit bg-[#c9c9e1] rounded-lg bottom-[-125px] right-[6.5rem] shadow-md">
              </div>
            </div>
            <button type="button" id="next-btn"
              class="select-none text-[14px] px-4 w-fit bg-[#000131] text-white p-2 rounded-full font-medium border !border-[#000131] hover:bg-white hover:!text-[#000131] transition delay-75 duration-75">Seguinte</button>
          </div>
        </form>
        <!-- Formulário Registro Empresas -->
        <form method="POST" id="registerBusiness" class="hidden">
          <div class="block" id="j22jn">
            <div class="relative my-1 mb-3" id="s2jn">
              <input type="text" id="name" name="name"
                class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelName').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelName').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                required>
              <label for="name" id="labelName"
                class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Nome</label>
              <!-- Validation -->
              <div id="errorNome" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
            </div>
            <div class="relative my-1 mb-3" id="s2jn">
              <input type="text" id="apelido" name="apelido"
                class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelApelido').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelApelido').classList.remove('!top-[-5px]', '!text-[#000131]')}">
              <label for="apelido" id="labelApelido"
                class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Apelido
                (opcional)</label>
              <!-- Validation -->
              <div id="errorApelido" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
            </div>
            <div class="relative my-1 mb-3" id="s2jn">
              <input type="text" id="email_usuario" placeholder="E-mail" name="email_usuario"
                class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelEmail').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelEmail').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                required>
              <!-- Validation -->
              <div id="errorEmail" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
            </div>
            <button type="button" id="avanceBtn"
              class="select-none text-[14px] px-4 w-fit bg-[#000131] text-white p-2 rounded-full font-medium border !border-[#000131] hover:bg-white hover:!text-[#000131] transition delay-75 duration-75 float-right right-0">Avançar</button>
          </div>
          <div class="hidden" id="j23jn">
            <div class="relative my-1 mb-3" id="s2jn">
              <input type="text" id="telefone" name="telefone"
                class="w-full md:w-[100%] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelTelefone').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelTelefone').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                required>
              <label for="telefone" id="labelTelefone"
                class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Telefone</label>

              <div id="errorTelefone" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
            </div>

            <div class="relative my-1 mb-6" id="s2jn">
              <input type="email" id="email-secundario" name="email-secundario"
                class="w-full md:w-[100%] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelEmailSecundario').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelEmailSecundario').classList.remove('!top-[-5px]', '!text-[#000131]')}">
              <label for="email-secundario" id="labelEmailSecundario"
                class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">E-mail
                secundário (Opcional)</label>

              <div id="errorEmailSecundario" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1">
              </div>
            </div>

            <div class="relative my-1 mb-3" id="s2jn">
              <input type="password" id="senha-registro" name="senha-registro" placeholder="Digite uma senha"
                class="w-full md:w-[100%] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelSenha').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelSenha').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                required>

              <div id="errorSenha" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
            </div>

            <div class="relative my-1 mb-3" id="s2jn">
              <input type="password" id="conf-senha" name="conf-senha" placeholder="Confirme sua senha"
                class="w-full md:w-[100%] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelSenha').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelSenha').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                required>
              <div id="errorConfSenha" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
            </div>
            <div class="flex flex-wrap gap-2 w-full">
              <div class="relative my-1 mb-3" id="s2jn">
                <input type="text" id="birthdaydia" name="birthdaydia"
                  class="w-full md:w-[144px] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                  onfocus="document.getElementById('labelDiaBirthday').classList.add('!top-[-5px]', '!text-[#000131]')"
                  onblur="if(this.value==''){document.getElementById('labelDiaBirthday').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                  required>
                <label for="birthdaydia" id="labelDiaBirthday"
                  class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Dia</label>

                <div id="errorDia" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
              </div>
              <div class="relative my-1 mb-3" id="s2jn">
                <select id="birthdaymes" name="birthdaymes"
                  class="w-full md:w-[144px] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                  onfocus="document.getElementById('labelMesBirthday').classList.add('!top-[-5px]', '!text-[#000131]')"
                  onblur="if(this.value==''){document.getElementById('labelMesBirthday').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                  required>
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
                <label for="birthdaymes" id="labelMesBirthday"
                  class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Mês</label>

                <div id="errorMes" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
              </div>
              <div class="relative my-1 mb-3" id="s2jn">
                <input type="text" id="birthdayano" name="birthdayano"
                  class="w-full md:w-[144px] form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                  onfocus="document.getElementById('labelAnoBirthday').classList.add('!top-[-5px]', '!text-[#000131]')"
                  onblur="if(this.value==''){document.getElementById('labelAnoBirthday').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                  required>
                <label for="birthdayano" id="labelAnoBirthday"
                  class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Ano</label>

                <div id="errorAno" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
              </div>
            </div>

            <div class="relative my-1 mb-3" id="s2jn">
              <select id="gender" name="gender"
                class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelGender').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelGender').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                required>
                <option value="" disabled selected hidden></option>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
                <option value="nao-binario">Não-binário</option>
                <option value="outro">Outro</option>
                <option value="prefiro-nao-dizer">Prefiro não dizer</option>
              </select>
              <label for="gender" id="labelGender"
                class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Gênero</label>

              <div id="errorGenero" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
            </div>

            <div class="relative my-1 mb-3" id="s2jn">
              <select id="tipoPessoa" name="tipoPessoa"
                class="w-full form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelTipoPessoa').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelTipoPessoa').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                onchange="alterarTipoPessoa()" required>
                <option value="" disabled selected hidden></option>
                <option value="pf">Pessoa Física</option>
                <option value="pj">Pessoa Jurídica</option>
              </select>
              <label for="tipoPessoa" id="labelTipoPessoa"
                class="absolute left-4 top-6 px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">Tipo
                de documento</label>

              <div id="errorTipoPessoa" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1"></div>
            </div>

            <div class="relative my-1 mb-6" id="s2jn">
              <input type="text" id="cpf" name="cpf" placeholder="CPF ex: 000.000.000-00" maxlength="11"
                class="w-full md:w-[100%] input-field-cpf form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelCpf').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelCpf').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                >
              <label for="cpf" id="labelCpf"
                class="absolute left-4 top-6 input-field-cpf px-2 bg-white transform -translate-y-1 text-[12px] text-gray-400 transition-all duration-300 origin-0 select-none">CPF</label>

              <div id="errorCpf" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1">
              </div>
            </div>

            <div class="relative my-1 mb-6" id="s2jn">
              <input type="text" id="cnpj" name="cnpj" placeholder="CNPJ ex: 00.000.000/0000-00" maxlength="18"
                class="w-full md:w-[100%] input-field-cnpj form-control !outline-none pt-[1.03rem] p-3 text-[13px] text-[#47494d] font-medium shadow-none rounded-md border-2 border-[#eceeef] focus:border-[#000131]"
                onfocus="document.getElementById('labelCnpj').classList.add('!top-[-5px]', '!text-[#000131]')"
                onblur="if(this.value==''){document.getElementById('labelCnpj').classList.remove('!top-[-5px]', '!text-[#000131]')}"
                >


              <div id="errorCnpj" class="hidden select-none text-red-500 font-medium text-[13px] px-1 my-1">
              </div>
            </div>

            <button type="button" id="concluirBtn"
              class="select-none text-[14px] px-4 w-fit bg-[#000131] text-white p-2 rounded-full font-medium border !border-[#000131] hover:bg-white hover:!text-[#000131] transition delay-75 duration-75 float-right right-0">Concluir</button>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="/assets/js/main.js?v<?= time(); ?>"></script>

  <script>

    document.addEventListener("DOMContentLoaded", function () {
      var cpfInput = document.querySelector("#cpf");

      cpfInput.addEventListener("blur", function () {
            var cpf = cpfInput.value.replace(/\D/g, ""); // Remove caracteres não numéricos
            if (cpf.length === 11) {
                cpfInput.value = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
            } else {
                alert("CPF inválido. Deve conter 11 dígitos.");
                cpfInput.value = "";
            }
        });

      document.getElementById('cnpj').addEventListener('input', function (e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
      e.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
    });
    });

    function alterarTipoPessoa() {
      var tipoPessoa = document.getElementById('tipoPessoa').value;
      var cnpjField = document.getElementById('cnpj');
      var cpfField = document.getElementById('cpf');

      cnpjField.style.display = 'none';
      cpfField.style.display = 'none';

      if (tipoPessoa === 'pj') {
        cnpjField.style.display = 'block';
      } else if (tipoPessoa === 'pf') {
        cpfField.style.display = 'block';
      }
    }
  </script>
</body>

</html>