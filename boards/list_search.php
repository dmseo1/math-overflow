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

			location.href = "/boards/list_search.php?boardname=" + boardname + "&search_type=" + search_type + "&keyword=" + keyword;
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
	$sql = "SELECT * FROM " . $boardname . " order by no desc";
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


	$result_title = $conn->query($sql_title);	
	$result = $conn->query($sql);
	
	
	while($row_title = $result_title->fetch_assoc())
	{
		echo "<font color=#000000><h2>" . $row_title["alias"] . "<h2></font>";
	}



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
			echo ($result->num_rows) - $n;
			echo "</font></b></center></td>";
			echo "<td class=\"underline\">";
			echo "<a href=\"/boards/view.php?boardname=" . $boardname . "&no=" . $row["no"] . "\" style=\"text-decoration:none\"><font color=black><pdongmin>" . htmlspecialchars($row["title"]) . " [" . $commentcount . "]</pdongmin></font></a>";
			echo "</td>";
			echo "<td class=\"underline\"><center>";

			//회원의 프로필 사진을 가져오는 부분
			if($memresult)
			{
				if($memresult->num_rows == 1)
				{
					while($memrow = $memresult->fetch_assoc())
					{
						echo "<img src=\"/member/memberimage/" . $memrow["photopath"] . "\" width=20 height=20 /> ";
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
			echo "<pdongmin>" . htmlspecialchars($row["writer"]) . "</pdongmin>";
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
				echo date("h:i", strtotime($row["date"]));
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

  </div>

  <div id="footer">
	<?php
	include("../frame_bottom.html");
	?>
  </div>
</div>
</body>

