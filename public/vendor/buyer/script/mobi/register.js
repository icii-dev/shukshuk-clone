$(document).ready(function () {
    //register
    var registerForm = $('#registerForm');
    var emailRegister = $("[name='email']", registerForm);
    var passwordRegister = $("[name='password']", registerForm);
    var btnRegister = $('#btnRegister', registerForm);
    btnRegister.prop("disabled", true);
    validFormRegister();

    btnRegister.click(function () {
        if(registerForm.valid()&&checkpass()){
            processForm(registerForm);
        }
        else if(!checkpass()){
            $('#valiPassRegister').html("<span>Your password must be longer than 8 characters</span>");
            passwordRegister.addClass("is-invalid");
        }
    });

    function processForm( e ){
        var term = e.serialize();
        term += '&password_confirmation=' + passwordRegister.val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/register',
            type: 'post',
            data: term,
            success: function( data, textStatus, jQxhr ){
                location.reload();
                $('#modalRegister').modal('hide');
            },
            error: function( response ){
                registerShowError( JSON.parse(response.responseText) );
            }
        });
    }

    function registerShowError(response) {
        $.each(response.errors, function (key, message) {
            console.log(message);
            switch (key) {
                case 'name':
                    break;
                case 'email':
                    emailRegister.addClass("is-invalid");
                    $('#validEmailRegister').html(message);
                    emailRegister.focus(function () {
                        emailRegister.removeClass("is-invalid");
                        $('#validEmailRegister').html('');
                    });
                    break;
                case 'password':
                    $('#valiPassRegister').html(message);
                    passwordRegister.addClass("is-invalid");
                    passwordRegister.focus(function () {
                        clearPass();
                    });
                    break;
                default:
                    break;
            }
        });
    }

    function validFormRegister() {

        registerForm.validate({
            onkeyup: function(element) {$(element).valid()},
            rules: {
                firstName: "required",
                lastName: "required",
                email: {
                    required: true,
                    minlength: 2
                }
            },
        });

        registerForm.keyup(function () {
            if(isFillForm()){
                if(registerForm.valid()&&checkpass()){
                    btnRegister.prop("disabled", false);
                    btnRegister.removeClass('btn-disable').addClass('btn-secondary').css("color", "#fff");
                }else{
                    btnRegister.prop("disabled", true);
                    btnRegister.removeClass('btn-secondary').addClass('btn-disable').css("color", "#ACB4B4");
                }
            }

        });
    }

    function clearPass() {
        $('#valiPassRegister').html('');
        passwordRegister.removeClass("is-invalid");
    }

    function isFillForm() {

        var formInvalid = true;
        $('#registerForm input').each(function() {
            if ($(this).val() === '') {
                formInvalid = false;
            }
        });

        return formInvalid;
    }

    passwordRegister.keyup(function () {
        checkpass();
    });

    function checkpass() {
        var pass = passwordRegister.val().length;
        if (pass<8){
            $('#valiPassRegister').html("<span>Your password must be longer than 8 characters</span>");
            passwordRegister.addClass("is-invalid");
            return false;
        }
        else{
            $('#valiPassRegister').html('');
            passwordRegister.removeClass("is-invalid");
            return true;
        }
    }

    //show/hide password
    $("#show_hide_password i").on('click', function() {
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }
        else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
})