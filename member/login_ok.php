<html>
<head>
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

<link rel="stylesheet" type="text/css" href="/framestyle.css" />
</head>
<body>

<?php

if(!isset($_POST['email']) || !isset($_POST['password'])) exit;


header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

$user_id = $_POST['email'];
$user_pw = $_POST['password'];
$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	if($conn->connect_error) {
		die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
	else {  }



$sql = "select * from member where email=\"" . $user_id . "\"";

$result = $conn->query($sql);

if($result)
{
	if($result->num_rows > 0)
	{
		$password = "";
		while($row = $result->fetch_assoc())
		{
			$password = $row['password'];
			if(password_verify($user_pw, $password))
			{
				session_start();

				if($_POST['auto_login'] == "auto_login_ok") //자동 로그인 처리
				{
					if($row['autologin_allowed'] == 0) //해당 계정이 자동 로그인을 허용하지 않은 경우
					{
						echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
						echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>이 계정은 자동로그인을 허용한 계정이 아닙니다.<br>해당 설정 변경은 마이페이지에서 할 수 있습니다.<br><br></center></td></tr>";
						echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
								<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
								</button></td>

						</tr></table></div>";

						return;
					}

					if($row['autologin_cookie'] > 0) //다른 곳에서 자동 로그인 후 명시적 로그아웃을 하지 않은 경우
					{
						echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
						echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>다른 기기 또는 브라우저에서 자동로그인 설정 후 해제(명시적인 로그아웃)하지 않은 이력이 있어서<br>현재 자동 로그인 기능을 이용할 수 없습니다.<br>해당 기기 또는 브라우저를 알 수 없는 경우, 자동 로그인 해제를 위해 관리자에게 문의하세요.<br>관리자 이메일: dkfk2747@gmail.com<br><br></center></td></tr>";
						echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
								<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
								</button></td>

						</tr></table></div>";

						return;
					}


					//echo "<script>alert('이전값:" . $_COOKIE["math_overflow_autologin_info"] . "')</script>";

					$sql_autologin = "select autologin_dummy from status";
					$result_autologin = $conn->query($sql_autologin);
					$cookie_value = "";
					if(!$result_autologin) { echo "잘못된 접근(1)"; return; }
					else
					{
						while($row_autologin = $result_autologin->fetch_assoc())
						{
							echo sprintf('%011d', $row['no']) . $row_autologin['autologin_dummy'];
							$cookie_value = password_hash(sprintf('%011d', $row['no']) . $row_autologin['autologin_dummy'] , PASSWORD_DEFAULT);
						}
					}

					$sql_increasecookie = "update member set autologin_cookie=1 where email='" . $user_id . "'";
					$result_increasecookie = $conn->query($sql_increasecookie);
					if(!$result_increasecookie) { echo "에러!"; return; }


					echo "<script>setCookie('math_overflow_autologin_info', '" . $cookie_value . "', 36555);</script>";
					echo "<script>setCookie('math_overflow_autologin_member_no_info', '" . $row['no'] . "', 36555);</script>";
			
					
				
					
					//echo "<script>alert('현재값: " . $_COOKIE["math_overflow_autologin_info"] ." !!!!!" . $cookie_value . "!!!!!" . $row['no'] . "!!!!!"  ."가 쿠키 값으로 설정되었습니다.');</script>";
				}

				//세션 처리
				$_SESSION['user_email'] = $user_id;
				$_SESSION['user_password'] = "MEMBER";

				$_SESSION['user_nickname'] = $row["nickname"];
				$_SESSION['user_picture'] = $row["photopath"];
				$_SESSION['user_member_no'] = $row["no"];


				echo"<meta http-equiv='refresh' content='0;url=/index.html'>";
			}
			else
			{
				echo "<html>
						<head>

							<script type=\"text/x-mathjax-config\">
							  MathJax.Hub.Config({
								tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
							  });
							</script>
							<script src=\"http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML\"></script>



								<meta charset=\"utf-8\">
								<link rel=\"stylesheet\" type=\"text/css\" href=\"/framestyle.css\" />
							<title>로그인 과정 - Math Overflow</title>
								</head>

								<body>

							<div id=\"wrap\">
						  <div id=\"header\">
							
						
							
						  </div>

						  <div id=\"sidebar\">
							
							
							
						  </div>

						  <div id=\"content\">";

						echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
						echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>패스워드를 잘못 입력하였습니다.<br><br></center></td></tr>";
						echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
								<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
								</button></td>

						</tr></table></div>";

						echo" </div>

					  <div id=\"footer\">
						
					
						
					  </div>
					</div>
					</body>";
			}
		}
	}
	else
	{
			echo "<html>
						<head>

							<script type=\"text/x-mathjax-config\">
							  MathJax.Hub.Config({
								tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
							  });
							</script>
							<script src=\"http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML\"></script>



								<meta charset=\"utf-8\">
								<link rel=\"stylesheet\" type=\"text/css\" href=\"/framestyle.css\" />
							<title>로그인 과정 - Math Overflow</title>
								</head>

								<body>

							<div id=\"wrap\">
						  <div id=\"header\">
							
						
							
						  </div>

						  <div id=\"sidebar\">
							
							
							
						  </div>

						  <div id=\"content\">";
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>존재하지 않는 이메일입니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

			echo" </div>

					  <div id=\"footer\">
						
					
						
					  </div>
					</div>
					</body>";
	}
}
else
{

			echo "<html>
						<head>

							<script type=\"text/x-mathjax-config\">
							  MathJax.Hub.Config({
								tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
							  });
							</script>
							<script src=\"http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML\"></script>



								<meta charset=\"utf-8\">
								<link rel=\"stylesheet\" type=\"text/css\" href=\"/framestyle.css\" />
							<title>로그인 과정 - Math Overflow</title>
								</head>

								<body>

							<div id=\"wrap\">
						  <div id=\"header\">
							
						
							
						  </div>

						  <div id=\"sidebar\">
							
						
							
						  </div>

						  <div id=\"content\">";

				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
					echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
					echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
							<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
							</button></td>

					</tr></table></div>";

				echo" </div>

						  <div id=\"footer\">
							
						
							
						  </div>
						</div>
						</body>";
}


?>



</body>

</html>

 

