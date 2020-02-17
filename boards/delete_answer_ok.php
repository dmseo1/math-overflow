<html>
<head>

 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>


<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
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
	$password = $_POST['password'];

	$conn = mysqli_connect("localhost", "root", "sdm9469", "math_overflow");
	if(mysqli_connect_errno())
	{
		echo("mysql 서버가 정상 동작하지 않습니다");
	}
	else {  }



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




	$sql_chkpwd = "select isadopted, member_no, password from answer_" . $boardname . " where no=" . $no;
	if(strpos($boardname, "onetoone"))
	{
		$sql_chkpwd = "select isadopted, member_no, password, part from answer_" . $boardname . " where no=" . $no;
	}
	$result_chkpwd = $conn->query($sql_chkpwd);
	$cur_password = "";
	$cur_isadopted = -1;
	$origin_member_no = -1;
	$origin_part = "";

	if($result_chkpwd->num_rows > 0)
	{
		while($row_chkpwd = $result_chkpwd->fetch_assoc())
		{
			$cur_isadopted = $row_chkpwd["isadopted"];
			$cur_password = $row_chkpwd["password"];
			$origin_member_no = $row_chkpwd["member_no"];
			$origin_part = $row_chkpwd["part"];
		}
	}
	else
	{
		echo "error!!";
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

	//포인트 체크
	$sql_getpoints = "select points from member where no=" . $_SESSION['user_member_no'];
	$result_getpoints = $conn->query($sql_getpoints);
	if(!$result_getpoints) { echo "에러1"; return; }
	else {
		while($row_getpoints = $result_getpoints->fetch_assoc())
		{
			if($row_getpoints['points'] < 10)
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>포인트가 부족하여 답변을 삭제할 수 없습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>

				</tr></table></div>";
				return;
			}

		}

	}


	if($_SESSION['user_member_no'] == $origin_member_no)
	{
		//해당 답변을 삭제한다
		$sql = "delete from answer_" . $boardname . " where no=" . $no;
		//해당 답변에 딸린 댓글도 삭제한다(보류)
		#$sql_also = "delete from comment_" . $boardname . " where fromno=" . $no . " and qora=2";
		//답변 개수를 하나 줄인다
		$sql_dc = "update " . $boardname . " set answers = answers-1 where no=" . $fromno;



		//포인트 회수
		$sql_points = "update member set points = points - 10 where no=" . $_SESSION['user_member_no'];
		$result_points = $conn->query($sql_points);
		if(!$result_points) { echo "에러"; return; }


		//답변 개수 하나 줄인다
		$sql_adoptplus = "";
		if($boardname == "board_middle_qna" || $origin_part == "middle")
		{
			$sql_adoptplus = "update member set mi_answered = mi_answered - 1 where no=" . $_SESSION['user_member_no'];
		}
		else if($boardname == "board_high_qna" || $origin_part == "high")
		{
			$sql_adoptplus = "update member set hi_answered = hi_answered - 1 where no=" . $_SESSION['user_member_no'];
		}
		else if($boardname == "board_univ_qna" || $origin_part == "univ")
		{
			$sql_adoptplus = "update member set ui_answered = ui_answered - 1 where no=" . $_SESSION['user_member_no'];
		}

		//채택 답변을 삭제하는 경우 채택 답변 수를 하나 줄인다.
		if($cur_isadopted == 3)
		{
			$sql_adoptminus = "";
			if($boardname == "board_middle_qna" || $origin_part == "middle")
			{
				$sql_adoptminus = "update member set mi_adopted = mi_adopted - 1 where no=" . $_SESSION['user_member_no'];
			}
			else if($boardname == "board_high_qna" || $origin_part == "high")
			{
				$sql_adoptminus = "update member set hi_adopted = hi_adopted - 1 where no=" . $_SESSION['user_member_no'];
			}
			else if($boardname == "board_univ_qna" || $origin_part == "univ")
			{
				$sql_adoptminus = "update member set ui_adopted = ui_adopted - 1 where no=" . $_SESSION['user_member_no'];
			}
			$result_adoptminus = $conn->query($sql_adoptminus);
			if(!$result_adoptminus) { echo "에러(채택답변 감소)"; return; }
		}

		//채택/미채택된 답변을 삭제하는 경우 5포인트를 추가 차감한다.
		if($cur_isadopted == 2 || $cur_isadopted == 3)
		{
			$sql_5pminus = "update member set points = points - 5 where no=" . $_SESSION['user_member_no'];
			$result_5pminus = $conn->query($sql_5pminus);
			if(!$result_5pminus) { echo "에러(5포인트 차감)"; return; }
		}

		$result_adoptplus = $conn->query($sql_adoptplus);
		if(!$result_adoptplus) { echo "에러(답변 감소)"; return; }

		
		$result = $conn->query($sql);
		#$result_also = $conn->query($sql_also); //보류
		$result_dc = $conn->query($sql_dc);

		if($result_dc)
		{
		}
		else
		{
			echo "query dc problem";
		}


		if($result && $result_dc)
		{
			echo "delete ok";
			echo "<meta http-equiv='refresh' content='0; url=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $fromno . "'>"; 
		}
		else
		{
			echo "delete fail";
		}
	}
	else
	{
		echo "<div style=\"width:40%;margin-left:10%;margin-top:80;margin-bottom:20;\">";
		echo "<center>비밀번호가 일치하지 않습니다</center></div>";
		echo "<div style=\"width:40%;margin-left:10%;margin-bottom:400;\"><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로</button></div>";
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









