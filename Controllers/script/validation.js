// JavaScript Document
$(document).ready(function(e) {;
	$('.changePassword').click(function(e) {
		$('#passwordDiv').show();
	});
    $('#buttonLogin').click(function(e) {
        var username = $('#username').val();
		var password = $('#password').val();
		if(username == "" || password == ""){
			$('#success').fadeIn(700,function(){
			$('#success').css({"font-weight":"bold","padding":"20px","width":"450px","background-position":"center","text-align":"center","background":"#900","color":"#FFF"});
			$('#success').html('<i class="fa fa-warning"></i>		Required field(s) empty, Please try again');
			$('#success').fadeOut(4000);	
			});
		}else{
			$.post('Controllers/inc/process_login.php',{'username':username,'password':password},function(result){
				
				 	if(result==1){
						$('#success').fadeIn(700,function(){
						$('#success').css({"font-weight":"bold","padding":"20px","width":"450px","background-position":"center","text-align":"center","background":"#030","color":"#FFF"});
						$('#success').html('<i class="fa fa-globe fa-spin"></i>      Redirecting....., to dashboard please wait');
						$('#success').fadeOut(4000);	
						});
						window.location="dashboard/pages/index.php";
					}
				 	else if(result==2){
						$('#success').fadeIn(700,function(){
						$('#success').css({"font-weight":"bold","padding":"20px","width":"450px","background-position":"center","text-align":"center","background":"#900","color":"#FFF"});
						$('#success').html('<i class="fa fa-warning"></i>		Invalid Login Details');
						$('#success').fadeOut(4000);	
						});	
					}
	});
		}
    });
});
function user_validate(){
	$.ajax({
	url: 'Controllers/inc/validateRegistration.php',
	async: true,
	cache: false,
	data: $('#register-form').serialize(),
	type: 'post',          
	success: function (data) {
		if(data == 2){
			$('#callback').fadeIn(700, function(){
			$('#callback').css({"font-weight":"bold","height":"70px","width":"350px","background-position":"center","text-align":"center","background":"#030","color":"#FFF"});
			$('#callback').html('<i class="fa fa-globe fa-spin"></i>Registration Successfully...... Redirection to Login Page');
			$('#callback').fadeOut(4000);
			});
			window.location="index.php?p=login";
			}
		else if(data == 1){
			$('#callback').fadeIn(700, function(){
			$('#callback').css({"font-weight":"bold","height":"70px","width":"350px","background-position":"center","text-align":"center","background":"#900","color":"#FFF"});
			$('#callback').html('<i class="fa fa-warning"></i> Username or email already exist please choose another username and email');
			$('#callback').fadeOut(4000);
			});
		}
			else {
						
			alert(data +'BAD');
		}
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
		alert(textStatus);
		}
					
		});

 };
   
				
$(function(){
	$.validator.setDefaults({
		errorClass: 'help-block',
		highlight:	function(element){
			$(element)
			.closest('.form-group')
			.addClass('has-error');
		},
		unhighlight: function(element){
					$(element)
					.closest('.form-group')
					.removeClass('has-error');
		}
	});

$.validator.addMethod('strongPassword',function(value,element) {
			return this.optional(element)
			|| value.length>=8
			&&/\d/.test(value)
			&&/[a-z]/i.test(value);
		},	'Your password must be at least 8 characters long and contain at least one number and one char')
			$("#register-form").validate({
				rules: {
					email: {
						required: true,
						email: true,
						
					},
					username: {
						required: true,
						nowhitespace: true,
					},
					name: {
						required: true,
					},
					phone: {
						required: true,
					},
					password: {
						required: true,
						strongPassword: true
					},
					passwordC:	{
						required:	true,
						equalTo:	"#password"
					},
					accountName:"required",
					bankName:	"required",
					accountNumber: "required"
					},
					
					messages: {
						email: {
							required: 'please enter your email',
							email: 'please enter <em>valid</em> email address'
						}
					},
					submitHandler:user_validate
					
});

});
function updateProfile() {
	var oldPassword = $("#oldPassword").val();
	var newPassword = $("#newPassword").val();
	var retypePassword = $("#retypePassword").val();
		if(oldPassword =="" ||
			newPassword =="" ||
			retypePassword ==""){
				alert("Required field(s) empty");
		}else if(newPassword != retypePassword){
			alert("Password Does Not Matched");
		}else {
			$.post('../../Controllers/inc/updateProfile.php',{'oldPassword':oldPassword,'newPassword':newPassword,'retypePassword':retypePassword},function(result){
				if (result==1){
					alert("Can't find the Old Password");
				}else{
					alert("Update Successful");
					window.location = "view_profile.php"
				}
			})
		}
}

/*//upload form validate
function upload_validate(){
	$.ajax({
	url: '../../Controllers/inc/updateProfile.php',
	async: true,
	cache: false,
	data: $('#upload-form').serialize(),
	type: 'post',          
	success: function (data) {
		if(data == 1){
			$('#callback').fadeIn(700, function(){
			$('#callback').css({"font-weight":"bold","height":"70px","width":"350px","background-position":"center","text-align":"center","background":"#030","color":"#FFF"});
			$('#callback').html('<i class="fa fa-globe fa-spin"></i>&nbsp;&nbsp;Update Successful');
			$('#callback').fadeOut(4000);
			});
			window.location="viewProfile.php";
			}
		else if(data == 2){
			$('#callback').fadeIn(700, function(){
			$('#callback').css({"font-weight":"bold","height":"70px","width":"350px","background-position":"center","text-align":"center","background":"#900","color":"#FFF"});
			$('#callback').html('<i class="fa fa-warning"></i>&nbsp;&nbsp;Error occured');
			$('#callback').fadeOut(4000);
			});
		}
			else {
						
			alert(data +'BAD');
		}
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
		alert(textStatus);
		}
					
		});

 };

$(function(){
	$.validator.setDefaults({
		errorClass: 'help-block',
		highlight:	function(element){
			$(element)
			.closest('.form-group')
			.addClass('has-error');
		},
		unhighlight: function(element){
					$(element)
					.closest('.form-group')
					.removeClass('has-error');
		}
	});

			$("#upload-form").validate({
				rules: {
					oldPassword: {
						required: true,						
					},
					newPassword: {
						required: true,
						strongPassword: true
					},
					retypePassword:	{
						required:	true,
						equalTo:	"#newPassword"
					},
					},
					submitHandler:upload_validate
					
});

});
*/function decline_downline(emailDownline,emailSponsor,id) {
$.post('../../Controllers/inc/declineValidate.php',{'emailDownline':emailDownline,'emailSponsor':emailSponsor,'id':id},function(responseText){
		if(responseText==1){
			window.location="index.php";
		}
	});
	
}
function comfirm_downline(emailDownline,emailSponsor,id) {
$.post('../../Controllers/inc/confirmPayment.php',{'emailDownline':emailDownline,'emailSponsor':emailSponsor,'id':id},function(responseText){
if(responseText){
			window.location="index.php";
		}
	});
	
}
function payment_refuse(emailDownline,emailSponsor) {
$.post('../../Controllers/inc/refusepaymentValidate.php',{'emailDownline':emailDownline,'emailSponsor':emailSponsor},function(responseText){
if(responseText==1){
			window.location="index.php";
		}
	});
	
}

