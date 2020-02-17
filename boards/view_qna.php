<!----------------------------------- view_qna.php ---------------------------------------------->

 <html>
<head>
	<script src="/js/jquery.js"></script>
	<script>
	  function setCookie(cName, cValue, cHour){
			var expire = new Date();
			expire.setTime(expire.getTime() + cHour*60*60*1000);
			cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
			if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
			document.cookie = cookies;
		}
	</script>

	<?php
		$boardname = $_GET['boardname'];
		$no = $_GET['no'];
		$q_member_no = -1;

		//답변 페이징
		$page = 0;
		$rows_in_once = 3;
		$pages_in_once = 10;

		//질문에 대한 댓글 페이징
		$qpage = 0;
		$qrows_in_once = 5;
		$qpages_in_once = 10;

		//답변에 대한 댓글 페이징
		$apage[0] = 0;
		$arows_in_once[0] = 5;
		$apages_in_once[0] = 10;

		$apage[1] = 0;
		$arows_in_once[1] = 5;
		$apages_in_once[1] = 10;

		$apage[2] = 0;
		$arows_in_once[2] = 5;
		$apages_in_once[2] = 10;

		if(!isset($_GET['page'])) //페이지값은 get으로 받는다
		{
			$page = 1;
		} else
		{
			$page = $_GET['page'];
		}

		if(!isset($_GET['qpage'])) //페이지값은 get으로 받는다
		{
			$qpage = 1;
		} else
		{
			$qpage = $_GET['qpage'];
		}

		if(!isset($_GET['apage0'])) //페이지값은 get으로 받는다
		{
			$apage[0] = 1;
		} else
		{
			$apage[0] = $_GET['apage0'];
		}

		if(!isset($_GET['apage1'])) //페이지값은 get으로 받는다
		{
			$apage[1] = 1;
		} else
		{
			$apage[1] = $_GET['apage1'];
		}

		if(!isset($_GET['apage2'])) //페이지값은 get으로 받는다
		{
			$apage[2] = 1;
		} else
		{
			$apage[2] = $_GET['apage2'];
		}

		//조회수 쿠키 설정(1시간)
		if(!isset($_COOKIE[$boardname . "_" . $no]))
		{
			echo "<script>setCookie('" . $boardname . "_" . $no . "', 'YOU CANT SEE ME', 1);</script>";
		}

		$conn = mysqli_connect("localhost", "root", "sdm9469", "math_overflow");
		if(mysqli_connect_errno())
		{
			echo("mysql 서버가 정상 동작하지 않습니다");
			return;
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
		if($result->num_rows == 0)
		{
			$titletitle = "삭제된 질문";
		}
		else
		{
			while($row = $result->fetch_assoc())
			{
				$titletitle = $row["title"];
			}
		}
		

		$aliasalias = "";
		while($row_title = $result_title->fetch_assoc())
		{
			$aliasalias = $row_title["alias"];
		}

		echo "<head><title>" . $titletitle . " - " . $aliasalias . " - Math Overflow</title></head>";
		#title plotting module end
	?>

	<script>
window.onload = function(){
		
		$(document).scrollTop(document.getElementById("scrollstat").value);
	}

</script>

 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>


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
		window.onload = function() {
		$(document).scrollTop(document.getElementById("get_scrollstat").value);
	}

	</script>

    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

	<script language="javascript">

		function Vote_Up(boardname, no)
		{
			var scrollpos = $(document).scrollTop();
			location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&votetype=1&scrollstat=" + scrollpos;
		}

		function Vote_Down(boardname, no)
		{
			var scrollpos = $(document).scrollTop();
			location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&votetype=2&scrollstat=" + scrollpos;
		}
	
		function Vote_Comment_Up(boardname, no, fromno)
		{
			var scrollpos = $(document).scrollTop();
			location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&votetype=1&boardtype=comment&scrollstat=" + scrollpos;
		}

		function Vote_Comment_Down(boardname, no, fromno)
		{
			var scrollpos = $(document).scrollTop();
			location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&votetype=2&boardtype=comment&scrollstat=" + scrollpos;
		}

		function Vote_Answer_Up(boardname, no, fromno)
		{
			var scrollpos = $(document).scrollTop();
			location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&votetype=1&boardtype=answer&scrollstat=" + scrollpos;
		}

		function Vote_Answer_Down(boardname, no, fromno)
		{
			var scrollpos = $(document).scrollTop();
			location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&votetype=2&boardtype=answer&scrollstat=" + scrollpos;
		}

		function Vote_Answer_Comment_Up(boardname, no, fromno)
		{
			var scrollpos = $(document).scrollTop();
			location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&votetype=1&boardtype=comment&scrollstat=" + scrollpos;
		}

		function Vote_Answer_Comment_Down(boardname, no, fromno)
		{
			var scrollpos = $(document).scrollTop();
			location.href="/boards/vote.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&votetype=2&boardtype=comment&scrollstat=" + scrollpos;
		}

		function go_adopt(boardname, no, fromno)
		{
			
			window.open("/boards/adopt.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno , "채택하기 - Math Overflow", "width=600, height=300, left=50, top=50, scrollbar=yes, resizable=no");
		}

		function pageMover(boardname, no, page, qpage, apage0, apage1, apage2)
		{
			var v_scrollstat = Math.ceil($(document).scrollTop());
			location.href="/boards/view_qna.php?boardname=" + boardname + "&no=" + no + "&page=" + page + "&qpage=" + qpage + "&apage0=" + apage0 + "&apage1=" + apage1 + "&apage2=" + apage2 + "&scrollstat=" + v_scrollstat;

		}

		

		

		function ChkBeforeComment_Q(boardname, no, page, qpage, apage0, apage1, apage2)
				{
					if(document.comment_q.comm_writer.value == "")
					{
						alert("이름을 입력해주세요");
						document.comment_q.comm_writer.focus();
						return;
					}
					else if(document.comment_q.comm_password.value == "" || document.comment_q.comm_password.value == "메롱메롱")
					{
						alert("비밀번호를 입력해주세요");
						document.comment_q.comm_password.focus();
						return;
					}
					else if(!document.comment_q.comm_message.value.replace(/(^\s*)|(\s*$)/gi,""))
					{
						alert("내용을 입력해주세요");
						document.comment_q.comm_message.focus();
						return;
					}
					else
					{
						var v_scrollstat = Math.ceil($(document).scrollTop());
						comment_q.action = "/boards/comment_qna_ok.php?boardname=" + boardname + "&no=" + no + "&type=1&page=" + page + "&qpage=" + qpage + "&apage0=" + apage0 + "&apage1=" + apage1 + "&apage2=" + apage2 + "&scrollstat=" + v_scrollstat;
					
						document.comment_q.submit();
					}
				}

		function delComment_Q(boardname, no, fromno, page, qpage, apage0, apage1, apage2)
		{
			var v_scrollstat = Math.ceil($(document).scrollTop());
			location.href="/boards/delete_comment_qna.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&type=1&page=" + page + "&qpage=" + qpage + "&apage0=" + apage0 + "&apage1=" + apage1 + "&apage2=" + apage2 + "&scrollstat=" + v_scrollstat;
		}



		function ChkBeforeComment_A(boardname, no, fromno, page, qpage, apage0, apage1, apage2, whatpage)
				{
					
					var formname = "comment_a_" + no;
					var formthis = document.getElementById(formname);

					if(formthis.comma_writer.value == "")
					{
						alert("이름을 입력해주세요");
						formthis.comma_writer.focus();
						return;
					}
					else if(formthis.comma_password.value == "" || formthis.comma_password.value == "메롱메롱")
					{
						alert("비밀번호를 입력해주세요");
						formthis.comma_password.focus();
						return;
					}
					else if(!formthis.comma_message.value.replace(/(^\s*)|(\s*$)/gi,""))
					{
						alert("내용을 입력해주세요");
						formthis.comma_message.focus();
						return;
					}
					else
					{
						var v_scrollstat = Math.ceil($(document).scrollTop());	
						formthis.action="/boards/comment_qna_ok.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&type=2&page=" + page + "&qpage=" + qpage + "&apage0=" + apage0 + "&apage1=" + apage1 + "&apage2=" + apage2 + "&wp=" + whatpage + "&scrollstat=" + v_scrollstat;
						formthis.submit();
					}
				}

		function delComment_A(boardname, no, fromno, page, qpage, apage0, apage1, apage2)
		{
			var v_scrollstat = Math.ceil($(document).scrollTop());
			location.href="/boards/delete_comment_qna.php?boardname=" + boardname + "&no=" + no + "&fromno=" + fromno + "&type=2&page=" + page + "&qpage=" + qpage + "&apage0=" + apage0 + "&apage1=" + apage1 + "&apage2=" + apage2 + "&scrollstat=" + v_scrollstat;
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
		echo "<input type='hidden' name='get_scrollstat' id='get_scrollstat' value='" . $_GET['scrollstat'] . "'/>";

	

		$member_no = -1;
		$boardname = $_GET['boardname'];
		$no = $_GET['no'];

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




		
		
		#게시판 제목을 표시함
		#title module
		$sql_title = "SELECT alias FROM board_master where name=\"" . $boardname . "\"";
		$sql = "SELECT * FROM " . $boardname . " ORDER BY no DESC";
		$result_title = $conn->query($sql_title);	
		$result = $conn->query($sql);
		
		#title module end
		$nickname_onetoone = "";
	
		if(strpos($boardname, "onetoone"))
		{
			$sql_tomember = "SELECT * FROM " . $boardname . " where no=" . $no;
			$result_tomember = $conn->query($sql_tomember);
			while($row_tomember = $result_tomember->fetch_assoc())
			{
				//1:1 질문을 받은 본인이 아니면 조회가 불가능하다
				if($row_tomember['to_member'] != $_SESSION['user_member_no'] && $row_tomember['from_member'] != $_SESSION['user_member_no'])
				{
					echo $row_tomember['to_member'] . "/" . $row_tomember['from_member'] . "/" . $_SESSION['user_member_no'];
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
					echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>이 질문은 다른 회원에게 전달된 1:1 질문입니다.<br><br></center></td></tr>";
					echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
							<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
							</button></td>

					</tr></table></div>";

					return;
				}

				$sql_tomember = "select no, nickname from member where no=" . $row_tomember['to_member'];
				$result_tomember = $conn->query($sql_tomember);
				while($row_tm = $result_tomember->fetch_assoc())
				{
					$nickname_onetoone = $row_tm['nickname'];
				}
			}
		}

		while($row_title = $result_title->fetch_assoc())
		{
			echo "<font color=#000000><h2>" . $row_title["alias"] . "</h2></font>";
		}
		



		#질문을 표시함
		$sql = "select * from " . $boardname . " where no=" . $no;
		$result = $conn->query($sql);	
		$answers = 0;
		$date_question = 0;
		$isfinished = 0;

		if(!$result)
		{
			echo "<meta http-equiv='refresh' content='0; url=/error.php'>";
		}
		if($result->num_rows > 0)
		{

			
			$member_no = -1;
			while($row = $result->fetch_assoc())
			{
				$member_no = $row['member_no'];
				$date_question = $row['date'];
				$isfinished = $row['isfinished'];
				echo "<br>";
				if(strpos($boardname, "onetoone"))
				{
					echo "<div style='width:90%;background:#EEDEC0;margin-top:10;margin-bottom:20;padding-top:15;padding-bottom:15;margin-right:10%'>";
					echo "<center><b>" . $nickname_onetoone . "</b> 님께 전달된 1:1 질문입니다.</center>";
					echo "</div>";

					echo "<table width=90% boarder=0>";
					echo "<tr>";
					echo "<td width=10% style='background:#FFEFD1'><center>질문 분야</center></td>";
					echo "<td width=90%>";
					if($row['part'] == "middle")
						echo "중등 수학";
					else if($row['part'] == "high")
						echo "고등 수학";
					else if($row['part'] == "univ")
						echo "대학 수학";

					echo "</td></tr></table>";
				}
				
				echo "<table width=90% border=0 bgcolor=\"#FFEFD1\">";
				$q_member_no = $row['member_no'];

				$memsql = "select * from member where no=" . $row["member_no"];
				$result_mem = $conn->query($memsql);
				$member_nickname = "";
				$member_photopath = "";
				$member_num_questionned = -1;
				$member_num_adopt = -1;

				if($result_mem->num_rows > 0)
				{
					while($row_mem = $result_mem->fetch_assoc())
					{
						$member_nickname = $row_mem['nickname'];
						$member_photopath = $row_mem['photopath'];
						$member_num_questionned = $row_mem['num_questionned'];
						$member_num_adopt = $row_mem['num_adopt'];
					}
				}

				
				echo "<tr>
					<td width=3%><center><a href=\"javascript:Vote_Up('" . $boardname . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▲</font></a></center></td> <td width=5% rowspan=2><center><b><font size=5>" . $row["vote"] . "</font></b></center></td> <td width=86%><font size=4><b><pdongmin>" .  htmlspecialchars($row["title"]) . "</pdongmin></font></b></td><td rowspan=2><center><b><font size=5>" . $row["points"] . " P</font></b></td>
				</tr>";

				echo "<tr>
					<td><center><a href=\"javascript:Vote_Down('" . $boardname . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▼</font></a></center></td> <td>조회수: " . $row["hit"] . "</td>
					</tr></table>";


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

				echo "<div style=\"width:100%;padding: 20 0 100 5\"><pdongmin>" .  htmlspecialchars($row["content"]) . "</pdongmin></div>";

			
				echo "<table width=90% border=0>";
				echo "<tr>";
				
				if($member_nickname != "")
				{
					echo "<table align=\"right\" style='width:23%;margin-right:10%'>";
					echo "<tr> <td colspan=2 style='padding-bottom=1%'>작성일시: " . $row["date"] . "<br><br></td> </tr>";
					echo "<tr>";
					echo "<td rowspan=2 width='20%'><img src=\"/member/memberimage/" . $member_photopath . "\" width=50 height=50 /></td>";
					echo "<td width='80%' style='margin-left:10'>&nbsp;&nbsp;&nbsp;<a href='/member/mypage.php?memberno=" . $row["member_no"] . "' style='text-decoration:none'><font color=black><b>" .  htmlspecialchars($member_nickname) . "</b></font></a></td></tr>";
					echo "<tr><td style='margin-left:10'>&nbsp;&nbsp;&nbsp;총 질문: " . $member_num_questionned . "회(마감: " . $member_num_adopt . ")</td></tr></table>";
				}
				else
				{
					echo "<td width=50% align=\"left\">" . $row["date"] . "</td> <td width=50% align=\"right\"><a href='/member/mypage.php?memberno=" . $row["member_no"] . "' style='text-decoration:none'><font color=black>" .  htmlspecialchars($row["writer"]) . "</font></a></td>";
				}

				echo "</tr>";
				echo "<tr><td colspan=2>" . $row["tags"] . "</td></tr></table>";

				if(!isset($_COOKIE[$boardname . "_" . $no]))
				{
					$current_hit = $row["hit"];
					$sql_update_hit = "update " . $boardname . " set hit=" . (($current_hit) + 1) . " where no=" . $no;
					$conn->query($sql_update_hit);
				}

				$answers = $row["answers"];
			}
			

			echo "<div style=\"width:90%;text-align:left;padding-top:30;padding-bottom:30\">";
			if(!strpos($boardname, "onetoone"))
			{
				echo "<button type='button' onclick=\"location.href='/boards/list_qna.php?boardname=" . $boardname . "'\" class=\"snip1535_list\">목록으로</button>&nbsp;&nbsp&nbsp;";
				echo "<button type='button' onclick=\"location.href='/boards/write_qna.php?boardname=" . $boardname . "'\" class=\"snip1535_list\">질문하기</button>&nbsp;&nbsp&nbsp;";
			}

			if(isset($_SESSION['user_member_no']) && isset($_SESSION['user_password']))
			{
				if($member_no == $_SESSION['user_member_no'] || $isfinished == 1)
				{
			
				}
				else
				{
					echo "<button type='button' onclick=\"location.href='/boards/write_answer.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">이 질문에 답변하기</button>&nbsp;&nbsp&nbsp;";

				}
			}
			else
			{
				if($isfinished == 1)
				{ 
				
				}
				else
				{
					echo "<button type='button' onclick=\"location.href='/boards/write_answer.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">이 질문에 답변하기</button>&nbsp;&nbsp&nbsp;";
				}
			}
		
			if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
			{
				if($_SESSION['user_member_no'] == $member_no)
				{
					if($isfinished == 1) {} else{
					echo "<button type='button' onclick=\"location.href='/boards/modify_qna.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">수정</button>&nbsp;&nbsp&nbsp;"; }
					echo "<button type='button' onclick=\"location.href='/boards/delete_qna.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">삭제</button>";
				}
			}
			else
			{


			}
	
			echo "</div>";

			#질문에 대한 댓글을 표시함 

			$sql_comment_all = "select count(*) as total from comment_" . $boardname . " where fromno=" . $no . " and qora=1 and date >='" . $date_question . "'";
			$result_comment_all = mysqli_query($conn, $sql_comment_all);
			if(!$result_comment_all) { echo "failed..."; }
			$commcount = mysqli_fetch_array($result_comment_all);

			echo "<div id=\"content_comment\">";

			if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
			{
				echo "<br>댓글 작성<br>";
				
				echo "<form name=\"comment_q\" action=\"/boards/comment_qna_ok.php?boardname=" . $boardname . "&no=" . $no . "&type=1&qpage=" . $qpage . "\" method=\"post\">";
				echo "<table border =0 width=90%>";
				echo "<tr>";
				echo "<td width=15%>";
				echo "<b>" . $_SESSION['user_nickname'] . "</b>";
				echo "<input type=\"hidden\" id=\"comm_writer\" name=\"comm_writer\" style=\"width:100%;margin-bottom:20;border:1px solid #ff901e\" value=\"". $_SESSION['user_nickname'] ."\" onfocus=\"this.value=''\"/> <br>";
				echo "<input type=\"hidden\" id=\"comm_password\" name=\"comm_password\" style=\"width:100%;border:1px solid #ff901e\"/ value=\"MEMBER\" onfocus=\"this.value=''\" /> </td>";
				echo "<td width=50%>";
				echo "<textarea id=\"comm_message\" name=\"comm_message\" style=\"width:100%;height:60;padding-top:10;padding-bottom:10;border:1px solid #ff901e\"></textarea></td>";
				echo "<td width=10%>";
				echo "<button type='button' style=\"width:100%;height:60px\" class=\"snip1535_list\" onclick=\"javascript:ChkBeforeComment_Q('" . $boardname . "', '" . $no . "', '" . $page . "', '" . (intval($commcount['total'] / $qrows_in_once) + 1) . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . $apage[2] . "');\">작성 완료</button></td>";
				echo "</tr></table></form>";
			}

			$sql_comment = "select * from comment_" . $boardname . " where fromno=" . $no . " and qora=1 and date >='" . $date_question . "'";
			
			$sql_nopage = $sql_comment;
			$sql_comment .= " LIMIT " . (($qpage - 1) * $qrows_in_once) .  ", " . $qrows_in_once;

			$result_comment = $conn->query($sql_comment);
			
			if($result_comment->num_rows > 0)
			{
				echo "<br>댓글 " . $commcount['total'] . "개가 달렸습니다.";
				while($row_comment = $result_comment->fetch_assoc())
				{
					$memsql = "select nickname from member where no=" . $row_comment['member_no'];
					$result_mem = $conn->query($memsql);
					$member_nickname = "";
					if($result_mem->num_rows > 0)
					{
						while($row_mem = $result_mem->fetch_assoc())
						{
							$member_nickname = $row_mem['nickname'];
						}
					}
					echo "<table width=90% border=0 style=\"border:0pt solid #ff901e\" bordercolor=white bgcolor=\"#FFEFD1\">";
					echo "<tr>";
					echo "<td width=2%><center><a href=\"javascript:Vote_Comment_Up('" . $boardname . "', '" . $row_comment[
						'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▲</font></a></center></td>";
					echo "<td width=2%><center><a href=\"javascript:Vote_Comment_Down('" . $boardname . "', '" . $row_comment[
						'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▼</font></a></center></td>";
					echo "<td width=3%><center>";
					echo $row_comment["vote"] . "</center></td>" ;
			




					echo "<td width=15%>";

					if($member_nickname != "")
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
					echo $row_comment["date"] . "</td>" ;
					echo "<td width=2%>";
	
					if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
					{
						if($row_comment['member_no'] == $_SESSION['user_member_no'])
						{	
							echo "<a href=\"javascript:delComment_Q('" . $boardname . "', '" . $row_comment["no"] . "', '" . $no . "', '" . $page . "', '" . min($qpage, (intval(($commcount['total'] - 2) / $qrows_in_once) + 1)) . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . $apage[2] . "');\"><img src=/boards/img/ico_delete.png width=20 height=20 border=0></a>";
						}
						else
						{
							echo "<img src='/boards/img/ico_delete_blank.png' width=20 height=20 border=0>";
						}

					}
					else
					{
						echo "<img src='/boards/img/ico_delete_blank.png' width=20 height=20 border=0>";
					}
					echo "</td></tr></table><br>";
				}

				//질문에 대한 댓글 페이징

				$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
				echo "<table align='center'>";
				echo "<tr><td>";

				
				$sql_chk = $sql_nopage . " LIMIT " . ((intval(($qpage - 1) / 10) - 1) * 10 + 9) * $qrows_in_once .  ", " . $qrows_in_once;
				
				$result_chk = $conn->query($sql_chk);
				if($result_chk && $result_chk->num_rows != 0)
				{
					echo "<a href=\"javascript:pageMover('$boardname', '$no', '$page', '" . ((intval(($qpage - 1) / 10) - 1) * 10 + 10) . "', '$apage[0]', '$apage[1]', '$apage[2]');\" style='text-decoration:none'><font color=black>◀</font></a> ";
				}
				else
				{ }

				for($i = 0; $i < 10; $i ++)
				{
					//echo "값: " . ($page - 1) % 10 . "<br>";
					if(($qpage - 1 ) % 10 == $i)
					{
						//echo "this???";
						echo "<b>";
						echo intval(($qpage - 1) / 10) * 10 + $i + 1;
						echo "</b>";
					}
					else
					{
						echo "<a href=\"javascript:pageMover('$boardname', '$no', '$page', '" . (intval(($qpage - 1) / 10) * 10 + $i + 1) . "', '$apage[0]', '$apage[1]', '$apage[2]');\" style='text-decoration:none'><font color=black>";
						echo intval(($qpage - 1) / 10) * 10 + $i + 1;
						echo "</font></a>";
					}

				
					$sql_chk = $sql_nopage . " LIMIT " . ((intval(($qpage - 1) / 10) * 10 + $i + 1) * $qrows_in_once) .  ", " . $qrows_in_once;
				
					$result_chk = $conn->query($sql_chk);

					if($result_chk->num_rows == 0) break;
				
					if($i == 9) continue;

					echo " | ";
				}

				$sql_chk = $sql_nopage . " LIMIT " . ((intval(($qpage - 1) / 10) + 1) * 10 + 1 - 1) * $qrows_in_once .  ", " . $qrows_in_once;
				$result_chk = $conn->query($sql_chk);
				if($result_chk->num_rows != 0)
				{
					echo " <a href=\"javascript:pageMover('$boardname', '$no', '$page', '" . ((intval(($qpage - 1) / 10) + 1) * 10 + 1) . "', '$apage[0]', '$apage[1]', '$apage[2]');\"  style='text-decoration:none'><font color=black>▶</font></a>";
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

			#답변을 출력함
			echo "<div id=\"content_answer\">";

			
			if($answers > 0)
			{
				echo "<br>총 " . $answers . "개의 답변이 있습니다.<br>";
				
				$sql_answer = "select * from answer_" . $boardname . " where tg_question_no=" . $no . " and date >='" . $date_question . "' ORDER BY isadopted DESC, date_modified ASC";
				$sql_nopage = $sql_answer;
				$sql_answer .= " LIMIT " . (($page - 1) * $rows_in_once) .  ", " . $rows_in_once;
				$no_in_page = 0;
				
				$result_answer = $conn->query($sql_answer);
				
				if($result_answer)
				{
					if($result_answer->num_rows > 0)
					{
						while($row_answer = $result_answer->fetch_assoc())
						{
							$memsql = "select * from member where no=" . $row_answer['member_no'];
							$result_mem = $conn->query($memsql);
							$member_nickname = "";
							$member_photopath = "";
							$member_here = "";
							$member_here_answered = -1;
							$member_here_adopted = -1;
							$member_answered = -1;
							$member_adopted = -1;
							if($result_mem->num_rows > 0)
							{
								while($row_mem = $result_mem->fetch_assoc())
								{
									$member_nickname = $row_mem['nickname'];
									$member_photopath = $row_mem['photopath'];
									$member_answered = $row_mem['mi_answered'] + $row_mem['hi_answered'] + $row_mem['ui_answered'];
									$member_adopted = $row_mem['mi_adopted'] + $row_mem['hi_adopted'] + $row_mem['ui_adopted'];
									if($boardname == "board_middle_qna" || $row_answer['part'] == "middle")
									{
										$member_here = "중등";
										$member_here_answered = $row_mem['mi_answered'];
										$member_here_adopted = $row_mem['mi_adopted'];
									} else if($boardname == "board_high_qna" || $row_answer['part'] == "high")
									{
										$member_here = "고등";
										$member_here_answered = $row_mem['hi_answered'];
										$member_here_adopted = $row_mem['hi_adopted'];
									} else if($boardname == "board_univ_qna" || $row_answer['part'] == "univ")
									{
										$member_here = "대학";
										$member_here_answered = $row_mem['ui_answered'];
										$member_here_adopted = $row_mem['ui_adopted'];
									} else
									{
										$member_here_answered = -999;
										$member_here_adopted = -999;
									}
								}
							}
							$date_answer = $row_answer["date"];
							echo "<div style=\"width:90%;padding-left:20;margin-top:15;margin-bottom:15;padding-bottom:10;border:1px solid #ff901e\">";
							echo "<table width=90% border=0 bordercolor=white>";
							
							echo "<tr>";
							echo "<td width=3%><a href=\"javascript:Vote_Answer_Up('" . $boardname . "', '" . $row_answer[
						'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▲</font></a></td> <td width=3% rowspan=2><font color=5><b>" . $row_answer["vote"] . "</td> <td width=88% rowspan=2><pdongmin>" .  htmlspecialchars($row_answer["title"]) . "</pdongmin></td>";
							
							echo "<td rowspan=2>";

							if($row_answer['isadopted'] == 3)
							{
								echo "<img src='img/adopted.png' style='width:40;height:40' />";
							}
							else
							{
								echo "<img src='img/empty.png' style='width:40;height:40' />";
							}


							
							echo "</td></tr>";
							
							echo "<tr><td><a href=\"javascript:Vote_Answer_Down('" . $boardname . "', '" . $row_answer[
						'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▼</font></a></td></tr></table>";

							if($row_answer['isadopted'] == 3)
							{	
								echo "<div style=\"width:80%;height:30;padding-top:10;margin-top:10;margin-bottom:10;margin:auto;background:#ffe6b7\">
									
									<pdongmin><b>&nbsp;&nbsp;질문자 감사인사</b>&nbsp;&nbsp;&nbsp;" . htmlspecialchars($row_answer["thanks_message"]) . "</pdongmin>
									
									</div>";
							}
							

								#이미지 첨부를 했으면~ 이미지를 표시한다
								if($row_answer['imgpath1'] != "")
								{
									echo "<br>";
									echo "<img src='/boards/boardimage/" . $row_answer['imgpath1'] . "' style='max-width:70%'>";
									echo "<br>";
								}
								
								if($row_answer['imgpath2'] != "")
								{
									echo "<br>";
									echo "<img src='/boards/boardimage/" . $row_answer['imgpath2'] . "' style='max-width:70%'>";
									echo "<br>";
								}

								if($row_answer['imgpath3'] != "")
								{
									echo "<br>";
									echo "<img src='/boards/boardimage/" . $row_answer['imgpath3'] . "' style='max_width:70%'>";
									echo "<br>";
								}



							echo "<div style=\"width=90%;padding-top:30;padding-bottom:30\">
								<td colspan=3><pdongmin>" .  htmlspecialchars($row_answer["content"]) . "</pdongmin></td></div>
								";
							
							
							echo "<table width=90% border=0 bordercolor=white>";
							echo "<tr>";
							
							
							if($member_nickname != "")
							{
								echo "<table align=\"right\" style='width:23%;margin-right:10%;padding-top:10;padding-bottom:10'>";
								echo "<tr> <td colspan=2 style='padding-bottom=1%'>작성일시: " . $row_answer["date"] . "<br><br></td> </tr>";
								if($row_answer["date"] != $row_answer["date_modified"])
								{
									echo "<tr><td colspan=2 style='padding-bottom=1%'>(최종수정: " . $row_answer["date_modified"] . ")<br><br></td></tr>";
								}
								echo "<tr>";
								echo "<td rowspan=3 width='20%'><img src=\"/member/memberimage/" . $member_photopath . "\" width=50 height=50 /></td>";
								echo "<td width='80%' style='margin-left:10'>&nbsp;&nbsp;&nbsp;<a href='/member/mypage.php?memberno=" . $row_answer["member_no"] . "' style='text-decoration:none'><font color=black><b>" .  htmlspecialchars($member_nickname) . "</b></font></a></td></tr>";
								echo "<tr><td style='margin-left:10'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;총 답변: " . $member_answered . "회(채택: " . $member_adopted . ")</td></tr>";
								echo "<tr><td style='margin-left:10'>&nbsp;&nbsp;&nbsp;" . $member_here . " 답변: " . $member_here_answered . "회(채택: " . $member_here_adopted . ")</td></tr></table><br>";
				
							}
							else
							{
								echo "<td width=50% align=\"left\">" . $row["date"] . "</td> <td width=50% align=\"right\"><a href='/member/mypage.php?memberno=" . $row["member_no"] . "' style='text-decoration:none'><font color=black>" .  htmlspecialchars($row["writer"]) . "</font></a></td>";
							}

							//본인의 답변에만 수정, 삭제 버튼이 보인다
						
							if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']) && $row_answer['member_no'] == $_SESSION['user_member_no'])
							{
								echo "<div style=\"width=90%;padding-top:10;padding-bottom:10\">";
								if($row_answer["isadopted"] == 2 || $row_answer["isadopted"] == 3)
								{ } else{
								echo "<button type='button' class=\"snip1535_list\" onclick=\"location.href='/boards/modify_answer.php?boardname=" . $boardname . "&no=" . $row_answer["no"] . "&fromno=" . $no . "'\">수정</button>&nbsp;&nbsp;";
								}
								echo"<button type='button' class=\"snip1535_list\" onclick=\"location.href='/boards/delete_answer.php?boardname=" . $boardname . "&no=" . $row_answer["no"] . "&fromno=" . $no . "'\">삭제</button>";
									
								echo "</div>";
							}

							if(isset($_SESSION['user_email']) && $_SESSION['user_member_no'] == $q_member_no && $isfinished == 0)
							{
								echo "<button type='button' class=\"snip1535_list\" onclick=\"javascript:go_adopt('" . $boardname . "', " . $row_answer['no'] . ", " . $row_answer['tg_question_no'] . ");\">채택하기</button>";
							}

							
								#답변에 대한 댓글을 표시함
								$sql_comment_all = "select count(*) as total from comment_" . $boardname . " where fromno=" . $row_answer["no"] . " and qora=2 and date >='" . $date_answer . "'";
								$result_comment_all = mysqli_query($conn, $sql_comment_all);
								$commcount = mysqli_fetch_assoc($result_comment_all);
								echo "<div>";	

								//회원에게만 댓글 작성 란이 보인다
								if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
								{
									echo "<form id=\"comment_a_" . $row_answer["no"] . "\" name=\"comment_a_" . $row_answer["no"] ."\" action=\"/boards/comment_qna_ok.php?boardname=" . $boardname . "&no=" . $row_answer["no"] . "&fromno=" . $no . "&type=2&apage" . $no_in_page . "=" . $apage[$no_in_page] . "\" method=\"post\">";
									echo "<table border=0 width=90% >";
									echo "<tr>";
									echo "<td width=15%>";
									echo "<b>" . $_SESSION['user_nickname'] . "</b>";
									echo "<input type=\"hidden\" id=\"comma_writer\" name=\"comma_writer\" style=\"width:100%;margin-bottom:20;border:1px solid #ff901e\" value=\"" . $_SESSION['user_nickname'] . "\" onfocus=\"this.value=''\"/> <br>";
									echo "<input type=\"hidden\" id=\"comma_password\" name=\"comma_password\" style=\"width:100%;border:1px solid #ff901e\"/ value=\"MEMBER\" onfocus=\"this.value=''\" /> </td>";
									echo "<td width=50%>";
									echo "<textarea id=\"comma_message\" name=\"comma_message\" style=\"width:100%;height:60;padding-top:10;padding-bottom:10;border:1px solid #ff901e\"></textarea></td>";
									echo "<td width=10%>";
									switch($no_in_page)
									{
										case 0:
											echo "<button type='button' style=\"width:100%;height:60px\" class=\"snip1535_list\" onclick=\"javascript:ChkBeforeComment_A('" . $boardname . "', '" . $row_answer['no'] . "', '" .  $no . "', '" . $page . "', '" . $qpage . "', '" .  (intval($commcount['total'] / $arows_in_once[0]) + 1) . "', '" . $apage[1] . "', '" . $apage[2] . "', '0');\">작성 완료</button></td>";
											break;
										case 1:
											echo "<button type='button' style=\"width:100%;height:60px\" class=\"snip1535_list\" onclick=\"javascript:ChkBeforeComment_A('" . $boardname . "', '" . $row_answer['no'] . "', '" .  $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . (intval($commcount['total'] / $arows_in_once[1]) + 1) . "', '" . $apage[2] . "', '1');\">작성 완료</button></td>";
											break;
										case 2:
											echo "<button type='button' style=\"width:100%;height:60px\" class=\"snip1535_list\" onclick=\"javascript:ChkBeforeComment_A('" . $boardname . "', '" . $row_answer['no'] . "', '" .  $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . (intval($commcount['total'] / $arows_in_once[2]) + 1) . "', '2');\">작성 완료</button></td>";
											break;
									}
											
										
									echo "</tr></table></form>";
								}
								
								$sql_comment = "select * from comment_" . $boardname . " where fromno=" . $row_answer["no"] . " and qora=2 and date >='" . $date_answer . "'";
								
								$sql_nopage2 = $sql_comment;
								$sql_comment .= " LIMIT " . (($apage[$no_in_page] - 1) * $arows_in_once[$no_in_page]) .  ", " . $arows_in_once[$no_in_page];
								$result_comment = $conn->query($sql_comment);
								if(!isset($_SESSION['user_email']))
								{
									echo "<br><br><br><br><br><br>";
								}


								echo "이 답변의 댓글 [" . $commcount['total'] . "]";
								
								if($result_comment->num_rows > 0)
								{
									while($row_comment = $result_comment->fetch_assoc())
									{
										$memsql = "select nickname from member where no=" . $row_comment['member_no'];
										$result_mem = $conn->query($memsql);
										$member_nickname = "";
										if($result_mem->num_rows > 0)
										{
											while($row_mem = $result_mem->fetch_assoc())
											{
												$member_nickname = $row_mem['nickname'];
											}
										}
										echo "<table width=90% border=0 style=\"border:0pt solid #ff901e\" bgcolor=\"#FFEFD1\">";
										echo "<tr>";
										echo "<td width=2%><center><a href=\"javascript:Vote_Answer_Comment_Up('" . $boardname . "', '" . $row_comment[
						'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▲</font></a></center></td>";
										echo "<td width=2%><center><a href=\"javascript:Vote_Answer_Comment_Down('" . $boardname . "', '" . $row_comment[
						'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▼</font></a></center></td>";
										echo "<td width=3%><center>";
										echo $row_comment["vote"] . "</center></td>" ;
								
										echo "<td width=15%>";

										if($member_nickname != "")
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
										echo $row_comment["date"] . "</td>" ;

										echo "<td width=2%>";
										if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
										{
											if($row_comment['member_no'] == $_SESSION['user_member_no'])
											{
												

												switch($no_in_page)
												{
													case 0:
														echo "<a href=\"javascript:delComment_A('" . $boardname . "', '" . $row_comment["no"] . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . min($apage[0], (intval(($commcount['total'] - 2) / $arows_in_once[0]) + 1)) . "', '" . $apage[1] . "', '" . $apage[2] . "');\"><img src=/boards/img/ico_delete.png width=20 height=20 border=0></a>";
														break;
													case 1:
														echo "<a href=\"javascript:delComment_A('" . $boardname . "', '" . $row_comment["no"] . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . min($apage[1], (intval(($commcount['total'] - 2) / $arows_in_once[1]) + 1)) . "', '" . $apage[2] . "');\"><img src=/boards/img/ico_delete.png width=20 height=20 border=0></a>";
														break;
													case 2:
														echo "<a href=\"javascript:delComment_A('" . $boardname . "', '" . $row_comment["no"] . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . min($apage[2], (intval(($commcount['total'] - 2) / $arows_in_once[2]) + 1)) . "');\"><img src=/boards/img/ico_delete.png width=20 height=20 border=0></a>";
														break;
												}
												
											}
											else
											{
												echo "<img src='/boards/img/ico_delete_blank.png' width=20 height=20 border=0>";
											}

										}
										else
										{
											echo "<img src='/boards/img/ico_delete_blank.png' width=20 height=20 border=0>";
										}
										echo "</td></tr></table><br>";
									}

									//답변에 대한 댓글 페이징

									$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
									echo "<table align='center'>";
									echo "<tr><td>";

									
									$sql_chk = $sql_nopage2 . " LIMIT " . ((intval(($apage[$no_in_page] - 1) / 10) - 1) * 10 + 9) * $arows_in_once[$no_in_page] .  ", " . $arows_in_once[$no_in_page];
									
									$result_chk = $conn->query($sql_chk);
									if($result_chk && $result_chk->num_rows != 0)
									{
										switch($no_in_page)
										{
								
											case 0:
												echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "' , '" .$page . "', '" . $qpage . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) - 1) * 10 + 10) . "', '" . $apage[1] . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>◀</font></a> ";
												break;
											case 1:
												echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "' , '" .$page . "', '" . $qpage . "', '" . $apage[0] . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) - 1) * 10 + 10) . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>◀</font></a> ";
												break;
											case 2:
												echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "' , '" .$page . "', '" . $qpage . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) - 1) * 10 + 10) . "');\" style='text-decoration:none'><font color=black>◀</font></a> ";
												break;
										}
									}
									else
									{ }

									for($i = 0; $i < 10; $i ++)
									{
										//echo "값: " . ($page - 1) % 10 . "<br>";
										if(($apage[$no_in_page] - 1 ) % 10 == $i)
										{
											//echo "this???";
											echo "<b>";
											echo intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1;
											echo "</b>";
										}
										else
										{
											switch($no_in_page)
											{
												case 0:
													
													echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . (intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1) . "', '" . $apage[1] . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>";
													break;
												case 1:
													echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . (intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1) . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>";
													break;
												case 2:
													echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . (intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1) . "');\" style='text-decoration:none'><font color=black>";
													break;
											}
											
											echo intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1;
											echo "</font></a>";
										}

									
										$sql_chk = $sql_nopage2 . " LIMIT " . ((intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1) * $arows_in_once[$no_in_page]) .  ", " . $arows_in_once[$no_in_page];
									
										$result_chk = $conn->query($sql_chk);

										if($result_chk->num_rows == 0) break;
									
										if($i == 9) continue;

										echo " | ";
									}
									
									$sql_chk = $sql_nopage2 . " LIMIT " . ((intval(($apage[$no_in_page] - 1) / 10) + 1) * 10 + 1 - 1) * $arows_in_once[$no_in_page] .  ", " . $arows_in_once[$no_in_page];
									$result_chk = $conn->query($sql_chk);
									if($result_chk->num_rows != 0)
									{
										switch($no_in_page)
										{
											case 0:
												echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) + 1) * 10 + 1) . "', '" . $apage[1] . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>";
												break;
											case 1:
												echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) + 1) * 10 + 1) . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>";
												break;
											case 2:
												echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) + 1) * 10 + 1) . "');\" style='text-decoration:none'><font color=black>";
												break;
										}
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

							$no_in_page ++;
							
						
						}


						//답변 페이징
						$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
						echo "<table align='center'>";
						echo "<tr><td>";
			
						$sql_chk = $sql_nopage . " LIMIT " . ((intval(($page - 1) / 10) - 1) * 10 + 9) * $rows_in_once .  ", " . $rows_in_once;
						$result_chk = $conn->query($sql_chk);
						if($result_chk && $result_chk->num_rows != 0)
						{
							
							echo "<a href='/boards/view_qna.php?boardname=" . $boardname . "&no=" . $no . "&page=" . ((intval(($page - 1) / 10) - 1) * 10 + 10) . "' style='text-decoration:none'><font color=black>◀</font></a> ";
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
								echo "<a href='/boards/view_qna.php?boardname=" . $boardname . "&no=" . $no . "&page=" . (intval(($page - 1) / 10) * 10 + $i + 1) . "' style='text-decoration:none'><font color=black>";
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
							echo " <a href='/boards/view_qna.php?boardname=" . $boardname . "&no=" . $no . "&page=" . ((intval(($page - 1) / 10) + 1) * 10 + 1) . "' style='text-decoration:none'><font color=black>▶</font></a>";
						}
						else
						{ }

						echo "</td></tr></table>";

					}
					else
					{
						//자기 질문 또는 1:1질문답변에 대해서는 '첫 답변 등록자가 되어보세요' 를 없앤다
						if($member_no == $_SESSION['user_member_no'] || strpos($boardname, "onetoone"))
						{
							echo "<br><br><br><br>등록된 답변이 없습니다.";
						}
						else
						{
							echo "<br><br><br><br>등록된 답변이 없습니다. 첫 답변 등록자가 되어보세요! &nbsp;";
							echo "<button type=\"button\" onclick=\"location.href='/boards/write_answer.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">답변하기</button>";
			
						}
					}
				}
				else
				{
					echo "쿼리 에러";
				}
				
			}
			else
			{
				//자기 질문에 대해서는 '첫 답변 등록자가 되어보세요' 를 없앤다
				if($member_no == $_SESSION['user_member_no'] || strpos($boardname, "onetoone"))
				{
					echo "<br><br><br><br>등록된 답변이 없습니다.";
				}
				else
				{
					echo "<br><br><br><br>등록된 답변이 없습니다. 첫 답변 등록자가 되어보세요! &nbsp;";
					echo "<button type=\"button\" onclick=\"location.href='/boards/write_answer.php?boardname=" . $boardname . "&no=" . $no . "'\" class=\"snip1535_list\">답변하기</button>";
				}
			}


			echo "</div>";
		  echo "</div>";
		}
		else
		{

			$sql_remainanswer = "select no from answer_" . $boardname . " where tg_question_no=" . $no;
			$result_remainanswer = $conn->query($sql_remainanswer);
			if($result_remainanswer->num_rows == 0)
			{
				echo "<div style=\"width:40%;margin-left:100;margin-top:80\"><center>삭제되었거나 존재하지 않는 질문입니다.</center></div>";
				echo "<div style=\"width:40%;margin-left:100;margin-top:20;margin-bottom:400\"><button type=\"button\" onclick=\"history.back();\" class=\"snip1535_list\" style=\"width:100%\">뒤로가기</button></div>";

				echo "</div>";
				echo "</div>";

			}
			else
			{
				echo "<div style=\"width:90%;margin-top:80;margin-bottom:80\"><center>질문이 삭제되었습니다.</center></div>";



				#답변을 출력함
				echo "<div id=\"content_answer\">";

				
				
					echo "<br>총 " . $result_remainanswer->num_rows . "개의 답변이 있었습니다.<br>";
					
					$sql_answer = "select * from answer_" . $boardname . " where tg_question_no=" . $no . " ORDER BY isadopted DESC, date_modified ASC";
					$sql_nopage = $sql_answer;
					$sql_answer .= " LIMIT " . (($page - 1) * $rows_in_once) .  ", " . $rows_in_once;
					
					$result_answer = $conn->query($sql_answer);
					
					if($result_answer)
					{
						if($result_answer->num_rows > 0)
						{
							while($row_answer = $result_answer->fetch_assoc())
							{

								$memsql = "select * from member where no=" . $row_answer['member_no'];
								$result_mem = $conn->query($memsql);
								$member_nickname = "";
								$member_photopath = "";
								$member_here = "";
								$member_here_answered = -1;
								$member_here_adopted = -1;
								$member_answered = -1;
								$member_adopted = -1;
								if($result_mem->num_rows > 0)
								{
									while($row_mem = $result_mem->fetch_assoc())
									{
										$member_nickname = $row_mem['nickname'];
										$member_photopath = $row_mem['photopath'];
										$member_answered = $row_mem['mi_answered'] + $row_mem['hi_answered'] + $row_mem['ui_answered'];
										$member_adopted = $row_mem['mi_adopted'] + $row_mem['hi_adopted'] + $row_mem['ui_adopted'];
										if($boardname == "board_middle_qna" || $row_answer['part'] == "middle")
										{
											$member_here = "중등";
											$member_here_answered = $row_mem['mi_answered'];
											$member_here_adopted = $row_mem['mi_adopted'];
										} else if($boardname == "board_high_qna" || $row_answer['part'] == "high")
										{
											$member_here = "고등";
											$member_here_answered = $row_mem['hi_answered'];
											$member_here_adopted = $row_mem['hi_adopted'];
										} else if($boardname == "board_univ_qna" || $row_answer['part'] == "univ")
										{
											$member_here = "대학";
											$member_here_answered = $row_mem['ui_answered'];
											$member_here_adopted = $row_mem['ui_adopted'];
										} else
										{
											$member_here_answered = -999;
											$member_here_adopted = -999;
										}
									}
								}
								$date_answer = $row_answer["date"];
								echo "<div style=\"width:90%;padding-left:20;margin-top:15;margin-bottom:15;padding-bottom:10;border:1px solid #ff901e\">";
								echo "<table width=90% border=0 bordercolor=white>";
								
								echo "<tr>";
								echo "<td width=3%><a href=\"javascript:Vote_Answer_Up('" . $boardname . "', '" . $row_answer[
							'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▲</font></a></td> <td width=3% rowspan=2><font color=5><b>" . $row_answer["vote"] . "</td> <td width=88% rowspan=2><pdongmin>" .  htmlspecialchars($row_answer["title"]) . "</pdongmin></td>";
								
								echo "<td rowspan=2>";

								if($row_answer['isadopted'] == 3)
								{
									echo "<img src='img/adopted.png' style='width:40;height:40' />";
								}
								else
								{
									echo "<img src='img/empty.png' style='width:40;height:40' />";
								}


								
								echo "</td></tr>";
								
								echo "<tr><td><a href=\"javascript:Vote_Answer_Down('" . $boardname . "', '" . $row_answer[
							'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▼</font></a></td></tr></table>";
								
								if($row_answer['isadopted'] == 3)
								{
									echo "<div style=\"width:80%;height:30;padding-top:10;margin-top:10;margin-bottom:10;margin:auto;background:#ffe6b7\">
									
									<pdongmin><b>&nbsp;&nbsp;질문자 감사인사</b>&nbsp;&nbsp;&nbsp;" . htmlspecialchars($row_answer["thanks_message"]) . "</pdongmin>
									
									</div>";
								}


								#이미지 첨부를 했으면~ 이미지를 표시한다
								if($row_answer['imgpath1'] != "")
								{
									echo "<br>";
									echo "<img src='/boards/boardimage/" . $row_answer['imgpath1'] . "' style='max-width:70%'>";
									echo "<br>";
								}
								
								if($row_answer['imgpath2'] != "")
								{
									echo "<br>";
									echo "<img src='/boards/boardimage/" . $row_answer['imgpath2'] . "' style='max-width:70%'>";
									echo "<br>";
								}

								if($row_answer['imgpath3'] != "")
								{
									echo "<br>";
									echo "<img src='/boards/boardimage/" . $row_answer['imgpath3'] . "' style='max_width:70%'>";
									echo "<br>";
								}


								echo "<div style=\"width:90%;padding-top:30;padding-bottom:30\">
									<td colspan=3><pdongmin>" .  htmlspecialchars($row_answer["content"]) . "</pdongmin></td></div>
									";
								
								
								echo "<table width=90% border=0 bordercolor=white>";
								echo "<tr>";
								//수정 여부에 따른 시각 표시 방법을 결정함
								if($row_answer["date"] != $row_answer["date_modified"])
								{
									echo "	<td width=50%>" . $row_answer["date"] . " (최종수정: " . $row_answer["date_modified"] . ")</td>";
								}
								else
								{
									echo "	<td width=50%>" . $row_answer["date"] . "</td>";
								}
								
								if($member_nickname != "")
								{
									echo "<table align=\"right\" style='width:23%;margin-right:10%;padding-top:10;padding-bottom:10'>";
									echo "<tr> <td colspan=2 style='padding-bottom=1%'>작성일시: " . $row_answer["date"] . "<br><br></td> </tr>";
									if($row_answer["date"] != $row_answer["date_modified"])
									{
										echo "<tr><td colspan=2 style='padding-bottom=1%'>(최종수정: " . $row_answer["date_modified"] . ")<br><br></td></tr>";
									}
									echo "<tr>";
									echo "<td rowspan=3 width='20%'><img src=\"/member/memberimage/" . $member_photopath . "\" width=50 height=50 /></td>";
									echo "<td width='80%' style='margin-left:10'>&nbsp;&nbsp;&nbsp;<a href='/member/mypage.php?memberno=" . $row_answer["member_no"] . "' style='text-decoration:none'><font color=black><b>" .  htmlspecialchars($member_nickname) . "</b></font></a></td></tr>";
									echo "<tr><td style='margin-left:10'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;총 답변: " . $member_answered . "회(채택: " . $member_adopted . ")</td></tr>";
									echo "<tr><td style='margin-left:10'>&nbsp;&nbsp;&nbsp;" . $member_here . " 답변: " . $member_here_answered . "회(채택: " . $member_here_adopted . ")</td></tr></table><br>";
				
								}
								else
								{
									echo "<td width=50% align=\"left\">" . $row["date"] . "</td> <td width=50% align=\"right\"><a href='/member/mypage.php?memberno=" . $row["member_no"] . "' style='text-decoration:none'><font color=black>" .  htmlspecialchars($row["writer"]) . "</font></a></td>";
								}



								//본인의 글에만 수정, 삭제 버튼이 보인다
							
								if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']) && $row_answer['member_no'] == $_SESSION['user_member_no'])
								{
									
									echo "<div style=\"width=90%;padding-top:10;padding-bottom:10\">";
									if($row_answer["isadopted"] == 2 || $row_answer["isadopted"] == 3)
									{ } else{
									echo "<button type='button' class=\"snip1535_list\" onclick=\"location.href='/boards/modify_answer.php?boardname=" . $boardname . "&no=" . $row_answer["no"] . "&fromno=" . $no . "'\">수정</button>&nbsp;&nbsp;";
									}
									echo"<button type='button' class=\"snip1535_list\" onclick=\"location.href='/boards/delete_answer.php?boardname=" . $boardname . "&no=" . $row_answer["no"] . "&fromno=" . $no . "'\">삭제</button>";
										
									echo "</div>";
								}

								if(isset($_SESSION['user_email']) && $_SESSION['user_member_no'] == $q_member_no && $isfinished == 0)
								{
									echo "<button type='button' class=\"snip1535_list\" onclick=\"javascript:go_adopt('" . $boardname . "', " . $row_answer['no'] . ", " . $row_answer['tg_question_no'] . ");\">채택하기</button>";
								}



									#답변에 대한 댓글을 표시함
									echo "<div>";	

									//회원에게만 댓글 작성 란이 보인다
									if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
									{
										echo "<form id=\"comment_a_" . $row_answer["no"] . "\" name=\"comment_a_" . $row_answer["no"] ."\" action=\"/boards/comment_qna_ok.php?boardname=" . $boardname . "&no=" . $row_answer["no"] . "&fromno=" . $no . "&type=2\" method=\"post\">";
										echo "<table border=0 width=90% >";
										echo "<tr>";
										echo "<td width=15%>";
										echo "<b>" . $_SESSION['user_nickname'] . "</b>";
										echo "<input type=\"hidden\" id=\"comma_writer\" name=\"comma_writer\" style=\"width:100%;margin-bottom:20;border:1px solid #ff901e\" value=\"" . $_SESSION['user_nickname'] . "\" onfocus=\"this.value=''\"/> <br>";
										echo "<input type=\"hidden\" id=\"comma_password\" name=\"comma_password\" style=\"width:100%;border:1px solid #ff901e\"/ value=\"MEMBER\" onfocus=\"this.value=''\" /> </td>";
										echo "<td width=50%>";
										echo "<textarea id=\"comma_message\" name=\"comma_message\" style=\"width:100%;height:60;padding-top:10;padding-bottom:10;border:1px solid #ff901e\"></textarea></td>";
										echo "<td width=10%>";
										switch($no_in_page)
										{
											case 0:
												echo "<button type='button' style=\"width:100%;height:60px\" class=\"snip1535_list\" onclick=\"javascript:ChkBeforeComment_A('" . $boardname . "', '" . $row_answer['no'] . "', '" .  $no . "', '" . $page . "', '" . $qpage . "', '" . (intval($commcount['total'] / $arows_in_once[0]) + 1) . "', '" . $apage[1] . "', '" . $apage[2] . "', '0');\">작성 완료</button></td>";
												break;
											case 1:
												echo "<button type='button' style=\"width:100%;height:60px\" class=\"snip1535_list\" onclick=\"javascript:ChkBeforeComment_A('" . $boardname . "', '" . $row_answer['no'] . "', '" .  $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . (intval($commcount['total'] / $arows_in_once[1]) + 1) . "', '" . $apage[2] . "', '1');\">작성 완료</button></td>";
												break;
											case 2:
												echo "<button type='button' style=\"width:100%;height:60px\" class=\"snip1535_list\" onclick=\"javascript:ChkBeforeComment_A('" . $boardname . "', '" . $row_answer['no'] . "', '" .  $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . (intval($commcount['total'] / $arows_in_once[2]) + 1) . "', '2');\">작성 완료</button></td>";
												break;
										}
										echo "</tr></table></form>";
									}

									$sql_comment = "select * from comment_" . $boardname . " where fromno=" . $row_answer["no"] . " and qora=2 and date >='" . $date_answer . "'";
									$result_comment = $conn->query($sql_comment);

									if(!isset($_SESSION['user_email']))
									{
										echo "<br><br><br><br><br><br>";
									}
									echo "<br>이 답변의 댓글 [" . $result_comment->num_rows . "]";
									
									if($result_comment->num_rows > 0)
									{
										while($row_comment = $result_comment->fetch_assoc())
										{

											$memsql = "select nickname from member where no=" . $row_comment['member_no'];
											$result_mem = $conn->query($memsql);
											$member_nickname = "";
											if($result_mem->num_rows > 0)
											{
												while($row_mem = $result_mem->fetch_assoc())
												{
													$member_nickname = $row_mem['nickname'];
												}
											}

											echo "<table width=90% border=0 style=\"border:0pt solid #ff901e\" bgcolor=\"#FFEFD1\">";
											echo "<tr>";
											echo "<td width=2%><center><a href=\"javascript:Vote_Answer_Comment_Up('" . $boardname . "', '" . $row_comment[
							'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▲</font></a></center></td>";
											echo "<td width=2%><center><a href=\"javascript:Vote_Answer_Comment_Down('" . $boardname . "', '" . $row_comment[
							'no'] . "', '" . $no . "');\" style='text-decoration:none'><font color=black>▼</font></a></center></td>";
											echo "<td width=3%><center>";
											echo $row_comment["vote"] . "</center></td>" ;
									
											if($member_nickname != "")
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
											echo $row_comment["date"] . "</td>" ;

											echo "<td width=2%>";
											if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
											{
												if($row_comment['member_no'] == $_SESSION['user_member_no'])
												{
													
													echo "<a href=\"delete_comment_qna.php?boardname=" . $boardname . "&fromno=" . $no . "&no=" . $row_comment["no"] . "&type=2\"><img src=/boards/img/ico_delete.png width=20 height=20 border=0></a>";
												}
												else
												{
													echo "<img src='/boards/img/ico_delete_blank.png' width=20 height=20 border=0>";
												}

											}
											else
											{
												echo "<img src='/boards/img/ico_delete_blank.png' width=20 height=20 border=0>";
											}
											echo "</td></tr></table><br>";
										}


										//답변에 대한 댓글 페이징

										$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
										echo "<table align='center'>";
										echo "<tr><td>";

										
										$sql_chk = $sql_nopage2 . " LIMIT " . ((intval(($apage[$no_in_page] - 1) / 10) - 1) * 10 + 9) * $arows_in_once[$no_in_page] .  ", " . $arows_in_once[$no_in_page];
										
										$result_chk = $conn->query($sql_chk);
										if($result_chk && $result_chk->num_rows != 0)
										{
											switch($no_in_page)
											{
												case 0:
													echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "' , '" .$page . "', '" . $qpage . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) - 1) * 10 + 10) . "', '" . $apage[1] . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>◀</font></a> ";
													break;
												case 1:
													echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "' , '" .$page . "', '" . $qpage . "', '" . $apage[0] . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) - 1) * 10 + 10) . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>◀</font></a> ";
													break;
												case 2:
													echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "' , '" .$page . "', '" . $qpage . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) - 1) * 10 + 10) . "');\" style='text-decoration:none'><font color=black>◀</font></a> ";
													break;
											}
										}
										else
										{ }

										for($i = 0; $i < 10; $i ++)
										{
											//echo "값: " . ($page - 1) % 10 . "<br>";
											if(($apage[$no_in_page] - 1 ) % 10 == $i)
											{
												//echo "this???";
												echo "<b>";
												echo intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1;
												echo "</b>";
											}
											else
											{
												switch($no_in_page)
												{
													case 0:
														
														echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . (intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1) . "', '" . $apage[1] . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>";
														break;
													case 1:
														echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . (intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1) . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>";
														break;
													case 2:
														echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . (intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1) . "');\" style='text-decoration:none'><font color=black>";
														break;
												}
												
												echo intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1;
												echo "</font></a>";
											}

										
											$sql_chk = $sql_nopage2 . " LIMIT " . ((intval(($apage[$no_in_page] - 1) / 10) * 10 + $i + 1) * $arows_in_once[$no_in_page]) .  ", " . $arows_in_once[$no_in_page];
										
											$result_chk = $conn->query($sql_chk);

											if($result_chk->num_rows == 0) break;
										
											if($i == 9) continue;

											echo " | ";
										}
										
										$sql_chk = $sql_nopage2 . " LIMIT " . ((intval(($apage[$no_in_page] - 1) / 10) + 1) * 10 + 1 - 1) * $arows_in_once[$no_in_page] .  ", " . $arows_in_once[$no_in_page];
										$result_chk = $conn->query($sql_chk);
										if($result_chk->num_rows != 0)
										{
											switch($no_in_page)
											{
												case 0:
													echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) + 1) * 10 + 1) . "', '" . $apage[1] . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>";
													break;
												case 1:
													echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) + 1) * 10 + 1) . "', '" . $apage[2] . "');\" style='text-decoration:none'><font color=black>";
													break;
												case 2:
													echo "<a href=\"javascript:pageMover('" . $boardname . "', '" . $no . "', '" . $page . "', '" . $qpage . "', '" . $apage[0] . "', '" . $apage[1] . "', '" . ((intval(($apage[$no_in_page] - 1) / 10) + 1) * 10 + 1) . "');\" style='text-decoration:none'><font color=black>";
													break;
											}
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
								$no_in_page ++;
							}


							 //답변 페이징
							$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
							echo "<table align='center'>";
							echo "<tr><td>";

							
							$sql_chk = $sql_nopage . " LIMIT " . ((intval(($page - 1) / 10) - 1) * 10 + 9) * $rows_in_once .  ", " . $rows_in_once;
							$result_chk = $conn->query($sql_chk);
							if($result_chk && $result_chk->num_rows != 0)
							{
								
								echo "<a href='/boards/view_qna.php?boardname=" . $boardname . "&no=" . $no . "&page=" . ((intval(($page - 1) / 10) - 1) * 10 + 10) . "' style='text-decoration:none'><font color=black>◀</font></a> ";
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
									echo "<a href='/boards/view_qna.php?boardname=" . $boardname . "&no=" . $no . "&page=" . (intval(($page - 1) / 10) * 10 + $i + 1) . "' style='text-decoration:none'><font color=black>";
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
								echo " <a href='/boards/view_qna.php?boardname=" . $boardname . "&no=" . $no . "&page=" . ((intval(($page - 1) / 10) + 1) * 10 + 1) . "' style='text-decoration:none'><font color=black>▶</font></a>";
							}
							else
							{ }

							echo "</td></tr></table>";
						}
						else
						{
							
						}
					}
					else
					{
						echo "쿼리 에러";
					}
					
				}			

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
