/* Set the width of the sidebar to 250px (show it) */
function openNav() {
  document.getElementById("mySidepanel").style.width = "100%";
}

/* Set the width of the sidebar to 0 (hide it) */
function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}
/*Cart-mobi*/
function openCart() {
  document.getElementById("cart-mobi-header").style.width = "100%";
}

/* Set the width of the sidebar to 0 (hide it) */
function closeCart() {
  document.getElementById("cart-mobi-header").style.width = "0";
}

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

//form valid
$(document).ready(function () {
    var loginForm = $('#loginForm');
    var inputLoginForm = $('#loginForm :input');
    inputLoginForm.focus(function () {
        inputLoginForm.removeClass('error');
        $('#z-email').html('');
        $('#z-password-1').html('');
    });

    $('#btnLogin').click(function () {
        login();
    });

    inputLoginForm.on('keypress',function(e) {
        if(e.which == 13) {
           login();
        }
    });

    function login() {

        var term = loginForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/login',
            type: 'post',
            data: term,
            success: function( data, textStatus, jQxhr ){
                if(data['error']){
                    inputLoginForm.addClass('error');
                    $('#z-email').html(data.error);
                    $('#z-password-1').html(data.error);
                }else {
                    location.reload();
                }
            },
            error: function( response ){
                var errors = JSON.parse(response.responseText);
                var messages = errors.errors;
                inputLoginForm.addClass('error');
                $('#z-email').html(messages.email);
                $('#z-password-1').html(messages.password);
            }
        });

    }


    //register
    var registerForm = $('#registerForm');
    var emailRegister = $("[name='email']", registerForm);
    var passwordRegister = $("[name='password']", registerForm);
    var rePasswordRegister = $("[name='password_confirmation']", registerForm);
    var btnRegister = $('#btnRegister', registerForm);
    btnRegister.prop("disabled", true);
    validFormRegister();

    btnRegister.click(function () {
        if(registerForm.valid()&&checkpass()&checkrePass()){
            processForm(registerForm);
        }else{
            $('#valiPassRegister').html("<span>Your password must be longer than 8 characters</span>");
            passwordRegister.addClass("is-invalid");
            $('#valiRePassRegister').html("<span>Your password must be longer than 8 characters</span>");
            rePasswordRegister.addClass("is-invalid");
        }
    });

    function processForm( e ){
        btnRegister.addClass('disabled');
        var term = e.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/register',
            type: 'post',
            data: term,
            statusCode: {
                //khong su dung duoc cho loi 302
                302: function(responseObject, textStatus, jqXHR) {
                    location.reload();
                }
            },
            success: function( data, textStatus, jQxhr ){
                location.reload();
                $('#modalRegister').modal('hide');
            },
            error: function( response ){
                if (response.status == 0) {
                    console.log('success');
                    location.reload();
                }else {
                    registerShowError( JSON.parse(response.responseText) );
                }
                btnRegister.removeClass('disabled');
            }
        });
    }

    function registerShowError(response) {
        if(!$.isEmptyObject(response.errors)){
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
                        $('#valiRePassRegister').html(message);
                        rePasswordRegister.addClass("is-invalid");
                        rePasswordRegister.focus(function () {
                            clearPass();
                        });
                        break;
                    default:
                        break;
                }
            });
        }else {
            console.log(response);
            $.notify({
                content :response.message,
                alertType: "alert-warning",
                timeout: 8000
            });
        }
    }

    function validFormRegister() {
        passwordRegister.keyup(function () {
            checkpass();
        });

        rePasswordRegister.keyup(function () {
            checkrePass();
        });

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
                if(registerForm.valid()&&checkpass()&checkrePass()){
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
        $('#valiRePassRegister').html("");
        rePasswordRegister.removeClass("is-invalid");
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
    function checkrePass() {
        var pass = rePasswordRegister.val().length
        if (pass<8){
            $('#valiRePassRegister').html("<span>Your password must be longer than 8 characters</span>");
            rePasswordRegister.addClass("is-invalid");
            return false;
        }
        else{
            $('#valiRePassRegister').html("");
            rePasswordRegister.removeClass("is-invalid");
            return true;
        }
    }


});






