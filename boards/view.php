 
 <!---------------------- view.php --------------------------->


 <html>
<head>

	<script>
		  function setCookie(cName, cValue, cHour){
        var expire = new Date();
        expire.setTime(expire.getTime() + cHour*60*60*1000);
        cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
        if(typeof cHour != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
        document.cookie = cookies;
    }

	</script>
	<script src="/js/jquery.js"></script>
	<?php
		
		$boardname = $_GET['boardname'];
		$no = $_GET['no'];
		
		$page = 0;
		$rows_in_once = 20;
		$pages_in_once = 10;

		if(!isset($_GET['page'])) //페이지값은 get으로 받는다
		{
			$page = 1;
		} else
		{
			$page = $_GET['page'];
		}

		$conn = mysqli_connect("localhost", "root", "sdm9469", "math_overflow");
		if(mysqli_connect_errno())
		{
			echo("mysql 서버가 정상 동작하지 않습니다");
		}
		else {  }

		#title plotting module
		$sql_title = "SELECT alias FROM board_master where name=\"" . $boardname . "\"";
		$sql = "SELECT title FROM " . $boardname . " where no=" . $no;
		$result_title = $conn->query($sql_title);	
		$result = $conn->query($sql);

		if(!$result || !$result_title)
		{
			echo "<meta http-equiv='refresh' content='0; url=/error.php'>";
		}
		
		$titletitle = "";
		while($row = $result->fetch_assoc())
		{
			$titletitle = $row["title"];
		}

		$aliasalias = "";
		while($row_title = $result_title->fetch_assoc())
		{
			$aliasalias = $row_title["alias"];
		}

		echo "<title>" . $titletitle . " - " . $aliasalias . " - Math Overflow</title>";
		#title plotting module end


	?>


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


<script>
window.onload = function(){
		
		$(document).scrollTop(document.getElementById("scrollstat").value);
	}

</script>

<script language="javascript">

	

	function Vote_Up(boardname, page, no)
	{
		var scrollpos = $(document).scrollTop();
		location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&votetype=1&page=" + page + "&scrollstat=" + scrollpos;
	}

	function Vote_Down(boardname, page, no)
	{
		var scrollpos = $(document).scrollTop();
		location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&votetype=2&page=" + page + "&scrollstat=" + scrollpos;
	}

	function Vote_Cancel_Up(boardname, page, no)
	{
		var scrollpos = $(document).scrollTop();
		location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&votetype=3&page=" + page + "&scrollstat=" + scrollpos;
	}

	function Vote_Cancel_Down(boardname, page, no)
	{
		var scrollpos = $(document).scrollTop();
		location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&votetype=4&page=" + page + "&scrollstat=" + scrollpos;
	}

	function Vote_Comment_Up(boardname, page, no, fromno)
	{
		var scrollpos = $(document).scrollTop();
		location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&votetype=1&page=" + page + "&boardtype=comment&scrollstat=" + scrollpos;
	}

	function Vote_Comment_Down(boardname, page, no, fromno)
	{
		var scrollpos = $(document).scrollTop();
		location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&votetype=2&page=" + page + "&boardtype=comment&scrollstat=" + scrollpos;
	}

	function ChkBeforeComment()
				{
					if(document.commentForm.comm_writer.value == "")
					{
						alert("이름을 입력해주세요");
						document.commentForm.comm_writer.focus();
						return;
					}
					else if(document.commentForm.comm_password.value == "" || document.commentForm.comm_password.value == "메롱메롱")
					{
						alert("비밀번호를 입력해주세요");
						document.commentForm.comm_password.focus();
						return;
					}
					else if(!document.commentForm.comm_message.value.replace(/(^\s*)|(\s*$)/gi,""))
					{
						alert("내용을 입력해주세요");
						document.commentForm.comm_message.focus();
						return;
					}
					else
					{
						document.commentForm.submit();
					}
				}


</script>

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


		//조회수 쿠키 설정(1시간)
		$boardname=$_GET['boardname'];
		$no=$_GET['no'];


		if(!isset($_COOKIE[$boardname . "_" . $no]))
		{
			echo "<script>setCookie('" . $boardname . "_" . $no . "', 'YOU CANT SEE ME', 1);</script>";
		}



		if(isset($_POST['scrollstat']))
		{
			echo "<input type='hidden' name='scrollstat' id='scrollstat' value='" . $_POST['scrollstat'] . "' >";
		}
	
		#title
		$sql_title = "SELECT alias FROM board_master where name=\"" . $boardname . "\"";
		$result_title = $conn->query($sql_title);	
		while($row_title = $result_title->fetch_assoc())
		{
			echo "<font color=#000000><h2>" . $row_title["alias"] . "</h2></font>";
		}
		#title module end



		#contents
		$sql = "select * from " . $boardname . " where no=" . $no;
		$result = $conn->query($sql);
		
		if($result && $result->num_rows > 0)
		{
			$date_question = 0;
			while($row = $result->fetch_assoc())
			{
				$memsql = "select nickname from member where no=" . $row["member_no"];
				$result_memsql = $conn->query($memsql);
				$member_nickname = "";
				if($result_memsql->num_rows == 1)
				{
					while($row_mem = $result_memsql->fetch_assoc())
					{
						$member_nickname = $row_mem['nickname'];
					}
				}
				$date_question = $row['date'];
				
				$upvote_count = explode(";",$row['vote_member']);
				if($upvote_count[1] == "") $upvote_count = count($upvote_count) - 1;
				else $upvote_count = count($upvote_count);
				
				$downvote_count = explode(";",$row['downvote_member']);
				if($downvote_count[1] == "") $downvote_count = count($downvote_count) - 1;
				else $downvote_count = count($downvote_count);


				echo "<br>";
				echo "<table width=90% border=0 bordercolor=white>";
				echo "<tr><td width=15% style=\"background-color:#ffcc99;padding-left:10\">제목</td>";
				echo "<td width=20% colspan=3><pdongmin>" .  htmlspecialchars($row["title"]) . "</pdongmin></td></tr>";
				
				echo "<tr><td style=\"background-color:#ffcc99;padding-left:10\">작성일시</td>";
				echo "<td>" . $row["date"] . "</td>";
				
				echo "<td style=\"background-color:#ffcc99;padding-left:10\">작성자</td>";

				
				if($row["member_no"] == -1)
				{
					echo "<td><pdogmin>" .  htmlspecialchars($row["writer"]) . "</pdongmin></td></tr>";
				}
				else if($member_nickname != "")
				{
					echo "<td><pdogmin><a href='/member/mypage.php?memberno=" . $row["member_no"] . "' style='text-decoration:none'><font color=black><pdongmin>" . htmlspecialchars($member_nickname) . "</font></a></pdongmin></td></tr>";
				}
				else
				{
					echo "<td><pdongmin><a href='/member/mypage.php?memberno=" . $row["member_no"] . "' style='text-decoration:none'><font color=black><pdongmin>" . htmlspecialchars($row['writer']) . "</font></a></pdongmin></td></tr>";
				}
				
			
				echo "<tr><td width=15% style=\"background-color:#ffcc99;padding-left:10\">조회</td><td width=20%>" . $row["hit"] . "</td><td width=15% style=\"background-color:#ffcc99;padding-left:10\">추천</td><td width=20%>" . $row["vote"] . " (추천: " . ($upvote_count - 1) . " / 비추천: " . ($downvote_count - 1) . ")</td></tr></table>";

				#이미지 첨부를 했으면~ 이미지를 표시한다
				if($row['imgpath1'] != "")
				{
					echo "<br>";
					echo "<img src='/boards/boardimage/" . $row['imgpath1'] . "' style='max-width:70%'>";
					echo "<br>";
				}
				
				if($row['imgpath2'] != "")
				{
					echo "<br>";
					echo "<img src='/boards/boardimage/" . $row['imgpath2'] . "' style='max-width:70%'>";
					echo "<br>";
				}

				if($row['imgpath3'] != "")
				{
					echo "<br>";
					echo "<img src='/boards/boardimage/" . $row['imgpath3'] . "' style='max_width:70%'>";
					echo "<br>";
				}



				echo "<div style=\"padding:10 0 100 5\"><pdongmin>" .  htmlspecialchars($row["content"]) . "</pdongmin></div>";
				if(!isset($_COOKIE[$boardname . "_" . $no]))
				{
					$current_hit = $row["hit"];
					$sql_update_hit = "update " . $boardname . " set hit=" . (($current_hit) + 1) . " where no=" . $no;
					$conn->query($sql_update_hit);
				}



				echo "<div>";
				echo "<div style=\"width:40%;text-align:left;float:left;padding-top:30;display:inline\"><button type='button' onclick=\"location.href='/boards/list.php?boardname=" . $boardname . "'\" class=\"snip1535_list\">목록으로</button>";
				echo "&nbsp;&nbsp;&nbsp;";
				echo "<button type='button' onclick=\"location.href='/boards/write.php?boardname=" . $boardname . "'\" class=\"snip1535_list\">글 작성</button>&nbsp;&nbsp&nbsp;";

				

				if($row["member_no"] != -1)
				{
					if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
					{


						if($_SESSION['user_member_no'] == $row['member_no'])
						{
							//회원 자신의 게시글이면 수정/삭제 버튼 노출
							echo "<button type='button' onclick=\"location.href='/boards/modify.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">수정</button>&nbsp;&nbsp&nbsp;";
							echo "<button type='button' onclick=\"location.href='/boards/delete.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">삭제</button></div>";
						}
						else
						{
							//회원 자신의 게시글이 아닌 경우 수정/삭제 버튼 노출 안함
							echo "</div>";
						}
					}
				}
				else
				{
					//비회원의 글은 수정/삭제 버튼 항상 노출
					echo "<button type='button' onclick=\"location.href='/boards/modify.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">수정</button>&nbsp;&nbsp&nbsp;";
					echo "<button type='button' onclick=\"location.href='/boards/delete.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">삭제</button></div>";
				}

				if(isset($_SESSION['user_email'])) //회원에게만 추천/비추천 기능 활성화
				{
				echo "<div style='margin-top:30;width:40%;float:right;margin-right:10%;text-align:right;display:inline'>";
				
					//추천/ 비추천 기능은 회원에게만 활성화
					$upvote_members = explode(";", $row['vote_member']);
					$downvote_members = explode(";", $row['downvote_member']);
					$witness = 0;
					for($i=0;$i<count($upvote_members);$i++) //이 글에 대한 추천 상태라면
					{
						if($upvote_members[$i] == $_SESSION['user_member_no'])
						{
							$witness ++;
							echo "<button type='button' onclick=\"javascript:Vote_Cancel_Up('" . $boardname . "', '" . $page . "', '" . $no . "');\" class=\"snip1535_list\">추천 취소</button>&nbsp;&nbsp&nbsp;";
							break;
						}
					}
					

					for($i=0;$i<count($downvote_members);$i++) //이 글에 대한 비추천 상태라면
					{
						if($downvote_members[$i] == $_SESSION['user_member_no'])
						{
							$witness ++;
							echo "<button type='button' onclick=\"javascript:Vote_Cancel_Down('" . $boardname . "', '" . $page . "', '" . $no . "');\" class=\"snip1535_list\">비추천 취소</button>&nbsp;&nbsp&nbsp;";
							break;
						}
					}
		

					if($witness == 0) //이 글에 추천, 비추천을 한 적이 없다면 
					{
						echo "<button type='button' onclick=\"javascript:Vote_Up('" . $boardname . "', '" . $page . "', '" . $no . "');\" class=\"snip1535_list\">추천</button>&nbsp;&nbsp&nbsp;";
						echo "<button type='button' onclick=\"javascript:Vote_Down('" . $boardname . "', '" . $page . "', '" . $no . "');\" class=\"snip1535_list\">비추천</button>&nbsp;&nbsp&nbsp;";
					}
				echo "</div>";
				}
				echo "</div>";
				
				
			}
			
				echo "<br>";

			#comment가 시작되는 부분입니다

			$sql_all = "select count(*) as total from comment_" . $boardname . " where fromno=" . $no . " and date >= '" . $date_question . "'";
			$result_all = mysqli_query($conn, $sql_all);
			$commcount = mysqli_fetch_array($result_all);

			echo "<div id=\"content_comment\">";
			
			echo "<br>댓글 작성<br>";

			if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
			{
				echo "<form name=\"commentForm\" action=\"/boards/comment_ok.php?boardname=" . $boardname . "&no=" . $no . "&page=" . (intval(($commcount['total']) / $rows_in_once ) + 1) . "\" method=\"post\">";
				echo "<table border=0 width=90%>";
				echo "<tr>";
				echo "<td width=12%>";
				echo "<b><pdongmin>" . $_SESSION['user_nickname'] . "</pdongmin></b>";
				echo "<input type=\"hidden\" id=\"comm_writer\" name=\"comm_writer\" style=\"width:100%;margin-bottom:20;border:1px solid #ff901e\" value=\"". $_SESSION['user_nickname'] ."\" onfocus=\"this.value=''\"/> <br>";
				echo "<input type=\"hidden\" id=\"comm_password\" name=\"comm_password\" style=\"width:100%;border:1px solid #ff901e\"/ value=\"MEMBER\" onfocus=\"this.value=''\" /> </td>";
				echo "<td width=58%>";
				echo "<textarea id=\"comm_message\" name=\"comm_message\" style=\"width:100%;height:60px;padding-top:10;padding-bottom:10;border:1px solid #ff901e\"></textarea></td>";
				echo "<td width=10%>";
				echo "<button type='button' style=\"width:100%;height:60px\" class=\"snip1535_list\" onclick=\"javascript:ChkBeforeComment();\">작성 완료</button></td>";
				echo "</tr></table></form>";

			}
			else
			{
				echo "<form name=\"commentForm\" action=\"/boards/comment_ok.php?boardname=" . $boardname . "&no=" . $no . "&page=" . (intval(($commcount['total']) / $rows_in_once ) + 1) . "\" method=\"post\">";
				echo "<table border=0 width=90%>";
				echo "<tr>";
				echo "<td width=15%>";
				echo "<input type=\"text\" id=\"comm_writer\" name=\"comm_writer\" style=\"width:100%;margin-bottom:20;border:1px solid #ff901e\" value=\"이름\" onfocus=\"this.value=''\"/> <br>";
				echo "<input type=\"password\" id=\"comm_password\" name=\"comm_password\" style=\"width:100%;border:1px solid #ff901e\"/ value=\"메롱메롱\" onfocus=\"this.value=''\" /> </td>";
				echo "<td width=50%>";
				echo "<textarea id=\"comm_message\" name=\"comm_message\" style=\"width:100%;height:60px;padding-top:10;padding-bottom:10;border:1px solid #ff901e\"></textarea></td>";
				echo "<td width=10%>";
				echo "<button type='button' style=\"width:100%;height:60px\" class=\"snip1535_list\" onclick=\"javascript:ChkBeforeComment();\">작성 완료</button></td>";
				echo "</tr></table></form>";

			}
			

			$sql_comment = "select * from comment_" . $boardname . " where fromno=" . $no . " and date >= '" . $date_question . "'";
			
			
			if(!$result_all) { echo "fail...";}

			

			
			$sql_nopage = $sql_comment;
			$sql_comment .= " LIMIT " . (($page - 1) * $rows_in_once) .  ", " . $rows_in_once;

			$result_comment = $conn->query($sql_comment);
			
			if($result_comment->num_rows > 0)
			{
				echo "댓글 " . $commcount['total'] . "개가 있습니다.";
				while($row_comment = $result_comment->fetch_assoc())
				{

					$memsql = "select nickname from member where no=" . $row_comment["member_no"];
					$result_memsql = $conn->query($memsql);
					$member_nickname = "";
					if($result_memsql->num_rows == 1)
					{
						while($row_mem = $result_memsql->fetch_assoc())
						{
							$member_nickname = $row_mem['nickname'];
						}
					}
					echo "<script>ScrollPos();</script>";
					echo "<table width=90% border=0 style=\"1pt solid #ff901e\" bgcolor=\"#FFEFD1\">";
					echo "<tr>";
					echo "<td width=2%><center><a href=\"javascript:Vote_Comment_Up('" . $boardname . "', '" . $page . "', '" . $row_comment["no"] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▲</font></a></center></td>";
					echo "<td width=2%><center><a href=\"javascript:Vote_Comment_Down('" . $boardname . "', '" . $page . "', '" . $row_comment["no"] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▼</font></a></center></td>";
					echo "<td width=6%>";
					echo $row_comment["vote"] . "</td>" ;
			

					echo "<td width=15%>";
					if($row_comment["member_no"] == -1)
					{
						echo "<pdongmin>" . htmlspecialchars($row_comment["writer"]) . "</pdongmin></td>" ;
					}
					else if($member_nickname != "")
					{
						echo "<a href='/member/mypage.php?memberno=" . $row_comment["member_no"] . "' style='text-decoration:none'><font color=black><pdongmin>" . htmlspecialchars($member_nickname) . "</font></a></pdongmin></td>";
					}
					else
					{
						echo "<a href='/member/mypage.php?memberno=" . $row_comment["member_no"] . "' style='text-decoration:none'><font color=black><pdongmin>" . htmlspecialchars($row_comment['writer']) . "</font></a></pdongmin></td>";
					}


					echo "<td width=60%><pdongmin>";
					echo  htmlspecialchars($row_comment["content"]) . "</pdongmin></td>" ;
			
					echo "<td width=20%>";
					echo $row_comment["date"] . "</td><br>" ;
					echo "<td width=2%>";
					if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
					{
						if($row_comment['member_no'] == -1) //로그인을 한 상태에서 비회원의 댓글에 대하여
						{
							echo "<a href=\"delete_comment.php?boardname=" . $boardname . "&fromno=" . $no . "&no=" . $row_comment["no"] . "&page=" . min($page, (intval(($commcount['total'] - 2) / $rows_in_once) + 1)) . "\"><img src=/boards/img/ico_delete.png width=20 height=20 border=0></a>";
						}
						else if($row_comment['member_no'] == $_SESSION['user_member_no']) //로그인을 한 상태에서 자신의 댓글에 대하여
						{
							echo "<a href=\"delete_comment.php?boardname=" . $boardname . "&fromno=" . $no . "&no=" . $row_comment["no"] . "&page=" . min($page, (intval(($commcount['total'] - 2) / $rows_in_once) + 1)) . "\"><img src=/boards/img/ico_delete.png width=20 height=20 border=0></a>";
					
						}
						else //로그인을 한 상태에서 비회원이나 자신의 댓글이 아닌 댓글에 대하여(다른 회원의 댓글에 대하여) (삭제버튼 안보임)
						{
							echo "<img src=/boards/img/ico_delete_blank.png width=20 height=20 border=0/>";
						}

					}
					else
					{
						if($row_comment['member_no'] == -1) //로그인을 안 한 상태에서 비회원의 댓글에 대하여
						{
							echo "<a href=\"delete_comment.php?boardname=" . $boardname . "&fromno=" . $no . "&no=" . $row_comment["no"] . "\"><img src=/boards/img/ico_delete.png width=20 height=20 border=0></a>";
					
						}
						else //로그인을 안 한 상태에서 회원의 댓글에 대하여 (삭제 버튼 안보임)
						{
							echo "<img src=/boards/img/ico_delete_blank.png width=20 height=20 border=0/>";
						}
					}
					echo "</td></tr></table>";
			
				}


				//댓글 페이징
				$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
				echo "<table align='center'>";
				echo "<tr><td>";

				
				$sql_chk = $sql_nopage . " LIMIT " . ((intval(($page - 1) / 10) - 1) * 10 + 9) * $rows_in_once .  ", " . $rows_in_once;
				$result_chk = $conn->query($sql_chk);
				if($result_chk && $result_chk->num_rows != 0)
				{
					
					echo "<a href='/boards/view.php?boardname=" . $boardname . "&no=" . $no . "&page=" . ((intval(($page - 1) / 10) - 1) * 10 + 10) . "' style='text-decoration:none'><font color=black>◀</font></a> ";
				}
				else
				{ }

				for($i = 0; $i < 10; $i ++)
				{
					

					//echo "값: " . ($page - 1) % 10 . "<br>";
					if(($page - 1 ) % 10 == $i)
					{
						//echo "this???";
						echo "<b>";
						echo intval(($page - 1) / 10) * 10 + $i + 1;
						echo "</b>";
					}
					else
					{
						echo "<a href='/boards/view.php?boardname=" . $boardname . "&no=" . $no . "&page=" . (intval(($page - 1) / 10) * 10 + $i + 1) . "' style='text-decoration:none'><font color=black>";
						echo intval(($page - 1) / 10) * 10 + $i + 1;
						echo "</font></a>";
					}

				
					$sql_chk = $sql_nopage . " LIMIT " . ((intval(($page - 1) / 10) * 10 + $i + 1) * $rows_in_once) .  ", " . $rows_in_once;
				
					$result_chk = $conn->query($sql_chk);

					if($result_chk->num_rows == 0) break;
				
					if($i == 9) continue;

					echo " | ";
				}

				$sql_chk = $sql_nopage . " LIMIT " . ((intval(($page - 1) / 10) + 1) * 10 + 1 - 1) * $rows_in_once .  ", " . $rows_in_once;
				$result_chk = $conn->query($sql_chk);
				if($result_chk->num_rows != 0)
				{
					echo " <a href='/boards/view.php?boardname=" . $boardname . "&no=" . $no . "&page=" . ((intval(($page - 1) / 10) + 1) * 10 + 1) . "' style='text-decoration:none'><font color=black>▶</font></a>";
				}
				else
				{ }

				echo "</td></tr></table>";


			}
			else
			{
				echo "<br>등록된 댓글이 없습니다.<br><br>";
			}


			echo "</div>";
			 echo "</div>";
			echo "</div>";
		}
		else
		{
			echo "<div style=\"width:40%;margin-left:100;margin-top:80\"><center>존재하지 않거나 삭제된 글입니다.</center></div>";
			echo "<div style=\"width:40%;margin-left:100;margin-top:20;margin-bottom:400\"><button type=\"button\" onclick=\"history.back();\" class=\"snip1535_list\" style=\"width:100%\">뒤로가기</button></div>";

			echo "</div>";
		  echo "</div>";		
		}

	
	?>

  <div id="footer">
	<?php
	include("../frame_bottom.html");
	?>
  </div>
</div>
</body>

