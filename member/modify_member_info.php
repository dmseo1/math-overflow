<!DOCTYPE html>
<html lang="en">

<head>

<style>


.user_profile
{
	min-height:50%;
	height:50%;

}

.user_activity
{
	min-height:50%;
	height:50%;

}

</style>

<script src="../js/AesUtil.js"></script> 
<script src="../js/aes.js"></script> 
<script src="../js/pbkdf2.js"></script> 



	<script src="click_cal.js"></script>

	<script src="http://code.jquery.com/jquery.min.js"></script>

	<!-- 이미지 등록과 관련된 함수를 정의하였음 -->

	<script language="javascript">
		function member_exiter(frm)
		{
		
			frm.target = "_self";        
			frm.action = "/member/exit.php";   
			frm.method = "post";
			frm.submit();
		}
	</script>

	<script type="text/javascript">
	
		function onImageRegistered()
		{
			document.joinForm.getimg.style.display = "none";
			document.joinForm.memberimage.style.display = "none";
			document.joinForm.reimg.style.display = "block";
			document.joinForm.memberimage_ok.value = "1";
		}

		function onImageRe()
		{
			 $('#blah').attr('src', "/member/memberimage/ico_noimg.png");
			 document.joinForm.getimg.style.display = "block";
			 document.joinForm.memberimage.style.display = "block";
			 document.joinForm.reimg.style.display="none";
			 document.joinForm.memberimage_ok.value = "0";
		}

        $(function() {
            $("#imgInp").on('change', function(){ //사진이 바뀌게 된다면
                readURL(this); //URL을 읽으세요
				var fileValue = $("#imgInp").val().split("\\");
				var fileName = fileValue[fileValue.length-1]; // 파일명
				//document.joinForm.memberimage_name.value = fileName;
				onImageRegistered();
			
            });
        });

        function readURL(input) { //URL을 읽는 과정
            if (input.files && input.files[0]) { //파일 인풋으로부터 읽어들인 자료가 존재한다면
            var reader = new FileReader(); //파일리더를 하나 정의하고

            reader.onload = function (e) {  
                    $('#blah').attr('src', e.target.result);
                }
              reader.readAsDataURL(input.files[0]);
            }
        }


    </script>
	<!-- 이미지 등록과 관련된 함수를 정의하였음 -->



	<!-- 이메일 검사와 관련된 함수를 정의하였음 -->
	<script language="javascript">


	

		function pwValidateChk()
		{
			if(document.joinForm.member_modify_pw_re.value == "")
			{
				document.joinForm.valid_text_re.value = "";
			}
			else if(document.joinForm.member_modify_pw.value != document.joinForm.member_modify_pw_re.value)
			{
				document.joinForm.valid_text_re.value = "두 비밀번호가 일치하지 않습니다";
			}
			else
			{
				document.joinForm.valid_text_re.value = "두 비밀번호가 일치합니다";
			}

			if(document.joinForm.member_modify_pw.value.length == 0)
			{
				document.joinForm.valid_text.value = "비밀번호를 입력하세요";
			}
			else if(document.joinForm.member_modify_pw.value.length < 6)
			{
				document.joinForm.valid_text.value = "비밀번호가 너무 짧습니다";
			}
			else
			{
				document.joinForm.valid_text.value = "";
			}
		}


		function pwValidateChk_Re()
		{
			if(document.joinForm.member_modify_pw_re.value != document.joinForm.member_modify_pw_re.value)
			{
				document.joinForm.valid_text_re.value = "두 비밀번호가 일치하지 않습니다";
			}
			else if(document.joinForm.member_modify_pw_re.value == "")
			{
				document.joinForm.valid_text_re.value = "";
			}
			else
			{
				document.joinForm.valid_text_re.value = "두 비밀번호가 일치합니다";
			}
		}

	


		//가입 전 최종점검
		function ChkBeforeModify()
		{
			if(document.joinForm.member_current_pw.value.length == 0)
			{
				alert("현재 비밀번호를 입력하여야 회원 정보 수정이 가능합니다.");
				document.joinForm.member_current_pw.focus();
				return;
			}
			else if(document.joinForm.member_modify_pw.value.length > 0 && document.joinForm.member_modify_pw.value.length < 6)
			{
				alert("새 비밀번호는 6자 이상으로 입력해주세요.");
				document.joinForm.member_modify_pw.value = "";
				document.joinForm.member_modify_pw.focus();
				return;
			}
			else if(document.joinForm.member_modify_pw.value.length > 0 && document.joinForm.member_modify_pw.value != document.joinForm.member_modify_pw_re.value)
			{ 
				alert("새 비밀번호와 비밀번호 확인 값이 일치하지 않습니다.");
				document.joinForm.member_modify_pw.value = "";
				document.joinForm.member_modify_pw_re.value = "";
				document.joinForm.member_modify_pw.focus();
				return;
			}
			else if(document.joinForm.member_modify_nickname.value == "")
			{
				alert("닉네임을 입력해주세요.");
				document.joinForm.member_modify_nickname.focus();
			}
			else if(document.joinForm.member_modify_nickname.value.length > 20)
			{
				alert("닉네임은 20자 이하로 입력해주세요.");
				document.joinForm.member_modify_nickname.focus();
			}
			else if(document.joinForm.member_modify_birthday.value == "")
			{
				alert("생년월일을 선택해주세요.");
				document.joinForm.member_modify_birthday.focus();
				return;
			}
			else
			{
				//window.open('about:blank','_self').close();
				
				//최종 암호화
				var keySize = 128;
				var iterations = iterationCount = 10000;
				 
				var iv = "F27D5C9927726BCEFE7510B1BDD3D137";
				var salt = "3FF2EC019C627B945225DEBAD71A01B6985FE84C95A70EB132882F88C0A59A55";
				var passPhrase = "passPhrase passPhrase aes encoding algorithm";
				 
				var plainText = document.joinForm.member_current_pw.value;
				var aesUtil = new AesUtil(keySize, iterationCount)
				var encrypt = aesUtil.encrypt(salt, iv, passPhrase, plainText);

				
				aesUtil = new AesUtil(keySize, iterationCount)

						
				document.joinForm.member_current_pw.value = encrypt;

			

				if(document.joinForm.member_modify_pw.value.length > 0 && document.joinForm.member_modify_pw_re.value.length > 0)
				{
					var plainText_newpass = document.joinForm.member_modify_pw.value;
					var encrypt_newpass = aesUtil.encrypt(salt, iv, passPhrase, plainText_newpass);

					aesUtil = new AesUtil(keySize, iterationCount)
					document.joinForm.member_modify_pw.value = encrypt_newpass;
					document.joinForm.member_modify_pw_re.value = encrypt_newpass;
				}
			
 				document.joinForm.target = "_self";
				document.joinForm.action = "/member/modify_member_info_ok.php";
				document.joinForm.submit();
			}
				
		}


		function DupChk()
		{
			var email = document.joinForm.member_join_email.value;
			var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			if(email == "")
			{
				alert("이메일을 입력해주세요.");
				document.getElementById("member_join_email").focus();
			}
			else if(!regex.test(email))
			{
				alert("올바른 이메일 형식이 아닙니다.");
				document.joinForm.member_join_email.value = "";
				document.getElementById("member_join_email").focus();
			}
			else
			{
				window.open("/member/join_id_dupchk.php?email=" + email, "중복 확인", "width=300, height=200, left=250, top=250, scrollbar=yes, resizable=no");
			}
			
			
		}




	

	</script>
	<!-- 이메일 검사와 관련된 함수를 정의하였음 -->




<script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
   </script>
   <script> w3.includeHTML(); </script> <!-- 수식 -->


<link rel="stylesheet" type="text/css" href="/framestyle.css" />
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

<meta charset="UTF-8 | euc-kr">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="">

<title>회원정보 수정 - Math Overflow</title>


   <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/half-slider.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body style="">

    <!-- Navigation -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background:#ff901e;border:1pt solid #ff901e" >
        <div class="container"  style="background:#ff901e">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header" style="background:#ff901e">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar" style="background:#ff901e"></span>
                    <span class="icon-bar" style="background:#ff901e"></span>
                    <span class="icon-bar" style="background:#ff901e"></span>
                </button>
                <a class="navbar-brand" href="/index.html"><font color=white>MathOverflow</font></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right" >
				<!--
                    <li>
                        <a href="../about.html"><font color=white>About</font></a>
                    </li>
					-->

				<?php
					@session_start();
                    echo "<li>";
					if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
					{
						echo "<a href=\"/member/logout.php\"><font color=white>로그아웃</font></a>";
					}
					else
					{
						 echo "<a href=\"/member/login.html\"><font color=white>로그인</font></a>";
					}
                    echo "</li>";

					
                    echo "<li>";
					if(isset($_SESSION['user_email']) && isset($_SESSION['user_password']))
					{
						echo "<a href=\"/member/mypage.php\"><font color=white>마이페이지</font></a>";
					}
					else
					{
						echo "<a href=\"/member/join.html\"><font color=white>회원가입</font></a>";
					}
                    echo "</li>";
				?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background:#ff901e"><font color=white>중등 포럼<b class="caret"></font></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/boards/list_qna.php?boardname=board_middle_qna">질문답변 게시판</a>
                            </li>
							<!--
                            <li>
                                <a href="portfolio-2-col.html">나만의 Tip 게시판</font></a>
                            </li>
                            <li>
                                <a href="portfolio-3-col.html">중등 Tip Best</a>
                            </li>
							 <li>
                                <a href="portfolio-3-col.html">토론게시판</a>
                            </li>
							-->
                            <li>
                                <a href="/boards/list.php?boardname=board_middle_freeboard">자유게시판</a>
                            </li>
                  
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background:#ff901e"><font color=white>고등 포럼<b class="caret"></font></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/boards/list_qna.php?boardname=board_high_qna">질문답변 게시판</a>
                            </li>
							<!--
                            <li>
                                <a href="portfolio-2-col.html">나만의 Tip 게시판</a>
                            </li>
                            <li>
                                <a href="portfolio-3-col.html">고등 Tip Best</a>
                            </li>
							<li>
                                <a href="portfolio-3-col.html">토론게시판</a>
                            </li>
							-->
                            <li>
                                <a href="/boards/list.php?boardname=board_high_freeboard">자유게시판</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background:#ff901e"><font color=white>대학 포럼<b class="caret"></font></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/boards/list_qna.php?boardname=board_univ_qna">질문답변 게시판</a>
                            </li>
							
                            <li>
                                <a href="/boards/list.php?boardname=board_univ_freeboard">자유게시판</a>
                            </li>
							<!--
							 <li>
                                <a href="portfolio-3-col.html">토론게시판</a>
                            </li>
                            <li>
                                <a href="#">미적분학</a>
                            </li>
							<li>
                                <a href="#">선형대수학</a>
                            </li>
							<li>
                                <a href="#">해석학</a>
                            </li>
							<li>
                                <a href="#">미분방정식</a>
                            </li>
							<li>
                                <a href="#">현대대수학</a>
                            </li>
							<li>
                                <a href="#">위상수학</a>
                            </li>
							<li>
                                <a href="#">이산수학</a>
                            </li>
							<li>
                                <a href="#">기하학</a>
                            </li>
							<li>
                                <a href="#">확률론/수리통계학</a>
                            </li>
							<li>
                                <a href="#">미분기하학</a>
                            </li>
							<li>
                                <a href="#">응용수학(금융, 경제, 보험)</a>
                            </li>
							<li>
                                <a href="#">응용수학(IT, 암호)</a>
                            </li>
							-->
                           
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

   	<br><br><br><br>

	<div>

	<?php
		@session_start();

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

		if(!isset($_POST['p_member_no']))
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다(2).<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

			</tr></table></div>";

			return;
		}

		$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
		$member_no = $_POST['p_member_no'];

		$sql_member = "select * from member where no=" . $member_no;
		$result_member = $conn->query($sql_member);
		if(!$result_member || $result_member->num_rows == 0) { echo "에러"; return; }
		$member_email = "";
		$member_realname = "";
		$member_nickname = "";
		$member_year = 0;
		$member_month = 0;
		$member_day = 0;
		$member_profileimg = "";
		$member_major_activity = 0;
		$member_interesting_part = "";
		$member_introduction = "";
		$member_autologin_allowed = -1;


		while($row_member = $result_member->fetch_assoc())
		{
			$member_email = $row_member['email'];
			$member_realname = $row_member['realname'];
			$member_nickname = $row_member['nickname'];
			$member_year = $row_member['b_year'];
			$member_month = $row_member['b_month'];
			$member_day = $row_member['b_day'];
			$member_profileimg = $row_member['photopath'];
			$member_major_activity = $row_member['major_activity'];
			$member_interesting_part = $row_member['interesting_part'];
			$member_introduction = $row_member['introduction'];
			$member_autologin_allowed = $row_member['autologin_allowed'];
		}

	?>

	<center><b><font size=5>회원 정보 수정</font></b></center>

	<form name="joinForm" action="/member/join_ok.php" method="post" enctype='multipart/form-data'>

		
		
		<div style="width:80%; border:1pt solid #bbbbbb;padding:2% 0 2% 0;margin-top:2%;margin-bottom:2%;margin:auto">
			
		<?php
			echo "<input type='hidden' name='p_member_no' id='p_member_no' value='" . $member_no . "' />";
			echo "<table width=100%>";
			echo "<tr align='left' border=0 >";
			
			echo "<td align='center' style='padding:1% 0 1% 0;width:120'>이메일</td>"; 
			echo "<td style='padding:1% 0 1% 0'><b>" . $member_email . "</b></td>";

			?>
			
			</tr>

			<tr align="left" border=0>
			
			<td align="center" style="padding:1% 0 1% 0;width:120">현재 비밀번호</td>
			<td style="padding:1% 0 1% 0"><input type="password" name="member_current_pw" style="width:25%;height:30;border:1px solid #ff901e;font-size:17;padding-left:5" /> &nbsp;&nbsp;- 현재 비밀번호를 입력하여야 개인정보 수정이 가능합니다.</td>
			</tr>


			<tr align="left" border=0>
				
				<td align="center" style="padding:1% 0 0.5% 0;width:120">새 비밀번호</td>
				<td style="padding:1% 0 0.5% 0"><input type="password" name="member_modify_pw" onkeyup="javascript:pwValidateChk();" style="width:25%;height:30;border:1px solid #ff901e;font-size:17;padding-left:5" /> <input type="text" name="valid_text" id="valid_text" style="border:0;background:white" disabled/></td>
				
			</tr>
			<tr border=0>
				<td align="center" style="padding:0.5% 0 1% 0;width:120">비밀번호 확인</td>
				<td style="padding:0.5% 0 1% 0"><input type="password" name="member_modify_pw_re" onkeyup="javascript:pwValidateChk_Re();" style="width:25%;height:30;border:1px solid #ff901e;font-size:17;padding-left:5" /> <input type="text" name="valid_text_re" id="valid_text_re" style="border:0;width:300;background:white" disabled/></td>
			</tr>

			<?php
				echo "<td align='center' style='padding:1% 0 1% 0;width:120'>성명(본명)</td>";
				echo "<td style='padding:1% 0 1% 0'><b>" . $member_realname  . "</b></td></tr>";
			?>
			<?php
				echo "<td align='center' style='padding:1% 0 1% 0;width:120'>닉네임</td>";
				echo "<td style='padding:1% 0 1% 0'><input type='text' id='member_modify_nickname' name='member_modify_nickname' style='width:25%;height:30;border:1px solid #ff901e;font-size:17;padding-left:5' value='" . $member_nickname . "'/> </td></tr>";
			?>

			<tr border=0>
				<td align="center" style="padding:1% 0 1% 0;width:120">생년월일</td>
				<td style="padding:1% 0 1% 0">
				<?php

					echo "<input type='text' name='member_modify_birthday' onfocus=\"Calendar(this, 'down','no');\" style='width:25%;height:30;border:1px solid #ff901e;font-size:17;padding-left:5' value='" . $member_year . "-" . sprintf('%02d', $member_month) . "-" . sprintf('%02d', $member_day) . "' readonly /></td></tr>";

				?>


			<tr border=0>
				<td align="center" style="padding:1% 0 1% 0;width:120">자동 로그인 사용</td>
				<td style="padding:1% 0 1% 0">
				<?php
				if($member_autologin_allowed == 1)
				{
					echo "<input type='radio' name='member_modify_autologin' value='yes' style='border:1px solid #ff901e;padding-left:5' checked='checked'/> 예 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='member_modify_autologin' value='no' style='border:1px solid #ff901e;padding-left:5' /> 아니오 &nbsp;&nbsp;&nbsp; - '아니오' 선택시 자동 로그인 기능이 활성화되지 않으며, 기존에 활성화된 자동 로그인은 모두 해제됩니다.</td></tr>";
				}
				else
				{
					echo "<input type='radio' name='member_modify_autologin' value='yes' style='border:1px solid #ff901e;padding-left:5' /> 예 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='member_modify_autologin' value='no' style='border:1px solid #ff901e;padding-left:5' checked='checked' /> 아니오 &nbsp;&nbsp;&nbsp; - '아니오' 선택시 자동 로그인 기능이 활성화되지 않으며, 기존에 활성화된 자동 로그인은 모두 해제됩니다.</td></tr>";
				}

				?>

			<tr border=0>
				<td align="center" style="padding:1% 0 1% 0;width:120">회원 탈퇴</td>
				<td style="padding:1% 0 1% 0">
					<form name='frm_member_exit' id='frm_member_exit' method='post' action='/member/exit.php'>
						<?php
							echo "<input type='hidden' name='member_exit_member_no' id='member_exit_member_no' value='" . $member_no . "'/>";
						?>
						<button type='button' name='member_exit' id='member_exit' class='snip1535_list' onclick="javascript:member_exiter(this.form);">회원 탈퇴</button>
					</form>
				</td>
			</tr>
			</table>

			</div>



			<br><br><br>
			<div style="width:80%;border:1pt solid #bbbbbb;margin-top:2%;margin-bottom:2%;padding:2% 0 2% 0;margin:auto">
			
				
			<table width=100%>
			<tr><td align="center" width="16.5%">프로필 사진</td>
				<td>
					<div>
					<button type="button" id="getimg" name="getimg" class="snip1535_list" style="display:none;position:absolute;cursor:pointer;width:120;height:40">이미지 업로드</button>
					<input type="file" id="imgInp" name="memberimage" style="display:none;opacity:0;position:relative;width:120;height:40;margin-bottom:10"/>
				<button type="button" id="reimg" name="reimg" class="snip1535_list" style="width:120;height:40;display:block;margin-bottom:10" onClick="javascript:onImageRe()">이미지 재선택</button></div>
				<br>
					<?php
						echo "<img id=\"blah\" src=\"/member/memberimage/" . $member_profileimg . "\" alt='' width=80 height=80 style=\"padding-bottom:15\" />";
					?>
					<input type="hidden" name="memberimage_ok" value="2" readonly/>
				
				
				</td>
			</tr>

			<tr><td align="center" width="16.5%" style="padding:1% 0 1% 0">주요 활동 분야<br>(질문&답변)</td>
			<td style="padding:1% 0 1% 0">
				<select name="major_activity" id="major_activity" style="border:0.5pt solid #ff901e">
				<?php
					switch($member_major_activity)
					{
						case 1:
							echo "
								<option value=1 selected='selected'>모두</option>
								<option value=2>중등 수학</option>
								<option value=3>고등 수학</option>
								<option value=4>대학 수학</option>";
							break;
						case 2:
							echo "
								<option value=1>모두</option>
								<option value=2 selected='selected'>중등 수학</option>
								<option value=3>고등 수학</option>
								<option value=4>대학 수학</option>";
							break;
						case 3:
							echo "
								<option value=1>모두</option>
								<option value=2>중등 수학</option>
								<option value=3 selected='selected'>고등 수학</option>
								<option value=4>대학 수학</option>";
							break;
						case 4:
							echo "
								<option value=1>모두</option>
								<option value=2>중등 수학</option>
								<option value=3>고등 수학</option>
								<option value=4 selected='selected'>대학 수학</option>";
							break;
						default:
							echo "오류";
							echo "
								<option value=1 selected='selected'>모두</option>
								<option value=2>중등 수학</option>
								<option value=3>고등 수학</option>
								<option value=4>대학 수학</option>";
							break;
					}	

				?>
				</select>
			</td>
			</tr>

			<tr><td align="center" width="16.5%" style="padding:1% 0 1% 0">관심있는 분야</td>
			<td style="padding:1% 0 1% 0">
				<?php
					echo "<input type=\"text\" id=\"interesting_part\" name=\"interesting_part\" style=\"width:90%;height:30;border:0.5pt solid #ff901e\" value='" . $member_interesting_part . "' />";
				?>
			</tr>

			<tr><td align="center" width="16.5%" style="padding:1% 0 1% 0">자기소개</td>
				<?php
					echo "<td style='padding:1% 0 1% 0'><textarea name=\"introduce\" id=\"introduce\" style=\"width:90%;height:80;border:0.5pt solid #ff901e\">" . $member_introduction . "</textarea></td>";
				?>
			</tr></table>
	
		
			</div>

			<div style="width:80%;padding-top:2%;padding-bottom:3%;margin:auto">
				<center><button type="button" name="member_modify_confirm" style="width:40%" onclick="javascript:ChkBeforeModify();" class="snip1535">수정</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" name="member_modify_cancel" style="width:40%" onclick="history.back();" class="snip1535">취소</button></center>
			</div>

	</form>

  </div>


 <!-- /.container -->

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>



</div>
</body>

