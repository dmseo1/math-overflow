<!-------------------------------------- modify_answer_ok.php ------------------------------------>

<html>
<head>

 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>


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

	$boardname = $_GET['boardname'];
 	$no = $_GET['no'];
	$fromno = $_GET['fromno'];
	$title = $_POST['title'];
	$message = $_POST['message'];
	$password = $_POST['password'];
	$writer = $_POST['writer'];



	$title = str_replace("\\", "\\\\", $title);
	$writer = str_replace("\\", "\\\\", $writer);
	$password = str_replace("\\", "\\\\", $password);
	$message = str_replace("\\", "\\\\", $message);

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




	$sql_password = "select * from answer_" . $boardname . " where no=" . $no;
	$result_password = $conn->query($sql_password);
	$origin_password = "";
	$origin_member_no = -1;
	$imgupload1 = "";
	$imgupload2 = "";
	$imgupload3 = "";
	while($row_result = $result_password->fetch_assoc())
	{
		$origin_password = $row_result["password"];
		$origin_member_no = $row_result["member_no"];
		$imgupload1 = $row_result["imgpath1"];
		$imgupload2 = $row_result["imgpath2"];
		$imgupload3 = $row_result["imgpath3"];
	}

	if($_POST['uploadimg1_ok'] == "1") //사진이 수정되었다면
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
	else if($_POST['uploadimg1_ok'] == "0")
	{
		$imgupload1 = "";
	}

	if($_POST['uploadimg2_ok'] == "1") ///사진이 수정되었다면
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
	else if($_POST['uploadimg2_ok'] == "0")
	{
		$imgupload2 = "";
	}

	if($_POST['uploadimg3_ok'] == "1") //사진이 수정되었다면
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
	else if($_POST['uploadimg3_ok'] == "0")
	{
		$imgupload3 = "";
	}




	if(!isset($_SESSION['user_email']) || !isset($_SESSION['user_password'])) //로그인 체크
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>로그인을 하여야 답변 수정이 가능합니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/member/login.html'\">로그인</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}
	else
	{
		if($_SESSION['user_member_no'] != $origin_member_no) //본인 체크
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>본인이 작성한 글 이외에는 수정할 수 없습니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";

			return;
		}
	}



	if( strcmp($_SESSION['user_member_no'], $origin_member_no) == 0 )
	{
		$sql = "update answer_" . $boardname . " set title=\"" . $title . "\", content=\"" . $message . "\", writer=\"" . $writer . "\", date_modified=now(), imgpath1='" . $imgupload1 . "', imgpath2='" . $imgupload2 . "', imgpath3='" . $imgupload3 . "' where no=" . $no;

		$result = $conn->query($sql);
		if($result)
		{
			echo "modify ok";
		}
		else
		{
			echo "modify fail";
		}

		echo "<meta http-equiv='refresh' content='0; url=/boards/view_qna.php?boardname=" . $boardname . "&no=" . $fromno . "'>"; 
	}
	else
	{
		echo "<div style=\"width:50%;float:center;margin-top:100;margin-bottom:500\">";
		echo "<tr><td style=\"padding-bottom:50px\"><center>비밀번호가 일치하지 않습니다<br><br></center></td></tr>";
		echo "<tr><td><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로</button></td></tr></table></div>";
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









