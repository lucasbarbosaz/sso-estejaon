
document.addEventListener("DOMContentLoaded", function () {
    var emailValidado = false;
    const ForgotNext = document.getElementById('nextForgot');

    ForgotNext.addEventListener('click', function (event) {
        var emailInput = document.getElementById('email').value;

        if (!emailValidado) {
            if (emailInput.trim() !== '') {
                $.ajax({
                    url: 'http://localhost/api/verify/login',
                    type: 'POST',
                    data: {
                        type: 'email',
                        email: emailInput
                    },
                })
            }
        }


        // document.getElementById('s7jn').classList.toggle('hidden');
        // document.getElementById('s5jn').classList.toggle('hidden');
    });

});
