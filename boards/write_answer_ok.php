<!------------------------------ write_answer_ok.php ----------------------------------->

<html>
<head>
	<title>답변 작성 완료</title>
 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
	<script src="click_cal.js"></script>

	<script language="javascript">

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

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
	}

	//답변 작성 폼을 거치지 않고 바로 해당 페이지에 접속해 온 경우를 차단
	if(!isset($_POST['title']) || !isset($_POST['message']))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";

			return;
	}


	$boardname = $_GET['boardname'];
	$no = $_GET['no'];
	$title = $_POST['title'];
	$message = $_POST['message'];
	$password = $_POST['password'];
	$writer = $_POST['writer'];

	if(!isset($_SESSION['user_email']) || !isset($_SESSION['user_password']))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>로그인을 하여야 답변 작성이 가능합니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/member/login.html'\">로그인</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}
	
	

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

	//사진 업로드에 대한 처리
	$imgupload1 = "";
	$imgupload2 = "";
	$imgupload3 = "";
	if($_POST['uploadimg1_ok'] == "1") //회원가입시 사진을 업로드했다면
	{
	
		// 설정
		$uploads_dir = './boardimage';
		$allowed_ext = array('jpg','jpeg','png','gif', 'JPG', 'JPEG', 'PNG', 'GIF');
		 
		// 변수 정리
		$error = $_FILES['uploadimg1']['error'];
		$imgupload1 = $_FILES['uploadimg1']['name'];

		$ext = explode('.', $imgupload1);
		 
		// 오류 확인
		if( $error != UPLOAD_ERR_OK ) {
			switch( $error ) {
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>파일 크기가 허용하는 크기(20MB)를 초과하였습니다(1번째 첨부파일)<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>

				</tr></table></div>";
					break;
				case UPLOAD_ERR_NO_FILE:
					echo "파일이 첨부되지 않았습니다. ($error)";
					break;
				default:
					echo "파일이 제대로 업로드되지 않았습니다. ($error)";
			}
			exit;
		}

		$ext[0] = $ext[0] . generateRandomString(20);
		 
		// 확장자 확인
		if( !in_array($ext[1], $allowed_ext) ) {
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>허용되지 않는 파일 확장자입니다(1번째 첨부파일)<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";
			exit;
		}

		$imgupload1 = $ext[0] . "." . $ext[1];
		 
		// 파일 이동
		move_uploaded_file( $_FILES['uploadimg1']['tmp_name'], "$uploads_dir/$imgupload1");
	}

	if($_POST['uploadimg2_ok'] == "1") //회원가입시 사진을 업로드했다면
	{
		
		// 설정
		$uploads_dir = './boardimage';
		$allowed_ext = array('jpg','jpeg','png','gif', 'JPG', 'JPEG', 'PNG', 'GIF');
		 
		// 변수 정리
		$error = $_FILES['uploadimg2']['error'];
		$imgupload2 = $_FILES['uploadimg2']['name'];
		$ext = explode('.', $imgupload2);
		 
		// 오류 확인
		if( $error != UPLOAD_ERR_OK ) {
			switch( $error ) {
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>파일 크기가 허용하는 크기(20MB)를 초과하였습니다(2번째 첨부파일)<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>

				</tr></table></div>";
					break;
				case UPLOAD_ERR_NO_FILE:
					echo "파일이 첨부되지 않았습니다. ($error)";
					break;
				default:
					echo "파일이 제대로 업로드되지 않았습니다. ($error)";
			}
			exit;
		}

		$ext[0] = $ext[0] . generateRandomString(20);
		 
		// 확장자 확인
		if( !in_array($ext[1], $allowed_ext) ) {
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>허용되지 않는 파일 확장자입니다(2번째 첨부파일)<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";
			exit;
		}

		$imgupload2 = $ext[0] . "." . $ext[1];
		 
		// 파일 이동
		move_uploaded_file( $_FILES['uploadimg2']['tmp_name'], "$uploads_dir/$imgupload2");
	}

	if($_POST['uploadimg3_ok'] == "1") //회원가입시 사진을 업로드했다면
	{
		
		// 설정
		$uploads_dir = './boardimage';
		$allowed_ext = array('jpg','jpeg','png','gif', 'JPG', 'JPEG', 'PNG', 'GIF');
		 
		// 변수 정리
		$error = $_FILES['uploadimg3']['error'];
		$imgupload3 = $_FILES['uploadimg3']['name'];
		$ext = explode('.', $imgupload3);
		 
		// 오류 확인
		if( $error != UPLOAD_ERR_OK ) {
			switch( $error ) {
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>파일 크기가 허용하는 크기(20MB)를 초과하였습니다(3번째 첨부파일)<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>

				</tr></table></div>";
					break;
				case UPLOAD_ERR_NO_FILE:
					echo "파일이 첨부되지 않았습니다. ($error)";
					break;
				default:
					echo "파일이 제대로 업로드되지 않았습니다. ($error)";
			}
			exit;
		}

		$ext[0] = $ext[0] . generateRandomString(20);
		 
		// 확장자 확인
		if( !in_array($ext[1], $allowed_ext) ) {
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>허용되지 않는 파일 확장자입니다(3번째 첨부파일)<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";
			exit;
		}

		$imgupload3 = $ext[0] . "." . $ext[1];
		 
		// 파일 이동
		move_uploaded_file( $_FILES['uploadimg3']['tmp_name'], "$uploads_dir/$imgupload3");
	}


	$title = str_replace("\\", "\\\\", $title);
	$writer = str_replace("\\", "\\\\", $writer);
	$password = str_replace("\\", "\\\\", $password);
	$message = str_replace("\\", "\\\\", $message);


	$answer_no = -1;
	$sql_getno = "select count from board_master where name='answer_" . $boardname . "'";
	$result_getno = $conn->query($sql_getno);
	while($row_getno = $result_getno->fetch_assoc())
	{
		$answer_no = $row_getno['count'];
	}
	$sql = "";
	if(strpos($boardname, "onetoone"))
	{
		$sql = "insert into answer_" . $boardname . " (no, member_no, title, writer, content, date, date_modified, vote, password, tg_question_no, vote_member, downvote_member, imgpath1, imgpath2, imgpath3, part) values (" . $answer_no . ", " . $_SESSION['user_member_no'] . ", \"" . $title . "\", \"" . $writer . "\", \"" . $message ."\", now(), now(), 0, \"" . $password . "\", " . $no .", \";\", \";\", '" . $imgupload1 . "', '" . $imgupload2 . "', '" . $imgupload3 . "', '" . $_POST['part'] . "')";
	}
	else
	{
		$sql = "insert into answer_" . $boardname . " (no, member_no, title, writer, content, date, date_modified, vote, password, tg_question_no, vote_member, downvote_member, imgpath1, imgpath2, imgpath3) values (" . $answer_no . ", " . $_SESSION['user_member_no'] . ", \"" . $title . "\", \"" . $writer . "\", \"" . $message ."\", now(), now(), 0, \"" . $password . "\", " . $no .", \";\", \";\", '" . $imgupload1 . "', '" . $imgupload2 . "', '" . $imgupload3 . "')";
	}
	
	$sql_inc = "update " . $boardname . " set answers=answers+1 where no=" . $no; 
	$sql_noupdate = "update board_master set count=count+1 where name='answer_" . $boardname . "'";
	$conn->query($sql_noupdate);


	//답변자의 답변 횟수를 하나 늘린다 변수명 고치기 귀찮아
	$sql_adoptplus = "";
	if($boardname == "board_middle_qna" || $_POST['part'] == "middle")
	{
		$sql_adoptplus = "update member set mi_answered = mi_answered + 1 where no=" . $_SESSION['user_member_no'];
	}
	else if($boardname == "board_high_qna" || $_POST['part'] == "high")
	{
		$sql_adoptplus = "update member set hi_answered = hi_answered + 1 where no=" . $_SESSION['user_member_no'];
	}
	else if($boardname == "board_univ_qna" || $_POST['part'] == "univ")
	{
		$sql_adoptplus = "update member set ui_answered = ui_answered + 1 where no=" . $_SESSION['user_member_no'];
	}
	$result_adoptplus = $conn->query($sql_adoptplus);
	if(!$result_adoptplus) { echo "에러"; return; }




	$sql_points = "update member set points = points + 10 where no=" . $_SESSION['user_member_no'];
	$result_points = $conn->query($sql_points);
	if(!$result_points) { echo "에러1"; return; }
	
	#$sql = "insert into board_middle_freeboard (title, writer, content, date, hit, vote) values (\"HAHA\", \"HEHE\", \"HIHI\", now(), 0, 0)";

	
	$result = $conn->query($sql);
	$result_inc = $conn->query($sql_inc);

	if($result)
	{
		echo "write ok";
	}
	else
	{
		echo "write fail";
	}

	if($result_inc)
	{
		echo "이거?";
	}
	else
	{
		echo "응 아니야";
	}

	//돌아갈 페이지 번호 결정
	$sql_getnum = "select answers from " . $boardname . " where no=" . $no;
	$result_getnum = $conn->query($sql_getnum);
	while($row_getnum = $result_getnum->fetch_assoc())
	{
		echo "<meta http-equiv='refresh' content='0; url=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $no . "&page=" . (intval(($row_getnum['answers'] - 1) / 3) + 1) . "'>"; 

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

