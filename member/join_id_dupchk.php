<html>
<head>
	<title>이메일 중복 확인</title>
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
	<script language="javascript">
		function Close(email)
		{
			window.opener.document.getElementById("dupchk_ok").value = "1";
			window.opener.document.getElementById("member_join_email").readOnly = true;
			window.opener.document.getElementById("member_join_email_reset").style.visibility = "visible";
			window.opener.document.getElementById("member_join_email_copy").value = email;

			window.close();
		}

		function Close_Fail()
		{
			window.opener.document.getElementById("dupchk_ok").value = "";
			window.opener.document.getElementById("member_join_email").value = "";
			window.opener.document.getElementById("member_join_email").focus();
			window.close();
		}
	</script>

</head>

<body>

<?php

	echo "<html><head><link rel=\"stylesheet\" type=\"text/css\" href=\"/framestyle.css\" /></head><body>";

	$try_email = $_POST['member_join_email'];

	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	if($conn->connect_error) {
		die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
	else { }


	$dup = 0;

	$sql_email = "select email from member";

	$result_email = $conn->query($sql_email);
	if($result_email->num_rows == 0)
	{
		echo "<div style=\"width:90%;margin:auto;margin-top:10;border:1pt solid #ff901e\">" . $try_email . "는 사용 가능한 이메일입니다.</div>";
		echo "<div style=\"width:90%;margin:auto;margin-top:15\"><button type='button' onclick=\"javascript:Close('" . $try_email . "')\" style=\"width:100%\" class=\"snip1535_list\">사용하기</button></div></body></html>";
	}
	else if($result_email->num_rows > 0)
	{
		while($row_email = $result_email->fetch_assoc())
		{
			if($try_email == $row_email["email"])
			{
				
				$dup = 1;
				break;
			}
		}

		if($dup == 1)
		{
			echo "<div style=\"width:90%;margin:auto;margin-top:10;border:1pt solid #ff901e\">" . $try_email . "는 이미 사용중인 이메일입니다.</div>";
			echo "<div style=\"width:90%;margin:auto;margin-top:15\"><button type='button' onclick=\"javascript:Close_Fail()\" style=\"width:100%\" class=\"snip1535_list\">확인</button></div></body></html>";
		}
		else
		{
			echo "<div style=\"width:90%;margin:auto;margin-top:10;border:1pt solid #ff901e\">" . $try_email . "는 사용 가능한 이메일입니다.</div>";
			echo "<div style=\"width:90%;margin:auto;margin-top:15\"><button type='button' onclick=\"javascript:Close('" . $try_email . "')\" style=\"width:100%\" class=\"snip1535_list\">사용하기</button></div></body></html>";
		}
	}

	

?>


</body>
</html>





