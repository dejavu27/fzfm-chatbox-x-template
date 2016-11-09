  twinhost = {}; 
  twinhost.timeCount = 0;
   twinhost.timeString = function(time) {
time = Math.floor(time);
var min = (time/60);
var sec = Math.floor(time%60);
if(sec<10) {
sec = '0'+sec;
}
var hours = Math.floor(min/60);
if(hours<10) {
hours = '0'+hours;
}
min = Math.floor(min%60);
if(min<10) {
min = '0'+min;
}
return min+':'+sec;
}
twinhost.timeUpdate = function(gutter){
twinhost.timeCount = twinhost.timeCount + 1;
var str =twinhost.timeString(twinhost.timeCount);
$('div.duration_'+gutter).html(str);
}
twinhost.isTouchPad = (/hp-tablet/gi).test(navigator.appVersion);
twinhost.hasTouch = 'ontouchstart' in window && !twinhost.isTouchPad && !(/BlackBerry/gi).test(navigator.userAgent);
if( twinhost.hasTouch ) {
twinhost.ev = 'touchend';
twinhost.ed = 'touchstart'
twinhost.em = 'touchmove'
} else {
twinhost.ev = 'mouseup';
twinhost.ed = 'mousedown'
twinhost.em = 'mousemove'
}

twinhost.gScrollers = {};
twinhost.createPlayer= function(url,gutter,autostart,useflash,vols) {
var playerSolution = 'html, flash';
if (useflash==true){
playerSolution = 'flash, html';
}
this.PlayerID = twinhost.gPlayers.length;
this.player = $('#'+gutter).children('.player-gutter_'+gutter);
this.player.jPlayer({
ready: function() {
$(this).jPlayer('setMedia', {
mp3:$(this).data('data-src')
});
$(this).jPlayer('volume',vols);
if (autostart==true){
$(this).jPlayer('play');
$('div.controls_'+gutter).removeClass('control-paused_'+gutter).addClass('control-playing_'+gutter);
twinhost.clocker=window.clearInterval(twinhost.clocker);
twinhost.clocker = self.setInterval(function(){twinhost.timeUpdate(gutter)},1000);
}
},
supplied: 'mp3',
errorAlerts: 'false',
solution: ''+playerSolution+'',
swfPath: '/player',
wmode: 'window',
size: { width: "1px", height: "1px" }
}).data('data-src',url + '/;stream' + (new Date().getTime()) + '/1');
this.gutter = $('#'+gutter);
this.gutter.children('.info_'+gutter).children('.volume_'+gutter).on(twinhost.ed,function(e){
   var gutterId = $(this).children('.vol-drag_'+gutter).data('gutterId');
   var width = $(this).innerWidth();
   var pos = $(this).offset();
if(twinhost.hasTouch == true){
var x = ( e.originalEvent.touches[0].pageX - pos.left - 4 ) /width;
}else{
var x = (e.clientX - pos.left - 4) /width;
}
var vol;
if(x < 0.9 && x >= 0) {
   vol = x;
}else if(x<0){
vol = 0;
x = 0;
}else if(x>0.9){
x = 0.9;
vol = 1.0;
} 
var gutterId = $(this).children('.vol-drag_'+gutter).css({
left:(x*100)+'%'
   }).data('gutterId');
$(gutterId).children('.player-gutter_'+gutter).jPlayer('volume',vol);
});
this.gutter.children('.info_'+gutter).children('.volume_'+gutter).children('.vol-drag_'+gutter).on(twinhost.ed, function(e) {
e.stopPropagation();
twinhost.gScrollers.scroller = $(this);
$(document).on(twinhost.ev, function(e) {
$(document).off(twinhost.em);
$(this).off(twinhost.ev);
twinhost.gScrollers.scroller = null;
e.stopPropagation();
})
$(document).on(twinhost.em, function(e) {
e.preventDefault();  
e.stopPropagation();
if(twinhost.gScrollers.scroller != null) {
var parn = twinhost.gScrollers.scroller.parent();
var width = parn.innerWidth();
var pos = parn.offset();
var x;
if(twinhost.hasTouch == false){
 x = (e.clientX - pos.left - 4) /width;
}else{
var touches = e.originalEvent.touches;
x = (touches[0].pageX - pos.left -4) / width;
}
var vol;
if(x < 0.9 && x >= 0) {
   vol = x;
}else if(x<0){
vol = 0;
x = 0;
}else if(x>0.9){
x = 0.9;
vol = 1.0;
} 
var gutterId = twinhost.gScrollers.scroller.css({
left:(x*100)+'%'
}).data('gutterId');
$(gutterId).children('.player-gutter_'+gutter).jPlayer('volume',vol);
}
});
}).data('gutterId','#'+gutter);
this.gutter.children('.controls_'+gutter).on(twinhost.ev, function(e) {
e.stopPropagation();
var gutterid = $($(this).data('gutterId'));

var player = $($(this).data('gutterId')).children('.player-gutter_'+gutter);
var playing = player.data("jPlayer").status.paused;
if( playing == false) {
player.jPlayer('clearMedia');
player.jPlayer('setMedia', {
mp3:player.data('data-src')
});
gutterid.children('.controls_'+gutter).removeClass('control-playing_'+gutter).addClass('control-paused_'+gutter);
twinhost.clocker=window.clearInterval(twinhost.clocker);
} else if(playing == true) {
player.jPlayer('play');
gutterid.children('.controls_'+gutter).removeClass('control-paused_'+gutter).addClass('control-playing_'+gutter);
twinhost.clocker=window.clearInterval(twinhost.clocker);
twinhost.clocker = self.setInterval(function(){twinhost.timeUpdate(gutter)},1000);
}
}).data('gutterId','#'+gutter);
}
twinhost.XMLHttpFactories = [
function () {return new XMLHttpRequest()},
function () {return new ActiveXObject("Msxml2.XMLHTTP")},
function () {return new ActiveXObject("Msxml3.XMLHTTP")},
function () {return new ActiveXObject("Microsoft.XMLHTTP")}
];

  twinhost.XHR = function() {
var xmlhttp = false;
for (var i=0;i<twinhost.XMLHttpFactories.length;i++) {
try {
xmlhttp = twinhost.XMLHttpFactories[i]();
}
catch (e) {
continue;
}
break;
}
return xmlhttp;
}
twinhost.gPlayers = [];
jQuery.support.cors = true;