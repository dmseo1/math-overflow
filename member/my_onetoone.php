<!-- ----------------------------------------------------- mypage.php ------------------------------------------------- -->

<?php
	@session_start();
	
?>

<!DOCTYPE html>
<html lang="en">

<head>

<style>


.user_profile
{
	min-height:50%;
	height:50%;

}

.user_activity
{
	min-height:50%;
	height:50%;

}

</style>

<script>

	window.onload = function(){
 
		
        var x = document.getElementById("footprint_type").selectedIndex;
        var y = document.getElementById("footprint_type").options;
        var z = document.getElementById("footprint_type").value;

		var a = document.getElementById("activity_type").selectedIndex;
        var b = document.getElementById("activity_type").options;
        var c = document.getElementById("activity_type").value;

		$(document).scrollTop(document.getElementById("scrollstat").value);
 





		
 


        //순서대로 값을 띄워줍니다.
        //alert("Index: " + y[x].index + " is " + y[x].text+" is " + z);
 
    }

</script>

<script language="javascript">
	
	function pageMover(qpage, apage)
	{
		var v_scrollstat = Math.ceil($(document).scrollTop());
		location.href="/member/my_onetoone.php?&type=" + document.getElementById("TabNum").value + "&qpage=" + qpage + "&apage=" + apage + "&scrollstat=" + v_scrollstat;
	}

	function TabChange(num)
	{
		document.getElementById("TabNum").value = num;
	}

	function modify_member_info(frm)
	{
		  var url    ="/member/modify_member_info.php";
		  var title  = "회원 정보 수정 - Math Overflow";
	
		  frm.target = "_self";                    //form.target 이 부분이 빠지면 form값 전송이 되지 않습니다. 
		  frm.action = url;                    //form.action 이 부분이 빠지면 action값을 찾지 못해서 제대로 된 팝업이 뜨질 않습니다.
		  frm.method = "post";
		  frm.submit();
	}

	


	function activity_footprint_change(memberno)
	{
		var v_activity_type = document.getElementById("activity_type").value;
		var v_footprint_type = document.getElementById("footprint_type").value;
		var v_scrollstat = Math.ceil($(document).scrollTop());
		var v_fpt = document.getElementById("TabNum").value;
		
		location.href="/member/mypage.php?memberno=" + memberno + "&fpt=" + v_fpt + "&activity_type=" + v_activity_type + "&footprint_type=" + v_footprint_type + "&scrollstat=" + v_scrollstat;
	}

	

</script>
<script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
   </script>
   <script> w3.includeHTML(); </script> <!-- 수식 -->


<link rel="stylesheet" type="text/css" href="/framestyle.css" />
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

<meta charset="UTF-8 | euc-kr">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="">

<title>1:1 질문답변 현황</title>


   <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/half-slider.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body style="">

    <!-- Navigation -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background:#ff901e;border:1pt solid #ff901e" >
        <div class="container"  style="background:#ff901e">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header" style="background:#ff901e">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar" style="background:#ff901e"></span>
                    <span class="icon-bar" style="background:#ff901e"></span>
                    <span class="icon-bar" style="background:#ff901e"></span>
                </button>
                <a class="navbar-brand" href="/index.html"><font color=white>MathOverflow</font></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right" >
				<!--
                    <li>
                        <a href="../about.html"><font color=white>About</font></a>
                    </li>
					-->

				<?php
					@session_start();
                    echo "<li>";
					if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
					{
						echo "<a href=\"/member/logout.php\"><font color=white>로그아웃</font></a>";
					}
					else
					{
						 echo "<a href=\"/member/login.html\"><font color=white>로그인</font></a>";
					}
                    echo "</li>";

					
                    echo "<li>";
					if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
					{
						echo "<a href=\"/member/mypage.php\"><font color=white>마이페이지</font></a>";
					}
					else
					{
						echo "<a href=\"/member/join.html\"><font color=white>회원가입</font></a>";
					}
                    echo "</li>";
				?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background:#ff901e"><font color=white>중등 포럼<b class="caret"></font></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/boards/list_qna.php?boardname=board_middle_qna">질문답변 게시판</a>
                            </li>
							<!--
                            <li>
                                <a href="portfolio-2-col.html">나만의 Tip 게시판</font></a>
                            </li>
                            <li>
                                <a href="portfolio-3-col.html">중등 Tip Best</a>
                            </li>
							 <li>
                                <a href="portfolio-3-col.html">토론게시판</a>
                            </li>
							-->
                            <li>
                                <a href="/boards/list.php?boardname=board_middle_freeboard">자유게시판</a>
                            </li>
                  
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background:#ff901e"><font color=white>고등 포럼<b class="caret"></font></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/boards/list_qna.php?boardname=board_high_qna">질문답변 게시판</a>
                            </li>
							<!--
                            <li>
                                <a href="portfolio-2-col.html">나만의 Tip 게시판</a>
                            </li>
                            <li>
                                <a href="portfolio-3-col.html">고등 Tip Best</a>
                            </li>
							<li>
                                <a href="portfolio-3-col.html">토론게시판</a>
                            </li>
							-->
                            <li>
                                <a href="/boards/list.php?boardname=board_high_freeboard">자유게시판</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background:#ff901e"><font color=white>대학 포럼<b class="caret"></font></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/boards/list_qna.php?boardname=board_univ_qna">질문답변 게시판</a>
                            </li>
						
                            <li>
                                <a href="/boards/list.php?boardname=board_univ_freeboard">자유게시판</a>
                            </li>
							<!--
								 <li>
                                <a href="portfolio-3-col.html">토론게시판</a>
                            </li>
                            <li>
                                <a href="#">미적분학</a>
                            </li>
							<li>
                                <a href="#">선형대수학</a>
                            </li>
							<li>
                                <a href="#">해석학</a>
                            </li>
							<li>
                                <a href="#">미분방정식</a>
                            </li>
							<li>
                                <a href="#">현대대수학</a>
                            </li>
							<li>
                                <a href="#">위상수학</a>
                            </li>
							<li>
                                <a href="#">이산수학</a>
                            </li>
							<li>
                                <a href="#">기하학</a>
                            </li>
							<li>
                                <a href="#">확률론/수리통계학</a>
                            </li>
							<li>
                                <a href="#">미분기하학</a>
                            </li>
							<li>
                                <a href="#">응용수학(금융, 경제, 보험)</a>
                            </li>
							<li>
                                <a href="#">응용수학(IT, 암호)</a>
                            </li>
							-->
                           
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

   	<br><br><br><br>

	<?php
		//그거
		echo "<input type='hidden' name='get_scrollstat' id='get_scrollstat' value='" . $_GET['scrollstat'] . "' />";
		echo "<input type='hidden' name='TabNum' id='TabNum' value='" . $_GET['type'] . "' />";
		$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");

		//기본 접근 제어
		if(!isset($_SESSION['user_member_no']))
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";
			return;
		}

		/*
		//다른 회원의 1:1 질문답변 현황은 볼 수 없음
		if($_SESSION['user_member_no'] != $_GET['memberno'])
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>다른 회원의 1:1 질문답변 현황은 볼 수 없습니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";

			return;
		}
		*/
		
		//기본 변수
		$member_no = $_SESSION['user_member_no'];
		$type = $_GET['type'];

		//페이징 변수
		$qpage = 0;
		$qrows_in_once = 10;
		$qpages_in_once = 10;
		if(!isset($_GET['qpage'])) //페이지값은 get으로 받는다
		{
			$qpage = 1;
		} else
		{
			$qpage = $_GET['qpage'];
		}


		$apage = 0;
		$arows_in_once = 10;
		$apages_in_once = 10;
		if(!isset($_GET['apage'])) //페이지값은 get으로 받는다
		{
			$apage = 1;
		} else
		{
			$apage = $_GET['apage'];
		}

	?>
	
	<h3><b>&nbsp;&nbsp;1:1 질문답변 현황</b></h3>
	<br>


	<?php
		echo "<ul id='myTab' class='nav nav-tabs nav-justified'>";
		switch($_GET['type'])
		{
			case 1:
				echo "<li class='active' onclick='javascript:TabChange(1)'><a href='#service-one' data-toggle='tab'><i class='fa fa-tree'></i>1:1 보낸 질문</a></li>";
				echo "<li class='' onclick='javascript:TabChange(2)'><a href='#service-two' data-toggle='tab'><i class='fa fa-car'></i>1:1 받은 질문</a></li>";
				break;
			case 2:
				echo "<li class='' onclick='javascript:TabChange(1)'><a href='#service-one' data-toggle='tab'><i class='fa fa-tree'></i>1:1 보낸 질문</a></li>";
				echo "<li class='active' onclick='javascript:TabChange(2)'><a href='#service-two' data-toggle='tab'><i class='fa fa-car'></i>1:1 받은 질문</a></li>";
				break;
			default:
				echo "<li class='active' onclick='javascript:TabChange(1)'><a href='#service-one' data-toggle='tab'><i class='fa fa-tree'></i>1:1 보낸 질문</a></li>";
				echo "<li class='' onclick='javascript:TabChange(2)'><a href='#service-two' data-toggle='tab'><i class='fa fa-car'></i>1:1 받은 질문</a></li>";
		}
		echo "</ul>";

	?>



	<div id="myTabContent" class="tab-content">



	<!------------------------------------------------------------------------ 1:1 보낸 질문 ------------------------------------------------------------------------>
	<?php
	if(!isset($_GET['type']) || $_GET['type'] == 1 || (!($_GET['type'] == 2)))
	{
		echo "<div class='tab-pane fade active in' id='service-one'>";
	}
	else
	{
		echo "<div class='tab-pane fade' id='service-one'>";
	}
	?>
	
	<br>
	  <?php

		$sql = "SELECT * FROM board_onetoone_qna where from_member=" . $member_no . " ORDER BY date DESC";



		$sql_nopage = $sql;
		$sql .= " LIMIT " . (($qpage - 1) * $qrows_in_once) .  ", " . $qrows_in_once;
		
		$result = $conn->query($sql);
		if(!$result) { echo "쿼리 에러 ㅜㅜ"; }

		#열 이름 표시
		echo "<table style='width:100%'>";
		echo "<tr>";
		echo "<td style='width:45%'><center><b>제목</b></center></td>";
		echo "<td style='width:15%'><center><b>답변자</b></center></td>";
		echo "<td style='width:10%'><center><b>포인트</b></center></td>";
		echo "<td style='width:15%'><center><b>답변상태</b></center></td>";
		echo "<td style='width:15%'><center><b>질문작성일시</b></center></td>";
		echo "</tr></table>";
		echo "<br>";

		
		
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{	
				$boardname = "board_onetoone_qna";
				$nickname_tomember = "";
				$sql_tomember = "select nickname from member where no=" . $row['to_member']; 
				$result_tomember = $conn->query($sql_tomember);
				while($row_tomember = $result_tomember->fetch_assoc())
				{
					$nickname_tomember = $row_tomember['nickname'];
				}
				$titlehead = "";
				if($row['part'] == "middle")
				{
					$titlehead = "[중등] ";
				}
				else if($row['part'] == "high")
				{
					$titlehead = "[고등] ";
				}
				else if($row['part'] == "univ")
				{
					$titlehead = "[대학] ";
				}
		
				echo "<a href=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $row['no'] . " style=\"text-decoration:none\"><font color=black>";
				echo "<table height=50 style=\"border-collapse:separate;width:100%;height:50;border-radius:18px\"><tr><td style=\"margin-bottom:10pt;background:#ffdebc;width:45%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\">　" . $titlehead . htmlspecialchars($row['title']). "</td>";
				echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center>" . $nickname_tomember . "</center></td>";

					
				echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:10%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><b>" . $row['points'] . " 포인트</b></center></td>";
				echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\">";
				if($row['isfinished'] == 1)
				{
					echo "<center><b><font color=blue>채택함</font></b></center>";
				}
				else if($row['answers'] == 0)
				{
					echo "<center><b><font color=gray>미답변</font></b></center>";
				}
				else
				{
					echo "<center><b><font color=red>답변 완료</font></b></center>";
				}

				echo "</td>";
				echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px\">";
				echo "<center>";
				
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

				echo "</center></td></tr></table><br>";
				echo "</font></a>";
			}

			//질문 내역 페이징
			$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
			echo "<table align='center'>";
			echo "<tr><td>";

			
			$sql_chk = $sql_nopage . " LIMIT " . ((intval(($qpage - 1) / 10) - 1) * 10 + 9) * $qrows_in_once .  ", " . $qrows_in_once;
			
			$result_chk = $conn->query($sql_chk);
			if($result_chk && $result_chk->num_rows != 0)
			{
				echo "<a href=\"javascript:pageMover('" . ((intval(($qpage - 1) / 10) - 1) * 10 + 10) . "', '$apage');\" style='text-decoration:none'><font color=black>◀</font></a>";
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
					echo "<a href=\"javascript:pageMover('" . (intval(($qpage - 1) / 10) * 10 + $i + 1) . "', '$apage');\" style='text-decoration:none'><font color=black>";
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
				echo "<a href=\"javascript:pageMover('" . ((intval(($qpage - 1) / 10) + 1) * 10 + 1) . "', '$apage');\" style='text-decoration:none'><font color=black>▶</font></a>";
			}
			else
			{ }

			echo "</td></tr></table>";


		} else { echo "등록된 글이 없습니다."; }
		
	
		echo "</div>";
	  
   ?>
 
<!------------------------------------------------------------------------ 1:1 받은 질문 ------------------------------------------------------------------------>
	<?php
	if($_GET['type'] == 2)
	{
		echo "<div class='tab-pane fade active in' id='service-two'>";
	}
	else
	{
		echo "<div class='tab-pane fade' id='service-two'>";
	}
	?>
	<br>
	  <?php


		$sql = "SELECT * FROM answer_board_onetoone_qna where member_no=" . $member_no . " ORDER BY date DESC";
		$sql_q = "SELECT * FROM board_onetoone_qna where to_member=" . $member_no . " and answers=0 ORDER BY date DESC";
		$result2 = $conn->query($sql);
		$a_arr = "";
		$i = 0;
		while($row_a = $result2->fetch_assoc())
		{
			$a_arr[$i] = $row_a['fromno'];
			$i++;
		}

		$result_q = $conn->query($sql_q);
		$result_q2 = $conn->query($sql_q);

		$q_arr = "";
		$i = 0;
	
		while($row_q = $result_q->fetch_assoc())
		{
			$q_arr[$i] = $row_q['no'];
			//echo "(" . $i . ", " . $q_arr[$i] . ")";
			$i++;
		}



		$sql_nopage = $sql;
		$sql .= " LIMIT " . (($qpage - 1) * $arows_in_once) .  ", " . $arows_in_once;
		
		$result = $conn->query($sql);
		if(!$result) { echo "쿼리 에러 ㅜㅜ"; }

		#열 이름 표시
		echo "<table style='width:100%'>";
		echo "<tr>";
		echo "<td style='width:45%'><center><b>제목</b></center></td>";
		echo "<td style='width:15%'><center><b>질문자</b></center></td>";
		echo "<td style='width:10%'><center><b>포인트</b></center></td>";
		echo "<td style='width:15%'><center><b>답변상태</b></center></td>";
		echo "<td style='width:15%'><center><b>답변작성일시</b></center></td>";
		echo "</tr></table>";
		echo "<br>";
		
		if($result->num_rows == 0) //이렇다면, 질문만을 표시하면 됩니다.
		{
			if($result_q2->num_rows > 0)
			{
				while($row_q2 = $result_q2->fetch_assoc())
				{
					$boardname = "board_onetoone_qna";
					$nickname_tomember = "";
					$sql_tomember = "select nickname from member where no=" . $row_q2['from_member']; 
					$result_tomember = $conn->query($sql_tomember);
					while($row_tomember = $result_tomember->fetch_assoc())
					{
						$nickname_tomember = $row_tomember['nickname'];
					}

					$titlehead = "";
					if($row_q2['part'] == "middle")
					{
						$titlehead = "[중등] ";
					}
					else if($row_q2['part'] == "high")
					{
						$titlehead = "[고등] ";
					}
					else if($row_q2['part'] == "univ")
					{
						$titlehead = "[대학] ";
					}

					echo "<a href=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $row_q2['no'] . " style=\"text-decoration:none\"><font color=black>";
					echo "<table height=50 style=\"border-collapse:separate;width:100%;height:50;border-radius:18px\"><tr><td style=\"margin-bottom:10pt;background:#ffdebc;width:45%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\">　" . $titlehead . htmlspecialchars($row_q2['title']). "</td>";
					echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center>" . $nickname_tomember . "</center></td>";
					echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:10%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><b>" . $row_q2['points'] . " 포인트</b></center></td>";
					echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><b><font color=gray>미답변</font></b></center></td>";
					echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px\">";
					echo "<center>-</center></td></tr></table><br>";
					echo "</font></a>";
				}
			}
		}
		else if($result->num_rows > 0)
		{
			$index = 0;
			while($row = $result->fetch_assoc())
			{	
				$sql_isq = "select * from board_onetoone_qna where no=" . $row['tg_question_no'];
				$result_isq = $conn->query($sql_isq);

				
				if($result_isq->num_rows == 1) //해당 fromno에 해당하는 질문이 삭제되지 않고 존재한다면
				{
					while($row_isq = $result_isq->fetch_assoc())
					{
						$no_preserve = true;
						while($no_preserve)
						{
							if($q_arr[$index] > $row_isq['no'])
							{
								$sql_isq2 = "select * from board_onetoone_qna where no=" . $q_arr[$index];
								$result_isq2 = $conn->query($sql_isq2);
								while($row_isq2 = $result_isq2->fetch_assoc())
								{
									$boardname = "board_onetoone_qna";
									$nickname_tomember = "";
									$sql_tomember = "select nickname from member where no=" . $row_isq2['from_member']; 
									$result_tomember = $conn->query($sql_tomember);
									while($row_tomember = $result_tomember->fetch_assoc())
									{
										$nickname_tomember = $row_tomember['nickname'];
									}

									$titlehead = "";
									if($row_isq2['part'] == "middle")
									{
										$titlehead = "[중등] ";
									}
									else if($row_isq2['part'] == "high")
									{
										$titlehead = "[고등] ";
									}
									else if($row_isq2['part'] == "univ")
									{
										$titlehead = "[대학] ";
									}

									echo "<a href=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $row_isq2['no'] . " style=\"text-decoration:none\"><font color=black>";
									echo "<table height=50 style=\"border-collapse:separate;width:100%;height:50;border-radius:18px\"><tr><td style=\"margin-bottom:10pt;background:#ffdebc;width:45%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\">　" . $titlehead  .htmlspecialchars($row_isq2['title']). "</td>";
									echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center>" . $nickname_tomember . "</center></td>";
									echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:10%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><b>" . $row_isq2['points'] . " 포인트</b></center></td>";
									echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><font color=gray><b>미답변</b></font></center></td>";
									echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px\">";
									echo "<center>-</center></td></tr></table><br>";
									echo "</font></a>";   
								}

								$index ++;
								continue;
							}
							
							$boardname = "board_onetoone_qna";
							$nickname_tomember = "";
							$sql_tomember = "select nickname from member where no=" . $row_isq['from_member']; 
							$result_tomember = $conn->query($sql_tomember);
							while($row_tomember = $result_tomember->fetch_assoc())
							{
								$nickname_tomember = $row_tomember['nickname'];
							}

							$titlehead = "";
							if($row_isq['part'] == "middle")
							{
								$titlehead = "[중등] ";
							}
							else if($row_isq['part'] == "high")
							{
								$titlehead = "[고등] ";
							}
							else if($row_isq['part'] == "univ")
							{
								$titlehead = "[대학] ";
							}

							echo "<a href=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $row_isq['no'] . " style=\"text-decoration:none\"><font color=black>";
							echo "<table height=50 style=\"border-collapse:separate;width:100%;height:50;border-radius:18px\"><tr><td style=\"margin-bottom:10pt;background:#ffdebc;width:45%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\">　" . $titlehead . htmlspecialchars($row_isq['title']). "</td>";
							echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center>" . $nickname_tomember . "</center></td>";
							echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:10%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><b>" . $row_isq['points'] . " 포인트</b></center></td>";
							echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center>";
							if($row['isadopted'] == 3)
							{
								echo "<b><font color=blue>채택됨</font></b>";
							}
							else if($row_isq['answers'] == 0)
							{
								echo "<b><font color=gray>미답변</font></b>";
							}
							else
							{
								echo "<b><font color=red>답변완료</font></b>";
							}
							echo "</center></td>";
							echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px\">";
							echo "<center>";
							
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

							echo "</center></td></tr></table><br>";
							echo "</font></a>";

							$no_preserve = false;
						}
					}

				}
				else //답변만 존재한다면
				{

					$titlehead = "";
					if($row['part'] == "middle")
					{
						$titlehead = "[중등] ";
					}
					else if($row['part'] == "high")
					{
						$titlehead = "[고등] ";
					}
					else if($row['part'] == "univ")
					{
						$titlehead = "[대학] ";
					}

					echo "<a href=/boards/view_qna.php?boardname=board_onetoone_qna&no=" . $row['tg_question_no'] . " style=\"text-decoration:none\"><font color=black>";
							echo "<table height=50 style=\"border-collapse:separate;width:100%;height:50;border-radius:18px\"><tr><td style=\"margin-bottom:10pt;background:#ffdebc;width:85%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><font color=gray><b>&nbsp;&nbsp;[삭제된 질문에 대한 답변]</b></font> " . $titlehead  .  htmlspecialchars($row['title']). "</td>";
							
							echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px\">";
							echo "<center>";
							
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

							
							echo "</center></td></tr></table><br>";
							echo "</font></a>";
				}
			}

			//남은 답 안달린 질문 다 내보내기
			
			for($i = $index; $i < count($q_arr); $i++)
			{
				if($q_arr[$i] == "") break;

				$sql_isq2 = "select * from board_onetoone_qna where no=" . $q_arr[$i];
				//echo $sql_isq2;
				$result_isq2 = $conn->query($sql_isq2);
				while($row_isq2 = $result_isq2->fetch_assoc())
				{

					$titlehead = "";
					if($row_isq2['part'] == "middle")
					{
						$titlehead = "[중등] ";
					}
					else if($row_isq2['part'] == "high")
					{
						$titlehead = "[고등] ";
					}
					else if($row_isq2['part'] == "univ")
					{
						$titlehead = "[대학] ";
					}

					$boardname = "board_onetoone_qna";
					$nickname_tomember = "";
					$sql_tomember = "select nickname from member where no=" . $row_isq2['from_member']; 
					$result_tomember = $conn->query($sql_tomember);
					while($row_tomember = $result_tomember->fetch_assoc())
					{
						$nickname_tomember = $row_tomember['nickname'];
					}

					echo "<a href=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $row_isq2['no'] . " style=\"text-decoration:none\"><font color=black>";
					echo "<table height=50 style=\"border-collapse:separate;width:100%;height:50;border-radius:18px\"><tr><td style=\"margin-bottom:10pt;background:#ffdebc;width:45%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\">　" . $titlehead . htmlspecialchars($row_isq2['title']). "</td>";
					echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center>" . $nickname_tomember . "</center></td>";
					echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:10%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><b>" . $row_isq2['points'] . " 포인트</b></center></td>";
					echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><b><font color=gray>미답변</font></b></center></td>";
					echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:15%;height:50;border:1pt solid #ffdebc;border-radius:18px\">";
					echo "<center>-</center></td></tr></table><br>";
					echo "</font></a>";   
				}
			}

			//받은 내역 페이징
			$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
			echo "<table align='center'>";
			echo "<tr><td>";

			
			$sql_chk = $sql_nopage . " LIMIT " . ((intval(($apage - 1) / 10) - 1) * 10 + 9) * $arows_in_once .  ", " . $arows_in_once;
			
			$result_chk = $conn->query($sql_chk);
			if($result_chk && $result_chk->num_rows != 0)
			{
				echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'qpage', '" . ((intval(($qpage - 1) / 10) - 1) * 10 + 10) . "');\" style='text-decoration:none'><font color=black>◀</font></a>";
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
					echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'qpage', '" . (intval(($qpage - 1) / 10) * 10 + $i + 1) . "');\" style='text-decoration:none'><font color=black>";
					echo intval(($qpage - 1) / 10) * 10 + $i + 1;
					echo "</font></a>";
				}

			
				$sql_chk = $sql_nopage . " LIMIT " . ((intval(($apage - 1) / 10) * 10 + $i + 1) * $arows_in_once) .  ", " . $arows_in_once;
			
				$result_chk = $conn->query($sql_chk);

				if($result_chk->num_rows == 0) break;
			
				if($i == 9) continue;

				echo " | ";
			}

			$sql_chk = $sql_nopage . " LIMIT " . ((intval(($apage - 1) / 10) + 1) * 10 + 1 - 1) * $arows_in_once .  ", " . $arows_in_once;
			$result_chk = $conn->query($sql_chk);
			if($result_chk->num_rows != 0)
			{
				echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'qpage', '" . ((intval(($qpage - 1) / 10) + 1) * 10 + 1) . "');\" style='text-decoration:none'><font color=black>▶</font></a>";
			}
			else
			{ }

			echo "</td></tr></table>";


		} else { echo "등록된 글이 없습니다."; }
		
	

   ?>
 </div>

 </div>
 

	   <!-- Page Content -->



	 </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
