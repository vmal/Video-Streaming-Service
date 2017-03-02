//events added to the event elements
$(document).ready(function () {
	
    //attempt to login
    $(document).on('click',"#UploadVideo", function () {
        document.location.href = "Create_New_Video.php";
    });
	
	//attempt to login
    $(document).on('click',"#home", function () {
        document.location.href = "index.php";
    });
	
	//attempt to login
    $(document).on('click',"#SignOut", function () {
		$.post("SignOut.php",
                function (data, status) {
                    if (status != "success") {
                        alert("Server Connection Failed");
                    }
                    else {
                        document.location.href = "Index.php";
                    }
                });
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
	
	function DisplayVideos(){
		var request = "username";
		
		$.post("Get_Videos.php", {byOrder: request},
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
