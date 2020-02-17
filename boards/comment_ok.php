<!----------------------------------------------------- comment_ok.php ------------------------------------------------------------>

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
	session_start();
	$boardname = $_GET['boardname'];
	$no = $_GET['no'];
	$writer = $_POST['comm_writer'];
	$message = $_POST['comm_message'];
	$password = $_POST['comm_password'];
	$page = -1;
	if(isset($_GET['page']) && $_GET['page'] != "")
	{
		$page = $_GET['page'];
	}

	$writer = str_replace("\\", "\\\\", $writer);
	$message = str_replace("\\", "\\\\", $message);

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



	$comment_no = -1;
	if(isset($_SESSION['user_email']) && isset($_SESSION['user_password'])) //회원의 댓글 쓰기
	{
		$sql_getno = "select count from board_master where name='comment_" . $boardname . "'";
		$result_getno = $conn->query($sql_getno);
		while($row_getno = $result_getno->fetch_assoc())
		{
			$comment_no = $row_getno['count'];
		}
		$sql = "insert into comment_" . $boardname . " (no, member_no, content, date, vote, isre, writer, fromno, password, vote_member, downvote_member) values (" . $comment_no . ", " . $_SESSION['user_member_no'] . ", \"" . $message . "\", now(), 0, 0, \"" . $writer . "\", ". $no . ", \"" . $password . "\", \";\", \";\")";
		$sql_noupdate = "update board_master set count=count+1 where name='comment_" . $boardname . "'";
		$conn->query($sql_noupdate);


	}
	else //비회원의 댓글 쓰기
	{
		$sql_getno = "select count from board_master where name='comment_" . $boardname . "'";
		$result_getno = $conn->query($sql_getno);
		while($row_getno = $result_getno->fetch_assoc())
		{
			$comment_no = $row_getno['count'];
		}
		$sql = "insert into comment_" . $boardname . " (no, member_no, content, date, vote, isre, writer, fromno, password, vote_member, downvote_member) values (" . $comment_no . ", -1, \"" . $message . "\", now(), 0, 0, \"" . $writer . "\", ". $no . ", \"" . $password . "\", \";\", \";\")";
		$sql_noupdate = "update board_master set count=count+1 where name='comment_" . $boardname . "'";
		$conn->query($sql_noupdate);
	}
	#$sql = "insert into comment_board_middle_freeboard (content, date, vote, isre, writer, fromno) values (\"testtest\", now(), 0, 0, \"test\", 256)";

	#코멘트 페이지 정상 표시를 위한 조치
	#페이지 파악
	$sql_commcount = "select count(*) as total from comment_" . $boardname . " where fromno=" . $no;
	$result_commcount = mysqli_query($conn, $sql_commcount);
	$commcount = mysqli_fetch_assoc($result_commcount);
	$page = intval(($commcount['total']) / 20) + 1;
	
	
	$result = $conn->query($sql);
	if($result)
	{
		echo "comment ok";
	}
	else
	{
		echo "<meta http-equiv='refresh' content='0; url=/error.php'>";
	}

	echo "<meta http-equiv='refresh' content='0; url=/boards/view.php?boardname=" . $boardname . "&no=" . $no . "&page=" . $page . "'>"; 

?> 


  </div>

  <div id="footer">
	<?php
	include("../frame_bottom.html");
	?>
  </div>
</div>
</body>


