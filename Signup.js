//events added to the event elements
$(document).ready(function () {
    //attempt to login
    $("#Confirm").click(function () {
            var userName = $("#userName").val();
            var Password = $("#password").val();
            var ConfirmPassword = $("#confirmPassword").val();
			var UserPic = $("#profilepic").attr('src');
			if(userName=="" || Password==""){
				$("#error").html("All Fields Need To Be Filled");
			}
			else if(Password!=ConfirmPassword){
				$("#error").html("Passwords Must Match");
			}
			else{
            //from account info given send request to signup
				$.post("Signup.php", { userName: userName, Password: Password, UserPic: UserPic},
					function (data, status) {
						//$("#error").html(data);
						//return;
						if (status != "success") {
							$("#error").html("server connection failed");
						}
						else {
							var response = JSON.parse(data);
							if (response.success) {
								document.location.href ="SignIn.html";
							}
							else {
								$("#error").html(response.details);
							}
					}
				});
			}
    });
    
    $("#Cancel").click(function () {
        document.location.href ="SignIn.html";
    });
    
	//change profile pic
	$("#profilepic").click(function(){
		$.post("ViewProfilePics.php",
					function (data, status) {
						if (status != "success") {
							$("#error").html("server connection failed");
						}
						else {
							var response = JSON.parse(data);
							if (response.success) {
								var container = $("<div></div>");
								container.css({
									"position": "absolute",
									"top":"257px",
									"left": "44.6%",
									"height": "155px",
									"overflow": "auto",
									"backgroundColor":"#E7E7E7" 
								})
								var imageBlock = $("<table id=availablePictures></table>");

								for(var i = 0; i < response.Pics.length; i++){
									var row = $("<tr></tr>");
									var img = $("<img src=" + response.Pics[i] + " width=150 height=150></img>");
									img.click(function(){
										$("#profilepic").attr('src',$(this).attr('src'));
										container.remove();
									});
									row.html(img);
									imageBlock.append(row);
								}
								container.html(imageBlock);
								$("#box").append(container);
							}
						}
				});
	});
	
	
});
