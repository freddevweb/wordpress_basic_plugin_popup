jQuery( document ).ready( function( $ ) {
	// console.log("here");
	$(".popup").click(function(){
		// console.log($(this));
		$(".popup .popup-text").toggleClass("show");
	});
});