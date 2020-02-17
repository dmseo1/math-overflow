<!----------------------------------------- delete_comment_ok.php --------------------------------------->
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
	$fromno = $_GET["fromno"];
	$no = $_GET["no"];
	$password = $_POST['password'];
	$page = 1;
	if(isset($_GET['page']) && $_GET['page'] != "")
	{
		$page = $_GET['page'];
	}
	


	$conn = mysqli_connect("localhost", "root", "sdm9469", "math_overflow");
	if(mysqli_connect_errno())
	{
		echo("mysql 서버가 정상 동작하지 않습니다");
	}
	else {  }

	$sql_chkpwd = "select * from comment_" . $boardname . " where no=" . $no;
	$result_chkpwd = $conn->query($sql_chkpwd);
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
	
	if($cur_member_no == -1) //비회원의 댓글일 경우
	{
		if($cur_password == $password)
		{
			$sql = "delete from comment_" . $boardname . " where no=" . $no;
			$sql_commcount = "select count(*) as total from comment_" . $boardname . " where fromno=" . $fromno;
			$result_commcount = mysqli_query($conn, $sql_commcount);
			$commcount = mysqli_fetch_assoc($result_commcount);
			$page = intval(($commcount['total'] - 2) / 20) + 1;
			
			$result = $conn->query($sql);
			if($result)
			{
				echo "delete ok";
				echo "<meta http-equiv='refresh' content='0; url=/boards/view.php?boardname=" . $boardname . "&no=" . $fromno . "&page=" . $page . "'>"; 
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
	else //회원의 댓글일 경우
	{
		if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
		{
			if($cur_member_no == $_SESSION['user_member_no']) 
			{
				$sql = "delete from comment_" . $boardname . " where no=" . $no;
				$sql_commcount = "select count(*) as total from comment_" . $boardname . " where fromno=" . $fromno;
				//echo $sql_commcount;
				$result_commcount = mysqli_query($conn, $sql_commcount);
				$commcount = mysqli_fetch_assoc($result_commcount);
				//echo $commcount['total'];
				$page = intval(($commcount['total'] - 2) / 20) + 1;
				
				$result = $conn->query($sql);
				if($result)
				{
					echo "delete ok";
					echo "<meta http-equiv='refresh' content='0; url=/boards/view.php?boardname=" . $boardname . "&no=" . $fromno . "&page=" . $page . "'>"; 
				}
				else
				{
					echo "delete fail";
				}
			}
			else
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>
				</tr></table></div>";
			}
		}
		else //비회원이 회원의 댓글을 삭제하려고 시도
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









