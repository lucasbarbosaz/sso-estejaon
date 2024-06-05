document.addEventListener("DOMContentLoaded", function() {
    var emailValidado = false;

    // Event listener for the 'next' button
    document.getElementById('next-btn').addEventListener('click', function() {
        var emailInput = document.getElementById('email').value;
        var senhaInput = document.getElementById('senha').value;

        // Validations
        var errorEmail = document.getElementById('errorEmail');
        var emailInputs = document.getElementById('email');
        var emailLabel = document.getElementById('labelEmail');

        // Check if email validation is not yet done
        if (!emailValidado) {
            // Validate email
            if (emailInput.trim() !== '') {
                $.ajax({
                    url: 'https://auth.estejaon.com.br/verify/email',
                    type: 'POST',
                    data: { email: emailInput },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Handle successful email verification
                            emailValidado = true;
                            var emailSpan = document.getElementById('skj2');
                            emailSpan.textContent = emailInput;

                            // Show password input and hide email input
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
                            // Handle invalid email
                            emailInputs.classList.remove('border-[#eceeef]');
                            emailInputs.classList.add('border-red-300');
                            emailInputs.classList.add('text-red-600');
                            emailLabel.classList.remove('text-gray-400');
                            emailLabel.classList.add('!text-red-600');
                            errorEmail.classList.remove('hidden');
                            errorEmail.classList.add('block');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        console.error("Error verifying email:", error);
                        alert("Erro ao verificar o e-mail: " + error);
                    }
                });
            }
        } else {
            // Email validation already done, check password
            if (senhaInput.trim() !== '') {
                $.ajax({
                    url: 'https://auth.estejaon.com.br/verify/password',
                    type: 'POST',
                    data: { email: emailInput, senha: senhaInput },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Handle successful login
                             window.location.href = 'https://accounts.estejaon.com.br/?token=' + encodeURIComponent(response.token);
                            // Redirect to profile page or handle as needed
                        } else {
                            // Handle invalid password
                            alert(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        console.error("Error verifying password:", error);
                        alert("Erro ao verificar a senha: " + error);
                    }
                });
            }
        }
    });
	
var useBusiness = document.getElementById('useBusiness');
        if (useBusiness) {
            useBusiness.addEventListener('click', function() {
                // Hide loginForm and show registerBusiness form
                document.getElementById('loginForm').classList.add('hidden');
                document.getElementById('registerBusiness').classList.remove('hidden');
            });
        }
        
        function checkRequiredFields(sectionId) {
            var requiredFields = document.querySelectorAll('#' + sectionId + ' [required]');
            var allFilled = true;
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    allFilled = false;
                    field.classList.add('border-red-300'); // Add red border for empty fields
                } else {
                    field.classList.remove('border-red-300'); // Remove red border if filled
                }
            });
            
            return allFilled;
        }

        var avanceBtn = document.getElementById('avanceBtn');
        if (avanceBtn) {
            avanceBtn.addEventListener('click', function() {
                if (checkRequiredFields('j22jn')) {
                    document.getElementById('j22jn').classList.add('hidden');
                    document.getElementById('j22jn').classList.remove('block');
                    document.getElementById('j23jn').classList.remove('hidden');
                    document.getElementById('j23jn').classList.add('block');
                } else {
                    alert('Por favor, preencha todos os campos obrigatórios.');
                }
            });
        }

        var concluirBtn = document.getElementById('concluirBtn');
        if (concluirBtn) {
            concluirBtn.addEventListener('click', function() {
                if (checkRequiredFields('j23jn')) {
                    // Submit the form or perform desired action
                    alert('Formulário concluído com sucesso!');
                    // document.getElementById('registerBusiness').submit(); // Uncomment to submit the form
                } else {
                    alert('Por favor, preencha todos os campos obrigatórios.');
                }
            });
        }
	//
	

    // Event listener for showing/hiding password
    var checkElement = document.getElementById('check');
    if (checkElement) {
        checkElement.addEventListener('change', function() {
            var senhaInput = document.getElementById('senha');
            var mostrarSenha = this.checked;
            senhaInput.type = mostrarSenha ? 'text' : 'password';
        });
    }

    // Event listener for creating account
    const createAccountBtn = document.getElementById('createAccount');
    const dropdown = document.querySelector('.dropdown');
    if (createAccountBtn && dropdown) {
        createAccountBtn.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            if (!dropdown.contains(event.target) && event.target !== createAccountBtn && dropdown.classList.contains('block')) {
                dropdown.classList.add('hidden');
            }
        });
    }
});
