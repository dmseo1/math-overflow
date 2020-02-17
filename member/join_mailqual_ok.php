<html>
<head>
<title>인증 결과</title>
<link rel="stylesheet" type="text/css" href="/framestyle.css" />
<script language="javascript">

	function Close()
	{
		window.opener.document.getElementById("qual_ok").value = "1";
		window.opener.document.getElementById("qual_ok_text").value = " 인증 완료!";
		window.opener.document.getElementById("member_join_email").readOnly = true;
		window.opener.document.getElementById("member_join_email_reset").style.display = "none";
		window.close();
	}

	function Close_Fail()
	{
		window.opener.document.getElementById("qual_ok").value = "";
		window.close();
	}


</script>


</head>
<body>

<?php

$qual_email = $_POST['member_join_email'];
$qual_code = $_POST['member_join_qualcode'];
$qual_isok = $_POST['qual_ok'];

if($qual_isok == "1")
{
	echo "<center><br><br>이미 인증을 받았습니다.<br><br></center>";
	echo "<center><button type=\"button\" onclick=\"javascript:Close();\" class=\"snip1535_list\">닫기</button></center>";
	return;
}

$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
$sql = "select * from mail_qualification where email=\"" . $qual_email . "\" order by date desc";
$result = $conn->query($sql);

if($result)
{
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			if($qual_code == $row['code'])
			{
				if($row['valid'] == 0)
				{
					echo "<br><br><center>이미 만료된 인증코드입니다.<br><br></center>";
					echo "<center><button type=\"button\" onclick=\"window.close();\" class=\"snip1535_list\">닫기</button></center>";
					return;
				}

				$sql_qualok = "update mail_qualification set valid=0 where email=\"" . $qual_email . "\"";
				$result_qualok = $conn->query($sql_qualok);
				if(!$result_qualok) { echo "쿼리 에러"; return; }
				echo "<br><br><center>올바른 인증코드를 입력하였습니다.<br>'닫기'를 눌러 인증을 완료해주세요.<br><br></center>";
				echo "<center><button type=\"button\" onclick=\"javascript:Close();\" class=\"snip1535_list\">닫기</button></center>";
			}
			else
			{
				echo "<br><br><center>틀린 인증코드를 입력하였습니다.<br>인증을 여러 번 시도한 경우, 가장 마지막에 도착한 메일의 인증코드를 입력하세요.<br><br>";
				echo "<center><button type=\"button\" onclick=\"javascript:Close_Fail();\" class=\"snip1535_list\">닫기</button></center>";
			}
			break; //최근 것 한 번만 시도
		}
	
	}
	else
	{
		echo "<br><br><center>인증 이후 이메일란을 수정하여 인증이 정상적으로 이루어지지 않았습니다.</center><br><br>";
		echo "<center><button type=\"button\" onclick=\"javascript:Close_Fail();\" class=\"snip1535_list\">닫기</button></center>";
	}
}
else
{
	echo "쿼리 실패";
}



?>
</body>
</html>


