document.addEventListener("DOMContentLoaded", function () {
    var emailValidado = false;

    // login
    document.getElementById('next-btn').addEventListener('click', function () {
        var emailInput = document.getElementById('email-login').value;

        var errorEmailLogin = document.getElementById('errorEmail-login');

        if (!emailValidado) {
            if (emailInput.trim() !== '') {
                $.ajax({
                    url: 'http://localhost/api/verify/login',
                    type: 'POST',
                    data: {
                        type: 'email',
                        email: emailInput
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            emailValidado = true;

                            var emailSpan = document.getElementById('skj2');
                            emailSpan.textContent = emailInput;

                            // Show password input and hide email input
                            var senhaDiv = document.getElementById('s0jn');
                            var emailDiv = document.getElementById('s2jn');
                            var forgotPassword = document.getElementById('sjw0');
                            var textAccount = document.getElementById('s9nk');
                            var emailAccount = document.getElementById('b3jk');
                            emailDiv.classList.add('hidden');
                            senhaDiv.classList.remove('hidden');
                            forgotPassword.classList.add('hidden');
                            textAccount.classList.add('hidden');
                            emailAccount.classList.remove('hidden');
                        }

                        if (response.error) {
                            if (response.input_error) {
                                const inputError = document.getElementById("" + response.input_error + "");
                                inputError.classList.add('border-red-300');
                            }

                            errorEmailLogin.textContent = "" + response.message + "";
                            errorEmailLogin.classList.remove('hidden');
                        }
                    }, error: function (xhr, status, error) {
                        console.log("Erro inesperado: " + error);
                    }
                })
            }
        } else {
            var queryString = window.location.search;


            var emailInput = document.getElementById('email-login').value;
            var senhaInput = document.getElementById('senha-login').value;
            var errorSenha = document.getElementById('errorSenha-login');

            if (senhaInput.trim() !== '') {
                $.ajax({
                    url: 'http://localhost/api/verify/login' + queryString,
                    type: 'POST',
                    data: {
                        type: 'senha',
                        email: emailInput,
                        senha: senhaInput
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            if (response.redirect) {
                                window.location.href = response.location;
                            } else {
                                console.log(response);
                                window.location.href = 'conta.php';
                            }
                        }

                        if (response.error) {
                            if (response.input_error) {
                                const inputError = document.getElementById("" + response.input_error + "");
                                inputError.classList.add('border-red-300');
                            }

                            errorSenha.textContent = "" + response.message + "";
                            errorSenha.classList.remove('hidden');
                        }
                    }, error: function (xhr, status, error) {
                        console.log("Erro inesperado: " + error);
                    }
                })
            }
        }
    });



    var useBusiness = document.getElementById('useBusiness');
    if (useBusiness) {
        useBusiness.addEventListener('click', function () {
            // Hide loginForm and show registerBusiness form
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('registerBusiness').classList.remove('hidden');
        });
    }

    function checkRequiredFields(sectionId) {
        var requiredFields = document.querySelectorAll('#' + sectionId + ' [required]');
        var allFilled = true;

        requiredFields.forEach(function (field) {
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
        avanceBtn.addEventListener('click', function () {


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

    //registro
    var concluirBtn = document.getElementById('concluirBtn');
    if (concluirBtn) {
        concluirBtn.addEventListener('click', function () {
            if (checkRequiredFields('j23jn')) {
                var queryString = window.location.search;


                const nameInput = document.getElementById('name').value;
                const surnameInput = document.getElementById('apelido').value;
                const emailInput = document.getElementById('email_usuario').value;
                const phoneInput = document.getElementById('telefone').value;
                const emailSecondaryInput = document.getElementById('email-secundario').value;
                const passwordInput = document.getElementById('senha-registro').value;
                const passwordRepeatInput = document.getElementById('conf-senha').value;
                const dayInput = document.getElementById('birthdaydia').value;
                const monthInput = document.getElementById('birthdaymes').value;
                const yearInput = document.getElementById('birthdayano').value;
                const genderInput = document.getElementById('gender').value;

                $.ajax({
                    url: 'http://localhost/api/verify/register' + queryString,
                    type: 'POST',
                    data: {
                        nome: nameInput,
                        apelido: surnameInput,
                        email: emailInput,
                        telefone: phoneInput,
                        email_secundario: emailSecondaryInput,
                        senha: passwordInput,
                        conf_senha: passwordRepeatInput,
                        dia: dayInput,
                        mes: monthInput,
                        ano: yearInput,
                        genero: genderInput
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            if (response.redirect) {
                                window.location.href = response.location;
                            } else {
                                window.location.href = 'conta.php';
                            }
                        } else {
                            if (response.error) {

                                if (response.input_error) {
                                    if (Array.isArray(response.input_error)) {
                                        response.input_error.forEach(function (inputErrorId) {
                                            const inputError = document.getElementById(inputErrorId);
                                            if (inputError) {
                                                inputError.classList.add('border-red-300');
                                            }
                                        })
                                    } else {
                                        const inputError = document.getElementById("" + response.input_error + "");
                                        inputError.classList.add('border-red-300');
                                    }
                                }

                                if (response.back) {

                                    document.getElementById('j22jn').classList.add('block');
                                    document.getElementById('j22jn').classList.remove('hidden');
                                    document.getElementById('j23jn').classList.remove('block');
                                    document.getElementById('j23jn').classList.add('hidden');


                                    switch (response.type) {
                                        case 'nome':
                                            const errorNome = document.getElementById('errorNome');
                                            errorNome.textContent = "" + response.message + "";
                                            errorNome.classList.remove('hidden');
                                            break;

                                        case 'apelido':
                                            const errorApelido = document.getElementById('errorApelido');
                                            errorApelido.textContent = "" + response.message + "";
                                            errorApelido.classList.remove('hidden');
                                            break;

                                        case 'email':
                                            const errorEmail = document.getElementById('errorEmail');
                                            errorEmail.textContent = "" + response.message + "";
                                            errorEmail.classList.remove('hidden');
                                            break;
                                    }

                                    return;

                                }

                                switch (response.type) {
                                    case 'telefone':
                                        const errorTelefone = document.getElementById('errorTelefone');
                                        errorTelefone.textContent = "" + response.message + "";
                                        errorTelefone.classList.remove('hidden');
                                        break;
                                    case 'email_secundario':
                                        const errorEmailSecundario = document.getElementById('errorEmailSecundario');
                                        errorEmailSecundario.textContent = "" + response.message + "";
                                        errorEmailSecundario.classList.remove('hidden');
                                        break;
                                    case 'senha':
                                        const errorSenha = document.getElementById('errorSenha');
                                        errorSenha.textContent = "" + response.message + "";
                                        errorSenha.classList.remove('hidden');
                                        break;
                                    case 'conf-senha':
                                        const errorConfSenha = document.getElementById('errorConfSenha');
                                        errorConfSenha.textContent = "" + response.message + "";
                                        errorConfSenha.classList.remove('hidden');
                                        break;
                                    case 'senha-diferente':
                                        alert(response.message);
                                        break;
                                    case 'nascimento':
                                        alert(response.message);
                                        break;
                                    case 'genero':
                                        const errorGenero = document.getElementById('errorGenero');
                                        errorGenero.textContent = "" + response.message + "";
                                        errorGenero.classList.remove('hidden');
                                        break;
                                    case 'url_blocked':
                                        $.ajax({
                                            url: 'http://localhost/api/verify/security?redirect_blocked=' + response.url + "",
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function (response) {
                                                window.location.href = "/";
                                            },
                                            error: function (xhr, status, error) {
                                                alert("Erro: " + error);
                                            }
                                        })
                                        break;
                                }
                            }

                            return;
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("Erro: " + error);
                    }
                });
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
        checkElement.addEventListener('change', function () {
            var senhaInput = document.getElementById('senha');
            var mostrarSenha = this.checked;
            senhaInput.type = mostrarSenha ? 'text' : 'password';
        });
    }

    // Event listener for creating account
    const createAccountBtn = document.getElementById('createAccount');
    const dropdown = document.querySelector('.dropdown');
    if (createAccountBtn && dropdown) {
        createAccountBtn.addEventListener('click', function (event) {
            event.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target) && event.target !== createAccountBtn && dropdown.classList.contains('block')) {
                dropdown.classList.add('hidden');
            }
        });
    }
});
