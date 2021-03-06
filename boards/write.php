<!-------------------------------- write.php --------------------------------------->

<html>
<head>

  <link href="css/default.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/HuskyEZCreator.js" charset="utf-8"></script>

 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
	<script src="http://code.jquery.com/jquery.min.js"></script> 
	<script type="text/javascript">

		function onImageRegistered1()
		{	
			$('#blah1').attr('onclick', 'window.open(this.src)');
			document.getElementById("getimg1").style.display = "none";
			document.getElementById("imgInp1").style.display = "none";
			document.getElementById("reimg1").style.display = "block";
			document.getElementById("uploadimg1_ok").value = "1";
		}

		function onImageRe1()
		{
			 $('#blah1').attr('src', "");
			 $('#blah1').attr('onclick', '');
			 document.getElementById("getimg1").style.display = "block";
			 document.getElementById("imgInp1").style.display = "block";
			 document.getElementById("reimg1").style.display="none";
			 document.getElementById("uploadimg1_ok").value = "0";
		}

        $(function() {
            $("#imgInp1").on('change', function(){ //사진이 바뀌게 된다면
				if(document.getElementById("imgInp1").value == "")
					return;

                readURL1(this); //URL을 읽으세요
				
				var fileValue = $("#imgInp1").val().split("\\");
				
				var fileName = fileValue[fileValue.length-1]; // 파일명
				//document.joinForm.memberimage_name.value = fileName;
				onImageRegistered1();
			
            });
        });

        function readURL1(input) { //URL을 읽는 과정
            if (input.files && input.files[0]) { //파일 인풋으로부터 읽어들인 자료가 존재한다면
            var reader = new FileReader(); //파일리더를 하나 정의하고

            reader.onload = function (e) {  
                    $('#blah1').attr('src', e.target.result);
                }
              reader.readAsDataURL(input.files[0]);
            }
        }




		function onImageRegistered2()
		{
			$('#blah2').attr('onclick', 'window.open(this.src)');
			document.getElementById("getimg2").style.display = "none";
			document.getElementById("imgInp2").style.display = "none";
			document.getElementById("reimg2").style.display = "block";
			document.getElementById("uploadimg2_ok").value = "1";
		}

		function onImageRe2()
		{
			 $('#blah2').attr('src', "");
			 $('#blah2').attr('onclick', '');
			 document.getElementById("getimg2").style.display = "block";
			 document.getElementById("imgInp2").style.display = "block";
			 document.getElementById("reimg2").style.display="none";
			 document.getElementById("uploadimg2_ok").value = "0";
		}

        $(function() {
            $("#imgInp2").on('change', function(){ //사진이 바뀌게 된다면
				if(document.getElementById("imgInp2").value == "")
					return;
                readURL2(this); //URL을 읽으세요
				var fileValue = $("#imgInp2").val().split("\\");
				var fileName = fileValue[fileValue.length-1]; // 파일명
				//document.joinForm.memberimage_name.value = fileName;
				onImageRegistered2();
			
            });
        });

        function readURL2(input) { //URL을 읽는 과정
            if (input.files && input.files[0]) { //파일 인풋으로부터 읽어들인 자료가 존재한다면
            var reader = new FileReader(); //파일리더를 하나 정의하고

            reader.onload = function (e) {  
                    $('#blah2').attr('src', e.target.result);
                }
              reader.readAsDataURL(input.files[0]);
            }
        }




		function onImageRegistered3()
		{
			$('#blah3').attr('onclick', 'window.open(this.src)');
			document.getElementById("getimg3").style.display = "none";
			document.getElementById("imgInp3").style.display = "none";
			document.getElementById("reimg3").style.display = "block";
			document.getElementById("uploadimg3_ok").value = "1";
		}

		function onImageRe3()
		{
			 $('#blah3').attr('src', "");
			 $('#blah3').attr('onclick', '');
			 document.getElementById("getimg3").style.display = "block";
			 document.getElementById("imgInp3").style.display = "block";
			 document.getElementById("reimg3").style.display="none";
			 document.getElementById("uploadimg3_ok").value = "0";
		}

        $(function() {
            $("#imgInp3").on('change', function(){ //사진이 바뀌게 된다면
				if(document.getElementById("imgInp3").value == "")
					return;
                readURL3(this); //URL을 읽으세요
				var fileValue = $("#imgInp3").val().split("\\");
				var fileName = fileValue[fileValue.length-1]; // 파일명
				//document.joinForm.memberimage_name.value = fileName;
				onImageRegistered3();
			
            });
        });

        function readURL3(input) { //URL을 읽는 과정
            if (input.files && input.files[0]) { //파일 인풋으로부터 읽어들인 자료가 존재한다면
            var reader = new FileReader(); //파일리더를 하나 정의하고

            reader.onload = function (e) {  
                    $('#blah3').attr('src', e.target.result);
                }
              reader.readAsDataURL(input.files[0]);
            }
        }


    </script>
	
	<script language="javascript">


	
		function ChkBeforeWrite()
		{
			if(document.writeForm.title.value == "")
			{
				alert("제목을 입력해주세요");
				document.writeForm.title.focus();
				return;
			}
			if(document.writeForm.title.value.length > 80)
			{
				alert("제목은 80자 이내로 입력해주세요");
				document.writeForm.title.focus();
				return;
			}
			else if(document.writeForm.writer.value == "")
			{
				alert("이름을 입력해주세요");
				document.writeForm.writer.focus();
				return;
			}
			else if(document.writeForm.password.value == "")
			{
				alert("비밀번호를 입력해주세요");
				document.writeForm.password.focus();
				return;
			}
			else if(!document.writeForm.message.value.replace(/(^\s*)|(\s*$)/gi,""))
			{
				alert("내용을 입력해주세요");
				document.writeForm.message.focus();
				return;
			}
			else
			{
				document.writeForm.submit();
			}
				
		}


		function Preview()
		{

			var title = document.writeForm.title.value;
			var message = document.getElementById("message").value;
			title= title.replace(/&/g,"%26"); 
    		title= title.replace(/\+/g,"%2B"); 
			message = message.replace(/(?:\r\n|\r|\n)/g, '<br>');
			message= message.replace(/&/g,"%26"); 
    		message= message.replace(/\+/g,"%2B"); 
			window.open("/boards/preview.php?title=" + title + "&message=" + message, "미리보기", "width=800, height=600, left=50, top=50, scrollbar=yes, resizable=no");
		}

			
		



	</script>


	<script>
//form변수로 지정하여 이미지업로드 페이지에서 호출하여 사용됨. form.filepath.value
var form = document.w_form;   // 사용할 폼 이름으로 수정.
 
//에디터호출 - <table> 안에 넣으면 안됨.
var oEditors = [];
nhn.husky.EZCreator.createInIFrame(oEditors, "ir1", "SEditorSkin.html", "createSEditorInIFrame", null, true);
 
//이미지삽입 - 업로드 완료페이지에서 호출됨.
function insertIMG(fname){
  var filepath = form.filepath.value;
  var sHTML = "<img src='" + filepath + "/" + fname + "' style='cursor:hand;' border='0'>";  
    // filepath 는 변수처리 혹은 직접 코딩해도 상관없음. 
    // imageUpload.asp 에서 insertIMG 호출시 경로를 포함하여 넣어주는 방법을 추천.
  oEditors.getById["ir1"].exec("PASTE_HTML", [sHTML]);
}
 
function pasteHTMLDemo(){
  sHTML = "<span style='color:#FF0000'>이미지 등도 이렇게 삽입하면 됩니다.</span>";
  oEditors.getById["ir1"].exec("PASTE_HTML", [sHTML]);
}
 
function showHTML(){
  alert(oEditors.getById["ir1"].getIR());
}
 
function onSubmit(){
  // 에디터의 내용을 에디터 생성시에 사용했던 textarea에 넣어 줍니다.
  oEditors.getById["ir1"].exec("UPDATE_IR_FIELD", []);
 
  // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
  form.content.value = document.getElementById("ir1").value;
 
  if(form.content.value == ""){
    alert("\'내용\'을 입력해 주세요");
    return;
  }
 
  var msg = "전송 하시겠습니까?"
  if(confirm(msg)){
    form.submit();
  }
  return;
}
</script>


<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
	<title>글 작성하기</title>
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
	$boardname = $_GET["boardname"];
	
	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	if($conn->connect_error) {
		die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
	else { }

	//게시판 존재성 모듈
	$sql_boardlist = "select * from board_master where name like '%freeboard%'";
	$result_boardlist = $conn->query($sql_boardlist);
	
	$witness = 0;
	while($row_boardlist = $result_boardlist->fetch_assoc())
	{
	
		if($boardname == $row_boardlist['name'])
		{
			$witness = 1;
			break;
		}
	}

	if($witness == 0)
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>존재하지 않는 게시판입니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}
	//게시판 존재성 모듈 끝

	if(!isset($_GET["boardname"]))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}


	$sql_title = "select alias from board_master where name=\"" . $boardname . "\"";
	$result_title = $conn->query($sql_title);
	

	


	while($row_title = $result_title->fetch_assoc())
	{
		echo "<h2>" . $row_title["alias"] . " - 글 작성하기</h2>";
	}

	echo "<form name=\"writeForm\" action=\"write_ok.php?boardname=" . $boardname . "\" method=\"post\" enctype='multipart/form-data'>";

	echo "<table border=0 width=90% bordercolor=\"white\">";
	echo "<tr>";
	echo "<td width=10% style=\"background-color:#ffcc99\"><font color=black><center>제목</td>";
	echo "<td width=90%><input type=\"text\" id=\"title\" name=\"title\" style=\"width:100%;border:1px solid #ff901e\" /></td></tr>";
	if(isset($_SESSION["user_password"]))
	{

	
		echo "<input type=\"hidden\" id=\"writer\" name=\"writer\" style=\"width:30%;border:1px solid #ff901e\" value=\"" . $_SESSION['user_nickname'] . "\" />";
		echo "<input type=\"hidden\" id=\"password\" name=\"password\" style=\"width:30%;border:1px solid #ff901e\" value=\"MEMBERWRITE\" />";
	}
	else
	{
		echo "<td width=10% style=\"background-color:#ffcc99\"><font color=black><center>작성자</td>";
		echo "<td width=90%><input type=\"text\" id=\"writer\" name=\"writer\" style=\"width:30%;border:1px solid #ff901e\" /></td></tr>";

		echo "<td width=10% style=\"background-color:#ffcc99\"><font color=black><center>비밀번호</td>";
		echo "<td width=90%><input type=\"password\" id=\"password\" name=\"password\" style=\"width:30%;border:1px solid #ff901e\" /></td></tr>";

	}

	

	echo "<tr>";
	echo "<td width=10% style=\"background-color:#ffcc99\"><font color=black><center>내용</td>";
	echo "<input type=\"hidden\" name=\"filepath\" value=\"/file\">";
	echo "<td width=90% height=500><textarea id=\"message\" name=\"message\" style=\"width:100%;height:100%;border:1px solid #ff901e;font-family:맑은 고딕;font-size:12pt\"></textarea>  <textarea id=\"content\" name=\"content\" style=\"display:none\"></textarea> </td></tr>";

	echo "<tr>";
	echo "<td width=10% style=\"background-color:#ffcc99\"><font color=black><center>이미지</td>";
	echo "<td width=90%>";
	echo "<div style='margin:0 30 0 0;float:left'>";
	echo "<div><button type='button' id='getimg1' name='getimg1' class='snip1535_list' style='position:absolute;cursor:pointer;width:130;height:30;margin-bottom:5'>이미지 업로드 1</button>";
	echo "<input type='file' id='imgInp1' name='uploadimg1' style='opacity:0;position:relative;width:130;height:30'/>";
	echo "<button type='button' id='reimg1' name='reimg1' class='snip1535_list' style='width:130;height:30;display:none' onclick='javascript:onImageRe1()'>이미지 제거</button></div>";

	echo "<img id='blah1' src='' alt='' width=130 height=130 style='margin-top:5' border=1 onclick='' />";
	echo "<input type='hidden' id='uploadimg1_ok' name='uploadimg1_ok' value='' readonly/>";
	echo "</div>";

	echo "<div style='margin:0 30 0 0;float:left'>";
	echo "<div><button type='button' id='getimg2' name='getimg2' class='snip1535_list' style='position:absolute;cursor:pointer;width:130;height:30;margin-bottom:5'>이미지 업로드 2</button>";
	echo "<input type='file' id='imgInp2' name='uploadimg2' style='opacity:0;position:relative;width:130;height:30'/>";
	echo "<button type='button' id='reimg2' name='reimg2' class='snip1535_list' style='width:130;height:30;display:none' onclick='javascript:onImageRe2()'>이미지 제거</button></div>";

	echo "<img id='blah2' src='' alt='' width=130 height=130 style='margin-top:5' border=1 onclick='' />";
	echo "<input type='hidden' id='uploadimg2_ok' name='uploadimg2_ok' value='' readonly/>";
	echo "</div>";

	echo "<div style='margin:0 30 0 0;float:left'>";
	echo "<div><button type='button' id='getimg3' name='getimg3' class='snip1535_list' style='position:absolute;cursor:pointer;width:130;height:30;margin-bottom:5'>이미지 업로드 3</button>";
	echo "<input type='file' id='imgInp3' name='uploadimg3' style='opacity:0;position:relative;width:120;height:30'/>";
	echo "<button type='button' id='reimg3' name='reimg3' class='snip1535_list' style='width:130;height:30;display:none' onclick='javascript:onImageRe3()'>이미지 제거</button></div>";

	echo "<img id='blah3' src='' alt='' width=130 height=130 style='margin-top:5' border=1 onclick='' />";
	echo "<input type='hidden' id='uploadimg3_ok' name='uploadimg3_ok' value='' readonly/>";
	echo "</div>";
	echo "</td></tr>";
	
	
	
	echo "</table>";


	echo "<div style=\"width:90%;text-align:right\"><button type='button' onclick=\"javascript:ChkBeforeWrite()\" class=\"snip1535_list\">작성 완료</button>&nbsp;&nbsp&nbsp;";
	echo "<button type='button' onclick=\"javascript:Preview()\" class=\"snip1535_list\">미리보기</button>&nbsp;&nbsp;&nbsp;";
	echo "<button type='button' onclick=\"history.back();\" class=\"snip1535_list\">취소</button></div>";


	echo "</form>";
	
	?>

  </div>

  <div id="footer">
	<?php
	include("../frame_bottom.html");
	?>
  </div>
</div>
</body>

