<!-------------------------------- write_answer.php --------------------------------->

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

<style type="text/css">
  pdongmin {
     width: 90%;
     display: inline-block;
	 word-break:break-all;
     word-wrap:break-word;
	 white-space:pre-wrap;
	 overflow-wrap:break-word;
	  }
</style>
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


		function PreviewScrollChange_s()
		{

			var gopos = $("#wmd-input").scrollTop();
			gopos = (15 + gopos);
			$("#wmd-preview").scrollTop(gopos);
		
		} 

		
		function PreviewScrollChange()
		{
			
			var gopos = $("#wmd-input").scrollTop();
			gopos = (10 + gopos);
			$("#wmd-preview").scrollTop(gopos);
		
		} 

	</script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.sstatic.net/Js/stub.en.js?v=830f653cea09"></script>
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.sstatic.net/Sites/math/all.css?v=b7f72d8a71cb">
  -->


<script src="https://cdn.sstatic.net/js/third-party/citation-helper.js?v=ff4f467a0a2b"></script>            <script type="text/x-mathjax-config">
                MathJax.Hub.Config({"HTML-CSS": { preferredFont: "TeX", availableFonts: ["STIX","TeX"], linebreaks: { automatic:true }, EqnChunk: (MathJax.Hub.Browser.isMobile ? 10 : 50) },
                    tex2jax: { inlineMath: [ ["$", "$"], ["\\\\(","\\\\)"] ], displayMath: [ ["$$","$$"], ["\\[", "\\]"] ], processEscapes: true, ignoreClass: "tex2jax_ignore|dno" },
                    TeX: { 
                        noUndefined: { attributes: { mathcolor: "red", mathbackground: "#FFEEEE", mathsize: "90%" } }, Macros: { href: "{}" } },
                    messageStyle: "none"
            });
            </script>        
            <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS_HTML-full"></script>  

    <script>
        StackExchange.init({"locale":"en","stackAuthUrl":"https://stackauth.com","networkMetaHostname":"meta.stackexchange.com","serverTime":1496746767,"routeName":"Questions/Ask","site":{"name":"Mathematics Stack Exchange","description":"Q&A for people studying math at any level and professionals in related fields","isNoticesTabEnabled":true,"recaptchaPublicKey":"6LdsB7sSAAAAAAzjgEF_Hd8vXv-C42sa_KyofaGR","recaptchaAudioLang":"en","enableNewTagCreationWarning":true,"insertSpaceAfterNameTabCompletion":false,"id":69,"enableInsertDocLinkDialog":false,"childUrl":"https://math.meta.stackexchange.com","enableSocialMediaInSharePopup":true,"protocol":"https"},"user":{"fkey":"96391f370c10c2b51c26f25418c1425e","rep":1,"isRegistered":true,"userType":3,"userId":452399,"accountId":11046089,"gravatar":"<div class=\"gravatar-wrapper-32\"><img src=\"https://www.gravatar.com/avatar/b7266d3c2c86f18ed8a1b073dbe02251?s=32&amp;d=identicon&amp;r=PG&amp;f=1\" alt=\"\" width=\"32\" height=\"32\"></div>","profileUrl":"https://math.stackexchange.com/users/452399/seodongmin","canSeeDeletedPosts":false,"ab":{"devstory_timeline_exp":{"v":"new_add_item_interaction","g":1}}},"realtime":{"newest":true,"active":true,"tagged":true,"staleDisconnectIntervalInHours":0,"workerIframeDomain":"https://cdn.sstatic.net"},"events":{"postType":{"question":1},"postEditionSection":{"title":1,"body":2,"tags":3}},"story":{"minCompleteBodyLength":75,"likedTagsMaxLength":300,"dislikedTagsMaxLength":300}}, {"site":{"allowImageUploads":true,"enableUserHovercards":true,"enableImgurHttps":true,"forceHttpsImages":true},"comments":{},"userProfile":{},"tags":{},"accounts":{"currentPasswordRequiredForChangingStackIdPassword":true},"flags":{"allowRetractingFlags":true},"snippets":{"renderDomain":"stacksnippets.net"},"markdown":{"asteriskIntraWordEmphasis":true},"monitoring":{"clientTimingsAbsoluteTimeout":30000,"clientTimingsDebounceTimeout":1000}});
        StackExchange.using.setCacheBreakers({"js/prettify-full.en.js":"a402bb3e9e28","js/moderator.en.js":"cbd9a328c047","js/full-anon.en.js":"10a1f993489b","js/full.en.js":"2ae11648a816","js/wmd.en.js":"a05d7b75c3b8","js/third-party/jquery.autocomplete.min.js":"d3b8fa7fdf74","js/third-party/jquery.autocomplete.min.en.js":"","js/mobile.en.js":"834f9e606700","js/help.en.js":"dbd4f489eff2","js/tageditor.en.js":"17e735d9a8ba","js/tageditornew.en.js":"1f0589f50be9","js/inline-tag-editing.en.js":"7581a98341e4","js/revisions.en.js":"2faaeaae2529","js/review.en.js":"82e5893b5290","js/tagsuggestions.en.js":"b278f9a0b23b","js/post-validation.en.js":"422d70c5065f","js/explore-qlist.en.js":"e71f14781288","js/events.en.js":"c8a3946d6fab","js/keyboard-shortcuts.en.js":"6e3c513a7070","js/external-editor.en.js":"e574ed908cf3","js/adops.en.js":"9a6a7812a212","js/mathjax-editing.en.js":"98371812eb54"});
        StackExchange.using("gps", function() {
             StackExchange.gps.init(true);
        });
    </script>
 
        <script>
            StackExchange.ifUsing("editor", function () {
                return StackExchange.using("mathjaxEditing", function () {
                    StackExchange.MarkdownEditor.creationCallbacks.add(function (editor, postfix) {
                        StackExchange.mathjaxEditing.prepareWmdForMathJax(editor, postfix, [["$", "$"], ["\\\\(","\\\\)"]]);
                    });
                });
            }, "mathjax-editing");
        </script>

        

<script>
    StackExchange.ready(function() {
        StackExchange.using("tagEditor", function () { StackExchange.tagEditor.ready.done(initFadingHelpText); });
        initTagRenderer("".split(" "), "".split(" "));
       
        StackExchange.using("externalEditor", function() {
                // Have to fire editor after snippets, if snippets enabled
                if (StackExchange.settings.snippets.snippetsEnabled) {
                    StackExchange.using("snippets", function() {
                        createEditor();
                    });
                }
                else {
                    createEditor();
                }
            });

            function createEditor() {
                StackExchange.prepareEditor({
                    heartbeatType: 'ask',
                convertImagesToLinks: true,
                reputationToPostImages: 10,
                bindNavPrevention: true,
                postfix: "",
noCode: true,                    onDemand: false,
                    discardSelector: ".discard-question"
                    ,immediatelyShowMarkdownHelp:true
                    });
                

        }
    });  
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
			message = message.replace(/(?:\r\n|\r|\n)/g, '<br />');
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
	<title>답변하기</title>
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
	$no = $_GET["no"];
	$part = "";
	
	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	if($conn->connect_error) {
		die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
	else { }


	//게시판 존재성 모듈
	$sql_boardlist = "select * from board_master where name like '%qna%'";
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



	$sql_title = "select alias from board_master where name=\"" . $boardname . "\"";
	$result_title = $conn->query($sql_title);
	
	
	while($row_title = $result_title->fetch_assoc())
	{
		echo "<h2>" . $row_title["alias"] . " - 답변하기</h2>";
	}


	//해당 url로 바로 접근 시도
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
	//해당 url로 바로 접근 시도 끝



	//답변 작성시 회원 여부 체크
	if(!isset($_SESSION['user_email']) || !isset($_SESSION['user_password']))
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>로그인을 하여야 답변 작성이 가능합니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/member/login.html'\">로그인</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}
	//답변 작성시 회원 여부 체크 끝

	//마감된 질문에 답변을 달려고 시도
	$sql_magam = "select isfinished from " . $boardname . " where no=" . $no;
	$result_magam = $conn->query($sql_magam);
	if(!$result_magam || $result_magam->num_rows == 0)
	{
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>잘못된 접근입니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";

		return;
	}
	else
	{	
		while($row_magam = $result_magam->fetch_assoc())
		{
			
			if($row_magam['isfinished'] == 1)
			{
					echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>이미 마감된 질문입니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>

				</tr></table></div>";

				return;
			}
		}
	}

	$sql = "select * from " . $boardname . " where no=" . $no;
	$result = $conn->query($sql);	
	if(!$result || $result->num_rows == 0) //비정상적 접근 시도
	{
		echo "<meta http-equiv='refresh' content='0; url=/error.php'>";
	}
	$origin_title = "";
	$origin_tmemberno = -1;
	while($row = $result->fetch_assoc())
	{
		//본인의 글에는 답변을 달 수 없음
		if($_SESSION['user_member_no'] == $row['member_no'])
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>본인의 글에는 답변을 달 수 없습니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";
			return;
		}

		//이미 답변을 단 게시글에 또다른 답변을 달 수 없음
		$sql_isanswered = "SELECT * from answer_" . $boardname . " where tg_question_no=" . $no . " and member_no=" . $_SESSION['user_member_no'];
		$result_isanswered = $conn->query($sql_isanswered);
		if(!$result_isanswered)
		{
			echo "<meta http-equiv='refresh' content='0; url=/error.php'>";
		}
		else
		{
			if($result_isanswered->num_rows > 0)
			{
				echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
				echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>이미 이 질문에 대한 답변을 작성하였습니다.<br><br></center></td></tr>";
				echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
						<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
						</button></td>

				</tr></table></div>";
				return;
			}
		}

		
		if(strpos($boardname, "onetoone") && $_SESSION['user_member_no'] != $row['to_member'])
		{
			echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
			echo "<table width=100%><tr><td colspan=2 style=\"padding-bottom:50px\"><center>다른 회원에게 전달된 1:1 질문입니다.<br><br></center></td></tr>";
			echo "<tr><td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
					<td width=50%><button style=\"width:100%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
					</button></td>

			</tr></table></div>";
			return;
		}

		echo "<br>";
		if(strpos($boardname, "onetoone"))
				{
				
					$part = $row['part'];
					echo "<table width=90% boarder=0>";
					echo "<tr>";
					echo "<td width=10% style='background:#FFEFD1'><center>질문 분야</center></td>";
					echo "<td width=90%>";
					if($row['part'] == "middle")
						echo "중등 수학";
					else if($row['part'] == "high")
						echo "고등 수학";
					else if($row['part'] == "univ")
						echo "대학 수학";

					echo "</td></tr></table>";
					
				}
		echo "<table width=90% border=0 bgcolor=\"#FFEFD1\">";

		echo "<tr>
			<td width=3%><center>▲</center></td> <td width=5% rowspan=2><center><b><font size=5>" . $row["vote"] . "</font></b></center></td> <td width=92%><font size=4><b><pdongmin>" . $row["title"] . "</pdongmin></font></b></td>
		</tr>";

		echo "<tr>
			<td><center>▼</center></td> <td>조회수: " . $row["hit"] . "</td>
			</tr></table>";
		#이미지 첨부를 했으면~ 이미지를 표시한다
				if($row['imgpath1'] != "")
				{
					echo "<br>";
					echo "<img src='/boards/boardimage/" . $row['imgpath1'] . "' style='max-width:70%'>";
					echo "<br>";
				}
				
				if($row['imgpath2'] != "")
				{
					echo "<br>";
					echo "<img src='/boards/boardimage/" . $row['imgpath2'] . "' style='max-width:70%'>";
					echo "<br>";
				}

				if($row['imgpath3'] != "")
				{
					echo "<br>";
					echo "<img src='/boards/boardimage/" . $row['imgpath3'] . "' style='max_width:70%'>";
					echo "<br>";
				}
		echo "<table width=100% border=0><tr><td style=\"padding-top:50px;padding-bottom:50px\"><pdongmin>" . $row["content"] . "</pdongmin></td></tr></table>";


		echo "<table width=90% border=0>";
		echo "<tr>
				<td width=50% align=\"left\">" . $row["date"] . "</td> <td width=50% align=\"right\">" . $row["writer"] . "</td>
			  </tr>";
		echo "<tr><td colspan=2>" . $row["tags"] . "</td></tr></table>";

		$origin_title = $row["title"];
	}
	



	echo "<br><br><br><form name=\"writeForm\" action=\"write_answer_ok.php?boardname=" . $boardname . "&no=" . $no ."\" method=\"post\" enctype='multipart/form-data'>";
	echo "*이 게시판은 LaTeX 문법을 이용한 작성을 허용합니다. ＄ ＄ 또는 ＄＄ ＄＄ 사이에 내용을 입력하세요.";
	echo "<input type='hidden' name='part' value='" . $part . "' />";
	echo "<table border=0pt width=90% bordercolor=\"white\">";
	echo "<tr>";
	echo "<td width=10% style=\"background-color:#ffcc99\"><font color=black><center>제목</td>";
	echo "<td width=90%><input type=\"text\" id=\"title\" name=\"title\" value=\"Re:" . $origin_title . "\" style=\"width:100%;border:1px solid #ff901e\" /></td></tr>";

	echo "<input type=\"hidden\" id=\"writer\" name=\"writer\" style=\"width:30%;border:1px solid #ff901e\" value=\"" . $_SESSION['user_nickname'] . "\" />";

	echo "<input type=\"hidden\" id=\"password\" name=\"password\" style=\"width:30%;border:1px solid #ff901e\" value=\"MEMBER\" /></td></tr>";

	

	echo "<tr>";
	echo "<td width=10% style=\"background-color:#ffcc99\"><font color=black><center>내용</td>";
echo "<td width=90% height=250><textarea id=\"wmd-input\" name=\"message\" style=\"width:100%;height:250;border:1px solid #ff901e;FONT-FAMILY:맑은 고딕;font-size:12pt\" onkeyup=\"javascript:PreviewScrollChange();\" onscroll=\"javascript:PreviewScrollChange_s();\">" . $origin_content . "</textarea></td></tr>";
	echo "<tr><td style=\"background-color:#ffcc99\"><font color=black><center>미리보기</center></font></td>";
   echo "<td><div id=\"wmd-preview\" style=\"height:250;overflow:auto\" class=\"wmd-preview\"></div></td></tr>";


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
