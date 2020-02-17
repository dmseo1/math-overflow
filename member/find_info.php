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

  <script src="click_cal_find.js"></script>
  
	<script language="javascript">

		function find_email(frm)
		{
			 var url    ="/member/find_info_result.php";
			 var title  = "이메일 찾기 - Math Overflow";
			 
			 document.getElementById("find_type").value = "1";
			 frm.target = "_self";                    //form.target 이 부분이 빠지면 form값 전송이 되지 않습니다. 
			 frm.action = url;                    //form.action 이 부분이 빠지면 action값을 찾지 못해서 제대로 된 팝업이 뜨질 않습니다.
			 frm.method = "post";
			 frm.submit();   

		}

		function find_password(frm)
		{
			 var url    ="/member/find_info_result.php";
			 var title  = "비밀번호 찾기 - Math Overflow";
				
			 document.getElementById("find_type").value = "2";
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

   
    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/half-slider.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

 
 
	<form name="TotalForm" action="/member/find_info_result.php">
		<input type="hidden" name="find_type" id="find_type" value="" />
		<div class="row">
            <div class="col-lg-12">
				<br>
				<font size=4><b>&nbsp;&nbsp;이메일/비밀번호 찾기</b></font>
				<br>
            </div>
            <div class="col-lg-12">
			
                <ul id="myTab" class="nav nav-tabs nav-justified" style="margin-top:2%">
                    <li class="active"><a href="#service-one" data-toggle="tab"></i>이메일 찾기</a>
                    </li>
                    <li class=""><a href="#service-two" data-toggle="tab"></i>비밀번호 찾기</a>
                    </li>
                 
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="service-one">
					
						
							<div style="width:100%;margin-top:2%;margin-bottom:2%;margin:auto;padding:2% 2% 2% 2%">
								<br>
								<table width="100%">
									<tr>
										<td align="center" style="width:20%;margin-top:10%;margin-bottom:10%">성명(본명)</td>
										<td style="margin-left:0.3%"><input type="text" id="realname" name="realname" style="border:0.5pt solid #ff901e;width:80%;height:30;font-size:15pt" /></td>
									</tr>
								</table>
									<br>
								<table width="100%">
									<tr>
										<td align="center" style="width:20%;margin-top:10%;margin-bottom:10%">생년월일</td>
										<td style="margin-left:0.3%"><input type="text" name="birthday" id="birthday" onfocus="Calendar(this, 'down','no');" style="border:0.5pt solid #ff901e;width:80%;height:30;font-size:15pt" readonly /></td>
									</tr>
								</table>
								<br><br>
								<div style="margin-bottom:4%;margin:auto;width:100%">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" style="width:40%" onclick="javascript:find_email(this.form);" class="snip1535_list">찾기</button>&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" style="width:40%" onclick="window.close();" class="snip1535_list">취소</button>
								</div>
							</div>

					
                      
                    </div>
                    <div class="tab-pane fade" id="service-two">

						
							<div style="width:90%;margin-top:2%;margin-bottom:2%;margin:auto;padding:2% 2% 2% 2%">
								<br>
								<table width="100%">
									<tr>
										<td align="center" style="width:20%;margin-top:10%;margin-bottom:10%">이메일</td>
										<td style="margin-left:0.3%"><input type="text" id="p_email" name="p_email" style="border:0.5pt solid #ff901e;width:80%;height:30;font-size:15pt" /></td>
									</tr>
								</table>
									<br>
								<table width="100%">
									<tr>
										<td align="center" style="width:20%;margin-top:10%;margin-bottom:10%">성명(본명)</td>
										<td style="margin-left:0.3%"><input type="text" id="p_realname" name="p_realname" style="border:0.5pt solid #ff901e;width:80%;height:30;font-size:15pt" /></td>
									</tr>
								</table>
									<br>
								<table width="100%">
									<tr>
										<td align="center" style="width:20%;margin-top:10%;margin-bottom:10%">생년월일</td>
										<td style="margin-left:0.3%"><input type="text" name="p_birthday" id="p_birthday" onfocus="Calendar(this, 'down','no');" style="border:0.5pt solid #ff901e;width:80%;height:30;font-size:15pt" readonly /></td>
									</tr>
								</table>
								<br><br>
								<div style="margin-bottom:4%;margin:auto;width:100%">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" style="width:40%" onclick="javascript:find_password(this.form);" class="snip1535_list">찾기</button>&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" style="width:40%" onclick="window.close();" class="snip1535_list">취소</button>
								</div>
							</div>

						
                       
                    </div>
               
                </div>

            </div>
        </div>
	</form>


	
    <!-- jQuery -->
    <script src="/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
