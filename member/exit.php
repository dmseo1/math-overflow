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

	
	
<script>
	function exit_oker(frm)
	{
		if(document.getElementById("member_exit_password").value.length == 0)
		{
			alert("비밀번호를 입력해주세요.");
			return;
		} else
		{
			//최종 암호화
			var keySize = 128;
			var iterations = iterationCount = 10000;
			 
			var iv = "F27D5C9927726BCEFE7510B1BDD3D137";
			var salt = "3FF2EC019C627B945225DEBAD71A01B6985FE84C95A70EB132882F88C0A59A55";
			var passPhrase = "passPhrase passPhrase aes encoding algorithm";
			 
			var plainText = document.getElementById("member_exit_password").value;


			var aesUtil = new AesUtil(keySize, iterationCount)
			var encrypt = aesUtil.encrypt(salt, iv, passPhrase, plainText);
			 
			aesUtil = new AesUtil(keySize, iterationCount)
			document.getElementById("member_exit_password").value = encrypt;


			frm.target = "_self";        
			frm.action = "/member/exit_ok.php";   
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
   <script> w3.includeHTML(); </script> <!-- 수식 -->


<link rel="stylesheet" type="text/css" href="/framestyle.css" />
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

<meta charset="UTF-8 | euc-kr">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="">

<title>회원 탈퇴 - Math Overflow</title>


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

   	<?php
		if($_SESSION['user_member_no'] != $_POST['member_exit_member_no'])
		{
			echo "<div style=\"width:50%;margin-top:100;margin:auto;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";

			return;
		}
	?>

	<div>
		<br><br><br><br><br><br><br><br><br><br>
		<center>탈퇴 시 회원 정보는 즉시 삭제되며, 복구할 수 없습니다.<br>
		정말 회원 탈퇴를 원하는 경우 아래 비밀번호를 입력 후 탈퇴 버튼을 눌러주세요.<br><br>
		<form name="byeform" method="post" action="/member/exit_ok.php">
		<?php

			echo "<input type='hidden' name='member_exit_member_no' id='member_exit_member_no' value='" . $_POST['member_exit_member_no'] . "' />";
		?>
		<input type="password" name="member_exit_password" id="member_exit_password" style="width:30%;height:30;text-size:15pt;border:2pt solid #ff901e" /><br><br>
		
		<button type="button" class="snip1535_list" style='width:13%' onclick='javascript:exit_oker(this.form)'>탈퇴</button>&nbsp;&nbsp;&nbsp;
		<button type="button" class="snip1535_list" style='width:13%' onclick="history.back();">취소</button><br><br><br><br>

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

