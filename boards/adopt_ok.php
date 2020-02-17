 <html>
<head>

	
<title>채택완료 - Math Overflow</title>

 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>

	
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

	<script language="javascript">
		function adopt_ok()
		{
			alert("채택이 완료되었습니다.");
			opener.parent.location.reload();
			window.close();

		}

		function adopt_fail_1()
		{
			alert("이미 채택이 완료된 답변입니다.");
			window.close();

		}

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


		

<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
</head>

<body>



	<?php
		@session_start();
		$q_member_no = -1;
		$a_member_no = -1;

		$boardname = $_GET['boardname'];
		$no = $_GET['no']; //답변 번호
		$fromno = $_GET['fromno']; //질문 번호
		$thankyou = $_POST['thankyou']; //감사인사


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


		//해당 답변이 해당 질문과 정상적인 관계인지 검사
		$sql_qna = "select * from answer_" . $boardname . " where no=" . $no . " and tg_question_no=" . $fromno;
		$result_qna = $conn->query($sql_qna);
		if(!$result_qna)
		{
			echo "1";
			echo "<center><br><br>잘못된 접근입니다.<br><br></center>";
			echo "<center><input type='button' onclick='javascript:close_fail()' class='snip1535_list' value='닫기' /></center>";
		}
		else
		{
			if($result_qna->num_rows == 1)
			{

				//걸려있는 포인트를 구해온다
				$sql_point = "SELECT isfinished, points from " . $boardname . " where no=" . $fromno;
				$result_point = $conn->query($sql_point);
				if(!$result_point) { echo "쿼리 실패(포인트 산출)"; }

				$points = 0;
				$isfinished = 0;
				while($row_point = $result_point->fetch_assoc())
				{
					$points = $row_point['points'];
					$isfinished = $row_point['isfinished'];
				}

				//채택이 완료된 질문인데 또다시 채택을 시도하는 것이 아닌지 검사한다
				if($isfinished == 1)
				{
					echo "<script language='javascript'>adopt_fail_1();</script>";
					return;
				}
	

				while($row_qna = $result_qna->fetch_assoc())
				{
					//채택 대상 답변을 한 회원의 번호를 구해온다
					$a_member_no = $row_qna['member_no'];
					
					//채택되지 못한 답변들에 대해 채택안됨 처리를 한다.
					$sql_noadopted = "update answer_" . $boardname . " set isadopted=2 where tg_question_no=" . $fromno;
					$result_noadopted = $conn->query($sql_noadopted);
					if(!$result_noadopted) { echo "쿼리 실패(미채택)";  return; }		

					//채택된 답변에 대해 채택 처리를 하고 감사 메시지를 남긴다.
					$sql_adopted = "update answer_" . $boardname . " set isadopted=3, thanks_message='" . $thankyou . "' where no=" . $no;
					$result_adopted = $conn->query($sql_adopted);
					if(!$result_adopted) { echo "쿼리 실패(채택)"; return; }

					//채택 대상 답변을 한 회원에게 걸려있는 포인트를 지급한다.
					$sql_givepoint = "update member set points=points + " . ($points+10) . " where no=" . $a_member_no;
					$result_givepoint = $conn->query($sql_givepoint);
					if(!$result_givepoint) { echo "쿼리 실패(포인트 주기)"; return; }

					//질문자의 채택 답변수를 하나 늘린다
					$sql_qadopt = "update member set num_adopt = num_adopt + 1 where no = " . $_SESSION['user_member_no'];
					$conn->query($sql_qadopt);

					//채택자의 채택 답변 개수를 하나 늘린다
					$sql_adoptplus = "";
					if($boardname == "board_middle_qna" || $row_qna['part'] == "middle")
					{
						$sql_adoptplus = "update member set mi_adopted = mi_adopted + 1 where no=" . $a_member_no;
					}
					else if($boardname == "board_high_qna" || $row_qna['part'] == "high")
					{
						$sql_adoptplus = "update member set hi_adopted = hi_adopted + 1 where no=" . $a_member_no;
					}
					else if($boardname == "board_univ_qna" || $row_qna['part'] == "univ")
					{
						$sql_adoptplus = "update member set ui_adopted = ui_adopted + 1 where no=" . $a_member_no;
					}
					$result_adoptplus = $conn->query($sql_adoptplus);
					if(!$result_adoptplus) { echo "에러"; return; }


					//채택을 한 본인에게도 포인트를 지급한다(5점)
					$sql_getpoint = "update member set points=points + 5 where no=" . $_SESSION['user_member_no'];
					$result_getpoint = $conn->query($sql_getpoint);
					if(!$result_getpoint) { echo "에러!"; return; }


					//채택 답변이 나온 질문에 대한 업데이트
					$sql_q_update = "update " . $boardname . " set isfinished=1 where no=" . $fromno;
					$result_q_update = $conn->query($sql_q_update);
					if(!$result_q_update) { echo $sql_q_update; echo "쿼리 실패(질문 마감 처리)"; return; }

					
					
					//메시지 표시
					echo "<script language='javascript'>adopt_ok();</script>";

				}
			}
		}
	?>


  </div>
</div>
</body>
</html>
