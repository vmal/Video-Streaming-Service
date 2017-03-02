<?php
session_start();
?>
<html> 
	<head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
        <meta charset="utf-8" />
        <title>Video For You</title>
		<style>
		
		:root {
				--base-color: #FFFFFF;
				--offset-base-color: #E7E7E7;
				--base-text-color: #1A1A1A;
				--border-color: #727272;
				--place-holder-text-color: #727272;
				--button-color-good: #A6F156;
				--button-color-nuetral: #56D7F1;
				--error-color: #9E1A05;
				--button-not-toggled: #A4BEC1;
		}
		
		
		#content{

			margin: auto;
			background-color: var(--offset-base-color);
			width:500px;
			height: 650px;
			padding: 10px;
			text-align: center;
		}
		
		H1{
			font-size: 50px;
		}
		
		text{
			font-size: 40px;
			
		}
		
		input[type=file] {
			display: none;
		}
		
		input{
			font-size: 24px;
			color: var(--base-text-color);
			border: 3px solid var(--border-color);
			background-color: var(--offset-base-color);
		}
		
		.custom-file-upload {
			border: 1px solid var(--border-color);
			display: inline-block;
			padding: 6px 12px;
			cursor: pointer;
			font-size: 24px;
			width: 200px;
			background-color: var(--button-color-nuetral);
		}
		
		.ToggleButton{
			background-color: var(--button-not-toggled);
			border-radius:40px/24px;
		}
		
		#cancel{
			background-color: var(--button-color-nuetral);
		}
		
		#submit{
			background-color: var(--button-color-good);
		}
		
		</style>
    </head>
    <body>
		<div id="content"> 
			<H1>Upload Video</H1>
			
			
			
			<div>
			<text>Video Name</text>
			</div>
			
			<div>
			<input id="VideoName" type="text" placeholder="Enter Video Name"></input>
			</div>
			
			<br></br>
			
			<div>
			<text>Video Thumbnail</text>
			</div >
			<div>
				<label for="thumbnailUpload" class="custom-file-upload">
					Select Thumbnail
				</label>
				<input id="thumbnailUpload" type="file"/ accept="image/*"/>
			</div>
			
			<div id="selectedThumbnail" style="font-size: 20px;  height: 40px;">
				
			</div >

			
			<div>
			<text>Video file</text>
			</div>
			
			<div>
				<label for="videoUpload" class="custom-file-upload">
					Select Video
				</label>
				<input id="videoUpload" type="file" accept="video/mp4"/>
			</div>
			
			<div id="selectedVideo" style="font-size: 20px; height: 40px;">
				
			</div >
			
			<div>
				<input type="button" class="ToggleButton" id="tag1" value="Funny"></input>
				<input type="button" class="ToggleButton" id="tag2" value="Educational"></input>
				<input type="button" class="ToggleButton" id="tag3" value="Music"></input>
				<input type="button" class="ToggleButton" id="tag4" value="News"></input>
			</div>
			
			<div>
				<input type="button" class="ToggleButton" id="tag5" value="Animal"></input>
				<input type="button" class="ToggleButton" id="tag6" value="VideoGame"></input>
				<input type="button" class="ToggleButton" id="tag7" value="Sports"></input>
				<input type="button" class="ToggleButton" id="tag8" value="MovieTrailers"></input>
			</div>
			
			<br>
			<div>
				<input type="button" id="cancel" value="Cancel"></input>
				<input type="button" id="submit" value="Submit"></input>
			</div>
			
			
			
		<div>
		<div id="status"></div>
		<script src="Upload_Manager.js"></script>
    </body>
</html>