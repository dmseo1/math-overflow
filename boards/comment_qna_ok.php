<!------------------------------------------------------------ comment_qna_ok.php --------------------------------------------->

<html>
<head>

 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>


<style type="text/css">
  pdongmin {
     width: 90%;
     display: inline-block;
	 word-break:break-all;
     word-wrap:break-word;
	 white-space:pre-wrap;
	 overflow-wrap:break-word;
	  }
</style>
	<script language="javascript">

		function ChkBeforeWrite()
		{
			if(document.writeForm.title.value == "")
			{
		
				alert("제목을 입력해주세요");
				document.writeForm.title.focus();
				return;
			}
			else if(document.writeForm.writer.value == "")
			{
				alert("이름을 입력해주세요");
				document.writeForm.writer.focus();
				return;
			}
			else if(document.writeForm.password.value == "")
			{
				
				alert("비밀번호를 입력해주세요");
				document.writeForm.password.focus();
				return;
			}
			else if(!document.writeForm.message.value.replace(/(^\s*)|(\s*$)/gi,""))
			{
				alert("내용을 입력해주세요");
				document.writeForm.message.focus();
				return;
			}
			else
			{
				document.writeForm.submit();
			}
				
		}


		function Preview()
		{
			var title = document.writeForm.title.value;
			var message = document.getElementById("message").value;
		
			title= title.replace(/&/g,"%26"); 
    		title= title.replace(/\+/g,"%2B"); 
			message = message.replace(/(?:\r\n|\r|\n)/g, '<br />');
			message= message.replace(/&/g,"%26"); 
    		message= message.replace(/\+/g,"%2B"); 
			window.open("/boards/preview.php?title=" + title + "&message=" + message, "미리보기", "width=800, height=600, left=50, top=50, scrollbar=yes, resizable=no");
		}

	</script>

<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
	<title>댓글 작성하기</title>
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

 <?php

	$boardname = $_GET['boardname'];
	$no = $_GET['no'];
	$fromno = $_GET['fromno'];
	$type = $_GET['type'];

	$page = 1;
	$qpage = 1;
	$apage0 = 1;
	$apage1 = 1;
	$apage2 = 1;

	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
	}
	if(isset($_GET['qpage']))
	{
		$qpage = $_GET['qpage'];
	}
	if(isset($_GET['apage0']))
	{
		$pagetype = "apage0";
		$page = $_GET['apage0'];
	}
	if(isset($_GET['apage1']))
	{
		$pagetype = "apage1";
		$page = $_GET['apage1'];
	}
	if(isset($_GET['apage2']))
	{
		$pagetype = "apage2";
		$page = $_GET['apage2'];
	}
	

	$conn = mysqli_connect("localhost", "root", "sdm9469", "math_overflow");
	if(mysqli_connect_errno())
	{
		echo("mysql 서버가 정상 동작하지 않습니다");
	}
	else { echo "success!!"; }


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


	if(!isset($_SESSION['user_email']) || !isset($_SESSION['user_password'])) //로그인 체크
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>로그인을 하여야 댓글 작성이 가능합니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/member/login.html'\">로그인</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}

	if($type == 1) //질문에 대한 댓글;
	{
		$writer = $_POST['comm_writer'];
		$message = $_POST['comm_message'];
		$password = $_POST['comm_password'];
		$writer = str_replace("\\", "\\\\", $writer);
		$message = str_replace("\\", "\\\\", $message);
		
		$comment_no = -1;
		$sql_getno = "select count from board_master where name='comment_" . $boardname . "'";
		$result_getno = $conn->query($sql_getno);
		while($row_getno = $result_getno->fetch_assoc())
		{
			$comment_no = $row_getno['count'];
		}
		$sql = "insert into comment_" . $boardname . " (member_no, content, date, vote, qora, writer, fromno, password, vote_member, downvote_member) values (" . $_SESSION['user_member_no'] . ", \"" . $message . "\", now(), 0," . $type . ", \"" . $writer . "\", ". $no . ", \"" . $password . "\", \";\", \";\")";

		//코멘트 개수를 세어서 페이지 위치 지정
		$sql_commcount = "select count(*) as total from comment_" . $boardname . " where fromno=" . $no . " and qora=" . $type;
		echo $sql_commcount;
		$result_commcount = mysqli_query($conn, $sql_commcount);
		$commcount = mysqli_fetch_assoc($result_commcount);
		$qpage = intval($commcount['total'] / 5) + 1;



			#$sql = "insert into comment_board_middle_freeboard (content, date, vote, isre, writer, fromno) values (\"testtest\", now(), 0, 0, \"test\", 256)";
		$sql_noupdate = "update board_master set count=count+1 where name='comment_" . $boardname . "'";
		$conn->query($sql_noupdate);

	
		
			
			$result = $conn->query($sql);
			if($result)
			{
				echo "comment ok(질문)";
			}
			else
			{
				echo "comment failed..(질문)";
			}
		echo "<meta http-equiv='refresh' content='0; url=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $no . "&page=" . $_GET['page'] . "&qpage=" . $qpage . "&apage0=" . $_GET['apage0'] . "&apage1=" . $_GET['apage1'] . "&apage2=" . $_GET['apage2'] . "&scrollstat=" . $_GET['scrollstat'] . "'>"; 
	}
	else if($type == 2) //답변에 대한 댓글
	{
		$writer_a = $_POST['comma_writer'];
		$message_a = $_POST['comma_message'];
		$password_a = $_POST['comma_password'];

		$sql = "insert into comment_" . $boardname . " (member_no, content, date, vote, qora, writer, fromno, password, vote_member, downvote_member) values (" . $_SESSION['user_member_no'] . ", \"" . $message_a . "\", now(), 0," . $type . ", \"" . $writer_a . "\", ". $no . ", \"" . $password_a . "\", \";\", \";\")";

		//코멘트 개수를 세어서 페이지 위치 지정
		$sql_commcount = "select count(*) as total from comment_" . $boardname . " where fromno=" . $no . " and qora=" . $type;
		echo $sql_commcount;
		$result_commcount = mysqli_query($conn, $sql_commcount);
		$commcount = mysqli_fetch_assoc($result_commcount);
		$apage0 = $_GET['apage0'];
		$apage1 = $_GET['apage1'];
		$apage2 = $_GET['apage1'];

		switch($_GET['wp'])
		{
			case 0:
				$apage0 = intval($commcount['total'] / 5) + 1;
				break;
			case 1:
				$apage1 = intval($commcount['total'] / 5) + 1;
				break;
			case 2:
				$apage2 = intval($commcount['total'] / 5) + 1;
				break;
			default:
				echo "<meta http-equiv='refresh' content='0; url=/error.php'>";
		}

		echo $sql;

		$result = $conn->query($sql);
		if($result)
		{
			echo "comment ok(답변)";
		}
		else
		{
			echo "comment failed..(답변)";
		}

		echo "<meta http-equiv='refresh' content='0; url=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $fromno . "&page=" . $_GET['page'] . "&qpage=" . $_GET['qpage'] . "&apage0=" . $apage0 . "&apage1=" . $apage1 . "&apage2=" . $apage2 . "&scrollstat=" . $_GET['scrollstat'] . "'>"; 
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

