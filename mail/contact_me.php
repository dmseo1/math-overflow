<html>
<head>

<link rel="stylesheet" type="text/css" href="/framestyle.css" />
<script>


function Close()
	{
		window.opener.document.getElementById("qual_ok").value = "1";
		window.opener.document.getElementById("qual_ok_text").value = "인증 완료!";
		window.opener.document.getElementById("member_join_email").readOnly = true;
		window.opener.document.getElementById("member_join_email_reset").style.display = "none";
		window.close();
	}

	function Close_Fail()
	{
		window.opener.document.getElementById("qual_ok").value = "";
		window.close();
	}

</script>
</head>
</html>

<?php
// Check for empty fields
if(empty($_POST['member_join_email']) 	||
   !filter_var($_POST['member_join_email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }

$isqual = $_POST['qual_ok'];
if($isqual == 1)
{
	echo "<center><br><br>이미 인증을 받았습니다.<br><br></center>";
	echo "<center><button type=\"button\" onclick=\"javascript:Close();\" class=\"snip1535_list\">닫기</button></center>";
	return;
}
	


$name = "000";
$email_address = strip_tags(htmlspecialchars($_POST['member_join_email']));
$phone = "000";
$message = "000";



function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}

$qual_code = generateRandomString();
$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
$sql = "insert into mail_qualification (email, code, date) values (\"" . $email_address . "\", \"" . $qual_code . "\", now())";
$result = $conn->query($sql);
if($result)
{

} else {
 	echo "query failed...";
}



	
// Create the email and send the message
$to = $email_address; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "[MathOverflow] " . $email_address  . " 님, 인증번호를 확인하세요.";
$email_body = "안녕하세요, " . $email_address . " 님.\nMathOverflow를 이용해주셔서 감사합니다.\n\n다음은 MathOverFlow에서 전송한 인증번호입니다. \n아래의 인증코드를 입력하여 회원가입 창에서 인증을 완료해주세요.\n\n인증코드: " . $qual_code;
$headers = "From: dkfk2747@gmail.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";	
mail($to,$email_subject,$email_body,$headers);			
?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="/framestyle.css" />
<title>인증번호 발송</title>
</head>
<body>

<br><br><center>인증번호가 발송되었습니다.</center><br><br>

<center><button type="button" class="snip1535_list" onclick="window.close();">확인</button></center>

</body>
</html>
