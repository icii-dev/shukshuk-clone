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
$(function(){
	$('#order').click(function(){
          $('#track-oder').addClass('d-none');
          $('#check-circle').removeClass('d-none');
    })
})