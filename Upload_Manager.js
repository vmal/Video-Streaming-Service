//events added to the event elements
$(document).ready(function () {
	
	var toggle_color = "rgb(0, 175, 195)";
	var not_toggled_color = "rgb(164, 190, 193)";
	$("#thumbnailUpload").change(function(){
		var filepath = $('#thumbnailUpload').val();
		if(filepath.substring(filepath.length-4) === ".png"){
			var filename = filepath.split("\\").pop();
			$("#selectedThumbnail").html(filename);
		}
		else{
			$("#selectedThumbnail").html("Invalid File");
			$('#thumbnailUpload').val("");
		}
		
	})
	
	$("#videoUpload").change(function(){
		var filepath = $('#videoUpload').val();
		
		if(filepath.substring(filepath.length-4) === ".mp4"){
			var filename = filepath.split("\\").pop();
			$("#selectedVideo").html(filename);
		}
		else{
			$("#selectedVideo").html("Invalid File");
			$('#videoUpload').val("");
		}
	})
	
	$(document).on("click","#cancel",function(){
		document.location.href = "ViewAccount.php";
	});
	
	
	$("#submit").click(function() {
		var tags = getTagString();
		var VideoName = $("#VideoName").val();
        var ThumbNail = $("#thumbnailUpload").prop("files")[0];
		var Video = $("#videoUpload").prop("files")[0];

		if(!VideoName || !ThumbNail || !Video){
			alert("All Fields Must Be Filled");
			return;
		}

		if(!/\w+$/.test(VideoName)){
			alert("Title Has Illegal Characters");
			return;
		}
		
		if(tags == "00000000"){
			alert("Must Select Atleast One Tag");
			return;
		}
		
		var formData = new FormData();
		formData.append("Tags",tags);
		formData.append("VideoName",VideoName);
		formData.append("ThumbNail",ThumbNail);
		formData.append("Video",Video);

		$.ajax({
			url: "Add_Video.php",
			type: 'POST',
            success: completeHandler = function(data) {
				//$("#status").html(data);
				//return;
                var response = JSON.parse(data);
                if (response.success) {
                    document.location.href = "ViewAccount.php";
                }
                else {
					$("#status").html(response.details);
                }
            },
            error: errorHandler = function() {
                $("#status").html("Server Connection failed");
            },

			data: formData,
			processData: false,
			contentType: false
		});
		
		
	});
	
	$(document).on("click",".ToggleButton",function(){
		var color = $(this).css("background-color")
		if(color == not_toggled_color){
			$(this).css("background-color" , toggle_color)
		}
		else{
			$(this).css("background-color" , not_toggled_color)
		}
	});
	
	function getTagString(){
		var tags = ""
		for(var i = 1; i <= 8; i++){
			var category = "#tag" + i;
			var color = $(category).css("background-color");
			if(color == toggle_color){
				tags += "1";
			}
			else{
				tags += "0";
			}
		}
		return tags;
	}
	
});
