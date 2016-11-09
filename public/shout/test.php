<!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(window).load(function(){
function updateTime(){
	setInterval(function(){
	var cur = document.getElementById('player').currentTime;
	if(cur > 60){
	var minute = parseInt(cur/60,10);
	var seconds = parseInt(cur-minute*60,10);
	if(seconds < 10){
	cur = (minute)+" : 0"+(seconds);
	}
	else {
	cur = (minute)+" : "+(seconds);
	}
	}
	else {
	if(cur < 10){
	cur = "0 : 0"+parseInt(cur,10)
	}
	else {
	cur = "0 : "+parseInt(cur,10);
	}
	}
	$('.duration').html(cur);
	},1000);
	}
	updateTime();
	$(".play").click(function(){
	document.getElementById('player').play();
	updateTime();
	});
	$(".pause").click(function(){
	document.getElementById('player').pause();
	updateTime();
	});
	$('input[name="volume"]').change(function(){
	var x = $(this).val();
	//alert(x/10);
	var vol = x/10;
	document.getElementById('player').volume = vol;
	});
	setInterval(function(){
	getDetails();
	},5000);
	function getDetails(){
	$.ajax({
	url: '/best/details.php',
	crossDomain: true,
	dataType: 'json',
	success: function(data){ 
	$('#content').html("");
	$('#content').append('<strong>Server Title:</strong> ' + data.SERVERTITLE + '<br>');
	$('#content').append('<strong>Now Playing:</strong> ' + data.SONGTITLE + '<br>');
	$('#content').append('<strong>Server Bitrate:</strong> ' + data.BITRATE + '<br>');
	$('#content').append('<strong>Listener:</strong> ' + data.CURRENTLISTENERS+ '<br>');
	refreshArtwork(data.SONGTITLE);
	}
	});
	}
	function refreshArtwork(track) {    
	$.ajax({
	url: 'https://itunes.apple.com/search',
	data: {
	term: track,
	media: 'music'
	},
	dataType: 'jsonp',
	success: function(json) {
	if(json.results.length === 0) {
	$('img[name="nowplayingimage"]').attr('src', 'http://www.paddywax.com/c.685897/site/img/noImageAvailable.jpg');
	return;
	}
	// trust the first result blindly...
	var artworkURL = json.results[0].artworkUrl100;
	$('img[name="nowplayingimage"]').attr('src', artworkURL);
	}
	});
	}
});
</script>
<style type="text/css">
input[type="range"] {
    -webkit-appearance: none;
    border: 1px solid black;
    position: absolute;
    top: 18px;
    display: block;
    width: 63%;
    height: 15px;
 
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;
    background-color: #242323;
    left: 90px;
 
    -webkit-box-shadow: inset 0px 4px 4px rgba(0,0,0,.6);
    -moz-box-shadow: inset 0px 4px 4px rgba(0,0,0,.6);
    box-shadow: inset 0px 4px 4px rgba(0,0,0,.6);
}
input::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    border:1px solid black;
 
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: #80e4df; /* Old browsers */
background: -webkit-linear-gradient(top, #80e4df 0%, #75dbd6 13%, #5ec4bf 33%, #57bbb6 47%, #419d99 80%, #378f8b 100%);
 
    background: -moz-linear-gradient(top, #80e4df 0%, #75dbd6 13%, #5ec4bf 33%, #57bbb6 47%, #419d99 80%, #378f8b 100%);
    background: -o-linear-gradient(top, #80e4df 0%, #75dbd6 13%, #5ec4bf 33%, #57bbb6 47%, #419d99 80%, #378f8b 100%);
    background: linear-gradient(top, #80e4df 0%, #75dbd6 13%, #5ec4bf 33%, #57bbb6 47%, #419d99 80%, #378f8b 100%); /* W3C */
}
</style>
</head>
<body>
<a href="#" class="play">Play</a><br>
<a href="#" class="pause">Stop</a><br>
<a href="#" class="duration">...</a><br>
<input type="range" name="volume" min="0" max="10"><br>
<div id="content">
	loading...
</div>
<img name="nowplayingimage" width="100px" height="100px" />
<audio controls src="http://50.116.107.13:8050/stream;" autoplay style="display:none" id="player"></audio>
</body>
</html>
