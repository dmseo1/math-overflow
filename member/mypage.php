<!-- ----------------------------------------------------- mypage.php ------------------------------------------------- -->

<?php

	@session_start();
	

	//마이페이지에서 사용할 기본 변수 세팅을 시작한다

	//GET으로 받은 변수 처리
	$activity_type = "";
	if(isset($_GET['activity_type']) && ($_GET['activity_type'] == "all" || $_GET['activity_type'] == "middle" || $_GET['activity_type'] == "high" || $_GET['activity_type'] == "univ"))
	{
		$activity_type = $_GET['activity_type'];
	}
	else
	{
		$activity_type = "all";
	}

	$footprint_type = "";
	if(isset($_GET['footprint_type']) && ($_GET['footprint_type'] == "all" || $_GET['footprint_type'] == "middle" || $_GET['footprint_type'] == "high" || $_GET['footprint_type'] == "univ" ))
	{
		$footprint_type = $_GET['footprint_type'];
	}
	else
	{
		$footprint_type = "all";
	}


	$member_no = -1;
	$profile_img = "";
	$email = "";
	$nickname ="";
	$major_activity = "";
	$interesting_part = "";
	$introduction = "";
	
	$mi_answered = 0;
	$hi_answered = 0;
	$ui_answered = 0;
	$sum_answered = 0;

	$mi_adopted = 0;
	$hi_adopted = 0;
	$ui_adopted = 0;
	$sum_adopted = 0;

	//공개 설정 변수
	$range_array = "";
	$range_profile = -1;
	$range_activity = -1;
	$range_question = -1;
	$range_answer = -1;
	$range_community = -1;
	$range_comment = -1;

	//페이징 변수
	$qpage = 0;
	$apage = 0;
	$cpage = 0;
	$dpage = 0;

	$qrows_in_once = 10;
	$qpages_in_once = 10;

	$arows_in_once = 10;
	$apages_in_once = 10;

	$crows_in_once = 10;
	$cpages_in_once = 10;

	$drows_in_once = 20;
	$dpages_in_once = 10;

	if(!isset($_GET['qpage'])) //페이지값은 get으로 받는다
	{
		$qpage = 1;
	} else
	{
		$qpage = $_GET['qpage'];
	}

	if(!isset($_GET['apage'])) //페이지값은 get으로 받는다
	{
		$apage = 1;
	} else
	{
		$apage = $_GET['apage'];
	}

	if(!isset($_GET['cpage'])) //페이지값은 get으로 받는다
	{
		$cpage = 1;
	} else
	{
		$cpage = $_GET['cpage'];
	}

	if(!isset($_GET['dpage'])) //페이지값은 get으로 받는다
	{
		$dpage = 1;
	} else
	{
		$dpage = $_GET['dpage'];
	}


	$points = 0;

	if($interesting_part == "")
	{
		$interesting_part == "-";
	}
	
	

	if(!isset($_GET['memberno'])) //멤버 번호가 주소창을 통해 넘어오지 않았다면
	{
		if(!isset($_SESSION['user_email'])) //로그인한 멤버의 마이페이지로 이동해야 하는데 로그인 상태가 아니라면
		{
			echo "<meta http-equiv='refresh' content='0; url=/error.php'>"; //에러이다
		}
		else //로그인한 상태라면
		{
			$member_no = $_SESSION['user_member_no']; //로그인한 멤버를 사용할 멤버 번호로 한다
		}
	}
	else //주소창을 통해 넘어 온 경우
	{
		$member_no = $_GET['memberno']; //넘어온 값을 사용할 멤버 번호로 한다
	}

	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	
	$sql = "select * from member where no =" . $member_no;
	
	$result = $conn->query($sql);

	if(!$result || $result->num_rows == 0)
	{
		echo "<meta http-equiv='refresh' content='0; url=/error.php'>"; //에러이다
	}
	else
	{
		while($row = $result->fetch_assoc())
		{
			$profile_img = $row['photopath'];
			$email = $row['email'];
			$nickname = $row['nickname'];
			switch($row['major_activity'])
			{
				case 1:
					$major_activity = "모두";
					break;
				case 2:
					$major_activity = "중등 수학";
					break;
				case 3:
					$major_activity = "고등 수학";
					break;
				case 4:
					$major_activity = "대학 수학";
					break;
				default:
					$major_activity = "-";
			}
			$introduction = $row['introduction'];
			$interesting_part = $row['interesting_part'];

			$mi_answered = $row['mi_answered'];
			$hi_answered = $row['hi_answered'];
			$ui_answered = $row['ui_answered'];

			$mi_adopted = $row['mi_adopted'];
			$hi_adopted = $row['hi_adopted'];
			$ui_adopted = $row['ui_adopted'];
			if(!isset($_GET['activity_type']) || $_GET['activity_type'] == "all")
			{
				$sum_answered = $mi_answered + $hi_answered + $ui_answered;
				$sum_adopted = $mi_adopted + $hi_adopted + $ui_adopted;
			} else if($_GET['activity_type'] == "middle")
			{
				$sum_answered = $mi_answered;
				$sum_adopted = $mi_adopted;
			} else if($_GET['activity_type'] == "high")
			{
				$sum_answered = $hi_answered;
				$sum_adopted = $hi_adopted;
			} else if($_GET['activity_type'] == "univ")
			{
				$sum_answered = $ui_answered;
				$sum_adopted = $ui_adopted;
			} else { $sum_answered = 0; }


			$points = $row['points'];
			$range_array = $row['info_range'];
		}
	}

	$range_profile = substr($range_array, 0, 1);
	$range_activity = substr($range_array, 1, 1);
	$range_question = substr($range_array, 2, 1);
	$range_answer = substr($range_array, 3, 1);
	$range_community = substr($range_array, 4, 1);
	$range_comment = substr($range_array, 5, 1);


	$sql_activity = "";
	if(!isset($_GET['activity_type']) || $_GET['activity_type'] == "all")
	{
		$sql_activity = "select no from member where (mi_adopted + hi_adopted + ui_adopted) >" . $sum_adopted;
	}
	else if($_GET['activity_type'] == "middle")
	{
		$sql_activity = "select no from member where mi_adopted >" . $sum_adopted;
	}
	else if($_GET['activity_type'] == "high")
	{
		$sql_activity = "select no from member where hi_adopted >" . $sum_adopted;
	}
	else if($_GET['activity_type'] == "univ")
	{
		$sql_activity = "select no from member where ui_adopted >" . $sum_adopted;
	}
	else
	{
		$sql_activity = "select no from member where (mi_adopted + hi_adopted + ui_adopted) >" . $sum_adopted;
	}

	$result_activity = $conn->query($sql_activity);
	$ranking_activity = $result_activity->num_rows + 1;


	$sql_ranking = "select no from member where points >" . $points;
	$result_ranking = $conn->query($sql_ranking);
	$ranking = $result_ranking->num_rows + 1;

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
 

		if(document.getElementById("post_footprint_type").value == "all")
		{
			y[0].selected = true;
		}
		else if(document.getElementById("post_footprint_type").value == "middle")
		{
			y[1].selected = true;
		}
		else if(document.getElementById("post_footprint_type").value == "high")
		{
			y[2].selected = true;	
		}
		else if(document.getElementById("post_footprint_type").value == "univ")
		{
			y[3].selected = true;
		}
		else
		{
			alert("예기치 않은 오류가 발생하였습니다.");
		}



		
 
		if(document.getElementById("post_activity_type").value == "all")
		{
			b[0].selected = true;		
		}
		else if(document.getElementById("post_activity_type").value == "middle")
		{
			b[1].selected = true;		
		}
		else if(document.getElementById("post_activity_type").value == "high")
		{
			b[2].selected = true;
		}
		else if(document.getElementById("post_activity_type").value == "univ")
		{
			b[3].selected = true;
		}
		else
		{
			alert("예기치 않은 오류가 발생하였습니다.");
		}


        //순서대로 값을 띄워줍니다.
        //alert("Index: " + y[x].index + " is " + y[x].text+" is " + z);
 
    }

</script>

<script language="javascript">
	
	function pageMover(memberno, fpt, activity_type, footprint_type, pagetype, pageno)
	{
		var v_scrollstat = Math.ceil($(document).scrollTop());
		location.href="/member/mypage.php?memberno=" + memberno + "&fpt=" + document.getElementById("TabNum").value + "&activity_type=" + activity_type + "&footprint_type=" + document.getElementById("TabNum").value + "&" + pagetype + "=" + pageno + "&scrollstat=" + v_scrollstat;
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

	function member_info_range(frm)
	{
		 var url    ="/member/member_info_range.php";
		 var title  = "정보 공개 범위 설정 - Math Overflow";
		 var status = "toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,width=600, height=450, top=100,left=100"; 
		 window.open(url, title,status); //window.open(url,title,status); window.open 함수에 url을 앞에와 같이
													//인수로  넣어도 동작에는 지장이 없으나 form.action에서 적용하므로 생략
													//가능합니다.
		
		 frm.target = title;                    //form.target 이 부분이 빠지면 form값 전송이 되지 않습니다. 
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

<title>마이페이지 - 수학 커뮤니티</title>


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



 

	   <!-- Page Content -->
	<br>
	<?php
	$fpt = -1;
	if(isset($_GET['fpt']))
	{
		$fpt = $_GET['fpt'];
	}
	else
	{
		$fpt = 1;
	}

	echo "<input type='hidden' name='TabNum' id='TabNum' value='" . $fpt . "'/>";
	echo "<form name=\"frm_activity_footprint\" id=\"frm_activity_footprint\" action=\"/member/mypage.php?memberno=" . $member_no . "\">";
	echo "<input type=\"hidden\" name=\"scrollstat\" id=\"scrollstat\" value=\"" . $_GET['scrollstat'] . " \" />";
	?>
    <div class="blacksheepwall">

		<!-- 프로필 -->
		<div id="user_profile" name="user_profile" class="user_profile" style="margin-left:5%;margin-right:1%;float:left;width:43%;min-height:50%;height:100%;border:0pt solid #ff901e">
		
		 <?php

			if($range_profile == 1 || $_SESSION['user_member_no'] == $member_no)
			{
				echo "<table style='margin-left:10;margin-top:10' width=100%><tr><td rowspan=2 style='width:25%'> <img src=/member/memberimage/" . $profile_img . " width=100em height=100em style='margin-top:7%;margin-left:7%'></td>";
				echo "<td style='padding-top:3%'><b><font size=4>" . $nickname . "</font></b></td></tr><tr><td><b><font size=4>(" . $email . ")</font></b>";
				
				if($_SESSION['user_member_no'] == $member_no)
				{
					echo "<form name=\"frm_modify_member_info\" id=\"frm_modify_member_info\" action=\"/member/modify_member_info.php\">";
					echo "<br>";
					echo "<button type=\"button\" name=\"p_modify_member_info\" id=\"p_modify_member_info\" class=\"snip1535_list\" onclick='javascript:modify_member_info(this.form);'>회원 정보 수정</button>";
					echo "&nbsp;&nbsp;&nbsp;<button type=\"button\" name=\"p_member_info_range\" id=\"p_member_info_range\" class=\"snip1535_list\" onclick='javascript:member_info_range(this.form);'>정보 공개 및 1:1 설정</button>";
					echo "<input type=\"hidden\" name=\"p_member_no\" id=\"p_member_no\" value=\"" . $member_no . "\" />";
					echo "</form>";
				}

				
				echo "</td></tr></table>";

				echo "<table width=100% height=30 style='margin-top:5%'><tr><td align='center' style='background:#ffb365' width=20%>주요활동분야</td><td style='padding-left:3%'> " .  $major_activity . "</td></tr></table>";
				echo "</table>";
				echo "<br>";
				echo "<table width=100% height=30><tr><td align='center' style='background:#ffb365' width=20%>관심 과목</td><td style='padding-left:3%'> " . htmlspecialchars($interesting_part) . "</td></tr></table>";
				echo "</table>";
				echo "<br>";
				echo "<table width=100% height=30><tr><td align='center' style='background:#ffb365' width=20%>소개</td><td style='padding-left:3%'> " . htmlspecialchars($introduction) . "</td></tr></table>";
				echo "</table>";
				echo "<br>";
			}
			else
			{
				echo "<br><br><br><br><br><br><br><br><br><center><b>";
				echo $nickname . "</b> 님은 프로필 정보를 비공개로 설정하였습니다.<br><br><br><br><br><br><br></center>";

			}

			//1:1 질문 버튼 노출
			if($_SESSION['user_member_no'] == $member_no)
			{
				echo "<button type='button' name='p_my_one_to_one' id='p_my_one_to_one' class='snip1535_list' onclick=\"location.href='/member/my_onetoone.php'\">나의 1:1 질문답변 현황</button>";
			}
			else
			{
				echo "<button type='button' name='p_go_one_to_one' id='p_go_one_to_one' class='snip1535_list' onclick=\"location.href='/boards/write_qna.php?boardname=board_onetoone_qna&tmemberno=" . $member_no . "'\">이 회원에게 1:1 질문하기</button>";
			}

			
		 ?>
		</div>
		<!-- 프로필 -->

		<!-- 답변 활동 현황 -->
		<div id="user_qna_status" name="user_qna_status" class="user_qna_status" style="padding-top:2%;margin-right:5%;margin-left:1%;float:right;width:43%;min-height:50%;height:100%;border:0pt solid #ff901e">
		<?php
		
			echo "<b><font size=4>&nbsp;&nbsp;&nbsp;답변 활동 현황&nbsp;&nbsp;&nbsp;</font></b>";
	
			echo "<input type=\"hidden\" id=\"post_activity_type\" value=\"" . $activity_type . "\" />";

			echo "<select name=\"activity_type\" id=\"activity_type\" class=\"activity_type\" style=\"border:0.5pt solid #ff901e\" onchange=\"javascript:activity_footprint_change(" . $member_no . ");\">";
	
		
			echo "<option value='all'>종합</option>
			<option value='middle'>중등</option>
			<option value='high'>고등</option>
			<option value='univ'>대학</option>
			</select><br><br>";

			if($range_activity == 1 || $_SESSION['user_member_no'] == $member_no)
			{
				echo "<table style='width:100%' height=30><tr><td align='center' style='background:#ffb365' width=20%>답변수</td><td style='padding-left:3%'><b>" . number_format($sum_answered) . "</td></tr></table>";
				echo "<br>";
				echo "<table style='width:100%' height=30><tr><td align='center' style='background:#ffb365' width=20%>채택수</td><td style='padding-left:3%'><b>" . number_format($sum_adopted) . "</td></tr></table>";
		
				echo "<br>";
				echo "<table style='width:100%' height=30><tr><td align='center' style='background:#ffb365' width=20%>채택수 랭킹</td><td style='padding-left:3%'><b>" . $ranking_activity . " 위</td></tr></table>";
				echo "<br>";
				if($sum_answered == 0)
				{
					$ad_an_ratio = round(0, 2);
				}
				else
				{
					$ad_an_ratio =  round((float)$sum_adopted * 100 / (float)$sum_answered, 2);
				}
				   echo "";
								   
				echo "<table style='width:100%' height=30><tr><td align='center' style='background:#ffb365' width=20%>채택률</td><td style='padding-top:3%;padding-left:3%;padding-right:3%'>
				
				<div class=\"progress\"><div class=\"progress-bar progress-bar-warning\" role=\"progressbar\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width:" . $ad_an_ratio . "% \">
				<span><b><font color=black size=3.5>" . $ad_an_ratio . " %</font></b></span>
				</div></div></td></tr></table>";


				echo "<br><br><br>";
				echo "<table style='width:100%;margin-bottom:2%' height=30><tr><td align='center' style='background:#ffb365' width=20%>포인트</td><td style='padding-left:3%'><b>" . number_format($points) . "</td></tr></table>";
				echo "<table style='width:100%;margin-bottom:2%' height=30><tr><td align='center' style='background:#ffb365' width=20%>포인트 랭킹</td><td style='padding-left:3%'><b>" . $ranking . " 위</td></tr></table>";
			}
			else
			{
					echo "<br><br><br><br><br><center><b>";
				echo $nickname . "</b> 님은 답변 활동 현황을 비공개로 설정하였습니다.<br><br><br><br><br><br><br></center>";
			}

			?>
		</div>
		<!-- 답변 활동 현황 -->

		
		<!-- 작성한 글 및 댓글 -->
		<div id="user_board_activity" name="user_board_activty" class="user_board_activity" style="margin-bottom:20%;margin-left:5%;margin-right:5%;float:left;margin-top:3%;width:90%;height:500;border:0pt solid #ff901e">
			  <div class="row">
				<div>
			<?php
		
            echo "<b><font size=4>&nbsp;&nbsp;&nbsp;작성한 글/댓글</font></b>";
			echo "<input type=\"hidden\" id=\"post_footprint_type\" value=\"" . $footprint_type . "\" />";
		
			echo "&nbsp;&nbsp;&nbsp;<select name=\"footprint_type\" id=\"footprint_type\" class=\"footprint_type\" style=\"border:0.5pt solid #ff901e\" onchange=\"javascript:activity_footprint_change(" . $member_no . ");\">";
			

			?>
				<option value="all">종합</option>
				<option value="middle">중등</option>
				<option value="high">고등</option>
				<option value="univ">대학</option>
			</select>

			</form> <!-- 없어보이는 GET 전송을 피하자 -->
				</div>
            <div class="col-lg-12">
				<!-- 위쪽 전환 버튼 -->
				<?php
                echo "<ul id='myTab' class='nav nav-tabs nav-justified'>";
				switch($_GET['fpt'])
				{
					case 1:
						echo "<li class='active' onclick='javascript:TabChange(1)'><a href='#service-one' data-toggle='tab'><i class='fa fa-tree'></i>질문</a></li>";
						echo "<li class='' onclick='javascript:TabChange(2)'><a href='#service-two' data-toggle='tab'><i class='fa fa-car'></i>답변</a></li>";
						echo "<li class='' onclick='javascript:TabChange(3)'><a href='#service-three' data-toggle='tab'><i class='fa fa-support'></i>커뮤니티</a></li>";
						echo "<li class='' onclick='javascript:TabChange(4)'><a href='#service-four' data-toggle='tab'><i class='fa fa-database'></i>댓글</a></li>";
						break;
					case 2:
						echo "<li class='' onclick='javascript:TabChange(1)'><a href='#service-one' data-toggle='tab'><i class='fa fa-tree'></i>질문</a></li>";
						echo "<li class='active' onclick='javascript:TabChange(2)'><a href='#service-two' data-toggle='tab'><i class='fa fa-car'></i>답변</a></li>";
						echo "<li class='' onclick='javascript:TabChange(3)'><a href='#service-three' data-toggle='tab'><i class='fa fa-support'></i>커뮤니티</a></li>";
						echo "<li class='' onclick='javascript:TabChange(4)'><a href='#service-four' data-toggle='tab'><i class='fa fa-database'></i>댓글</a></li>";
						break;
					case 3:
						echo "<li class='' onclick='javascript:TabChange(1)'><a href='#service-one' data-toggle='tab'><i class='fa fa-tree'></i>질문</a></li>";
						echo "<li class='' onclick='javascript:TabChange(2)'><a href='#service-two' data-toggle='tab'><i class='fa fa-car'></i>답변</a></li>";
						echo "<li class='active' onclick='javascript:TabChange(3)'><a href='#service-three' data-toggle='tab'><i class='fa fa-support'></i>커뮤니티</a></li>";
						echo "<li class='' onclick='javascript:TabChange(4)'><a href='#service-four' data-toggle='tab'><i class='fa fa-database'></i>댓글</a></li>";
						break;
					case 4:
						echo "<li class='' onclick='javascript:TabChange(1)'><a href='#service-one' data-toggle='tab'><i class='fa fa-tree'></i>질문</a></li>";
						echo "<li class='' onclick='javascript:TabChange(2)'><a href='#service-two' data-toggle='tab'><i class='fa fa-car'></i>답변</a></li>";
						echo "<li class='' onclick='javascript:TabChange(3)'><a href='#service-three' data-toggle='tab'><i class='fa fa-support'></i>커뮤니티</a></li>";
						echo "<li class='active' onclick='javascript:TabChange(4)'><a href='#service-four' data-toggle='tab'><i class='fa fa-database'></i>댓글</a></li>";
						break;
					default:
						echo "<li class='active' onclick='javascript:TabChange(1)'><a href='#service-one' data-toggle='tab'><i class='fa fa-tree'></i>질문</a></li>";
						echo "<li class='' onclick='javascript:TabChange(2)'><a href='#service-two' data-toggle='tab'><i class='fa fa-car'></i>답변</a></li>";
						echo "<li class='' onclick='javascript:TabChange(3)'><a href='#service-three' data-toggle='tab'><i class='fa fa-support'></i>커뮤니티</a></li>";
						echo "<li class='' onclick='javascript:TabChange(4)'><a href='#service-four' data-toggle='tab'><i class='fa fa-database'></i>댓글</a></li>";
				}
                echo "</ul>";

				?>
	
                <div id="myTabContent" class="tab-content">

					<!------------------------------------------------------------------------ 질문 ------------------------------------------------------------------------>
					<?php
					if(!isset($_GET['fpt']) || $_GET['fpt'] == 1 || (!($_GET['fpt'] == 2) && !($_GET['fpt'] == 3) && !($_GET['fpt'] == 4)))
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
							$servername = "localhost";
							$username = "root";
							$password = "sdm9469";
							$dbname = "math_overflow";

							$conn = new mysqli($servername, $username, $password, $dbname);

							if($conn->connect_error) {
								die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
							else { }
			
							$sql = "";

							if(!isset($footprint_type) || $footprint_type == "all" || (!($footprint_type =="middle") && !($footprint_type == "high") && !($footprint_type =="univ")) )
							{
								$sql_board = "SELECT name from board_master where name like '%qna%' and not name like '%comment%' and not name like '%answer%' and not name like '%onetoone%'";
								$result_board = $conn->query($sql_board);
								$first = true;
								while($row_board = $result_board->fetch_assoc())
								{
									if($first)
									{
										$sql .= "SELECT * FROM " . $row_board['name'] . " where member_no=" . $member_no . " ";
										$first = false;
									}
									else
									{
										$sql .= "UNION SELECT * FROM " . $row_board['name'] . " where member_no=" . $member_no . " ";
									}
								}

								$sql .=  "ORDER BY date DESC";

							}
							else
							{
								$sql = "SELECT * FROM board_" . $footprint_type . "_qna where member_no=" . $member_no . " ORDER BY date DESC";
								
							}

							$sql_nopage = $sql;
							$sql .= " LIMIT " . (($qpage - 1) * $qrows_in_once) .  ", " . $qrows_in_once;
							
							$result = $conn->query($sql);
							if(!$result) { echo "쿼리 에러 ㅜㅜ"; }



							$n = 0;
							$array_exception;
							$array_exception_type;
							if($range_question == 1 || $_SESSION['user_member_no'] == $member_no)
							{
								if($result->num_rows > 0)
								{
									while($row = $result->fetch_assoc())
									{	
										$boardname = "board_" . $row['type'] . "_qna";
										$boardname_alias = "";
										$sql_alias = "select * from board_master where name=\"" . $boardname . "\""; 
										$result_alias = $conn->query($sql_alias);
										while($row_alias = $result_alias->fetch_assoc())
										{
											$boardname_alias = $row_alias['alias'];
										}
					
										echo "<a href=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $row['no'] . " style=\"text-decoration:none\"><font color=black>";
										echo "<table height=50 style=\"border-collapse:separate;width:100%;height:50;border-radius:18px\"><tr><td style=\"margin-bottom:10pt;background:#ffdebc;width:55%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\">　" . htmlspecialchars($row['title']). "</td>";
										echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:20%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center>" . $boardname_alias . "</center></td>";
										echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:9%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><b>" . $row['points'] . " 포인트</b></center></td>";
										echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:16%;height:50;border:1pt solid #ffdebc;border-radius:18px\">";
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
										echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'qpage', '" . ((intval(($qpage - 1) / 10) + 1) * 10 + 1) . "');\" style='text-decoration:none'><font color=black>▶</font></a>";
									}
									else
									{ }

									echo "</td></tr></table>";


								} else { echo "등록된 글이 없습니다."; }
							}
							else
							{
									echo "<br><br><br><center><b>";
									echo $nickname . "</b> 님은 질문 내역을 비공개로 설정하였습니다.<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></center>";
							}
						

					   ?>
                    </div>


					<!------------------------------------------------------------------------ 답변 ------------------------------------------------------------------------>
                    <?php
					if($_GET['fpt'] == 2)
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
							$servername = "localhost";
							$username = "root";
							$password = "sdm9469";
							$dbname = "math_overflow";

							$conn = new mysqli($servername, $username, $password, $dbname);

							if($conn->connect_error) {
								die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
							else { }
			
							$sql = "";

							if(!isset($footprint_type) || $footprint_type == "all" || (!($footprint_type =="middle") && !($footprint_type == "high") && !($footprint_type =="univ")) )
							{
								
								$sql_board = "SELECT name from board_master where name like '%qna%' and not name like '%comment%' and not name like '%answer%' and not name like '%onetoone%'";
								$result_board = $conn->query($sql_board);
								$first = true;
								if(!$result_board) { echo "이게 무슨 일이람"; }
								while($row_board = $result_board->fetch_assoc())
								{
									if($first)
									{
										$sql .= "SELECT * FROM answer_" . $row_board['name'] . " where member_no=" . $member_no . " ";
										$first = false;
									}
									else
									{
										$sql .= "UNION SELECT * FROM answer_" . $row_board['name'] . " where member_no=" . $member_no . " ";
									}
								}

								$sql .=  "ORDER BY date DESC";

							}
							else
							{
								$sql = "SELECT * FROM answer_board_" . $footprint_type . "_qna where member_no=" . $member_no . " ORDER BY date DESC";
								
							}

							$sql_nopage = $sql;
							$sql .= " LIMIT " . (($apage - 1) * $arows_in_once) .  ", " . $arows_in_once;
					
							$result = $conn->query($sql);
							if(!$result) { echo "쿼리 에러 ㅜㅜ"; }



							$n = 0;
							$array_exception;
							$array_exception_type;

							if($range_answer == 1 || $_SESSION['user_member_no'] == $member_no)
							{
								if($result->num_rows > 0)
								{
									while($row = $result->fetch_assoc())
									{	
										$boardname = "board_" . $row['type'] . "_qna";
										$boardname_alias = "";
										$sql_alias = "select * from board_master where name=\"" . $boardname . "\""; 
										$result_alias = $conn->query($sql_alias);
										while($row_alias = $result_alias->fetch_assoc())
										{
											$boardname_alias = $row_alias['alias'];
										}
					
										echo "<a href=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $row['tg_question_no'] . " style=\"text-decoration:none\"><font color=black>";
										echo "<table height=50 style=\"border-collapse:separate;width:100%;height:50;border-radius:18px\"><tr><td style=\"margin-bottom:10pt;background:#ffdebc;width:55%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\">　" . htmlspecialchars($row['title']). "</td>";
										echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:20%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center>" . $boardname_alias . "</center></td>";
										echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:9%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center><b>";
										
										switch($row['isadopted'])
										{
											case 1:
												echo "진행중";
												break;
											case 2:
												echo "<font color=gray>채택안됨</font>";
												break;
											case 3:
												echo "<font color=blue>채택됨</font>";
												break;
										}
										
										echo "</b></center></td>";
										echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:16%;height:50;border:1pt solid #ffdebc;border-radius:18px\">";
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
									//답변 내역 페이징
									$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
									echo "<table align='center'>";
									echo "<tr><td>";

									
									$sql_chk = $sql_nopage . " LIMIT " . ((intval(($apage - 1) / 10) - 1) * 10 + 9) * $arows_in_once .  ", " . $arows_in_once;
									
									$result_chk = $conn->query($sql_chk);
									if($result_chk && $result_chk->num_rows != 0)
									{
										echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'apage', '" . ((intval(($apage - 1) / 10) - 1) * 10 + 10) . "');\" style='text-decoration:none'><font color=black>◀</font></a> ";
									}
									else
									{ }

									for($i = 0; $i < 10; $i ++)
									{
										//echo "값: " . ($page - 1) % 10 . "<br>";
										if(($apage - 1 ) % 10 == $i)
										{
											//echo "this???";
											echo "<b>";
											echo intval(($apage - 1) / 10) * 10 + $i + 1;
											echo "</b>";
										}
										else
										{
											echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'apage', '" . (intval(($apage - 1) / 10) * 10 + $i + 1) . "');\" style='text-decoration:none'><font color=black>";
											echo intval(($apage - 1) / 10) * 10 + $i + 1;
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
										echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'apage', '" . ((intval(($apage - 1) / 10) + 1) * 10 + 1) . "');\" style='text-decoration:none'><font color=black>▶</font></a>";
									}
									else
									{ }

									echo "</td></tr></table>";
										
								} else { echo "등록된 글이 없습니다."; }
							}
							else
							{
								echo "<br><br><br><center><b>";
								echo $nickname . "</b> 님은 답변 내역을 비공개로 설정하였습니다.<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></center>";
							}

					   ?>
                    </div>

					<!------------------------------------------------------------------------ 커뮤니티 ------------------------------------------------------------------------>
					<?php
						if($_GET['fpt'] == 3)
						{
							echo "<div class='tab-pane fade active in' id='service-three'>";
						}
						else
						{
							echo "<div class='tab-pane fade' id='service-three'>";
						}
					?>
					<br>
                            <?php
							$servername = "localhost";
							$username = "root";
							$password = "sdm9469";
							$dbname = "math_overflow";

							$conn = new mysqli($servername, $username, $password, $dbname);

							if($conn->connect_error) {
								die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
							else { }
			
							$sql = "";

							if(!isset($footprint_type) || $footprint_type == "all" || (!($footprint_type =="middle") && !($footprint_type == "high") && !($footprint_type =="univ")) )
							{
								
								$sql_board = "SELECT name from board_master where name like '%freeboard%' and name not like '%comment%'";
								$result_board = $conn->query($sql_board);
								$first = true;
								if(!$result_board) { echo "이게 무슨 일이람"; }
								while($row_board = $result_board->fetch_assoc())
								{
									if($first)
									{
										$sql .= "SELECT * FROM " . $row_board['name'] . " where member_no=" . $member_no . " ";
										$first = false;
									}
									else
									{
										$sql .= "UNION SELECT * FROM " . $row_board['name'] . " where member_no=" . $member_no . " ";
									}
								}

								$sql .=  "ORDER BY date DESC";

							}
							else
							{
								$sql = "SELECT * FROM board_" . $footprint_type . "_freeboard where member_no=" . $member_no . " ORDER BY date DESC";
								
							}

							$sql_nopage = $sql;
							$sql .= " LIMIT " . (($cpage - 1) * $crows_in_once) .  ", " . $crows_in_once;
			
							$result = $conn->query($sql);
							if(!$result) { echo "쿼리 에러 ㅜㅜ"; }



							$n = 0;
							$array_exception;
							$array_exception_type;

							if($range_community == 1 || $_SESSION['user_member_no'] == $member_no)
							{
								if($result->num_rows > 0)
								{
									while($row = $result->fetch_assoc())
									{	
										$boardname = "board_" . $row['type'] . "_freeboard";
										$boardname_alias = "";
										$sql_alias = "select * from board_master where name=\"" . $boardname . "\""; 
										$result_alias = $conn->query($sql_alias);
										while($row_alias = $result_alias->fetch_assoc())
										{
											$boardname_alias = $row_alias['alias'];
										}
					
										echo "<a href=/boards/view.php?boardname=" . $boardname . "&no=" . $row['no'] . " style=\"text-decoration:none\"><font color=black>";
										echo "<table height=50 style=\"border-collapse:separate;width:100%;height:50;border-radius:18px\"><tr><td style=\"margin-bottom:10pt;background:#ffdebc;width:64%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\">　" . htmlspecialchars($row['title']). "</td>";
										echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:20%;height:50;border:1pt solid #ffdebc;border-radius:18px;margin-right:10\"><center>" . $boardname_alias . "</center></td>";
										
										echo "<td style=\"margin-bottom:10pt;background:#ffdebc;width:16%;height:50;border:1pt solid #ffdebc;border-radius:18px\">";
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

									//커뮤니티 내역 페이징
									$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
									echo "<table align='center'>";
									echo "<tr><td>";

									
									$sql_chk = $sql_nopage . " LIMIT " . ((intval(($cpage - 1) / 10) - 1) * 10 + 9) * $crows_in_once .  ", " . $crows_in_once;
									
									$result_chk = $conn->query($sql_chk);
									if($result_chk && $result_chk->num_rows != 0)
									{
										echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'cpage', '" . ((intval(($cpage - 1) / 10) - 1) * 10 + 10) . "');\" style='text-decoration:none'><font color=black>◀</font></a> ";
									}
									else
									{ }

									for($i = 0; $i < 10; $i ++)
									{
										//echo "값: " . ($page - 1) % 10 . "<br>";
										if(($cpage - 1 ) % 10 == $i)
										{
											//echo "this???";
											echo "<b>";
											echo intval(($cpage - 1) / 10) * 10 + $i + 1;
											echo "</b>";
										}
										else
										{
											echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'cpage', '" . (intval(($cpage - 1) / 10) * 10 + $i + 1) . "');\" style='text-decoration:none'><font color=black>";
											echo intval(($cpage - 1) / 10) * 10 + $i + 1;
											echo "</font></a>";
										}

									
										$sql_chk = $sql_nopage . " LIMIT " . ((intval(($cpage - 1) / 10) * 10 + $i + 1) * $crows_in_once) .  ", " . $crows_in_once;
									
										$result_chk = $conn->query($sql_chk);

										if($result_chk->num_rows == 0) break;
									
										if($i == 9) continue;

										echo " | ";
									}

									$sql_chk = $sql_nopage . " LIMIT " . ((intval(($cpage - 1) / 10) + 1) * 10 + 1 - 1) * $crows_in_once .  ", " . $crows_in_once;
									$result_chk = $conn->query($sql_chk);
									if($result_chk->num_rows != 0)
									{
										echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'cpage', '" . ((intval(($cpage - 1) / 10) + 1) * 10 + 1) . "');\" style='text-decoration:none'><font color=black>▶</font></a>";
									}
									else
									{ }

									echo "</td></tr></table>";
								} else { echo "등록된 글이 없습니다."; }
							}
							else
							{
								echo "<br><br><br><center><b>";
								echo $nickname . "</b> 님은 커뮤니티 활동 내역을 비공개로 설정하였습니다.<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></center>";
							}

					   ?>
                    </div>

					<!------------------------------------------------------------------------ 댓글 ------------------------------------------------------------------------>
                    <?php
						if($_GET['fpt'] == 4)
						{
							echo "<div class='tab-pane fade active in' id='service-four'>";
						}
						else
						{
							echo "<div class='tab-pane fade' id='service-four'>";
						}
					?>
					<br>
                          <?php
							$servername = "localhost";
							$username = "root";
							$password = "sdm9469";
							$dbname = "math_overflow";

							$conn = new mysqli($servername, $username, $password, $dbname);

							if($conn->connect_error) {
								die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
							else { }
			
							$sql = "";

							if(!isset($footprint_type) || $footprint_type == "all" || (!($footprint_type =="middle") && !($footprint_type == "high") && !($footprint_type =="univ")) )
							{
								
								$sql_board = "SELECT name from board_master where name like '%comment%'";
								$result_board = $conn->query($sql_board);
								$first = true;
								if(!$result_board) { echo "이게 무슨 일이람"; }
								while($row_board = $result_board->fetch_assoc())
								{
									if($first)
									{
										$sql .= "SELECT no, member_no, content, date, vote, fromno, writer, type, pers FROM " . $row_board['name'] . " where member_no=" . $member_no . " ";
										$first = false;
									}
									else
									{
										$sql .= "UNION SELECT no, member_no, content, date, vote, fromno, writer, type, pers FROM " . $row_board['name'] . " where member_no=" . $member_no . " ";
									}
								}

								$sql .=  "ORDER BY date DESC";

							}
							else
							{
								$sql = "SELECT no, member_no, content, date, vote, fromno, writer, type, pers FROM comment_board_" . $footprint_type . "_freeboard where member_no=" . $member_no . " UNION 
								        SELECT no, member_no, content, date, vote, fromno, writer, type, pers FROM comment_board_" . $footprint_type . "_qna where member_no=" . $member_no . " ORDER BY date DESC";
								
							}

							$sql_nopage = $sql;
							$sql .= " LIMIT " . (($dpage - 1) * $drows_in_once) .  ", " . $drows_in_once;
			
							$result = $conn->query($sql);
							
							if(!$result) { echo "쿼리 에러 ㅜㅜ"; }



							$n = 0;
							$array_exception;
							$array_exception_type;

							if($range_comment == 1 || $_SESSION['user_member_no'] == $member_no)
							{
								if($result->num_rows > 0)
								{
									while($row = $result->fetch_assoc())
									{	
										$boardname = "board_" . $row['type'] . "_" . $row['pers'];
										$boardname_alias = "";
										$sql_alias = "select * from board_master where name=\"" . $boardname . "\"";
										$result_alias = $conn->query($sql_alias);
										while($row_alias = $result_alias->fetch_assoc())
										{
											$boardname_alias = $row_alias['alias'];
										}
					
									

										if($row['pers'] == "freeboard")
										{
											echo "<a href=\"/boards/view.php?boardname=" . $boardname . "&no=" . $row['fromno'] . "\" style=\"text-decoration:none\"><font color=black>";
										}
										else if($row['pers'] == "qna")
										{
											echo "<a href=\"/boards/view_qna.php?boardname=" . $boardname . "&no=" . $row['fromno'] . "\" style=\"text-decoration:none\"><font color=black>";
										}


									
										echo "<table width=100% border=0 style=\"background:#FFEFD1\">";
										echo "<tr>";
										echo "<td width=3%><center>추천</center></td>";
										echo "<td width=3%>";
										echo $row["vote"] . "</td>" ;
								

										echo "<td width=40%><pdongmin>";
										echo  htmlspecialchars($row["content"]) . "</pdongmin></td>" ;

										echo "<td width=20%>" . $boardname_alias ."</td>";
								
										echo "<td width=20%>";


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



										echo "</td>" ;

										echo "</tr></table>";
									
									

									echo "</font></a><br>";
										
									}


									//댓글 내역 페이징
									$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
									echo "<table align='center'>";
									echo "<tr><td>";

									
									$sql_chk = $sql_nopage . " LIMIT " . ((intval(($dpage - 1) / 10) - 1) * 10 + 9) * $drows_in_once .  ", " . $drows_in_once;
									
									$result_chk = $conn->query($sql_chk);
									if($result_chk && $result_chk->num_rows != 0)
									{
										echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'dpage', '" . ((intval(($dpage - 1) / 10) - 1) * 10 + 10) . "');\" style='text-decoration:none'><font color=black>◀</font></a> ";
									}
									else
									{ }

									for($i = 0; $i < 10; $i ++)
									{
										//echo "값: " . ($page - 1) % 10 . "<br>";
										if(($dpage - 1 ) % 10 == $i)
										{
											//echo "this???";
											echo "<b>";
											echo intval(($dpage - 1) / 10) * 10 + $i + 1;
											echo "</b>";
										}
										else
										{
											echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'dpage', '" . (intval(($dpage - 1) / 10) * 10 + $i + 1) . "');\" style='text-decoration:none'><font color=black>";
											echo intval(($dpage - 1) / 10) * 10 + $i + 1;
											echo "</font></a>";
										}

									
										$sql_chk = $sql_nopage . " LIMIT " . ((intval(($dpage - 1) / 10) * 10 + $i + 1) * $drows_in_once) .  ", " . $drows_in_once;
									
										$result_chk = $conn->query($sql_chk);

										if($result_chk->num_rows == 0) break;
									
										if($i == 9) continue;

										echo " | ";
									}

									$sql_chk = $sql_nopage . " LIMIT " . ((intval(($dpage - 1) / 10) + 1) * 10 + 1 - 1) * $drows_in_once .  ", " . $drows_in_once;
									$result_chk = $conn->query($sql_chk);
									if($result_chk->num_rows != 0)
									{
										echo "<a href=\"javascript:pageMover('" . $member_no . "', '" . $_GET['fpt'] . "' , '" . $_GET['activity_type'] . "', '" . $_GET['footprint_type'] . "', 'dpage', '" . ((intval(($dpage - 1) / 10) + 1) * 10 + 1) . "');\" style='text-decoration:none'><font color=black>▶</font></a>";
									}
									else
									{ }

									echo "</td></tr></table>";
								} else { echo "등록된 글이 없습니다."; }
							}
							else
							{
								echo "<br><br><br><center><b>";
								echo $nickname . "</b> 님은 댓글 내역을 비공개로 설정하였습니다.<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></center>";
							}

					   ?>
                    </div>
                </div>

            </div>
        </div>
		</div>



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
