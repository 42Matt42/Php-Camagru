<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p> ~ Take a picture ! ~ </p></h2>
	<p>
		SMIiiiiiiiiiiiLE ! 0_0<br><br>
		You can select a filter below. Then take a picture or upload one to mix them up !<br><br>
	</p>
    <main id="camera">
		<!-- Camera -->
		<nav class="level">
			<div>
				<div>
					<div class="level-left" class="columns">
						<div class="column"><article class="notification is-info">
							<!-- Camera sensor -->
							<!-- grab a frame from the video stream when we tell it to,and draw it to the next element we’ll create -->
							<canvas style="display: none"; id="canvas">
							</canvas>
							<!-- Camera view -->
							<!-- access the device’s camera and display the video stream -->
							<video id="camera--view" autoplay playsinline style="transform: scaleX(-1);">
							</video>
						</article></div>
						<div class="column"><article class="notification is-warning">
							<!-- Camera output -->
							<!-- display the picture after it’s taken -->
							<!-- that src ref prevents the empty image icon from showing without the browser showing a security warning -->
							<img src="//:0" alt="" id="camera--output" style="transform: scaleX(-1);">
						</article></div>
						<div class="column">
						<!-- Camera trigger -->
						<img src="" alt=" * NEW Picture ! * " id="camera--trigger" class="button is-link" class="button is-medium">
						</div>
					</div>
					<div class="level-left" class="columns">
						<div>
							<form action="upload" method="post" enctype="multipart/form-data">
								You may select a .png file to replace the camera picture:<br> <input type="file" name="upfile" id="upfile" accept="image/*"><br><br>
								<ul  style="display: block; margin-left: auto; margin-right: auto; width: 50%;">
								<li><label><img style="width: 120px;" src="uploads/background_1.png"><input type="radio" name="alpha" value="background_1" checked="checked"></label></li>
								<li><label><img style="width: 120px;" src="uploads/background_2.png"><input type="radio" name="alpha" value="background_2"></label></li>
								<li><label><img style="width: 120px;" src="uploads/background_3.png"><input type="radio" name="alpha" value="background_3"></label></li>
								<button class="button is-danger is-light" class="button is-medium" onclick="myFunction()">* UPLOAD ! *</button>
									<script>
										function myFunction() {
										if (document.getElementById("camera--output").src == "//:0") {
											document.getElementById("camera--check").value = "no_pic_taken";
										}
										else {
											document.getElementById("camera--final").value = document.getElementById("camera--output").src;
											document.getElementById("camera--check").value = "picture_on_the_way";
										}}
									</script>
								</ul>
								<input type="hidden" name="camera--final" id="camera--final" value="">
								<input type="hidden" name="camera--check" id="camera--check" value="awaiting_the_orders">
							</form>
						</div>
						<script src="views/app.js"></script>
						<div class="column" style="max-width: 250px">
							<div class="notification is-primary">
								<?php foreach($pictures as $picture): ?>
								By <?= $picture->users()->username() ?>
								<p><img style="width: 20vw;height: auto;" src="<?= $picture->picture_cam() ?>" /></p>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</main>
<?php
