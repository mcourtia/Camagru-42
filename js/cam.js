(function cam() {
	var streaming = false,
		video = document.querySelector('#video'),
		cover = document.querySelector('#cover'),
		canvas = document.querySelector('#canvas'),
		photo = document.querySelector('#photo'),
		startbutton = document.querySelector('#startbutton'),
		width = 400,
		height = 0;
	navigator.getMedia = (navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia);
	navigator.getMedia(
		{
			video: true,
			audio: false
		},
		function(stream) {
			if (video)
			{
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				}
				else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
			video.play();
			}
		},
		function(err) {
			console.log("An error occured !" + err);
		}
	);
	if (video)
	{
		video.addEventListener('canplay', function(ev){
			if (!streaming) {
				height = video.videoHeight / (video.videoWidth/width);
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);
		startbutton.addEventListener('click', function(ev){
			takepicture();
			ev.preventDefault();
		},false);
	}
	function takepicture() {
		canvas.width = width;
		canvas.height = height;
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		var data = canvas.toDataURL('image/png');
		var form = document.createElement('form');
		form.method = 'post';
		form.action = 'main.php';
		var input = document.createElement('input');
		input.name = 'img';
		input.value = data;
		var big_img = document.getElementById('big_pict');
		var obj = document.createElement('input');
		obj.name = 'obj';
		obj.value = big_img.src;
		form.appendChild(obj);
		form.appendChild(input);
		document.body.appendChild(form);
		form.submit();
	}
})();
