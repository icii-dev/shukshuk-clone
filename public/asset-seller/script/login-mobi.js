function checkmail() {
	var mail = document.getElementById('email').value;
    if (mail=="") {
        document.getElementById('z-email').innerHTML = "<span>Email address cannot be empty</span>";
        document.getElementById("email").classList.add("is-invalid");
    }
    else{
      document.getElementById('z-email').innerHTML = "";
      document.getElementById("email").classList.remove("is-invalid");
    }
    
}
function checkpass1() {
  var pass = document.getElementById('password-1').value.length;
  if (pass<8){
      document.getElementById('z-password-1').innerHTML = "<span>Your password must be longer than 8 characters</span>";
      document.getElementById("password-1").classList.add("is-invalid");
    }
    else{
      document.getElementById('z-password-1').innerHTML ="";
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
$(function(){
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