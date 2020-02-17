<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
	<title>글 삭제하기</title>

	<script language="javascript">


		function ChkBeforeDelete()
		{
			if(document.writeForm.password.value == "")
			{
				alert("비밀번호를 입력해주세요.");
				document.writeForm.password.focus();
				return;
			}
			else
			{
				document.writeForm.submit();
			}
		}


		function ChkBeforeDelete_member()
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
	
	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	if($conn->connect_error) {
		die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
	else { }

	//게시판 존재성 모듈
	$sql_boardlist = "select * from board_master where name like '%freeboard%'";
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
		echo "<h2>" . $row_title["alias"] . " - 글 삭제하기</h2>";
	}

	echo "<form name=\"writeForm\" action=\"delete_ok.php?boardname=" . $boardname . "&no=" . $no . "\" method=\"post\">";
	
	
	
	$sql_memberno = "select member_no from " . $boardname . " where no=" . $no;
	$result_memberno = $conn->query($sql_memberno);
	if(!$result_memberno || $result_memberno->num_rows == 0)
	{
		echo "<meta http-equiv='refresh' content='0; url=/error.php'>";
	}
	$memberno = -1;
	if($result_memberno)
	{
		while($row_memberno = $result_memberno->fetch_assoc())
		{
			$memberno = $row_memberno["member_no"];
		}
		
		if($memberno != -1)
		{
			if(isset($_SESSION['user_email']) && isset($_SESSION['user_password'])) //로그인했는지 체크
			{
				if($_SESSION['user_member_no'] == $memberno) //회원 자신의 글
				{
					echo "<div style=\"width:40%;margin-left:10%;margin-top:50;margin-bottom:20\"><center>글을 삭제하시겠습니까?</center></div>";
					echo "<div style=\"width:40%;margin-left:14%;margin-bottom:400\"><button type=\"button\" onclick=\"javascript:ChkBeforeDelete_member()\" class=\"snip1535_list\" style=\"width:40%\">확인</button>&nbsp;&nbsp;";
					echo "<button type=\"button\" onclick=\"history.back();\" class=\"snip1535_list\" style=\"width:40%\">취소</button></div>";
					echo "</form>";
				}
				else //회원이 다른 회원의 글을 삭제하려고 시도
				{
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
					echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다<br><br></center></td></tr>";
					echo "<tr>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
						</tr></table></div>";

				}
			}
			else //회원도 아닌데 회원 글 삭제에 접근?
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다<br><br></center></td></tr>";
				echo "<tr>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
						</tr></table></div>";

			}
		}
		else //비회원 글 삭제
		{
			echo "<form name=\"writeForm\" action=\"delete_ok.php?boardname=" . $boardname . "&no=" . $no . "\" method=\"post\">";
			echo "<div style=\"width:40%;margin-left:10%;margin-top:50;margin-bottom:20\"><center>글 등록시 입력했던 비밀번호를 입력하세요</center></div>";
			echo "<div style=\"width:40%;margin-left:10%;margin-bottom:20\"><input type=\"password\" id=\"password\" name=\"password\" style=\"width:100%;height:35;border:1pt solid #ff901e\" /></div>";
			echo "<div style=\"width:40%;margin-left:14%;margin-bottom:400\"><button type=\"button\" onclick=\"javascript:ChkBeforeDelete()\" class=\"snip1535_list\" style=\"width:40%\">확인</button>&nbsp;&nbsp;";
			echo "<button type=\"button\" onclick=\"history.back();\" class=\"snip1535_list\" style=\"width:40%\">취소</button></div>";
			echo "</form>";

		}
	}
	else
	{
		echo "사실은 쿼리 실패";
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다<br><br></center></td></tr>";
		echo "<tr>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>
					</tr></table></div>";
	}




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
