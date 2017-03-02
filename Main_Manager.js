//events added to the event elements
$(document).ready(function () {
	
	var toggle_color = "rgb(0, 175, 195)";
	var not_toggled_color = "rgb(164, 190, 193)";
	
    //attempt to login
    $(document).on('click',"#SignInButton", function () {
        document.location.href = "SignIn.html";
    });
	
	//attempt to login
    $(document).on('click',"#profilePic", function () {
        document.location.href = "ViewAccount.php";
    });
	
	//toggle search tags
	$(document).on("click",".ToggleButton",function(){
		var color = $(this).css("background-color")
		if(color == not_toggled_color){
			$(this).css("background-color" , toggle_color)
		}
		else{
			$(this).css("background-color" , not_toggled_color)
		}
	});
	
	//pull video up and allow user to watch it
	$(document).on("click",".watchVideo",function(){
		var box = $("#videoBox");
		var video = $("<video width=500 height=500 controls></video>")
		var source = $("<source src=" + $(this).attr("id") + " type=video/mp4>");
		video.append(source);
		video.append("Videos Are Not Supported By This Browser");
		box.html(video);
		box.show();
		$("#fadeOut").show();
	});
	$(document).on("click","#fadeOut",function(){
		$("#videoBox").html("");
		$("#videoBox").hide();
		$("#fadeOut").hide();
	});

	//apply search toggles
	$(document).on("click","#Search",function(){
		DisplayVideos();
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
	
	function DisplayVideos(){
		var tags = getTagString();
		var request = "tag";	
		
		$.post("Get_Videos.php", { Tags: tags, byOrder: request},
					function (data, status) {
						//$("#videoContainer").html(data);
						//return;
						if (status != "success") {
							$("#videoContainer").html("server connection failed");
						}
						else {
							var response = JSON.parse(data);
							if (response.success) {
								var videos = response.videos;
								var table = $("<table border=1 frame=hsides rules=rows></table>");
								for(var i = 0; i < videos.length; i++){
									var vid = videos[i];
									var row = $("<tr class=\"watchVideo\" id=\"" + vid["path"] + "\"></tr>");
									var imgCell = $("<td align=right></td>");
									var img = $("<image class=videoPics src=\"" + vid["thumb"] + "\"></image>")
									var nameCell = $("<td></td>");
									var name = $("<H2>" + vid["name"] + "</H2>");
									var tags = $("<div>Tags: " + vid["tags"] + "</div>");
									var creator = $("<div>Created By: " + vid["creator"] + "</div>");
									
									imgCell.append(img);									
									
									nameCell.append(name);
									nameCell.append(tags);
									nameCell.append(creator);
																		
									row.append(imgCell);
									row.append(nameCell);
									table.append(row);
								}
								$("#videoContainer").html(table);
							}
							else {
								$("#videoContainer").html(response.details);
							}
					}
				});
	}
	

	DisplayVideos();
	
});
