<?php
 
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

if(!empty($_GET["host"]) && !empty($_GET["port"]) ){
if(is_numeric($_GET["port"])){	
$ip = trim($_GET["host"]);
$port = trim($_GET["port"]);
$color = @trim($_GET["color"]);
$volume = @trim($_GET["volume"]);
$hash = twinRand(18);
if(filter_var($ip, FILTER_VALIDATE_IP)){

if(empty($_GET["color"])){
	cPlayer($ip,$port,$hash);

}else{
	$realVolume = volume($volume);
	$SlideRealVolume = SlideVolume($volume);
if (preg_match('/([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $color))
{
	$color = "#".$color;
    	cPlayer($ip,$port,$hash,$realVolume,$color,$SlideRealVolume);
		
	
}else{
	
	cPlayer($ip,$port,$hash,$realVolume,"000000",$SlideRealVolume);
}


}


}
}
}


function SlideVolume($vols = 90){
	if(is_numeric($vols)){
		if ($vols > 90){
		
		return 90;
		
		}else{
		switch($vols){
		case 1:
        return 10;
		case 2:
	    return 20;
        case 3:
	    return 30;
		case 4:
	    return 40;
		case 5:
	    return 50;
		case 6:
	    return 60;
		case 7:
	    return 70;
		case 8:
	    return 80;
		default:
		return 90;
		
		}
		}
	}else{
		
		return 90;
		
	}
}


function volume($vols = 1){
	if(is_numeric($vols)){
		if ($vols > 100){
		
		return 1;
		
		}else{
		switch($vols){
		case 1:
        return 0.1;
		case 2:
	    return 0.2;
        case 3:
	    return 0.3;
		case 4:
	    return 0.4;
		case 5:
	    return 0.5;
		case 6:
	    return 0.6;
		case 7:
	    return 0.7;
		case 8:
	    return 0.8;
		default:
		
		return 1;
		
		}
		}
	}else{
		
		return 1;
		
	}
}

function twinRand($length = 18) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function cPlayer($ip,$port,$generated,$volume = "1",$color = "#000000",$volShit = "90"){
echo "<!DOCTYPE html><script type='text/javascript' src='https://code.jquery.com/jquery-1.11.2.min.js'></script><script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jplayer/2.9.2/jplayer/jquery.jplayer.js'></script><script type='text/javascript' src='twinhost_player.js'></script><style type='text/css'>* {margin:0px;padding:0px;}.html5player_".$generated." {width:150px;height:30px;position:relative;margin:0px;background:".$color.";webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;}.info_".$generated." {width:50px;}.controls_".$generated." {position:absolute;left:10px;top:7px;border-radius:4px;height:16px;width:16px;}.control-playing_".$generated." {background:url('pause.png') no-repeat -18px -18px;}.control-paused_".$generated." {background:url('play.png') no-repeat -18px -18px;}div.volume_".$generated." {width:50px;height:6px;left:90px;position:absolute;bottom:12px;background:#AAA;border-radius:4px;}div.duration_".$generated." {position:absolute;font-size:11px;font-family:Tahoma;left:36px;bottom:8px;color:#FFFFFF;}div.mute-button_".$generated." {width:16px;height:16px;background:url('speaker_white.png') no-repeat;background-size:100% 100%;font-size:10px;font-family:Tahoma;position:absolute;left:70px;bottom:7px;}div.vol-drag_".$generated." {position:absolute;left:".$volShit."%;border-radius:5px;height:14px;top:-5px;width:8px;background:#DDD;border:1px solid black;overflow:hidden;}div.vol-drag_".$generated.":hover {background:#FFF;}</style><div id='".$generated."' class='html5player_".$generated."' unselectable='on' ><div class='player-gutter_".$generated."'  style='overflow:hidden;'></div><div class='controls_".$generated." control-paused_".$generated."' unselectable='on' ></div><div class='info_".$generated."' unselectable='on' ><div class='duration_".$generated."' unselectable='on' >00:00</div><div class='mute-button_".$generated."' unselectable='on' ></div><div class='volume_".$generated."' unselectable='on' ><div class='vol-drag_".$generated."' unselectable='off' ></div></div></div></div><!--[if IE 6]><style type='text/css'>.control-playing_".$generated.", .control-paused_".$generated." { background:".$color."; }</style><script type='text/javascript'>$('.controls_".$generated."').prepend('<img style='margin:3px 0 0 0px;' src='ie6.gif' width='19' height='12' alt=''/>');</script><![endif]--><script type='text/javascript' >var useFlash = false;
var autoplay = true;if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {autoplay = false;}else{autoplay = true;}
new twinhost.createPlayer('http://".$ip.":".$port."','".$generated."',autoplay,useFlash,".$volume.");document.oncontextmenu=RightMouseDown;function RightMouseDown() { return false; }</script>";	
}



?>