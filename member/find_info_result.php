 <!DOCTYPE html>
<html lang="en">

<head>

<style>



</style>
<script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
   </script>
   <script> w3.includeHTML(); </script>

   <script language="javascript">

	 function validate_ok(frm)
	 {
	
		 if(document.getElementById("validate_code").value == "")
		 {
			alert("인증 번호를 입력하세요");
			return;
		 }

		 var url    ="/member/find_info_result_pw.php";
		 var title  = "비밀번호 찾기 - Math Overflow";
		 
		 frm.target = "_self";                    //form.target 이 부분이 빠지면 form값 전송이 되지 않습니다. 
		 frm.action = url;                    //form.action 이 부분이 빠지면 action값을 찾지 못해서 제대로 된 팝업이 뜨질 않습니다.
		 frm.method = "post";
		 frm.submit();   
	 }


   </script>

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

			function generateRandomString($length = 10) {
			    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			    $charactersLength = strlen($characters);
			    $randomString = '';
			    for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			    }
			    return $randomString;
				}

			$find_type = 0;
			$b_year = 0;
			$b_month = 0;
			$b_day = 0;
			$realname = "";
			$email = "";
			if(!isset($_POST['find_type']))
			{
				echo "잘못된 접근입니다.";
				echo "<script>window.close();</script>";
			}
			else { $find_type = $_POST['find_type']; }


			$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");

			if($find_type == 1) //이메일 찾기
			{
				$realname = $_POST['realname'];
				$birthday = $_POST['birthday'];
				$birthdays = explode("-", $birthday);
				$b_year = $birthdays[0];
				$b_month = $birthdays[1];
				$b_day = $birthdays[2];
				
				$sql_findemail = "select nickname, email from member where realname='" . $realname . "' and b_year=" . $b_year . " and b_month=" . $b_month . " and b_day=" . $b_day;
				$result_findemail = $conn->query($sql_findemail);
				if(!$result_findemail) { echo "잘못된 접근입니다."; echo "<script>window.close();</script>"; }
				else
				{
					if($result_findemail->num_rows == 0)
					{
						echo "<div style='margin:auto;width:90%'>";
						echo "<br><br><br><br><center>입력한 정보와 일치하는 회원 정보가 없습니다.</center><br><br><br><br><br>";

						echo "<center><button type='button' class='snip1535_list' style='width:40%' onclick='history.back();'>다시 입력하기</button>&nbsp;&nbsp;&nbsp;";
						echo "<button type='button' class='snip1535_list' style='width:40%' onclick='window.close();'>닫기</button></center>";
						echo "</div>";
					}
					else if($result_findemail->num_rows == 1)
					{
						echo "<div style='margin:auto;width:90%'>";
						echo "<br><br><center>찾고자 하는 이메일은 다음과 같습니다.<center><br><br>";

						$email_origin = "";
						while($row_findemail = $result_findemail->fetch_assoc())
						{
							$email_origin = $row_findemail = $row_findemail['email'];
						}
						$email_parse = explode("@", $email_origin);
						$email_front = $email_parse[0];
						$front_length =  floor((7* strlen($email_front)) / 10);
				
						$r_email_front = substr($email_front, 0, $front_length);
						$email_front = $r_email_front . "****";
						
						$email_origin = $email_front . "@" . $email_parse[1];

						echo "<center><font size=4><b>" . $email_origin . "<b></font></center><br><br><br><br><br>";

						

						echo "<center><button type='button' class='snip1535_list' style='width:80%' onclick='window.close();'>확인</button></center>";
						echo "</div>";

					}
					else
					{
						echo "<div style='margin:auto;width:90%'>";
						echo "<br><br><center>입력한 정보와 일치하는 회원 정보가 " . $result_findemail->num_rows . "건 있습니다.</center><br><br>";
						echo "<center>";
						echo "<table width=80% style='margin:auto'><tr><td style='width:30%'>닉네임</td><td>이메일</td></tr></table>";
						while($row_findemail = $result_findemail->fetch_assoc())
						{
							echo "<table width=80% style='margin:auto'><tr><td style='width:30%'>" . $row_findemail['nickname'] . "</td>";
							echo "<td><b>";
							

							$email_origin = $row_findemail = $row_findemail['email'];

							$email_parse = explode("@", $email_origin);
							$email_front = $email_parse[0];
							$front_length =  floor((7* strlen($email_front)) / 10);
					
							$r_email_front = substr($email_front, 0, $front_length);
							$email_front = $r_email_front . "****";
							
							$email_origin = $email_front . "@" . $email_parse[1];
							echo $email_origin;
								
							echo "</b></td></tr></table>";
						}

						echo "</center>";


						echo "<br><br><br><br><br>";
						echo "<center><button type='button' class='snip1535_list' style='width:80%' onclick='window.close();'>확인</button></center>";
						echo "</div>";
					}
				}
					

			}
			else //비밀번호 찾기 
			{
				$email = $_POST['p_email'];
				$realname = $_POST['p_realname'];
				$birthday = $_POST['p_birthday'];
				$birthdays = explode("-", $birthday);
				$b_year = $birthdays[0];
				$b_month = $birthdays[1];
				$b_day = $birthdays[2];
				
				$sql_findemail = "select nickname, email from member where email='" . $email . "' and realname='" . $realname . "' and b_year=" . $b_year . " and b_month=" . $b_month . " and b_day=" . $b_day;
				$result_findemail = $conn->query($sql_findemail);
				if(!$result_findemail) { echo "잘못된 접근입니다."; echo "<script>window.close();</script>"; }
				else if($result_findemail->num_rows == 0)
				{
					echo "<div style='margin:auto;width:90%'>";
					echo "<br><br><br><br><center>입력한 정보와 일치하는 회원 정보가 없습니다.</center><br><br><br><br><br>";

					echo "<center><button type='button' class='snip1535_list' style='width:40%' onclick='history.back();'>다시 입력하기</button>&nbsp;&nbsp;&nbsp;";
					echo "<button type='button' class='snip1535_list' style='width:40%' onclick='window.close();'>닫기</button></center>";
					echo "</div>";
				}
				else
				{

					$qual_code = generateRandomString();
					$sql_qual = "insert into mail_qualification (email, code, date) values (\"" . $email . "\", \"" . $qual_code . "\", now())";
					$result_qual = $conn->query($sql_qual);
					if($result_qual)
					{
					
					} else {
						echo "query failed...";
					}
					// Create the email and send the message
						$to = $email; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
						$email_subject = "[MathOverflow] " . $email  . " 님, 비밀번호 재설정을 위한 인증번호입니다.";
						$email_body = "안녕하세요, " . $email . " 님.\nMathOverflow를 이용해주셔서 감사합니다.\n\n다음은 MathOverFlow에서 전송한 비밀번호 재설정을 위한 인증번호입니다. \n아래의 인증코드를 입력하여 비밀번호 재설정 창에서 인증을 완료해주세요.\n\n인증번호: " . $qual_code;
						$headers = "From: webmaster@mathoverflow.dongmin\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
						$headers .= "Reply-To: $email_address";	
						mail($to,$email_subject,$email_body,$headers);			
				
					
					echo "<div style='margin:auto;width:90%'>";
					echo "<form>";
						echo "<br><br><center><b>" . $email ."</b>로 비밀번호 재설정을 위한 인증메일을 전송하였습니다.<br><br>이메일 내용에 포함되어 있는 인증번호를 아래 칸에 입력해주세요.</center><br><br>";
						echo "<input type='hidden' name='email' id='email' value='" . $email . "'/>";
						echo "<center><input type='text' id='validate_code' name='validate_code' style='border:0.5pt solid #ff901e;width:80%;height:30;font-size:15pt;margin:auto' />";
						echo "</center>";
						echo "<br><br><br><br><br>";
						echo "<center><button type='button' class='snip1535_list' style='width:40%' onclick='javascript:validate_ok(this.form);'>입력 완료</button>&nbsp;&nbsp;&nbsp;";
					echo "<button type='button' class='snip1535_list' style='width:40%' onclick='window.close();'>닫기</button></center>";
					echo "</form>";
					echo "</div>";
				}

			}

		?>


		





   </body>

</html>
