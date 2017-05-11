function displayPics()
{
	var photos = document.getElementById('mini');
	var liens = photos.getElementsByTagName('a');
	var big_photo = document.getElementById('big_pict');
	var obj = document.getElementById('valobj');
	for (var i = 0 ; i < liens.length ; ++i) {
		liens[i].onclick = function() {
			big_photo.src = this.href;
			big_photo.alt = this.title;
			obj.value = this.href;
			return false;
			};
	}
}
window.onload = displayPics;
