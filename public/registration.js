$(document).ready(function () {
	$("#registration_form").removeClass('hidden');
	$("#registration_form").on('submit', function (event){
		event.preventDefault();
		sendForm('registration_form', '');
	});
});

function sendForm(registration_form, url) {
	$.ajax({ 
		url: url, 
		type: 'POST',
		dataType: 'html',
		data: $('#' + registration_form).serialize(),
		success: function (response) {
			var errors = $.parseJSON(response);
			if(errors["errors"]==false){
				window.location.href = "/login";
			}
			else{
				$('#user_login_error').html(errors["user_login"]);
				$('#user_password_error').html(errors["user_password"]);
				$('#user_password_repeat_error').html(errors["user_password_repeat"]);
				$('#user_email_error').html(errors["user_email"]);
				$('#user_name_error').html(errors["user_name"]);
			}
		},
		error: function (response) {
			$('#result_form').html('Ошибка. Данные не отправлены.');
		}
	});
}
