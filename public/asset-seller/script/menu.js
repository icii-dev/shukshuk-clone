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

function checkmail() {
    var mail = document.getElementById('email').value;
    if (mail == "") {
        document.getElementById('z-email').innerHTML = "<span>Email address cannot be empty</span>";
        document.getElementById("email").classList.add("is-invalid");
    } else {
        document.getElementById('z-email').innerHTML = "";
        document.getElementById("email").classList.remove("is-invalid");
    }

}

function checkpass() {
    var pass = document.getElementById('password').value.length;
    if (pass < 8) {
        document.getElementById('z-password').innerHTML = "<span>Your password must be longer than 8 characters</span>";
        document.getElementById("password").classList.add("is-invalid");
    } else {
        document.getElementById('z-password').innerHTML = "";
        document.getElementById("password").classList.remove("is-invalid");
    }
}

function checkpass1() {
    var pass = document.getElementById('password-1').value.length;
    if (pass < 8) {
        document.getElementById('z-password-1').innerHTML = "<span>Your password must be longer than 8 characters</span>";
        document.getElementById("password-1").classList.add("is-invalid");
    } else {
        document.getElementById('z-password-1').innerHTML = "";
        document.getElementById("password-1").classList.remove("is-invalid");
    }
}

function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

$(function () {
    $('body').on("click", ".detail-cart", function (e) {
        $(this).parent().is(".show") && e.stopPropagation();
    });
    $('#click-login,.btn-login-mobi').click(function () {
        $('.wrap-login').removeClass('d-flex');
        $('.wrap-login').addClass('d-none');
        $('.customer').removeClass('d-none');
        $('.customer').addClass('d-block');
        $('.wrap-login-mobi').addClass('d-none');
        $('.account-mobi').removeClass('d-none');
    })
    $('#log-out-1,.log-out-mobi').click(function () {
        $('.wrap-login').removeClass('d-none');
        $('.wrap-login').addClass('d-flex');
        $('.customer').removeClass('d-block');
        $('.customer').addClass('d-none');
        $('.account-mobi').addClass('d-none');
        $('.wrap-login-mobi').removeClass('d-none');
    })
    $('.back-to-login').click(function () {
        $('.modal-backdrop').removeClass('show')
        $('.moda-register').removeClass('show')
        $('.modal-login').addClass('show');
    });
    $('.back-register').click(function () {
        $('.modal-backdrop').removeClass('show')
        $('.modal-login').removeClass('show');
        $('.moda-register').addClass('show');
    });
    $('.heart').click(function () {
        if ($(this).find("img").attr("src") == "Img/heart-2.svg") {
            $(this).find("img").attr("src", "Img/wishlist-checked.svg")
        } else {
            $(this).find("img").attr("src", "Img/heart-2.svg")
        }
    });
    $(".button-1").on("click", function () {
        var $button = $(this);
        var $parent = $button.parent();
        var oldValue = $parent.find('.input').val();
        var newVal = parseFloat(oldValue) - 1;
        if (newVal <= 1) {
            newVal = 1
        }
        $parent.find('.input').val(newVal);
    });

    $(".button-2").on("click", function () {
        var $button = $(this);
        var $parent = $button.parent();
        var oldValue = $parent.find('.input').val();
        var newVal = parseFloat(oldValue) + 1;
        $parent.find('.input').val(newVal);
    });
    $("#show_hide_password i").on('click', function () {
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });
    $(function () {
        var projects = [{
            value: "Coffee Bean",
            label: "Coffee Bean",
            desc: "Product",
        }, {
            value: "Coffee Grind",
            label: "Coffee Grind",
            desc: "Product",

        }, {
            value: "Coffee Windmill",
            label: "Coffee Windmill",
            desc: "Store",
        }];

        // $("#project,#project-1").autocomplete({
        //     minLength: 0,
        //     source: projects,
        //     focus: function (event, ui) {
        //         $("#project-1").val(ui.item.label);
        //         return false;
        //     },
        //     select: function (event, ui) {
        //         $("#project").val(ui.item.label);
        //         $("#project-id").val(ui.item.value);
        //         $("#project-description").html(ui.item.desc);
        //         $("#project-icon").attr("src", "images/" + ui.item.icon);
        //         return false;
        //     }
        // }).data("autocomplete")._renderItem = function (ul, item) {
        //     return $("<li>")
        //         .data("item.autocomplete", item)
        //         .append("<a>" + "<p>" + item.label + "</p>" + "<span>" + item.desc + "</sapn>" + "</a>")
        //         .appendTo(ul);
        // };
    });
    jQuery.curCSS = function (element, prop, val) {
    };
})



