//events added to the event elements
$(document).ready(function () {
    //attempt to login
    $("#LoginButton").click(function () {
        var userName = $("#userName").val();
        var Password = $("#password").val();
		if(userName=="" || Password==""){
			$("#error").html("Must Provide User Name And Password");
		}
		else{
            $.post("SignIn.php", { userName: userName, Password: Password },
                function (data, status) {
                    //$("#error").html(data);
                    //return;
                    if (status != "success") {
                        $("#error").html("Server Connection Failed");
                    }
                    else {
                        var response = JSON.parse(data);
                        if (response.success) {
                            document.location.href = "Index.php";
                        }
                        else {
                            $("#error").html(response.details);
                        }
                    }
                });
		}
    })
    
    $("#SignupButton").click(function () {
        document.location.href = "Signup.html";
    })
	
	$("#Cancel").click(function () {
        document.location.href = "index.php";
    })
});
