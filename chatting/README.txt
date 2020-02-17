//----------------------------------------------
//Chatting v1.0 Source By Bermann
//dobermann75@gmail.com
//----------------------------------------------

********************************************************************************************************************************************

* 모든 소스, 테스트는 UTF-8 환경에서 작업 되었습니다.

********************************************************************************************************************************************

------- chattingSession/ -------
	chattingSession/ 디렉토리는 세션을 직접 읽고 쓸 수 있도록 퍼미션을 777 로 해주시기 바랍니다.

********************************************************************************************************************************************

------- index.php -------
	addEvent(window,"onload",function () { //window 가 loading 완료 되면 실행되는 함수
		myChatting = new Chatting(); //채팅객체를 생성합니다.
		myChatting.cycle = 1000; //서버정보를 갱신하는 시간주기 입니다.(1000 = 1초)
		myChatting.canvas = $("canvas"); //채팅내용이 출력되는 엘리먼트를 지정합니다. ($() == document.getElementById())
		myChatting.status = $("status"); //유저리스트가 출력되는 엘리먼트를 지정합니다.
		myChatting.username = $("username"); //닉네임 혹은 유저명을 입력하는 엘리먼트를 지정합니다.
		myChatting.message = $("message"); //메세지를 입력하는 엘리먼트를 지정합니다.
		myChatting.handlingPage = "chattingProcess.php"; //서버측에서 처리하는 파일명을 지정합니다.
		myChatting.canvas.innerHTML = "<b><i> * 우왕ㅋ굳ㅋ 입장하셨스빈다</i></b>"; //채팅이 시작되기전 알림메세지를 띄웁니다.
		new Ajax("POST",myChatting.handlingPage,false,"","username=<?=$username?>",""); //서버측으로 유저명을 전달해 세션에 적용시킵니다.
		myChatting.Run(); //채팅 어플리케이션을 시작합니다.
		myChatting.message.focus(); //메세지를 입력하는 엘리먼트에 포커스를 줍니다.
	});

	var myDrag = new Drag("draggable","dragelement","dragarea","dragdirection","dragscalepercentage"); //채팅창을 드래그 하기위한 설정입니다.

********************************************************************************************************************************************

------- chattingProcess.php -------
	header("Content-Type: text/xml; charset=utf-8"); //XML 헤더선언
	$sessionDirectory = "./chattingSession"; //세션이 저장될 디렉토리 변수
	ini_set("session.gc_maxlifetime",3); //실시간 유저리스트 갱신을 위한 유효한 세션시간을 지정합니다. (3 = 3초)
	ini_set("session.gc_probability",100); //유효하지 않은 세션을 100%로 GarbageCollection 합니다.
	ini_set("session.save_path",$sessionDirectory); //세션이 저장될 디렉토리를 지정합니다.
	session_start();
	$connect = @mysql_connect("LOCALHOST","USERNAME","PASSWORD"); @mysql_select_db("DATABASE",$connect); //각 connection 정보를 알맞게 세팅해줍니다.
	$table = "chatting"; //DB TABLE 명 변수

	function removeEvent($strings) { //html 태그중 사용자 악의성 태그가 다분한 성질의 태그, 이벤트 제거 함수 (기본적인세팅이므로 부족할 경우 추가하시기 바랍니다.)
		$pattern = array("/<meta/i","/<script/i","/onload=/i","/onerror=/i","/onmouseover=/i","/onmousemove=/i","/onmousedown=/i","/onmouseout=/i","/onclick=/i","/onkeydown=/i","/onkeypress=/i","/onkeyup=/i","/onsubmit=/i","/onreset=/i","/javascript:/i","/iframe/i");
		$replacement = array("<3eta","<scr1pt","0nload=","0nerror=","0nmouseover=","0nmousemove=","0nmousedown=","0nmouseout=","0nclick=","0nkeydown=","0nkeypress=","0nkeyup=","0nsubmit=","0nreset=","xjavascript:","lframe");
		return preg_replace($pattern,$replacement,$strings);
	}

	$time = $_REQUEST["time"];
	$microtimes = explode(" ",microtime());

	if (!$time) { $time = (int)$microtimes[1] + (float)$microtimes[0]; } //클라이언트에서 넘어오는 time 정보가 없으면 현재시간으로 세팅합니다.

	if (!$_SESSION["userid"]) { //세션이 없으면 세션을 생성합니다.
		session_register("userid");
		session_register("username");
		session_register("userip");
		$_SESSION["userid"] = session_id();
		$_SESSION["username"] = ($_POST["username"]) ? $_POST["username"] : "GUEST";
		$_SESSION["userip"] = $_SERVER["REMOTE_ADDR"];
	}

	if (!is_null($_POST["username"]) AND !is_null($_POST["message"])) { //POST 형식으로 넘어온 유저명과 채팅내용이 있을때만
		$_SESSION["username"] = htmlspecialchars(removeEvent($_POST["username"])); //변하는 유저명을 세션에 적용시킵니다.
		$message = htmlspecialchars(removeEvent($_POST['message']));
		$query = "INSERT INTO " . $table . " VALUES ('','" . $_SESSION["userid"] . "','" . $_SESSION["userip"] . "','" . $_SESSION["username"] . "','" . $message . "'," . $microtimes[1] . "," . (float)$microtimes[0] . ")";
		mysql_query($query,$connect); //DB 에 채팅내용 입력
		$query = "SELECT username,message,(time+microtime) AS t FROM " . $table . " WHERE idx=" . mysql_insert_id(); //방금 입력된 Data 를 검색
	} else { //POST 형식으로 넘어온 유저명과 채팅내용이 없으면
		$query = "SELECT username,message,(time+microtime) AS t FROM " . $table . " WHERE time+microtime>" . ($time + 0.01); //요청하고 있는 time 보다 큰 time 의 Data 만 검색
	}

	echo "<?xml version='1.0' encoding='utf-8' ?>";
	echo "<chatting>";

	$result = mysql_query($query,$connect);
	$resultRow = @mysql_num_rows($result);
	$resultData = "";

	$dir = dir($sessionDirectory); //세션디렉토리 open

	if ($resultRow) { //검색된 Data 가 있으면 해당 Data를 뿌려주고
		for ($i = 0; $i < $resultRow; $i++) {
			$resultData = mysql_fetch_object($result);
			echo "<data>";
			echo	"<username>" . $resultData->username . "</username>";
			echo	"<message>" . $resultData->message . "</message>";
			//echo	"<message><![CDATA[" . $resultData->message . "]]></message>"; //html 태그를 완전히 허용하지 않을경우
			echo	"<time>" . $resultData->t . "</time>";
			if ($i == $resultRow - 1) {
				echo "<status>";
				while ($filename = $dir->read()) { //세션디렉토리를 읽는동안
					if (ereg("^\.\.?$",$filename)) { continue; } //포인터가 현재디렉토리(./) 또는 상위디렉토리(../) 일 때는 건너뜁니다.
					$files = $sessionDirectory . "/" . $filename; //하나의 세션파일이 읽혀지고
					$fp = fopen($files, "r"); //읽혀진 해당파일을 열어
					$data = @fread($fp,@filesize($files)); //내용을 읽고
					$data = preg_replace('/([a-z]+)\|s:[0-9]+:/','$each$1=',$data); //읽은 내용을 변수형태의 새로운 문자열로 대체합니다. (|s:[0-9]+는 세션이 문자열 형태 일 때 입니다. 문자열이 아닐경우에는 그에 맞게 소스를 바꿔줘야 합니다.)
					eval($data); //실질적인 변수로 바꿈
					echo "<user>" . $eachusername . "</user>";
					echo "<ip>" . $eachuserip . "</ip>";
					fclose($fp); //작업한 세션파일 닫기
				}
				echo "</status>";
			}
			echo "</data>";
		}
	} else { //검색된 Data 가 없으면 요청시와 동일한 time 정보를 넘겨 줍니다.
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

********************************************************************************************************************************************

------- chatting.sql -------
CREATE TABLE `chatting` (
  `idx` int(11) unsigned NOT NULL auto_increment,
  `userid` varchar(50) default NULL, //추후 쪽지기능에 쓰일 필드
  `userip` varchar(50) default NULL,
  `username` varchar(100) default NULL, //추후 닉네임 히스토리 기능에 쓰일 필드
  `message` text,
  `time` int(11) unsigned NOT NULL default '0',
  `microtime` float NOT NULL default '0',
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM;

********************************************************************************************************************************************
