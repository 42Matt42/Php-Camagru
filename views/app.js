	// Set constraints for the video stream
	var constraints = { video: {
		width: { ideal: 640 },
		// height: { ideal: 360 }
	  }, audio: false };
	// { frameRate: { ideal: 10, max: 15 } }
	// video: { width: 1280, height: 720 }
	const	cameraView = document.querySelector("#camera--view"),
    		cameraOutput = document.querySelector("#camera--output"),
    		cameraCanvas = document.querySelector("#canvas"),
   			cameraTrigger = document.querySelector("#camera--trigger")

	// Access the device camera and stream to cameraView
	// Use the getUserMedia method to access the camera ; we make cameraView the source for the stream.
	function cameraStart() {
		// access the MediaDevices object
		navigator.mediaDevices
			.getUserMedia(constraints)
			// use the stream
        	.then(function(stream) {
				cameraView.srcObject = stream;
				cameraView.play();
			})
			.catch(function(err) { console.log("Camera desactivated"); });
	}

	// Take a picture when cameraTrigger is tapped
	cameraTrigger.onclick = function() {
		cameraCanvas.width = cameraView.videoWidth;
		cameraCanvas.height = cameraView.videoHeight;
		if (cameraCanvas.width != 0) {
    	cameraCanvas.getContext("2d").drawImage(cameraView, 0, 0);
		cameraOutput.src = cameraCanvas.toDataURL("image/png");
		}
	};

	// Start the video stream run when the page has finished loading
	window.addEventListener("load", cameraStart, false);
