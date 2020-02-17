<!---------------------------------------------------------------- vote.php ----------------------------------------------------->

<html>
<head>
	<title>추천 처리 - Math Overflow</title>
 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
	<script src="click_cal.js"></script>

	<script language="javascript">
		
		function go_page_1(frm, boardname, page, no)
		{
			
			  var url    ="/boards/view_qna.php?boardname=" + boardname + "&no=" + no + "&page=" + page;
			
			  frm.target = "_self";                    //form.target 이 부분이 빠지면 form값 전송이 되지 않습니다. 
			
			  frm.action = url;                    //form.action 이 부분이 빠지면 action값을 찾지 못해서 제대로 된 팝업이 뜨질 않습니다.
			  frm.method = "post";
			  frm.submit();
		}

		function go_page_2(frm, boardname, page, no)
		{
			 
			  var url    ="/boards/view.php?boardname=" + boardname + "&no=" + no + "&page=" + page;
			 
		
			  frm.target = "_self";                    //form.target 이 부분이 빠지면 form값 전송이 되지 않습니다. 
			  
			  frm.action = url;                    //form.action 이 부분이 빠지면 action값을 찾지 못해서 제대로 된 팝업이 뜨질 않습니다.
			  frm.method = "post";
			  frm.submit();
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
	//vote type
	//1: 추천
	//2: 비추천
	//3: 추천취소
	//4: 비추천취소

	//필수요소 결여

	if(!isset($_GET['boardname']) || !isset($_GET['votetype']) || !isset($_GET['no']) || !isset($_GET['scrollstat']))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(1).<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>
		</tr></table></div>";

		return;
	} else
	{
		if((strpos($_GET['boardname'], "nswer") || strpos($_GET['boardname'], "mment")) && !isset($_GET['fromno']))
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(1-1).<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>
			</tr></table></div>";

			return;
		}
	}

	if(!isset($_SESSION['user_email']))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>추천/비추천 기능은 회원만 이용할 수 있는 기능입니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/member/login.html'\">로그인</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>
		</tr></table></div>";

		return;
	}



	$boardname = "";
	$no = $_GET['no'];
	$fromno = $_GET['fromno'];
	//echo $fromno;

	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	$str_upvote_members;
	$str_downvote_members;
	$upvote_members;
	$downvote_members;
	$writer_no = -1;

	//게시판명 완성
	if(isset($_GET['boardtype']))
	{
		$boardname = $_GET['boardtype'] . "_" . $_GET['boardname'];
	}
	else
	{

		$boardname = $_GET['boardname'];
		//echo "<script>alert('" . $boardname . "');</script>";
	}

	$sql = "select member_no, vote_member, downvote_member from " . $boardname . " where no=" . $_GET['no'];
	//echo $sql;
	$result = $conn->query($sql);

	if(!$result || $result->num_rows == 0)
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(3).<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>
		</tr></table></div>";

		return;
	} else
	{
		while($row = $result->fetch_assoc())
		{
			$writer_no = $row['member_no'];
			$str_upvote_members = $row['vote_member'];
			$str_downvote_members = $row['downvote_member'];
			$upvote_members = explode(";", $row['vote_member']);
			$downvote_members = explode(";", $row['downvote_member']);
		}

		//자추 금지
		if($_SESSION['user_member_no'] == $writer_no)
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>자기 자신의 글은 추천 또는 비추천할 수 없습니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>
			</tr></table></div>";

			return;
		}

		//현재 상태 추출
		$witness_upvote = 0;
		$witness_downvote = 0;
		$upvote_pos = -1;
		$downvote_pos = -1;
		for($i = 0 ; $i < count($upvote_members) ; $i ++)
		{
			if($upvote_members[$i] == $_SESSION['user_member_no'])
			{
				$witness_upvote = 1;
				$upvote_pos = $i;
				break;
			}
		}
	
		for($i = 0; $i < count($downvote_members) ; $i ++)
		{
			if($downvote_members[$i] == $_SESSION['user_member_no'])
			{
				$witness_downvote = 1;
				$downvote_pos = $i;
				break;
			}
		}
		
		//votetype에 따른 처리
		$sql_cheorry = "";
		switch($_GET['votetype'])
		{
			case 1: //추천 버튼을 클릭
			if($witness_upvote > 0)
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>이미 추천하였습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
				</tr></table></div>";

				return;
			}
			else if($witness_downvote > 0)
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>이미 비추천하였습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
				</tr></table></div>";

				return;
			}
			else
			{
				//질문답변 게시판의 경우, 추천/비추천 자격 요건 검사를 한다
				if(strpos($boardname, "qna"))
				{
					$sql_points = "select * from member where no=" . $_SESSION['user_member_no'];
					$result_points = $conn->query($sql_points);
					if(!$result_points) { echo "에러!"; return;}
					else
					{
						while($row_points = $result_points->fetch_assoc())
						{
							$num_adopted = ((strpos($boardname, "middle"))? $row_points['mi_adopted'] : 0) +
											((strpos($boardname, "high"))? $row_points['hi_adopted'] : 0) +
											 ((strpos($boardname, "univ"))? $row_points['ui_adopted'] : 0);

							if(strpos($boardname, "mment"))
							{
								if($num_adopted < 25)
								{
									echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
									echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>회원님의 채택 답변수가 부족하여 추천할 수 없습니다.<br>질문/답변 게시판의 댓글을 추천하기 위해서는 25개의 해당 포럼 채택답변수가 필요합니다.<br><br></center></td></tr>";
									echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
											<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
											</button></td>
									</tr></table></div>";

									return;
								}
								else
								{
									$sql_modifypoints = "update member set points=points+1 where no=" . $writer_no;
									$result_modifypoints = $conn->query($sql_modifypoints);
									if(!$result_modifypoints) { echo "에러(댓글 포인트)"; return; }
								}

							} else
							{
								if($num_adopted < 50)
								{
									echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
									echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>회원님의 채택 답변수가 부족하여 추천할 수 없습니다.<br>질문/답변글을 추천하기 위해서는 50개의 해당 포럼 채택답변수가 필요합니다.<br><br></center></td></tr>";
									echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
											<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
											</button></td>
									</tr></table></div>";

									return;
								}
								else
								{
									$sql_modifypoints = "update member set points=points+2 where no=" . $writer_no;
									$result_modifypoints = $conn->query($sql_modifypoints);
									if(!$result_modifypoints) { echo "에러(댓글 포인트)"; return; }
								}
							}
						}
					}
				}

				//echo "<script>alert('" . count($upvote_members) . "');</script>";
				$str_upvote_members .= ";" . $_SESSION['user_member_no'];
				$sql_cheorry = "update " . $boardname . " set vote_member ='" . $str_upvote_members . "', vote=vote+1 where no=" . $no;
				$result_cheorry = $conn->query($sql_cheorry);

				//질문답변 게시판의 경우, 포인트 조정이 들어간다
				
				
				
				if(!$result_cheorry)
				{ 
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
					echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(4).<br><br></center></td></tr>";
					echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
							<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
							</button></td>
					</tr></table></div>";

					return; 
					
				}
			}
				break;


			case 2: //비추천 버튼을 클릭

			if($witness_downvote > 0)
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>이미 비추천하였습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
				</tr></table></div>";

				return;
			}
			else if($witness_upvote > 0)
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>이미 추천하였습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
				</tr></table></div>";

				return;
			}
			else
			{

				//질문답변 게시판의 경우, 추천/비추천 자격 요건 검사를 한다
				if(strpos($boardname, "qna"))
				{
					$sql_points = "select * from member where no=" . $_SESSION['user_member_no'];
					$result_points = $conn->query($sql_points);
					if(!$result_points) { echo "에러!"; return;}
					else
					{
						while($row_points = $result_points->fetch_assoc())
						{
							$num_adopted = ((strpos($boardname, "middle"))? $row_points['mi_adopted'] : 0) +
											((strpos($boardname, "high"))? $row_points['hi_adopted'] : 0) +
											 ((strpos($boardname, "univ"))? $row_points['ui_adopted'] : 0);

							if(strpos($boardname, "mment"))
							{
								if($num_adopted < 50)
								{
									echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
									echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>회원님의 채택 답변수가 부족하여 비추천할 수 없습니다.<br>질문/답변 게시판의 댓글을 비추천하기 위해서는 50개의 해당 포럼 채택답변수가 필요합니다.<br><br></center></td></tr>";
									echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
											<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
											</button></td>
									</tr></table></div>";

									return;
								}
								else
								{
									$sql_modifypoints = "update member set points=points-1 where no=" . $writer_no;
									$result_modifypoints = $conn->query($sql_modifypoints);
									if(!$result_modifypoints) { echo "에러(댓글 포인트)"; return; }
								}

							} else
							{
								if($num_adopted < 100)
								{
									echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
									echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>회원님의 채택 답변수가 부족하여 비추천할 수 없습니다.<br>질문/답변글을 비추천하기 위해서는 100개의 해당 포럼 채택답변수가 필요합니다.<br><br></center></td></tr>";
									echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
											<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
											</button></td>
									</tr></table></div>";

									return;
								}
								else
								{
									$sql_modifypoints = "update member set points=points-2 where no=" . $writer_no;
									$result_modifypoints = $conn->query($sql_modifypoints);
									if(!$result_modifypoints) { echo "에러(댓글 포인트)"; return; }
								}
							}
						}
					}
				}


				$str_downvote_members .= ";" . $_SESSION['user_member_no'];
				$sql_cheorry = "update " . $boardname . " set downvote_member ='" . $str_downvote_members . "', vote=vote-1 where no=" . $no;
				$result_cheorry = $conn->query($sql_cheorry);
				if(!$result_cheorry)
				{
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
					echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(5).<br><br></center></td></tr>";
					echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
							<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
							</button></td>
					</tr></table></div>";

					return;
				}
			}
				break;





			case 3: //추천취소 버튼을 클릭
			//qna 게시판은 추천/비추천 기능이 없으므로 배제한다.
			if(strpos($boardname, "qna"))
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br>질문답변 게시판의 경우 추천을 취소할 수 없습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
				</tr></table></div>";

				return;
			}
			if($witness_upvote == 0)
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다. 추천한 사실이 없습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
				</tr></table></div>";

				return;
			} else
			{
				$upvote_members[$upvote_pos] = "";
				$new_list = ";";
				for($i=0 ; $i<count($upvote_members) ; $i ++)
				{
					$new_list .= $upvote_members[$i]; //추천 멤버 리스트 재생성
				}

				$sql_cheorry = "update " . $boardname . " set vote_member = '" . $new_list . "', vote=vote-1 where no=" . $no;
				$result_cheorry = $conn->query($sql_cheorry);
				if(!$result_cheorry)
				{ 
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
					echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(6).<br><br></center></td></tr>";
					echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
							<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
							</button></td>
					</tr></table></div>";

					return;
				
				}
			}

				break;





			case 4: //비추천취소 버튼을 클릭
			if(strpos($boardname, "qna"))
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br>질문답변 게시판의 경우 비추천을 취소할 수 없습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
				</tr></table></div>";

				return;
			}
			if($witness_downvote == 0)
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다. 비추천한 사실이 없습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
				</tr></table></div>";

				return;
			} else
			{
				$downvote_members[$downvote_pos] = "";
				$new_list = ";";
				for($i=0 ; $i<count($downvote_members) ; $i ++)
				{
					$new_list .= $downvote_members[$i]; //추천 멤버 리스트 재생성
				}

				$sql_cheorry = "update " . $boardname . " set downvote_member = '" . $new_list . "', vote=vote+1 where no=" . $no;
				$result_cheorry = $conn->query($sql_cheorry);
				if(!$result_cheorry)
				{ 
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
					echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(7).<br><br></center></td></tr>";
					echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
							<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
							</button></td>
					</tr></table></div>";

					return;
				}
			}
				break;
			default:
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(8).<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>
				</tr></table></div>";

				return;
				break;
		}
		

		echo "<form name='gopage' id='gopage' method='post' action='/boards/list.php?boardname=board_middle_freeboard'>";
		echo "<input type='hidden' name='scrollstat' id='scrollstat' value='" . $_GET['scrollstat'] . "' />";
		//echo "<script>alert('" . $_GET['scrollpos'] . "');</script>";
		echo "</form>";
		if(strpos($boardname, "qna"))
		{
			if(strpos($boardname, "nswer") || strpos($boardname, "mment"))
			{
				//echo "<script>alert('1');</script>";
				echo "<script>go_page_1(document.getElementById('gopage'), '" . $_GET['boardname'] . "', '" . $_GET['page'] . "', '" . $fromno . "');</script>";

				//echo "<meta http-equiv='refresh' content='0; url=/boards/view_qna.php?boardname=" . $_GET['boardname'] . "&no=" . $fromno . "'>"; 
			} else
			{
				//echo "<script>alert('2');</script>";
				echo "<script>go_page_1(document.getElementById('gopage'), '" . $boardname . "', '" . $_GET['page'] . "', '" . $no . "');</script>";
				//echo "<meta http-equiv='refresh' content='0; url=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $no . "'>"; 
			}
		}
		else
		{
			if(strpos($boardname, "mment"))
			{
				//echo "<script>alert('3');</script>";
				echo "<script>go_page_2(document.getElementById('gopage'), '" . $_GET['boardname'] . "', '" . $_GET['page'] . "', '" . $fromno . "');</script>";
				//echo "<meta http-equiv='refresh' content='0; url=/boards/view.php?boardname=" . $_GET['boardname'] . "&no=" . $fromno . "'>"; 
			}
			else
			{
				//echo "<script>alert('4');</script>";
				echo "<script>go_page_2(document.getElementById('gopage'), '" . $boardname . "', '" . $_GET['page'] . "', '" . $no . "');</script>";
				//echo "<meta http-equiv='refresh' content='0; url=/boards/view.php?boardname=" . $boardname . "&no=" . $no . "'>"; 
			}
			
		}
		
		
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

