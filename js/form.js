$(function(){
    $('#respond .form').validate({
	rules: {
			message_name: "required",
		    message_email: {
		      required: true,
		      email: true
			},
			message_text: "required"
		},
	messages: {
		message_name: "Campo requerido",
		message_email: {
			required: "Campo requerido",
			email: "No parece un email válido"
		},
		message_text: "Campo requerido",
    }
	});
});
