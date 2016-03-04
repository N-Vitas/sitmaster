
$('.checkbox-group').hide(500);
$(document)
    .on("click", ".icons-right", function (e) {
    	var parent = $(this).offsetParent();
		if($(this).text() == 'arrow_drop_up'){
		 	$(this).text('arrow_drop_down_circle');
			parent.nextAll('.checkbox-group').hide(500);
		}
		else{
			$(this).text('arrow_drop_up');
			parent.nextAll('.checkbox-group').show(500);
		}
})
