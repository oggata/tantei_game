<!--[if IE]><script type="text/javascript" src="http://bank.blamestitch.com/js/excanvas_r3/excanvas.compiled.js"></script><![endif]-->
<script type="text/javascript">
<!--
setTimeout("link()", 3000);
function link(){
location.href='<?php echo $jump_url;?>';
}
-->
</script>
<div style="text-align:center;">
<canvas id="testCanvas" width="320" height="320" style="border:0px solid #CCC;"></canvas>
</div>
<script type="text/javascript">
//制御
var timerID;
var cW=320;
var cH=320;
var back_X=0;
var back_Y=0;
var human_X=-50;
var human_Y=0;
window.onload = function(){
  setTimer();
}
//フレームレート
function setTimer(){
  clearInterval(timerID);
  timerID = setInterval("setMove()", 100);
}
//制御
function setMove(){
  back_Y-=50;
  human_X+=2;
  if(human_X>=100){
    human_X = 100;
  }
  draw();
}
var i=0;
//描画
function draw(){
  //Canvas
  var canvas=document.getElementById('testCanvas');
  if (!canvas||!canvas.getContext) return false;
  var ctx = canvas.getContext('2d');
  //refresh
  ctx.clearRect(0,0,cW,cH);
  //images
  back_img = new Image();
  back_img.src = "http://bank.blamestitch.com/jpg/back.png";
  human_img = new Image();
  human_img.src = "http://bank.blamestitch.com/jpg/human.png";
  char_img = new Image();
  char_img.src = "http://bank.blamestitch.com/jpg/char.png";
  ctx.drawImage(back_img, back_X, back_Y);
  ctx.drawImage(human_img, human_X, human_Y);
  i+=1;
  if(i%5==0){
    ctx.drawImage(char_img, 0, 100);
  }
}
</script>