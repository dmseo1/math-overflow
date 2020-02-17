<html>
<head>

<?php


	$boardname = $_GET['boardname'];
	$search_type = $_GET['search_type'];
	$keyword = $_GET['keyword'];

	$servername = "localhost";
	$username = "root";
	$password = "sdm9469";
	$dbname = "math_overflow";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if($conn->connect_error) {
		die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
	else { }


	


	#title plotting module
	$sql_title = "SELECT alias FROM board_master where name=\"" . $boardname . "\"";	
	$result_title = $conn->query($sql_title);	
	


	$aliasalias = "";
	while($row_title = $result_title->fetch_assoc())
	{
		$aliasalias = $row_title["alias"];
	}

	echo "<title>" . $aliasalias . " - Math Overflow</title>";
	#title plotting module end


?>

 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

	<script language="javascript">
		
		function goSearch(boardname)
		{
			var search_type = document.getElementById("list_search_type").value;
			var keyword = document.getElementById("list_search_keyword").value;

			location.href = "/boards/list_qna_search.php?boardname=" + boardname + "&search_type=" + search_type + "&keyword=" + keyword;
		}

	</script>


	<style type="text/css">
  		.underline{border-bottom:1px solid #ff8000;}
	</style>
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

	$keywords = explode(' ', $keyword);

	$sql_title = "SELECT alias FROM board_master where name=\"" . $boardname . "\"";
	$result_title = $conn->query($sql_title);	


	
	while($row_title = $result_title->fetch_assoc())
	{
		echo "<h2>" . $row_title["alias"] . "</h2>";
	}


	$sql = "SELECT no, title, writer, date, hit, content, interesting, answers, points, tags FROM " . $boardname . " ORDER BY no DESC";

	switch($search_type)
	{
		case 1:
			
			$sql = "SELECT * FROM " . $boardname . " WHERE  title like '%" .  $keywords[0]  . "%' OR  content like '%" . $keywords[0] . "%'";
			for($i = 1; $i < count($keywords) ; $i ++)
			{
				$sql .= " UNION SELECT * FROM " . $boardname . " WHERE ( title like '%" .  $keywords[$i] . "%') OR ( content like '%" . $keywords[$i] . "%')";
			}

			$sql_answer = "SELECT tg_question_no FROM answer_" . $boardname . " WHERE  title like '%" .  $keywords[0]  . "%' OR  content like '%" . $keywords[0] . "%'";
			for($i = 1; $i < count($keywords) ; $i ++)
			{
				$sql_answer .= " UNION SELECT tg_question_no FROM answer_" . $boardname . " WHERE ( title like '%" .  $keywords[$i] . "%') OR ( content like '%" . $keywords[$i] . "%')";
			}
			$result_answer = $conn->query($sql_answer);
			$arr_answer_fromno = "";
			$num = 0;
			if($result_answer)
			{
				
				while($row_answer = $result_answer->fetch_assoc())
				{
					$arr_answer_fromno[$num] = $row_answer['tg_question_no'];
					$num++;
				}
			}
			else { echo "쿼리에러"; }

			for($i = 0; $i < $num; $i++)
			{
				$sql .= " UNION SELECT * FROM " . $boardname . " WHERE no=" . $arr_answer_fromno[$i];
			}

			$sql .= " order by no desc";
			
			break;
		case 2:
			$sql = "SELECT * FROM " . $boardname . " WHERE ( title like '%" .  $keywords[0]  . "%')";
			for($i = 1; $i < count($keywords) ; $i ++)
			{
				$sql .= " UNION SELECT * FROM " . $boardname . " WHERE ( title like '%" .  $keywords[$i] . "%')";
			}

			$sql_answer = "SELECT tg_question_no FROM answer_" . $boardname . " WHERE  title like '%" .  $keywords[0] . "%'";
			for($i = 1; $i < count($keywords) ; $i ++)
			{
				$sql_answer .= " UNION SELECT tg_question_no FROM answer_" . $boardname . " WHERE ( title like '%" .  $keywords[$i] . "%')";
			}

			$result_answer = $conn->query($sql_answer);
			$arr_answer_fromno = "";
			$num = 0;
			if($result_answer)
			{
				
				while($row_answer = $result_answer->fetch_assoc())
				{
					$arr_answer_fromno[$num] = $row_answer['tg_question_no'];
					$num++;
				}
			}
			else { echo "쿼리에러"; }

			for($i = 0; $i < $num; $i++)
			{
				$sql .= " UNION SELECT * FROM " . $boardname . " WHERE no=" . $arr_answer_fromno[$i];
			}

			$sql .= " order by no desc";

		
			break;
		case 3:
			$sql = "SELECT * FROM " . $boardname . " WHERE ( content like '%" .  $keywords[0]  . "%')";
			for($i = 1; $i < count($keywords) ; $i ++)
			{
				$sql .= " UNION SELECT * FROM " . $boardname . " WHERE ( content like '%" .  $keywords[$i] . "%')";
			}

			$sql_answer = "SELECT tg_question_no FROM answer_" . $boardname . " WHERE  content like '%" .  $keywords[0] . "%'";
			for($i = 1; $i < count($keywords) ; $i ++)
			{
				$sql_answer .= " UNION SELECT tg_question_no FROM answer_" . $boardname . " WHERE ( content like '%" .  $keywords[$i] . "%')";
			}

			$result_answer = $conn->query($sql_answer);
			$arr_answer_fromno = "";
			$num = 0;
			if($result_answer)
			{
				
				while($row_answer = $result_answer->fetch_assoc())
				{
					$arr_answer_fromno[$num] = $row_answer['tg_question_no'];
					$num++;
				}
			}
			else { echo "쿼리에러"; }

			for($i = 0; $i < $num; $i++)
			{
				$sql .= " UNION SELECT * FROM " . $boardname . " WHERE no=" . $arr_answer_fromno[$i];
			}

			$sql .= " order by no desc";
			
			break;
		case 4:
			$sql = "SELECT * FROM " . $boardname . " WHERE ( writer like '%" .  $keywords[0]  . "%')";
			for($i = 1; $i < count($keywords) ; $i ++)
			{
				$sql .= " UNION SELECT * FROM " . $boardname . " WHERE ( writer like '%" .  $keywords[$i] . "%')";
			
			}

			$sql_answer = "SELECT tg_question_no FROM answer_" . $boardname . " WHERE  writer like '%" .  $keywords[0] . "%'";
			for($i = 1; $i < count($keywords) ; $i ++)
			{
				$sql_answer .= " UNION SELECT tg_question_no FROM answer_" . $boardname . " WHERE ( writer like '%" .  $keywords[$i] . "%')";
			}

		$result_answer = $conn->query($sql_answer);
			$arr_answer_fromno = "";
			$num = 0;
			if($result_answer)
			{
				
				while($row_answer = $result_answer->fetch_assoc())
				{
					$arr_answer_fromno[$num] = $row_answer['tg_question_no'];
					$num++;
				}
			}
			else { echo "쿼리에러"; }

			for($i = 0; $i < $num; $i++)
			{
				$sql .= " UNION SELECT * FROM " . $boardname . " WHERE no=" . $arr_answer_fromno[$i];
			}

			$sql .= " order by no desc";
			
			break;
		default:

			break;
	}


	$result = $conn->query($sql);

	if(!$result)
	{
		echo "쿼리 에러";
	}


	$n = 0;
	if($result->num_rows > 0)
	{
		
		while($row = $result->fetch_assoc())
		{	
			$commsql = "SELECT * from comment_" . $boardname . " where fromno=" . $row["no"];
			$commresult = $conn->query($commsql);
			$commentcount = $commresult->num_rows;
			echo "<table border=0 width=100% style=\"border-collapse:collapse;border:0px gray solid;word-break:break-all\">";
			echo "<colgroup><col style=\"10%\"><col style=\"70%\"><col style=\"20%\"></colgroup>";
			echo "<tr>";

			#관심있어요
			echo "<td rowspan=2 width=\"100\"><center>";
			echo "관심<br><font size=5><b>" . $row["interesting"];
			echo "</font></b></center></td>";

			#제목
			echo "<td colspan=2 style=\"overflow:hidden;text-overflow:ellipsis;white-space:nowrap;\">";
			echo "<a href=\"/boards/view_qna.php?boardname=" . $boardname . "&no=" . $row["no"] . "\" style=\"text-decoration:none\"><font color=#1e90ff size=4><b><div style=\"max-width:900px\">" . htmlspecialchars($row["title"]) . "</b></font></a>";
			echo "</div></td>";
			echo "</tr>";

			#내용
			echo "<tr style=\"word-break:break-all\">";
			echo "<td style=\"vertical-align:top;overflow:hidden;text-overflow:ellipsis;white-space:pre-line;word-wrap:break-word;word-break:break-all;table-layout:fixed;\" width=680 rowspan=3><div style=\"height:60px;overflow:hidden;text-overflow:ellipsis\">" . htmlspecialchars($row["content"]);
			echo "</div></td>";

			#특이사항
			echo "<td><center><b>" . $row["points"];
			echo "</b> 포인트</center></td>";
			echo "</tr>";

			#답변
			echo "<td rowspan=2><center>";
			echo "답변<br><font size=5><b>" . $row["answers"];
			echo "</font></b></center></td>";


			

			#일시
			echo "<td><center>";
			$datenow = time();
			$dateword = strtotime($row["date"]);
			$datediff = $datenow - $dateword;
			if($datediff < 60)
			{
				echo floor($datediff) . "초 전";
			}
			else if($datediff < 3600)
			{
				echo floor($datediff / 60) . "분 전";
			}
			else if($datediff / 3600 < 6)
			{
				echo floor($datediff / 3600) . "시간 전";
			}
			else if(date("d", time()) == date("d", strtotime($row["date"])))
			{
				echo date("h:m", strtotime($row["date"]));
			}
			else
			{
				$dateonedayoff = date("Y-m-d", strtotime($row["date"]));
				echo $dateonedayoff;
			}
			echo "</center></td>";
			echo "</tr>";

			#작성자
			echo "<tr>";
			echo "<td rowspan=2><center>" . htmlspecialchars($row["writer"]);
			echo "</center></td>";
			echo "</tr>";

			#조회수
			echo "<tr>";
			echo "<td><center>조회수: " . $row["hit"];
			echo "</center></td>";

			#태그
			echo "<td>" . $row["tags"];
			echo "</td>";
			echo "</tr>";
			echo "</table>";

			echo "<br>";
			echo "<hr align=\"left\" width=85% color=\"#ff901e\" size=\"4px\" />";
			echo "<br>";
			$n ++;
		
		}


	} else { echo "등록된 글이 없습니다."; }

	echo "</table>";
	$conn->close();


	echo "<div style=\"margin-top:10\"> <button type=\"button\" onclick=\"location.href='/boards/write_qna.php?boardname=" . $boardname . "'\" class=\"snip1535_list\" style=\"width:70\">글 작성</button>";

	
		
?>

	<div style="float:right;font-size:10pt;margin-right:15%">
	<select id="list_search_type" name="list_search_type" style="border:1px solid #ff901e;height:30px">
				<option value=1>제목+내용</option>
				<option value=2>제목</option>
				<option value=3>내용</option>
				<option value=4>닉네임</option>
		</select>　
	<?php
	echo "<input type='text' id=\"list_search_keyword\" name=\"list_search_keyword\" style=\"width:150px;height:30px;border:3pt solid #ff901e\" value=\"" . $_GET["keyword"] . "\" />　<button type=\"button\" onclick=\"javascript:goSearch('" . $boardname . "');\" class='snip1535_list'>검색</button></div>";
	?>	



	</div>

  </div>

  <div id="footer">
	<?php
	include("../frame_bottom.html");
	?>
  </div>
</div>
</body>

