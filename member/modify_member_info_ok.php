<html>
<head>

 <title>회원 정보 수정 완료 - Math Overflow</title>

 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

<script>
// 쿠키 생성
    function setCookie(cName, cValue, cDay){
        var expire = new Date();
        expire.setDate(expire.getDate() + cDay);
        cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
        if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
        document.cookie = cookies;
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
	@session_start;

	//로그인도 안 했는데 회원 정보 수정?
	if(!isset($_SESSION['user_email']))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(1).<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
			<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
			</button></td>

		</tr></table></div>";

		return;
	}

	//수정 폼을 통한 정상적인 접근이 아닌 경우
	if(!isset($_POST['p_member_no']) || $_SESSION['user_member_no'] != $_POST['p_member_no'])
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(2).<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
			<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
			</button></td>

		</tr></table></div>";

		return;
	}


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



	
	
		
	$password = $_POST['member_current_pw'];
	$cur_password = "";
	$sql_getpw = "select password from member where no=" . $_POST['p_member_no'];
	$result_getpw = $conn->query($sql_getpw);
	if(!$result_getpw || $result_getpw->num_rows == 0) { echo "에러!"; return; }
	else
	{
		while($row_getpw = $result_getpw->fetch_assoc())
		{
			$cur_password = $row_getpw['password'];
		}
	}

	if(!password_verify($password, $cur_password))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>현재 비밀번호를 잘못 입력하였습니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
			<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
			</button></td>

		</tr></table></div>";

		return;
	}

	//새 비밀번호를 설정하였다면
	$new_password = "";
	if(isset($_POST['member_modify_pw']) && $_POST['member_modify_pw'] != "")
	{
		if($_POST['member_current_pw'] == $_POST['member_modify_pw'])
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>현재 비밀번호와는 다른 비밀번호를 입력해주세요.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

			</tr></table></div>";

			return;
		}
		$new_password = $_POST['member_modify_pw'];
		$new_password = password_hash($new_password, PASSWORD_DEFAULT);
	}
	
	
	$birthday = explode("-", $_POST['member_modify_birthday']);
	$b_year = $birthday[0];
	$b_month = $birthday[1];
	$b_day = $birthday[2];

	$nickname = $_POST['member_modify_nickname'];
	$memberimage_ok = $_POST['memberimage_ok'];

	$major_activity = $_POST['major_activity'];
	$interesting_part = $_POST['interesting_part'];
	$introduction = $_POST['introduce'];
	$autologin_allow = -1;
	if($_POST['member_modify_autologin'] == "yes")
	{
		$autologin_allow = 1;
	}
	else
	{
		$autologin_allow = 0;
	}

	
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
	else if($memberimage_ok == "0")
	{
		$name = "ico_noimg.png";
	}


	
	
	
	//위의 상황에 따라 쿼리를 다르게 한다.
	if(isset($_POST['member_modify_pw']) && $_POST['member_modify_pw'] != "") //비밀번호를 수정하였다면
	{
		if($memberimage_ok == "2") //원래의 프로필 사진을 고치지 않음
		{
			$sql = "update member set nickname='" . $nickname . "', password='" . $new_password . "', b_year=" . $b_year . ", b_month=" . $b_month . ", b_day=" . $b_day . ", introduction='" . $introduction . "', major_activity='" . $major_activity . "', interesting_part='" . $interesting_part . "', autologin_allowed=" . $autologin_allow . " where no=" . $_POST['p_member_no'];
		}
		else //프로필 사진을 고쳤다면
		{
			$sql = "update member set nickname='" . $nickname . "', password='" . $new_password . "', b_year=" . $b_year . ", b_month=" . $b_month . ", b_day=" . $b_day . ", introduction='" . $introduction . "', major_activity='" . $major_activity . "', interesting_part='" . $interesting_part . "', photopath='" . $name . "', autologin_allowed=" . $autologin_allow . " where no=" . $_POST['p_member_no'];
		}

	}
	else //비밀번호를 수정하지 않았다면
	{
		if($memberimage_ok == "2")
		{
			$sql = "update member set nickname='" . $nickname . "', b_year=" . $b_year . ", b_month=" . $b_month . ", b_day=" . $b_day . ", introduction='" . $introduction . "', major_activity='" . $major_activity . "', interesting_part='" . $interesting_part . "', autologin_allowed=" . $autologin_allow . " where no=" . $_POST['p_member_no'];
		}
		else
		{
			$sql = "update member set nickname='" . $nickname . "', b_year=" . $b_year . ", b_month=" . $b_month . ", b_day=" . $b_day . ", introduction='" . $introduction . "', major_activity='" . $major_activity . "', interesting_part='" . $interesting_part . "', photopath='" . $name . "', autologin_allowed=" . $autologin_allow . " where no=" . $_POST['p_member_no'];
		}
	}

	//echo $sql;
	$result = $conn->query($sql);


	if($result)
	{

		echo "<script>setCookie('math_overflow_autologin_info','',-1);</script>";
		echo "<script>setCookie('math_overflow_autologin_member_no_info', '', -1);</script>";
		@setcookie("math_overflow_autologin_info", "");
		@setcookie("math_overflow_autologin_member_no_info", "");

		
		$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
		$sql_explicit_cookie_delete = "update member set autologin_cookie=0 where no=" . $_SESSION['user_member_no'];
		$result_explicit_cookie_delete = $conn->query($sql_explicit_cookie_delete);
		if(!$result_explicit_cookie_delete) { echo "로그아웃 에러"; return; }
		
		@session_destroy();


		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>회원정보가 수정되었습니다.<br>변경된 내용의 정상적인 적용을 위해 다시 로그인해주세요.<br><br></center></td></tr>";

	

		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/member/login.html'\">로그인</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로
				</button></td>
		</tr></table></div>";
	}
	else
	{

		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(3)<br><br></center></td></tr>";
		echo "<tr>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로
				</button></td>
		</tr></table></div>";
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
