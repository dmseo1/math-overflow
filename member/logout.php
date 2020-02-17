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
</head>
<body>
</body>
</html>

<?php

	
	echo "<script>setCookie('math_overflow_autologin_info','',-1);</script>";
	echo "<script>setCookie('math_overflow_autologin_member_no_info', '', -1);</script>";
	setcookie("math_overflow_autologin_info", "");
	setcookie("math_overflow_autologin_member_no_info", "");

	session_start();
	
	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	$sql_explicit_cookie_delete = "update member set autologin_cookie=0 where no=" . $_SESSION['user_member_no'];
	$result_explicit_cookie_delete = $conn->query($sql_explicit_cookie_delete);
	if(!$result_explicit_cookie_delete) { echo "로그아웃 에러"; return; }
	
	
	session_destroy();
	
?>
 <meta http-equiv='refresh' content='0;url=/index.html'>
