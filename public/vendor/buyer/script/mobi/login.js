$(document).ready(function () {
    var loginForm = $('#loginForm');
    var inputLoginForm = $('#loginForm :input');
    inputLoginForm.focus(function () {
        inputLoginForm.removeClass('error');
        $('#z-email').html('');
        $('#z-password-1').html('');
    });

    $('#btnLogin').click(function () {
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
                console.log(data);
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
                console.log(errors.errors);
                var messages = errors.errors;
                inputLoginForm.addClass('error');
                $('#z-email').html(messages.email);
                $('#z-password-1').html(messages.password);
            }
        });
    });


});