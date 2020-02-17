<?php

	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	
	echo $_POST['member_find_pw'];
	$email = $_POST['email'];
	$password = password_hash($_POST['member_find_pw'], PASSWORD_DEFAULT);


	$sql_findpw = "update member set password='" . $password . "' where email='" . $email . "'";
	$result_findpw = $conn->query($sql_findpw);

	if(!$result_findpw) { echo "잘못된 접근입니다."; return; }
	else
	{
		echo "<script>alert('비밀번호 변경이 완료되었습니다. 새로운 비밀번호로 로그인해주세요.'); window.close();</script>";
	}

?>
