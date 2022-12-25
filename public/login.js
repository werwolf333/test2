$(document).ready(function () {
	$("#login_form").on('submit', function (event){
		event.preventDefault();
		sendForm('login_form', '');
	});
});

function sendForm(login_form, url) {
	$.ajax({
		url: url, 
		type: "POST",
		dataType: "html",
		data: $("#" + login_form).serialize(),
		success: function (response) {
			var errors = $.parseJSON(response);
			if(errors["errors"]==false){
				window.location.href = "/index";
			}
			else{
				$('#user_login_error').html(errors["user_login"]);
				$('#user_password_error').html(errors["user_password"]);
			}
		},
		error: function (response) {
			$('#result_form').html('Ошибка. Данные не отправлены.');
		}
	});
}
