<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML> 
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跳转提示</title>
<style type="text/css">
*{ padding: 0; margin: 0; }
body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
.system-message{ padding: 24px 48px; }
.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
.system-message .jump{ padding-top: 10px}
.system-message .jump a{ color: #333;}
.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}

.msgdiv{
-moz-border-radius: 40px;
-webkit-border-radius: 40px;
border-radius: 40px;
/*IE 7 AND 8 DO NOT SUPPORT BORDER RADIUS*/
-moz-box-shadow: 0px 0px 20px #6aff66;
-webkit-box-shadow: 0px 0px 20px #6aff66;
box-shadow: 0px 0px 20px #6aff66;
/*IE 7 AND 8 DO NOT SUPPORT BLUR PROPERTY OF SHADOWS*/
filter: progid:DXImageTransform.Microsoft.gradient(GradientType = 1, startColorstr = '#ff784f', endColorstr = '#c0ff82');
/*INNER ELEMENTS MUST NOT BREAK THIS ELEMENTS BOUNDARIES*/
/*Element must have a height (not auto)*/
/*All filters must be placed together*/
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType = 1, startColorstr = '#ff784f', endColorstr = '#c0ff82')";
/*Element must have a height (not auto)*/
/*All filters must be placed together*/
background-image: -moz-linear-gradient(left, #ff784f, #c0ff82);
background-image: -ms-linear-gradient(left, #ff784f, #c0ff82);
background-image: -o-linear-gradient(left, #ff784f, #c0ff82);
background-image: -webkit-gradient(linear, left top, right top, from(#ff784f), to(#c0ff82));
background-image: -webkit-linear-gradient(left, #ff784f, #c0ff82);
background-image: linear-gradient(left, #ff784f, #c0ff82);
-moz-background-clip: padding;
-webkit-background-clip: padding-box;
background-clip: padding-box;
/*Use "background-clip: padding-box" when using rounded corners to avoid the gradient bleeding through the corners*/
/*--IE9 WILL PLACE THE FILTER ON TOP OF THE ROUNDED CORNERS--*/
opacity: 0.47;
-ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity = 47);
/*-ms-filter must come before filter*/
filter: alpha(opacity = 47);
/*INNER ELEMENTS MUST NOT BREAK THIS ELEMENTS BOUNDARIES*/
/*All filters must be placed together*/


	width:400px;
	margin:0px auto;
	margin-top:180px;
	text-align:center;
}
</style>
</head>
<body>
<div class="system-message">
	<div class="msgdiv">
		<img src="<?php echo (PUBLIC_PATH); ?>/IMG/error.png"/>
		<p class="error"><?php echo ($noteString); ?></p>
		<p class="jump">
		页面自动 <a id="href" href="/index.php/Admin/Index">跳转</a> 等待时间： <b id="wait">3</b>
		</p>
	</div><p class="detail"></p>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time == 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>
<script type="text/javascript">
(function(){
var tab_tit  = document.getElementById('think_page_trace_tab_tit').getElementsByTagName('span');
var tab_cont = document.getElementById('think_page_trace_tab_cont').getElementsByTagName('div');
var open     = document.getElementById('think_page_trace_open');
var close    = document.getElementById('think_page_trace_close').childNodes[0];
var trace    = document.getElementById('think_page_trace_tab');
var cookie   = document.cookie.match(/thinkphp_show_page_trace=(\d\|\d)/);
var history  = (cookie && typeof cookie[1] != 'undefined' && cookie[1].split('|')) || [0,0];
open.onclick = function(){
	trace.style.display = 'block';
	this.style.display = 'none';
	close.parentNode.style.display = 'block';
	history[0] = 1;
	document.cookie = 'thinkphp_show_page_trace='+history.join('|')
}
close.onclick = function(){
	trace.style.display = 'none';
this.parentNode.style.display = 'none';
	open.style.display = 'block';
	history[0] = 0;
	document.cookie = 'thinkphp_show_page_trace='+history.join('|')
}
for(var i = 0; i < tab_tit.length; i++){
	tab_tit[i].onclick = (function(i){
		return function(){
			for(var j = 0; j < tab_cont.length; j++){
				tab_cont[j].style.display = 'none';
				tab_tit[j].style.color = '#999';
			}
			tab_cont[i].style.display = 'block';
			tab_tit[i].style.color = '#000';
			history[1] = i;
			document.cookie = 'thinkphp_show_page_trace='+history.join('|')
		}
	})(i)
}
parseInt(history[0]) && open.click();
tab_tit[history[1]].click();
})();
</script>