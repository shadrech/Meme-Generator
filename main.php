<?php require_once('helper.php'); ?>
<?php
	$arr = array('title'=>'Meme Generator 1.0', 'cssFile'=>'memeStyle.css');
	createTemplate($arr, 'header');
?>
<div class="container">
	<div class="row">
		<h3><?= $arr['title'] ?></h3>
		<form class="form-horizontal">
			<div class="form-group">
				<label for="imageSelector" class="col-sm-4 control-label">Select image: </label>
				<div class="col-sm-8">
					<select class="form-control" id="imageSelector" onchange="updateMeme()">
						<option value="images/splash.jpg">Free shower</option>
						<option value="images/bill.jpg">Not Bill again!</option>
						<option value="images/moon_jump.jpg">Moon Jump</option>
						<option value="images/baller.jpg">Headless baller</option>
						<option value="images/birds.jpg">Bird jar</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="topLabel" class="col-sm-2 control-label">Top Label: </label>
				<div class="col-sm-10">
					<input type="text" id="topLabel" class="form-control" oninput="textUpdate(event)" />
				</div>
			</div>
			<div class="form-group">
				<label for="bottomLabel" class="col-sm-2 control-label">Bottom Label: </label>
				<div class="col-sm-10">
					<input type="text" id="bottomLabel" class="form-control" oninput="textUpdate(event)" />
				</div>
			</div>
		</form>
	</div>
	<div class="row">
		<canvas id="c" width="550" height="500"></canvas>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p class="instructions">To save the image just right click on it and select 'Save Picture As' from dropdown menu</p>
		</div>
	</div>
</div>
<script type="text/javascript">
	var canvas = document.querySelector('#c');
	var	context = canvas.getContext('2d');
	context.textAlign = 'center';
	context.fillStyle = 'white';
	context.strokeStyle = 'black';
	var img = new Image();
	//create Text Objects which hold text String, size variable, and any other future value we may decide to add
	var Text = function(){
		this.text = "";
		this.size = 50;
	};
	Text.prototype = {
		/** Dilates (enlarges) text by factor of 10, then sets new text size into canvases context Object */
		dilate : function(){
			this.size += 10;
		context.font = this.size + "pt Impact";
		},
		/** Shrinks text by factor of 10, then sets new text size into canvases context Object */
		shrink : function(){
			this.size -= 10;
			context.font = this.size + "pt Impact";
		}
	};
	var topText = new Text();
	var bottomText = new Text();

	window.onload = function(){ //initial image setup
		updateMeme();
	};

	function textUpdate(event){
		// find out which element fired event (event.target.id) and assign inputted text with corresponding global text variable (topText / bottomText)
		if (event.target.id == "topLabel"){
			topText.text = event.target.value;
		} else {
			bottomText.text = event.target.value;
		}
		updateMeme();
	}
		function updateMeme(){
		context.clearRect(0, 0, canvas.width, canvas.height);
		loadMemeImage();
	}
	function loadMemeImage(){
		img = new Image();
		img.onload = function(){
			context.drawImage(img, 0, 0, canvas.width, canvas.height);
			loadMemeText();
		};
		img.src = document.querySelector('#imageSelector').value;
	}
	function loadMemeText(){
		//top text
		context.font = topText.size + "pt Impact";
		var textWidth = context.measureText(topText.text).width; // width of text before being written to canvas
		if (textWidth >= canvas.width-50 && topText.size >= 30) { //text too big must be minimised
			topText.shrink();
		} else if (textWidth <= canvas.width/2 && topText.size <= 50) {
			topText.dilate();
		}
		context.fillText(topText.text, canvas.width/2, topText.size+20);
		context.strokeText(topText.text, canvas.width/2, topText.size+20);

		//bottom text
		context.font = bottomText.size + "pt Impact";
		textWidth = context.measureText(bottomText.text).width;
		if (textWidth >= canvas.width-50 && bottomText.size >= 30) { //text too big must be minimised
			bottomText.shrink();
		} else if (textWidth <= canvas.width/2 && bottomText.size <= 50) {
			bottomText.dilate();
		}
		context.fillText(bottomText.text, canvas.width/2, canvas.height-20);
		context.strokeText(bottomText.text, canvas.width/2, canvas.height-20);
	}
</script>
<?php createTemplate(array(), 'footer'); ?>