document.addEventListener("DOMContentLoaded", function() {
	var emailValidado = false;

    document.getElementById('next-btn').addEventListener('click', function() {
        var emailInput = document.getElementById('email').value;
        var senhaInput = document.getElementById('senha').value;
		
		// Validations
		var errorEmail = document.getElementById('errorEmail');
		var emailInputs = document.getElementById('email');
		var emailLabel = document.getElementById('email-label');

        if (!emailValidado) {
            // Etapa de verificação do e-mail
            if (emailInput.trim() !== '') {

                $.ajax({
                    url: 'https://auth.estejaon.com.br/verify/email',
                    type: 'POST',
                    data: { email: emailInput },
                    dataType: 'json', // Indica que você espera receber JSON na resposta
                    success: function(response) {
                        if (response.success) {
                            var emailSpan = document.getElementById('skj2');
                            emailSpan.textContent = emailInput;
                            emailValidado = true;

                            var senhaDiv = document.getElementById('s0jn');
                            var emailDiv = document.getElementById('s2jn');
                            var forgotPassword = document.getElementById('sjw0');
                            var blockPassword = document.getElementById('sjw2');
                            var textAccount = document.getElementById('s9nk');
                            var emailAccount = document.getElementById('b3jk');
                            emailDiv.classList.add('hidden');
                            senhaDiv.classList.remove('hidden');
                            forgotPassword.classList.add('hidden');
                            blockPassword.classList.remove('hidden');
                            textAccount.classList.add('hidden');
                            emailAccount.classList.remove('hidden');
                        } else {
                            // Lidar com o caso em que o e-mail não é válido
                            //alert(response.error);
							emailInputs.classList.remove('border-[#eceeef]');
							emailInputs.classList.add('border-red-300');
							emailInputs.classList.add('text-red-600');
							emailLabel.classList.remove('text-[#47494d]');
							emailLabel.classList.add('text-red-600');
							errorEmail.classList.remove('hidden');
							errorEmail.classList.add('block');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Lidar com erros de comunicação com o servidor
                        alert("Erro ao verificar o e-mail: " + error);
                    }
                });
            }
        } else {
            // Etapa de verificação da senha
            if (senhaInput.trim() !== '') {
                $.ajax({
                    url: 'https://auth.estejaon.com.br/verify/password',
                    type: 'POST',
                    data: { email: emailInput, senha: senhaInput },
                    dataType: 'json', // Indica que você espera receber JSON na resposta
                    success: function(response) {
                        if (response.success) {
                            alert('Login bem-sucedido!');
                            // Redirecionar para a página de perfil, por exemplo
                        } else {
                            // Lidar com o caso em que a senha não é válida
                            alert(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Lidar com erros de comunicação com o servidor
                        alert("Erro ao verificar a senha: " + error);
                    }
                });
            }
        }
    });

var checkElement = document.getElementById('check');
if (checkElement) {
    checkElement.addEventListener('change', function() {
        var senhaInput = document.getElementById('senha');
        var mostrarSenha = this.checked;
        senhaInput.type = mostrarSenha ? 'text' : 'password';
    });
}
	//document.getElementById('check').addEventListener('change', function() {
      //  var senhaInput = document.getElementById('senha');
      //  var mostrarSenha = this.checked;
      //  senhaInput.type = mostrarSenha ? 'text' : 'password';
   // });
	
    const createAccountBtn = document.getElementById('createAccount');
    const dropdown = document.querySelector('.dropdown');

    createAccountBtn.addEventListener('click', function(event) {
        event.stopPropagation();
        dropdown.classList.add('block');
        dropdown.classList.remove('hidden');
    });

    document.addEventListener('click', function(event) {
        if (!dropdown.contains(event.target) && event.target !== createAccountBtn && dropdown.classList.contains('block')) {
            dropdown.classList.remove('block');
            dropdown.classList.add('hidden');
        }
    });
});