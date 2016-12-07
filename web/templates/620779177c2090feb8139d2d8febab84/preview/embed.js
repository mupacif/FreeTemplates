(function() {
	var scripts = document.getElementsByTagName('script'),
		path = scripts[scripts.length-1].src,
		idx = path.lastIndexOf('?');
	if (idx !== -1) {
		path = path.substr(idx, path.length-1);
	}

	function $_GET(name) {
		var a = new RegExp(name+"=([^&#=]*)");
		a = a.exec(path);
		if (null === a) return false;
		return decodeURIComponent(a[1]);
	}





	var	game = $_GET('game'),
		width = parseInt($_GET('width'))+20 || 800,
		html = [],
		height = parseInt($_GET('height'))+30 || 480;


	if (false === game) {
		alert("ERROR: Please provide a 'game' argument!");
		return;
	}

	var url = 'games/'+ encodeURIComponent(game) + '/index.html';



		html.push(
			'<iframe src="' + url + '" width="' + width + '" height="' + height + '" frameborder="0" style="display:block" allowfullscreen></iframe>'
		);
	

	document.write(html.join(''));
    console.log(html.join(''));
})();