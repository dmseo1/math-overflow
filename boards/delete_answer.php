<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
	<title>답변 삭제하기</title>

	<script language="javascript">


		function ChkBeforeDelete()
		{
	
			document.writeForm.submit();

		}

	</script>
	

</head>

<body>

<div id="wrap">
  <div id="header">
    <?php
	include("../frame_top.html");
    ?>
  </div>

  <div id="sidebar">
    <?php
	include("../frame_left.html");
    ?>
  </div>

  <div id="content">

	<?php
	$boardname = $_GET["boardname"];
	$no = $_GET["no"];
 	$fromno = $_GET["fromno"];
	
	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	if($conn->connect_error) {
		die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
	else { }



	//게시판 존재성 모듈
	$sql_boardlist = "select * from board_master where name like '%qna%'";
	$result_boardlist = $conn->query($sql_boardlist);
	
	$witness = 0;
	while($row_boardlist = $result_boardlist->fetch_assoc())
	{
	
		if($boardname == $row_boardlist['name'])
		{
			$witness = 1;
			break;
		}
	}

	if($witness == 0)
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>존재하지 않는 게시판입니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}
	//게시판 존재성 모듈 끝


	if(!isset($_GET["boardname"]))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}




	$sql_title = "select alias from board_master where name=\"" . $boardname . "\"";
	$result_title = $conn->query($sql_title);
	
	
	while($row_title = $result_title->fetch_assoc())
	{
		echo "<h2>" . $row_title["alias"] . " - 답변 삭제하기</h2>";
	}


	$sql = "select member_no from answer_" . $boardname . " where no=" . $no;
	$result = $conn->query($sql);
	$origin_member_no = -1;
	while($row = $result->fetch_assoc())
	{
		$origin_member_no = $row['member_no'];
	}

	
	if(!isset($_SESSION['user_email']) || !isset($_SESSION['user_password'])) //로그인 체크
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>로그인을 하여야 답변 삭제가 가능합니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/member/login.html'\">로그인</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}
	else
	{
		if($_SESSION['user_member_no'] != $origin_member_no) //본인 체크
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>본인이 작성한 글 이외에는 삭제할 수 없습니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";

			return;
		}
	}



		echo "<form name=\"writeForm\" action=\"delete_answer_ok.php?boardname=" . $boardname . "&no=" . $no . "&fromno=" . $fromno . "\" method=\"post\">";

		echo "<div style=\"width:40%;margin-left:10%;margin-top:50;margin-bottom:20\"><center>답변을 삭제하면 답변 등록시 획득한 10포인트가 차감됩니다.<br>또한, 채택/미채택 이후 삭제할 경우 패널티 5점이 추가 차감됩니다.<br>정말 삭제하시겠습니까?</center></div>";
		echo "<div style=\"width:40%;margin-left:14%;margin-bottom:400\"><button type=\"button\" onclick=\"javascript:ChkBeforeDelete()\" class=\"snip1535_list\" style=\"width:40%\">확인</button>&nbsp;&nbsp;";
		echo "<button type=\"button\" onclick=\"history.back();\" class=\"snip1535_list\" style=\"width:40%\">취소</button></div>";
		echo "</form>";
	
	?>

  </div>

  <div id="footer">
	<?php
	include("../frame_bottom.html");
	?>
  </div>
</div>
</body>



</html>
