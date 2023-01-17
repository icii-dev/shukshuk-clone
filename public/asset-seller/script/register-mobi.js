function checkpass() {
  var pass = document.getElementById('password').value.length;
  if (pass<8){
      document.getElementById('z-password').innerHTML = "<span>Your password must be longer than 8 characters</span>";
      document.getElementById("password").classList.add("is-invalid");
    }
    else{
      document.getElementById('z-password').innerHTML ="";
      document.getElementById("password").classList.remove("is-invalid");
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