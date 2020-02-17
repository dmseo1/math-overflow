 <html>
<head>

	
<title>채택하기 - Math Overflow</title>

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

		function go_adopt(frm)
		{
			if(document.getElementById("thankyou").value.length < 10)
			{
				alert("감사 인사는 10자 이상으로 입력해주세요.");
			} else
			{
				frm.submit();
			}
		}

		function close_fail()
		{
			window.close();
		}

	</script>



		

<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
</head>

<body>



	<?php
		$member_no = -1;
		$boardname = $_GET['boardname'];
		$no = $_GET['no']; //답변 번호
		$fromno = $_GET['fromno']; //질문 번호
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
		$sql_qna = "select no, tg_question_no from answer_" . $boardname . " where no=" . $no . " and tg_question_no=" . $fromno;
		$result_qna = $conn->query($sql_qna);
		if(!$result_qna)
		{

			echo "<center><br><br>잘못된 접근입니다(1).<br><br></center>";
			echo "<center><input type='button' onclick='javascript:close_fail()' class='snip1535_list' value='닫기' /></center>";
		}
		else
		{
			if($result_qna->num_rows == 1)
			{
				//마감된 질문인지 검사
				$sql_finished = "select isfinished from " . $boardname . " where no=" . $fromno;
				$result_finished = $conn->query($sql_finished);
				if(!$result_finished) { echo "쿼리 에러(마감 질문)"; return; }
				$isfinished = 0;
				while($row_finished = $result_finished->fetch_assoc())
				{
					$isfinished = $row_finished['isfinished'];
				}

				if($isfinished == 1)
				{
					echo "<center><br><br>이미 채택되어 마감된 질문입니다.<br><br></center>";
					echo "<center><input type='button' onclick='javascript:close_fail()' class='snip1535_list' value='닫기' /></center>";
					return;
				}

				echo "<form name='adopt' id='adopt' method='post' action='/boards/adopt_ok.php?boardname=" . $boardname . "&no=" . $no . "&fromno=" . $fromno . "'>";
				echo "<br><center>답변자에게 감사 인사를 남겨보세요!<center><br>";
				echo "<textarea name=thankyou id=thankyou style='width:90%;height:100;border:0.5pt solid #ff901e'></textarea><br>";
				echo "<center><button type='button' class='snip1535_list' onclick='javascript:go_adopt(this.form)'>채택하기</button>";
				echo "&nbsp;&nbsp;&nbsp;<input type='button' onclick='javascript:close_fail()' class='snip1535_list' value='취소하기' /></center>";
				echo "</form>";
			}
			else
			{
		
				echo "<br><br>잘못된 접근입니다(2).<br><br>";
				echo "<input type='button' onclick='javascript:close_fail()' class='snip1535_list' value='닫기' />";
			}
		}
	?>


  </div>
</div>
</body>
