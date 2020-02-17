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


	$sql_chkpwd = "select member_no, password from " . $boardname . " where no=" . $no;
	$result_chkpwd = $conn->query($sql_chkpwd);
	if(!$result_chkpwd || $result_chkpwd->num_rows == 0) //잘못된 정보가 넘어오는 경우
	{
		echo "<meta http-equiv='refresh' content='0; url=/error.php'>";
	}

	$cur_password = "";
	$cur_member_no = -1;

	if($result_chkpwd->num_rows > 0)
	{
		while($row_chkpwd = $result_chkpwd->fetch_assoc())
		{
			$cur_member_no = $row_chkpwd["member_no"];
			$cur_password = $row_chkpwd["password"];
		}
	}
	else
	{
		echo "error!!";
	}

	//회원의 글
	if($cur_member_no == -1) //비회원의 글을 삭제
	{
		if($password == $cur_password)
		{
			$sql = "delete from " . $boardname . " where no=" . $no;
			$sql_also = "delete from comment_" . $boardname . " where member_no=-1 and fromno=" . $no;
			
			$result = $conn->query($sql);
			$result_also = $conn->query($sql_also);
			if($result && $result_also)
			{
				echo "delete ok";
				echo "<meta http-equiv='refresh' content='0; url=/boards/list.php?boardname=" . $boardname . "'>"; 
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
	}
	else //회원의 글을 삭제
	{
		if(!isset($_SESSION['user_email'])) //로그인 상태가 아니라면
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>
			</tr></table></div>";
		}
		else if($cur_member_no == $_SESSION['user_member_no']) //멤버 번호가 일치하면 삭제할 수 있도록
		{
			$sql = "delete from " . $boardname . " where no=" . $no;
			$sql_also = "delete from comment_" . $boardname . " where member_no=-1 and fromno=" . $no;
			
			$result = $conn->query($sql);
			$result_also = $conn->query($sql_also);
			if($result && $result_also)
			{
				echo "delete ok";
				echo "<meta http-equiv='refresh' content='0; url=/boards/list.php?boardname=" . $boardname . "'>"; 
			}
			else
			{
				echo "delete fail";
			}
		}
		else //이상한 상황
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>
			</tr></table></div>";
		}
		
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









