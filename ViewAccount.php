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
		}
		
		input{
			color: var(--base-text-color);
			border: 3px solid var(--border-color);
			background-color: var(--offset-base-color);
		}
		
		#header{
			height: 200px;
			width: 100%;
			background-color: var(--offset-base-color);
		}
		
		#GoHome{
			position: absolute;
			top: 5%;
			left: 0;
			padding-left: 100px;
		}
		
		#home{
			width: 100px;
			height: 100px;
		}
		
		#ProfileInfo {
			position: relative;
			display: table;
			margin: 0 auto;
			top: 10%;
			text-align: center;
			
		}
		
		#profilePic{
			height: 100px;
			width: 100px;
			border:1px solid var(--border-color);
		}
		
		#buttons{
			position: absolute;
			top: 8%;
			right: 0;
			padding-right: 100px;
		}
		
		#SignOut{
			font-size: 24px;
			margin-left: 50px;
			background-color: var(--button-color-nuetral);
		}
		
		#UploadVideo{
			font-size: 24px;
			background-color: var(--button-color-good);
		}
		
		#videoList{
			width: 100%;
			background-color: var(--base-color);
			text-align: center;
		}
		
		#VideosHeader{
			font-size: 50px;
			
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
		<div id="header">
			

			<div id="GoHome">
				<img id="home" src="OtherPics/home.png"></canvas>
			
			</div>

		
			<div id="ProfileInfo">
				<div>
					
					<?php
						if(isset($_SESSION["profilePicture"])){
							$pic = $_SESSION["profilePicture"];
							echo "<img id=profilePic src=$pic></img>";
						}

					?>
					
				</div>
				<div>
					<text style="font-size: 50px;"> 
					<?php
						if(isset($_SESSION["userName"])){

							echo $_SESSION["userName"];
						}
						else{
							echo "Please Sign In";
						}
					
					
					?>
					
					<text>
				</div>
			</div>
		
			<div id="buttons">
				<input type="button" id="UploadVideo" value="Upload"></input>
				<input type="button" id="SignOut" value="Sign Out"></input>
			</div>
		</div>
		
		<div id="videoList">
			<H1 id="VideosHeader">Your Videos</H1>
			<div id="videoContainer">
			</div>
		</div>
		<script src="Account_Manager.js"></script>
    </body>
</html>