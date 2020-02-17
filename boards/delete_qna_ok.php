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



	$sql_chkpwd = "select member_no, password, points, answers from " . $boardname . " where no=" . $no;
	$result_chkpwd = $conn->query($sql_chkpwd);
	$cur_password = "";
	$origin_member_no = -1;

	$cur_points = 0;
	$cur_answers = 0;
	
	if($result_chkpwd->num_rows > 0)
	{
		while($row_chkpwd = $result_chkpwd->fetch_assoc())
		{
			$cur_password = $row_chkpwd["password"];
			$origin_member_no = $row_chkpwd["member_no"];
			$cur_points = $row_chkpwd["points"];
			$cur_answers = $row_chkpwd["answers"];
		}
	}
	else
	{
		echo "error!!";
	}



	if(!isset($_SESSION['user_email']) || !isset($_SESSION['user_password']))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}
	else
	{
		if($_SESSION['user_member_no'] != $origin_member_no)
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



	if($_SESSION['user_member_no'] == $origin_member_no)
	{
		$sql_getpoints = "select points from member where no=" . $_SESSION['user_member_no'];
		$result_getpoints = $conn->query($sql_getpoints);
		if(!$result_getpoints) { echo "에러1"; return; }
		else{
			while($row_getpoints = $result_getpoints->fetch_assoc())
			{
				if($row_getpoints < 10 + ($cur_answers) * 5 - $cur_points)
				{
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
					echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>포인트가 부족하여 질문을 삭제할 수 없습니다.<br><br></center></td></tr>";
					echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
							<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
							</button></td>

					</tr></table></div>";

					return;
				}
			}
		}
		$minus_points = 10 + ($cur_answers) * 5 - $cur_points;
		$sql_points = "update member set points= points -" . $minus_points . " where no=" . $_SESSION['user_member_no'];
		$result_points = $conn->query($sql_points);
		if(!$result_points) { echo "에러2"; return; }

		$sql = "delete from " . $boardname . " where no=" . $no;
		#$sql_also = "delete from comment_" . $boardname . " where fromno=" . $no; //댓글 삭제 보류


		
		$result = $conn->query($sql);
		#$result_also = $conn->query($sql_also);
		if($result)
		{
			echo "delete ok";
			if(strpos($boardname, "onetoone"))
			{
				echo "<meta http-equiv='refresh' content='0; url=/member/my_onetoone.php?type=1'>"; 
			}
			else
			{
				echo "<meta http-equiv='refresh' content='0; url=/boards/list_qna.php?boardname=" . $boardname . "'>"; 
			}
			
		}
		else
		{
			echo "delete fail";
		}

		//질문수를 줄인다.
		$sql_num_question = "update member set num_questionned = num_questionned - 1 where no=" . $_SESSION['user_member_no'];
		$conn->query($sql_num_question);
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









