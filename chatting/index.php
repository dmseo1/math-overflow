<!--
//----------------------------------------------
//Chatting v1.0 Source By Bermann
//dobermann75@gmail.com
//----------------------------------------------
-->

<?php
$username = $_REQUEST['username'];
$url = $_REQUEST['url'];
if (is_null($username)) { $username = 'GUEST'; }
if (is_null($url)) { $url = 'http://www.phpschool.com'; }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bermann Chatting</title>
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./js/Base.js"></script>
<script type="text/javascript" src="./js/Drag.js"></script>
<script type="text/javascript" src="./js/Ajax.js"></script>
<script type="text/javascript" src="./js/Chatting.js"></script>
<script type="text/javascript">
var myChatting = null;

addEvent(window,"onload",function () {
	myChatting = new Chatting();
	myChatting.cycle = 1000;
	myChatting.canvas = $("canvas");
	myChatting.status = $("status");
	myChatting.username = $("username");
	myChatting.message = $("message");
	myChatting.handlingPage = "chattingProcess.php";
	myChatting.canvas.innerHTML = "<b><i> * 우왕ㅋ굳ㅋ 입장하셨스빈다</i></b>";
	new Ajax("POST",myChatting.handlingPage,false,"","username=<?=$username?>","");
	myChatting.Run();
	myChatting.message.focus();
});

var myDrag = new Drag("draggable","dragelement","dragarea","dragdirection","dragscalepercentage");
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="overflow: hidden;">


<div id="chattingtable" style="position: absolute; width: 600px; height: 400px;" dragarea="document.body">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
<td class="top-left"></td>
<td class="top" draggable="true" dragelement="$('chattingtable')">&nbsp;</td>
<td class="top-right"></td>
</tr>
<tr>

<td class="left"></td>
<td>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="4" align="center">
	<tr>
	<td width="80%" height="80%"><div class="aero" id="canvas" style="width: 427px; height: 288px; border: 1px solid #4ba200; background-color: #FFFFFF; overflow: auto;"></div></td>
	<td width="20%" height="80%"><div class="aero" id="status" style="width: 111px; height: 288px; border: 1px solid #4ba200; background-color: #FFFFFF; overflow: auto;"></div></td>
	</tr>
	<tr>
	<td colspan="2" height="10%" align="center" valign="middle" class="aero">
	대화명<input class="aero" id="username" type="text" size="5" value="<?=$username?>" />
	메세지<input class="aero" id="message" type="text" onkeydown="myChatting.sendData(event.which || event.keyCode)" />
	<input class="aero" type="button" value="보내기" onclick="myChatting.sendData(13)" />
	<input class="aero" type="button" value="방청소" onclick="myChatting.canvas.innerHTML='';" />
	</td>
	</tr>
	</table>
</td>
<td class="right"></td>

</tr>
<tr>
<td class="bottom-left"></td>
<td class="bottom"></td>
<td class="bottom-right"></td>
</tr>
</table>
</div>

<div>
<iframe src="<?=$url?>" height="100%" width="100%" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0"></iframe>
</div>

</body>
</html>
