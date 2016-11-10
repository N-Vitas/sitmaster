function createGroup(){
	$('#createGroup-modal').modal();
}
function getUsers(id){
	$('#userGroup-modal').modal()
	$.ajax({
		url:'/api/get-userlist-group/'+id,
		dataType:'json',
	})
	.done(function(response) {			
		renderUsers(response);  
	})
}

function changeGroup(title,id){
	$('#changeGroup-modal').modal();
	renderGroup(title,id);
}

function deleteGroup(title,id){
	$('#deleteGroup-modal').modal();
	$('#warning').html('Вы действительно хотите удалить группу <span class"text-danger">'+title+'</span>?')
	$('#sub_delete').click(function(){
		$.ajax({
				url:'/api/delete-group/'+id
			})
			.done(function(res) {
				if(res.result)
				location.reload();
				else{
					if(res.error)
					$('#error').text('Ошибка удаления!'); 
					else
					$('#error').text('Вы не можете удалить группу, не удалив подгруппы!'); 
				}	
			})
	})
}

function renderUsers(response){
	var html = '<div class="form-group">';
	html += '<H3>Пользователи в группе</H3>';
	for (var i in response) {
		html += '<div>';
		html += '<a href="/profile/index/'+response[i].user_id+'" class="link-primary">'+response[i].username+'</a>';
		html += '<a href="/profile/index/'+response[i].user_id+'" class="link-primary pull-right">'+response[i].rolename+'</a>';
		html += '</div>';
	}
	html += '</div>';
	html += '<div class="btn-group" role="group">';
	html += '<a  href="/profile/create" class="btn btn-primary">Создать пользователя</a>';
	html += '<button  type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>';
	html += '</div>';
	$('#container').html(html);
}

function renderGroup(title,id){
	var html = '<div class="form-group">';
	html += '<H3>Редактирование группы</H3>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label" for="input">Название новой группы</label>';
	html += '<input type="text" id="changeInput" class="form-control" name="group" value="'+title+'">';
	html += '</div>';
	html += '<div class="btn-group" role="group">';
	html += '<button type="button" id="sub_save" class="btn btn-primary">Сохранить</a>';
	html += '<button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>';
	html += '</div>';
	$('#groupContainer').html(html);
	$('#sub_save').click(function(){
		var value = $('#changeInput').val();
		if(value.length > 0){
			$.ajax({
				url:'/api/change-group/'+id,
				method:'post',
				data:{title:value}
			})
			.done(function(res) {
				if(res.result)
				location.reload();		
				$('#changeGroup-modal').modal('hide'); 
			})
		}
	})
}