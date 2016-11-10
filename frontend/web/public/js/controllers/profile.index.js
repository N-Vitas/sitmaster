// $('.activity-view-link').click(function(data) {
// 	console.log(data);
//     $('#activity-modal').modal();
// });
function editProfile(model,name,data){
	console.log(data);
	$('#activity-modal').modal();
	$('#input').val(data);
	$('#input').attr('name',name);	
}
function editRole(){
	$('#role-activity-modal').modal();
}
$('.delete').click(function(e){
	
	$('#delete-modal').modal();
<<<<<<< HEAD
});


// Это у нас выпадающий список
function editSimpleGroup(){
	$('#group-activity-modal').modal();
	$.ajax({
		url:'/api/get-users-group',
		dataType:'json',
	})
	.done(function(response) {	
		renderGroup(response);  
	})
}

// Это у нас радио кнопки
function editGustomGroup(){
	$('#group-activity-modal').modal();	
	$.ajax({
		url:'/api/get-all-group',
		dataType:'json',
	})
	.done(function(response) {			
		renderGroups(response);  
	})	
}

var renderGroups = function(response){
	var html = '<label class="control-label" for="group">Место работы</label>';
			html += '<div class="lead-group">';
			for (var i in response) {
				html += '<div class="checkbox btn-checkbox">';
				html += '<label class="checkbox-inline">';
				html += '<input class="agree" type="checkbox" name="group[]" value="'+response[i].id+'">';
				html += '<span class="checkbox-material"><span class="check"></span></span>&nbsp;'+response[i].title;
				html += '</label>';
				if(response[i].children.length > 0)
					for(var s in response[i].children){
						html += '<div class="checkbox checkbox-group children'+response[i].id+'">';
						html += '<label class="checkbox-inline">';
						html += '<input type="checkbox" name="group[]" value="'+response[i].children[s].id+'">';
						html += '<span class="checkbox-material"><span class="check"></span></span>&nbsp;'+response[i].children[s].title;
						html += '</label>';
						html += '</div>';
					}
				html += '</div>';
			}
			html += '</div>';
	$('#form-group').html(html);
	handlerRootClick()
	handlerChildClick()
}
var renderGroup = function(response){
	var html = '<div class="form-group field-signupform-group has-success">';
	html += '<label class="control-label" for="signupform-group">Место работы</label>';
	html += '<select id="signupform-group" class="form-control" name="group">';
	for(var i in response){
		html += '<option value="'+response[i].id+'">'+response[i].title+'</option>';		
	}
	html += '</select>';

	html += '<div class="help-block"></div>';
	html += '</div>';
	$('#form-group').html(html);
}
// var child;
function handlerRootClick(){
	$('.agree').each(function(){
		$(this).on('click',function(){
			var child = $('.children'+$(this).val()+' :checkbox').siblings();	
			console.log($(this).prop( "checked" ),child)
			if ($(this).prop( "checked" )){
					child.prevObject.prop('checked', true)
			}
			else{
					child.prevObject.prop('checked',false);
			}
		})
	})
}
function handlerChildClick(id){
	$('.checkbox-group :checkbox').each(function(){
		$(this).on('click',function(){
			var child = $(this).parents('.btn-checkbox');
			console.log(child)
			if ($(this).is(':checked')){
				child.find('.agree').prop('checked', true)
			}
			else{
				child.prop('checked',false);
			}
		})
	})
}