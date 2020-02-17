<html>
<head>

 <title>회원가입 완료</title>

 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>


	<script>
	//뒤로가기 막기
		history.pushState(null, null, location.href); 
		window.onpopstate = function(event) { 
		history.go(1); 
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

	function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}

	$conn = mysqli_connect("localhost", "root", "sdm9469", "math_overflow");
	if(mysqli_connect_errno())
	{
		echo("mysql 서버가 정상 동작하지 않습니다");
	}
	else {  }

	$email = $_POST['member_join_email'];

	$sql_emaildup = "select email from member";
	$result_emaildup = $conn->query($sql_emaildup);
	$witness = 0;
	if($result_emaildup)
	{
		while($row_emaildup = $result_emaildup->fetch_assoc())
		{
			if($row_emaildup["email"] == $email)
			{
				$witness++;
				break;
			}
		}
	}
	else
	{
		echo "이것마저도 실패하면...";
	}


	
	

	if($witness == 1)
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다<br><br></center></td></tr>";
			echo "<tr>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로
					</button></td>
			</tr></table></div>";
	}
	else
	{
		
		$password = $_POST['member_join_pw'];
		$password = password_hash($password, PASSWORD_DEFAULT);
		
		
		$birthday = explode("-", $_POST['member_join_birthday']);
		$b_year = $birthday[0];
		$b_month = $birthday[1];
		$b_day = $birthday[2];

		$realname = $_POST['member_join_realname'];
		$nickname = $_POST['member_join_nickname'];
		$memberimage_ok = $_POST['memberimage_ok'];

		$major_activity = $_POST['major_activity'];
		$interesting_part = $_POST['interesting_part'];
		$introduction = $_POST['introduce'];


		if($memberimage_ok == "1") //회원가입시 사진을 업로드했다면
		{
			// 설정
			$uploads_dir = './memberimage';
			$allowed_ext = array('jpg','jpeg','png','gif', 'JPG', 'JPEG', 'PNG', 'GIF');
			 
			// 변수 정리
			$error = $_FILES['memberimage']['error'];
			$name = $_FILES['memberimage']['name'];
			$ext = explode('.', $name);
			 
			// 오류 확인
			if( $error != UPLOAD_ERR_OK ) {
				switch( $error ) {
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						echo "파일이 너무 큽니다. ($error)";
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
				echo "허용되지 않는 확장자입니다.";
				exit;
			}

			$name = $ext[0] . "." . $ext[1];
			 
			// 파일 이동
			move_uploaded_file( $_FILES['memberimage']['tmp_name'], "$uploads_dir/$name");

		}
		else
		{
			$name = "ico_noimg.png";
		}

		$sql_memberno = "select memcount from status";
		$result_memberno = $conn->query($sql_memberno);
		$memcount = -1;
		while($row_memberno = $result_memberno->fetch_assoc())
		{
			$memcount = $row_memberno['memcount'] + 1;
		}
		
		$sql_memincrease = "update status set memcount=memcount+1";
		$result_memincrease = $conn->query($sql_memincrease);

		$sql = "insert into member (no, email, password, realname, nickname, b_year, b_month, b_day, introduction, regdate, photopath, major_activity, interesting_part) values (" . $memcount . ", \"" . $email . "\", \"" . $password . "\", \"" . $realname . "\", \"" . $nickname . "\", " . $b_year . ", " . $b_month . ", " . $b_day . ", \"" . $introduction . "\", now(), \"" . $name . "\", \"" . $major_activity . "\", \"" . $interesting_part . "\")";
		$result = $conn->query($sql);


		if($result)
		{
	
			if($result_memincrease)
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>회원가입이 완료되었습니다!<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/member/login.html'\">로그인</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로
						</button></td>

				</tr></table></div>";
			}
			else
			{
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
					echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다<br><br></center></td></tr>";
					echo "<tr>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로
						</button></td>
						</tr></table></div>";
			}
		}
		else
		{

			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다<br><br></center></td></tr>";
			echo "<tr>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로
					</button></td>
			</tr></table></div>";
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









