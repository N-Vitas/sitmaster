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