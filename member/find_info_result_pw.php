 <!DOCTYPE html>
<html lang="en">

<head>

<script src="../js/AesUtil.js"></script> 
<script src="../js/aes.js"></script> 
<script src="../js/pbkdf2.js"></script> 


<script language="javascript">

		//비밀번호 유효성
		function pwValidateChk()
		{
			if(document.resetForm.member_find_pw_re.value == "")
			{
				document.resetForm.valid_text_re.value = "";
			}
			else if(document.resetForm.member_find_pw.value != document.resetForm.member_find_pw_re.value)
			{
				document.resetForm.valid_text_re.value = "두 비밀번호가 일치하지 않습니다";
			}
			else
			{
				document.resetForm.valid_text_re.value = "두 비밀번호가 일치합니다";
			}

			if(document.resetForm.member_find_pw.value.length == 0)
			{
				document.resetForm.valid_text.value = "비밀번호를 입력하세요";
			}
			else if(document.resetForm.member_find_pw.value.length < 6)
			{
				document.resetForm.valid_text.value = "비밀번호가 너무 짧습니다";
			}
			else
			{
				document.resetForm.valid_text.value = "";
			}
		}


		function pwValidateChk_Re()
		{
			if(document.resetForm.member_find_pw.value != document.resetForm.member_find_pw_re.value)
			{
				document.resetForm.valid_text_re.value = "두 비밀번호가 일치하지 않습니다";
			}
			else if(document.resetForm.member_find_pw_re.value == "")
			{
				document.resetForm.valid_text_re.value = "";
			}
			else
			{
				document.resetForm.valid_text_re.value = "두 비밀번호가 일치합니다";
			}
		}

		//비밀번호 최종 검사

		function pw_ok(frm)
		{
			if(document.resetForm.member_find_pw.value.length == 0)
			{
				alert("새 비밀번호를 입력하세요.");
			}
			else if(document.resetForm.member_find_pw_re.value.length == 0)
			{
				alert("비밀번호 확인 값을 입력하세요.");
			}
			else if(document.resetForm.member_find_pw.value.length < 6)
			{
				alert("비밀번호는 6자 이상으로 입력해주세요.");
			}
			else if(document.resetForm.member_find_pw.value != document.resetForm.member_find_pw_re.value)
			{
				alert("새 비밀번호와 비밀번호 확인 값이 일치하지 않습니다.");
			}
			else
			{

				//최종 암호화
				var keySize = 128;
				var iterations = iterationCount = 10000;
				 
				var iv = "F27D5C9927726BCEFE7510B1BDD3D137";
				var salt = "3FF2EC019C627B945225DEBAD71A01B6985FE84C95A70EB132882F88C0A59A55";
				var passPhrase = "passPhrase passPhrase aes encoding algorithm";
				 
				var plainText = document.resetForm.member_find_pw.value;
				var aesUtil = new AesUtil(keySize, iterationCount)
				var encrypt = aesUtil.encrypt(salt, iv, passPhrase, plainText);

				
				aesUtil = new AesUtil(keySize, iterationCount)

						
				document.resetForm.member_find_pw.value = encrypt;
				document.resetForm.member_find_pw_re.value = encrypt;

				 var url    ="/member/find_info_result_pw_ok.php";
				 var title  = "비밀번호 재설정 완료 - Math Overflow";
				 
				 frm.target = "_self";                    //form.target 이 부분이 빠지면 form값 전송이 되지 않습니다. 
				 frm.action = url;                    //form.action 이 부분이 빠지면 action값을 찾지 못해서 제대로 된 팝업이 뜨질 않습니다.
				 frm.method = "post";
				 frm.submit();   
			}


		}

</script>

<script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
   </script>
   <script> w3.includeHTML(); </script>

 <script src="https://www.w3schools.com/lib/w3.js"></script>
   <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

    <meta charset="UTF-8 | euc-kr">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

   <title>이메일/비밀번호 찾기 - Math Overflow</title>

	<!-- 버튼 디자인 -->
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />

   
 <body>
	
	<?php
		$email = "";
		if(!isset($_POST['validate_code']) && !isset($_POST['email']))
		{
			echo "비정상적인 접근";
			echo "<script>window.close();</script>";
		}
		else
		{
			$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
			$email = $_POST['email'];
			$sql_validateok = "select date, code from mail_qualification where email='" . $email . "' order by date desc limit 1";
			$result_validateok = $conn->query($sql_validateok);
			if(!$result_validateok || $result_validateok->num_rows == 0) { echo "비정상적인 접근"; echo "<script>window.close();</script>"; }
			else
			{
				while($row_validateok = $result_validateok->fetch_assoc())
				{

					if($_POST['validate_code'] == $row_validateok['code'])
					{
						echo "<form name='resetForm' method='post' action='/member/find_info_result_pw_ok.php'>";
						echo "<div style='margin:auto;width:90%'>";
						echo "<br><br><center><b>" . $email ."</b>님, 새로운 비밀번호를 설정해주세요.</center><br><br>";
						echo "<input type='hidden' name='email' id='email' value='" . $email . "'/>";
						
						echo "<table width=90% style='margin:auto'><tr><td align='center' style='width:20%'>새 비밀번호</td>
							<td style='padding-top:1%'><input type='password' name='member_find_pw' onkeyup='javascript:pwValidateChk();' style='border:0.5pt solid #ff901e;width:50%;height:30;font-size:15pt;margin:auto' /> <input type='text' name='valid_text' id='valid_text' style='border:0;width:40%;background:white' disabled/></td>
							
						</tr></table>
						<br>
						<table width=90% style='margin:auto'>
						<tr border=0>
							<td align='center' style='width:20%'>비밀번호 확인</td>
							<td><input type='password' name='member_find_pw_re' onkeyup='javascript:pwValidateChk_Re();' style='border:0.5pt solid #ff901e;width:50%;height:30;font-size:15pt;margin:auto'/> <input type='text' name='valid_text_re' id='valid_text_re' style='border:0;width:40%;background:white' disabled/></td>
						</tr></table>";

						echo "</center>";
						echo "<br><br><br><br><br>";
						echo "<center><button type='button' class='snip1535_list' style='width:40%' onclick='javascript:pw_ok(this.form);'>입력 완료</button>&nbsp;&nbsp;&nbsp;";
						echo "<button type='button' class='snip1535_list' style='width:40%' onclick='window.close();'>닫기</button></center>";
						echo "</div>";
						echo "</form>";
					
					}
					else
					{
						echo "<div style='margin:auto;width:90%'>";
						echo "<br><br><br><br><center>인증번호를 잘못 입력하였습니다.</center><br><br><br><br><br>";

						echo "<center><button type='button' class='snip1535_list' style='width:40%' onclick=\"location.href='/member/find_info.php'\">비밀번호 찾기 재시도</button>&nbsp;&nbsp;&nbsp;";
						echo "<button type='button' class='snip1535_list' style='width:40%' onclick='window.close();'>닫기</button></center>";
						echo "</div>";
					}
				}
			}
		}


	?>
	

 </body>

</html>
