// JavaScript Document
	
// JavaScript Document
/*function user_validate(){
	$('#register-form').serialize();
		var txtcaptcha = $("#txtCaptchaCode").val();
		var hiddenCaptcha = $("#hiddenCaptcha").val();
		var referral=$("#referral").val();
		var username=$("#username").val();
		var name=$("#name").val();
		var gender=$("#gender").val()
		var state=$("#state").val();
		var email=$("#email").val();
		var phone=$("#number").val();
		var password=$("#password").val();
		var accountName=$("#accountName").val();
		var accountNumber=$("#accountNumber").val();
		var bankName=$("#bankName").val();
		var package=$("#package").val();
			if (txtcaptcha == hiddenCaptcha) {
					alert("NICE CAPTCHA");
					e.preventDefault();
					}else {
					alert("wrong");
					e.preventDefault();
			}
			$.post('Controllers/inc/validateRegistration.php',{'username':username,'name':name,'gender':gender,'state':state,'email':email,'phone':phone,
				'password':password,'accountName':accountName,'accountNumber':accountNumber,'bankName':bankName,'package':package},function(result){
					if(result==1){
						alert(result);
						e.preventDefault();
					}else{
						alert(result);
						e.preventDefault();
					}
					e.preventDefault();
				});
				
/*				$('.error').fadeOut(500);
				window.location='admission-step2.php';*/
				
/*}
submitHandler:user_validation();*/
