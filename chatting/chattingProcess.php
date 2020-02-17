<?php
//----------------------------------------------
//Chatting v1.0 Source By Bermann
//dobermann75@gmail.com
//----------------------------------------------

header("Content-Type: text/xml; charset=utf-8");
$sessionDirectory = "./chattingSession";
ini_set("session.gc_maxlifetime",3);
ini_set("session.gc_probability",100);
ini_set("session.save_path",$sessionDirectory);
session_start();
$connect = @mysql_connect("LOCALHOST","USERNAME","PASSWORD"); @mysql_select_db("DATABASE",$connect);
$table = "chatting";

function removeEvent($strings) {
	$pattern = array("/<meta/i","/<script/i","/onload=/i","/onerror=/i","/onmouseover=/i","/onmousemove=/i","/onmousedown=/i","/onmouseout=/i","/onclick=/i","/onkeydown=/i","/onkeypress=/i","/onkeyup=/i","/onsubmit=/i","/onreset=/i","/javascript:/i","/iframe/i");
	$replacement = array("<3eta","<scr1pt","0nload=","0nerror=","0nmouseover=","0nmousemove=","0nmousedown=","0nmouseout=","0nclick=","0nkeydown=","0nkeypress=","0nkeyup=","0nsubmit=","0nreset=","xjavascript:","lframe");
	return preg_replace($pattern,$replacement,$strings);
}

$time = $_REQUEST["time"];
$microtimes = explode(" ",microtime());

if (!$time) { $time = (int)$microtimes[1] + (float)$microtimes[0]; }

if (!$_SESSION["userid"]) {
	session_register("userid");
	session_register("username");
	session_register("userip");
	$_SESSION["userid"] = session_id();
	$_SESSION["username"] = ($_POST["username"]) ? $_POST["username"] : "GUEST";
	$_SESSION["userip"] = $_SERVER["REMOTE_ADDR"];
}

if (!is_null($_POST["username"]) AND !is_null($_POST["message"])) {
	$_SESSION["username"] = htmlspecialchars(removeEvent($_POST["username"]));
	$message = htmlspecialchars(removeEvent($_POST['message']));
	$query = "INSERT INTO " . $table . " VALUES ('','" . $_SESSION["userid"] . "','" . $_SESSION["userip"] . "','" . $_SESSION["username"] . "','" . $message . "'," . $microtimes[1] . "," . (float)$microtimes[0] . ")";
	mysql_query($query,$connect);
	$query = "SELECT username,message,(time+microtime) AS t FROM " . $table . " WHERE idx=" . mysql_insert_id();
} else {
	$query = "SELECT username,message,(time+microtime) AS t FROM " . $table . " WHERE time+microtime>" . ($time + 0.01);
}

echo "<?xml version='1.0' encoding='utf-8' ?>";
echo "<chatting>";

$result = mysql_query($query,$connect);
$resultRow = @mysql_num_rows($result);
$resultData = "";

$dir = dir($sessionDirectory);

if ($resultRow) {
	for ($i = 0; $i < $resultRow; $i++) {
		$resultData = mysql_fetch_object($result);
		echo "<data>";
		echo	"<username>" . $resultData->username . "</username>";
		echo	"<message>" . $resultData->message . "</message>";
		//echo	"<message><![CDATA[" . $resultData->message . "]]></message>";
		echo	"<time>" . $resultData->t . "</time>";
		if ($i == $resultRow - 1) {
			echo "<status>";
			while ($filename = $dir->read()) {
				if (ereg("^\.\.?$",$filename)) { continue; }
				$files = $sessionDirectory . "/" . $filename;
				$fp = fopen($files, "r");
				$data = @fread($fp,@filesize($files));
				$data = preg_replace('/([a-z]+)\|s:[0-9]+:/','$each$1=',$data);
				eval($data);
				echo "<user>" . $eachusername . "</user>";
				echo "<ip>" . $eachuserip . "</ip>";
				fclose($fp);
			}
			echo "</status>";
		}
		echo "</data>";
	}
} else {
	echo "<data>";
	echo	"<time>" . $time . "</time>";
	echo	"<status>";
		while ($filename = $dir->read()) {
			if (ereg("^\.\.?$",$filename)) { continue; }
			$files = $sessionDirectory . "/" . $filename;
			$fp = fopen($files, "r");
			$data = @fread($fp,@filesize($files));
			$data = preg_replace('/([a-z]+)\|s:[0-9]+:/','$each$1=',$data);
			eval($data);
			echo "<user>" . $eachusername . "</user>";
			echo "<ip>" . $eachuserip . "</ip>";
			fclose($fp);
		}
	echo	"</status>";
	echo "</data>";
}

echo "</chatting>";
?>
