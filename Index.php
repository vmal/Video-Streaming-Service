<?php
session_start();
?>



<html> 
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
        <meta charset="utf-8" />
        <title>Videos For You</title>
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
			
			input{
				color: var(--base-text-color);
				border: 3px solid var(--border-color);
				background-color: var(--offset-base-color);
			}
			
			#profile{
				position:absolute;
				font-size: 24px;
				top:0;
				right:0;
				padding: 20px;
			}
			
			#profilePic{
				height: 50px;
				width: 50px;
					
			}
			
			#SignInButton{
				font-size: 24px;
				background-color: var(--button-color-good);
			}
			#controllBox{
				background-color: var(--offset-base-color);
				width: 100%;
				height:175px;
			}
			#SearchToggles{
				position:relative;
				top:10%;
				margin-left:auto;
				margin-right:auto;
				width: 500px;
				height:100px;
				text-align: center;
				
			}
			
			#VideoDisplay{
				width: 100%;
				font-size: 32px;
				text-align: center;
			}
			
			.ToggleButton{
				background-color: var(--button-not-toggled);
				border-radius:40px/24px;
				font-size: 24px;
			}
			
			#Search{
				background-color: var(--button-color-good);
				font-size: 24px;
				
			}
			
			table{
				margin: 0 auto;
				width: 100%
			}
			
			td{
				padding-bottom: 50px;
				padding-right: 40px;
				width: 50%;
				font-size: 20px;
				background-color: var(--offset-base-color);
			}
			
			.videoPics{
				height: 100px;
				width: 100px;
				
			}
			
			
			#fadeOut{
				display: none;
				opacity: .8;
				position: absolute;
				background: #FFF;
				width: 100%;
				height: 100%;
				z-index: 1;
				x-index: 0;
				y-index:0;
			}
			
			#videoBox{
				display: none;
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				z-index: 10;
				background-color: 0;
			}



			
			
		</style>
    </head>
	<body>
	<div id="fadeOut"></div>
	<div id="videoBox"></div>
	
	<div id="controllBox">
		<div id="profile">
			<?php
				if(isset($_SESSION["profilePicture"])){
					$pic = $_SESSION["profilePicture"];
					echo "<img id=profilePic src=$pic></img>";
				}
				else{
					echo "<input id=SignInButton type=button value=\"Sign In\"></button>";
				}
			?>
		</div>
		
		<div id="SearchToggles">
			<div>
				<input type="button" class="ToggleButton" id="tag1" value="Funny"></input>
				<input type="button" class="ToggleButton" id="tag2" value="Educational"></input>
				<input type="button" class="ToggleButton" id="tag3" value="Music"></input>
				<input type="button" class="ToggleButton" id="tag4" value="News"></input>
			</div>
			<br>
			<div>
				<input type="button" class="ToggleButton" id="tag5" value="Animal"></input>
				<input type="button" class="ToggleButton" id="tag6" value="VideoGame"></input>
				<input type="button" class="ToggleButton" id="tag7" value="Sports"></input>
				<input type="button" class="ToggleButton" id="tag8" value="MovieTrailers"></input>
			</div>
			<br>
			<div>
				<input type="button" id="Search" value="Search"></input>
			</div>
			
		</div>
	</div>
	
	<div id="VideoDisplay">
		<h1>Videos</h1>
		<div id="videoContainer">
		</div>
	
	</div>
		
	<script src="Main_Manager.js"></script>
		

    </body>
</html>
