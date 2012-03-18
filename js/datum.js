// JavaScript Document
// Einfache Uhr
// <script src="js/datum.js" type="text/javascript"></script>
// <script type="text/javascript">writeclock()</script>

var clockid=new Array()
var clockidoutside=new Array()
var i_clock=-1
var thistime= new Date()
var Tag = thistime.getDate();
var Jahresmonat = thistime.getMonth();
var Monat = new Array("1","2","3","4","5","6","7","8","9","10","11","12");
var Jahr =thistime.getYear();
<!-- Hier die Variabeln für die Zeit -->
var hours=thistime.getHours() 
var minutes=thistime.getMinutes()
var seconds=thistime.getSeconds()
if (eval(hours) <10) {hours="0"+hours}
if (eval(minutes) < 10) {minutes="0"+minutes}
if (seconds < 10) {seconds="0"+seconds}
if (Jahr<2000) Jahr=Jahr+1900;
var thistime = Tag +"." + Monat[Jahresmonat] + "."+ Jahr +"&nbsp;&nbsp;" + hours + ":" + minutes + ":" + seconds
	
function writeclock() {
	i_clock++
	if (document.all || document.getElementById || document.layers) {
		clockid[i_clock]="clock"+i_clock
		document.write("<font family=arial><span id='"+clockid[i_clock]+"' style='position:relative'>"+thistime+"</span></font>")
	}
}

function clockon() {
	thistime= new Date()
	Tag = thistime.getDate();
	Jahresmonat = thistime.getMonth();
	Monat = new Array("1","2","3","4","5","6","7","8","9","10","11","12");
	Jahr =thistime.getYear();
	<!-- Hier die Variabeln für die Zeit -->
	hours=thistime.getHours()
	minutes=thistime.getMinutes()
	seconds=thistime.getSeconds()
	if (eval(hours) <10) {hours="0"+hours}
	if (eval(minutes) < 10) {minutes="0"+minutes}
	if (seconds < 10) {seconds="0"+seconds}
	if (Jahr<2000) Jahr=Jahr+1900;
	thistime = Tag +"." + Monat[Jahresmonat] + "."+ Jahr +"&nbsp;&nbsp;" + hours + ":" + minutes + ":" + seconds + " Uhr"
		
	if (document.all) {
		for (i=0;i<=clockid.length-1;i++) {
			var thisclock=eval(clockid[i])
			thisclock.innerHTML=thistime
		}
	}
	
	if (document.getElementById) {
		for (i=0;i<=clockid.length-1;i++) {
			document.getElementById(clockid[i]).innerHTML=thistime
		}
	}
	var timer=setTimeout("clockon()",1000)
}
window.onload=clockon
