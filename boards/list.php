<html>
<head>

<?php


	$boardname = $_GET['boardname'];
	$search_type = $_GET['search_type'];
	$keyword = $_GET['keyword'];
	
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

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script>
	var absolute_entry_no = -1;


	function getXY(no)
	{
		var x = event.pageX;
		var y = event.pageY;
		var m_menu = document.getElementById("member_menu");
		var temp_member_no = document.getElementById("temp_member_no");
		temp_member_no.value = no;

		var querypark = "select * from member where no=" + no;
		alert(querypark);

		  $('.member_menu_email').html(
			  "<?php $sql='" + querypark + "';  $sql_copy = $sql; echo $sql_copy; echo '<br>'; $result = $conn->query($sql_copy); if($result) { echo 'success..'; } else{ echo 'error!!'; } if($result->num_rows > 0) { echo 'success'; while($row = $result->fetch_assoc()) { echo $row['email']; } } else { echo 'error!!!!!!!!!!'; } echo 'wow'; ?>"
		  );

	

		m_menu.style.display = "block";
		m_menu.style.position = "absolute";
		m_menu.style.left = x;
		m_menu.style.top = y;
	

		
	}


</script>

<style type="text/css">
  pdongmin {
     width: 90%;
	 overflow:hidden;
	 text-overflow:ellipsis;
	  }
</style>

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

			location.href = "/boards/list.php?boardname=" + boardname + "&search_type=" + search_type + "&keyword=" + keyword;
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
	
	$abs_member_no = -1;
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

	$keywords = explode(' ', $keyword);

	$sql_title = "SELECT alias FROM board_master where name=\"" . $boardname . "\"";
	$sql = "SELECT * FROM " . $boardname . " ORDER BY no DESC";


	if(isset($_GET['search_type'])) //검색을 들어간 경우의 출력
	{
		switch($search_type)
		{
			case 1:
				$sql = "SELECT * FROM " . $boardname . " WHERE  title like '%" .  $keywords[0]  . "%' OR  content like '%" . $keywords[0] . "%'";
				for($i = 1; $i < count($keywords) ; $i ++)
				{
					$sql .= " UNION SELECT * FROM " . $boardname . " WHERE ( title like '%" .  $keywords[$i] . "%') OR ( content like '%" . $keywords[$i] . "%')";
				}
				$sql .= " order by no desc";
			
				break;
			case 2:
				$sql = "SELECT * FROM " . $boardname . " WHERE ( title like '%" .  $keywords[0]  . "%')";
				for($i = 1; $i < count($keywords) ; $i ++)
				{
					$sql .= " UNION SELECT * FROM " . $boardname . " WHERE ( title like '%" .  $keywords[$i] . "%')";
				}
				$sql .= " order by no desc";
			
				break;
			case 3:
				$sql = "SELECT * FROM " . $boardname . " WHERE ( content like '%" .  $keywords[0]  . "%')";
				for($i = 1; $i < count($keywords) ; $i ++)
				{
					$sql .= " UNION SELECT * FROM " . $boardname . " WHERE ( content like '%" .  $keywords[$i] . "%')";
				}
				$sql .= " order by no desc";
			
				break;
			case 4:
				$sql = "SELECT * FROM " . $boardname . " WHERE ( writer like '%" .  $keywords[0]  . "%')";
				for($i = 1; $i < count($keywords) ; $i ++)
				{
					$sql .= " UNION SELECT * FROM " . $boardname . " WHERE ( writer like '%" .  $keywords[$i] . "%')";
				}
				$sql .= " order by no desc";
			
				break;
			default:

				break;
		}
	}
	$sql_nopage = $sql;
	$sql .=  " LIMIT " . (($page - 1) * $rows_in_once) .  ", " . $rows_in_once;




	$result_title = $conn->query($sql_title);	
	$result = $conn->query($sql);
	
	while($row_title = $result_title->fetch_assoc())
	{
		echo "<font color=#000000><h2>" . $row_title["alias"] . "<h2></font>";
	}


	echo "<input type='hidden' id='temp_member_no' name='temp_member_no' value='' />";
	echo "<table border=0 width=90%>";
	echo "<tr>";
	echo "<td width=5% class=\"underline\" style=\"background-color:#ff901e\"><b><font color=white><center>번호</center></font></b></td> ";
	echo "<td width=40% class=\"underline\" style=\"background-color:#ff901e\"><b><font color=white><center>제목</center></font></b></td> ";
	echo "<td width=10% class=\"underline\" style=\"background-color:#ff901e\"><b><font color=white><center>작성자</center></font></b></td> ";
	echo "<td width=15% class=\"underline\" style=\"background-color:#ff901e\"><b><font color=white><center>작성일</center></font></b></td>";
	echo "<td width=5% class=\"underline\" style=\"background-color:#ff901e\"><b><font color=white><center>조회</center></font></b></td>";
	echo "<td width=5% class=\"underline\" style=\"background-color:#ff901e\"><b><font color=white><center>추천</center></font></b></td>";
	echo "</tr>";

	$n = 0;
	if($result->num_rows > 0)
	{
		
		while($row = $result->fetch_assoc())
		{	
			$commsql = "SELECT * from comment_" . $boardname . " where fromno=" . $row["no"];
			$memsql = "SELECT * from member where no=" . $row["member_no"];
			$commresult = $conn->query($commsql);
			$memresult = $conn->query($memsql);
			

			$commentcount = $commresult->num_rows;
			
			echo "<tr>";
			echo "<td class=\"underline\" style=\"padding-top:5;padding-bottom:5\"><center><b><font color=#7A3D00>";
			echo $row["no"];
			echo "</font></b></center></td>";
			echo "<td class=\"underline\">";
			if($row['imgpath1'] != "" || $row['imgpath2'] != "" || $row['imgpath3'] != "")
			{
				echo "<img src='/boards/img/picture_yes.png' width=20 height=20> &nbsp;";
			}
			else
			{
				echo "<img src='/boards/img/picture_no.png' width=20 height=20> &nbsp;";
			}
			echo "<a href=\"/boards/view.php?boardname=" . $boardname . "&no=" . $row["no"] . "\" style=\"text-decoration:none\"><font color=black><pdongmin>" . htmlspecialchars($row["title"]) . " [" . $commentcount . "]</pdongmin></font></a>";
			echo "</td>";
			echo "<td class=\"underline\"><center>";
			//echo "<div class=\"test_" . $row["no"] . "\" onclick=\"javascript:getXY('" . $row["member_no"] . "');\">";
			//회원의 프로필 사진을 가져오는 부분
			$mem_nickname = "";
			if($memresult)
			{
				if($memresult->num_rows == 1)
				{
					while($memrow = $memresult->fetch_assoc())
					{
						echo "<img src=\"/member/memberimage/" . $memrow["photopath"] . "\" width=20 height=20 /> ";
						$mem_nickname = $memrow["nickname"];
					}
				}
				else
				{
					//비회원
					echo "";
				}
			}
			else
			{
				echo "FATAL: 쿼리 실패";
			}

			if($row["member_no"] == -1)
			{
				echo "<pdongmin>" . htmlspecialchars($row["writer"]) . "</pdongmin>";
			}
			else if($mem_nickname != "")
			{
				echo "<a href='/member/mypage.php?memberno=" . $row["member_no"] . "' style='text-decoration:none'><font color=black><pdongmin>" . htmlspecialchars($mem_nickname) . "</font></a></pdongmin>";
			}
			else
			{
				echo "<a href='/member/mypage.php?memberno=" . $row["member_no"] . "' style='text-decoration:none'><font color=black><pdongmin>" . htmlspecialchars($row["writer"]) . "</font></a></pdongmin>";
			}
			
			//echo "</div>";
			echo "</center></td>";
			echo "<td class=\"underline\"><center>";
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
				echo date("H:i", strtotime($row["date"]));
			}
			else
			{
				$dateonedayoff = date("Y-m-d", strtotime($row["date"]));
				echo $dateonedayoff;
			}
			echo "</center></td>";
			echo "<td class=\"underline\"><center>";
			echo $row["hit"];
			echo "</center></td>";
			echo "<td class=\"underline\"><center>";
			echo $row["vote"];
			echo "</center></td>";
			echo "</tr>";

			
			$n ++;
		
		}


	} else { echo "<tr><td colspan=6>등록된 글이 없습니다.</td></tr>"; }

	echo "</table>";


	$conn->close();


	echo "<div style=\"margin-top:10\"> 
		<button type=\"button\" onclick=\"location.href='/boards/write.php?boardname=" . $boardname . "'\" class=\"snip1535_list\" style=\"width:70\">글 작성</button>";
	
	
	?>


	<div style="float:right;font-size:10pt;margin-right:10%">
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

	<div style='margin-right:10%'>
		<?php
		  $conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
		  echo "<table align='center'>";
			echo "<tr><td>";

			
			$sql_chk = $sql_nopage . " LIMIT " . ((intval(($page - 1) / 10) - 1) * 10 + 9) * $rows_in_once .  ", " . $rows_in_once;
			$result_chk = $conn->query($sql_chk);
			if($result_chk && $result_chk->num_rows != 0)
			{
				if($search_type == 1 || $search_type == 2 || $search_type == 3 || $search_type == 4)
				{
					echo "<a href='/boards/list.php?boardname=" . $boardname . "&search_type=" . $search_type . "&keyword=" . $keyword . "&page=" . ((intval(($page - 1) / 10) - 1) * 10 + 10) . "' style='text-decoration:none'><font color=black>◀</font></a> ";
				}
				else
				{
					echo "<a href='/boards/list.php?boardname=" . $boardname . "&page=" . ((intval(($page - 1) / 10) - 1) * 10 + 10) . "' style='text-decoration:none'><font color=black>◀</font></a> ";
				}
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
					if($search_type == 1 || $search_type == 2 || $search_type == 3 || $search_type == 4)
					{
						echo "<a href='/boards/list.php?boardname=" . $boardname . "&search_type=" . $search_type . "&keyword=" . $keyword . "&page=" . (intval(($page - 1) / 10) * 10 + $i + 1) . "' style='text-decoration:none'><font color=black>";
					}
					else
					{
						echo "<a href='/boards/list.php?boardname=" . $boardname . "&page=" . (intval(($page - 1) / 10) * 10 + $i + 1) . "' style='text-decoration:none'><font color=black>";
					}
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
				if($search_type == 1 || $search_type == 2 || $search_type == 3 || $search_type == 4)
				{
					echo " <a href='/boards/list.php?boardname=" . $boardname . "&search_type=" . $search_type . "&keyword=" . $keyword . "&page=" . (intval(($page - 1) / 10) * 10 + $i + 1) . "' style='text-decoration:none'><font color=black>▶</font></a>";
				}
				else
				{
					echo " <a href='/boards/list.php?boardname=" . $boardname . "&page=" . ((intval(($page - 1) / 10) + 1) * 10 + 1) . "' style='text-decoration:none'><font color=black>▶</font></a>";
				}
			}
			else
			{ }

			echo "</td></tr></table>";
		?>
	</div>



  </div>


  <div id="footer">
	<?php
	include("../frame_bottom.html");
	?>
  </div>
</div>



	</div>
	

</body>
</html>

