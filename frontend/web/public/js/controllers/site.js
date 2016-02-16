$.material.init();
$( window ).bind('scroll',function(e) {
	var position = $(document).scrollTop();
	if(position > 5){
		$( ".navbar" ).addClass( "navbar-fixed-top" );
	}
	else{
		$( ".navbar" ).removeClass( "navbar-fixed-top" );		
	}
	
});
// navbar-fixed-top