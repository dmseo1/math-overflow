 <!DOCTYPE html>
<html lang="en">

<head>


<script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
   </script>
   <script> w3.includeHTML(); </script>

 <script language="javascript">
	function info_range_apply(frm)
	{
		 var url    ="/member/member_info_range_apply.php";
		 var title  = "회원 정보 수정 완료 - Math Overflow";
	
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

   <title>회원 정보 공개 범위 설정 - Math Overflow</title>

	<!-- 버튼 디자인 -->
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />

   
 <body>
	<form name='apply' action='/member/member_info_range_apply.php' method='post'>
	
	<?php
		echo "<input type='hidden' name='member_no' id='member_no' value='" . $_POST['p_member_no'] . "'/>";
		$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
		$sql = "select info_range, allow_onetoone from member where no=" . $_POST['p_member_no'];
		$result = $conn->query($sql);
		if(!$result) { echo "error!"; return;}
		$info_range = "";
		$range_onetoone = -1;
		while($row = $result->fetch_assoc())
		{
			$info_range = $row['info_range'];
			$range_onetoone = $row['allow_onetoone'];
		}

		$range_profile = substr($info_range, 0, 1);
		$range_activity = substr($info_range, 1, 1);
		$range_footprint_question = substr($info_range, 2, 1);
		$range_footprint_answer = substr($info_range, 3, 1);
		$range_footprint_community = substr($info_range, 4, 1);
		$range_footprint_comment = substr($info_range, 5, 1);

	?>
	<div style="width:90%;margin:auto;margin-top:2%">

	<b>개인 정보</b>
	<table style="width:100%;margin:auto;margin-top:2%">
		<td stlyle="width:25%">
			프로필
		</td>
		<?php
		if($range_profile == 1)
		{
			echo "<td style='width:35%'>
				<input type='radio' name='profile' value='yes' id='profile-yes' checked='checked'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='profile' value='no' id='profile-no'> 비공개
			</td>";
		}
		else
		{
			echo "<td style='width:35%'>
				<input type='radio' name='profile' value='yes' id='profile-yes'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='profile' value='no' id='profile-no' checked='checked'> 비공개
			</td>";
		}
		?>
	</table>

	<table style="width:100%;margin:auto;margin-top:2%">
		<td stlyle="width:25%">
			답변 활동
		</td>
	<?php
		if($range_activity == 1)
		{
			echo "<td style='width:35%'>
				<input type='radio' name='activity' value='yes' id='activity-yes' checked='checked'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='activity' value='no' id='activity-no'> 비공개
			</td>";
		}
		else
		{
			echo "<td style='width:35%'>
				<input type='radio' name='activity' value='yes' id='activity-yes'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='activity' value='no' id='activity-no' checked='checked'> 비공개
			</td>";
		}
		?>
	</table>

	</div>

	<div style="width:90%;margin:auto;margin-top:2%">
	<b>작성한 글/댓글</b>

	<table style="width:100%;margin:auto;margin-top:2%">
	<td stlyle="width:25%">
		질문
	</td>
	<?php
		if($range_footprint_question == 1)
		{
			echo "<td style='width:35%'>
				<input type='radio' name='footprint_question' value='yes' id='footprint_question-yes' checked='checked'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='footprint_question' value='no' id='footprint_question-no'> 비공개
			</td>";
		}
		else
		{
			echo "<td style='width:35%'>
				<input type='radio' name='footprint_question' value='yes' id='footprint_question-yes'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='footprint_question' value='no' id='footprint_question-no' checked='checked'> 비공개
			</td>";
		}
	?>
	</table>

	<table style="width:100%;margin:auto;margin-top:2%">
	<td stlyle="width:25%">
		답변
	</td>
	<?php
		if($range_footprint_answer == 1)
		{
			echo "<td style='width:35%'>
				<input type='radio' name='footprint_answer' value='yes' id='footprint_answer-yes' checked='checked'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='footprint_answer' value='no' id='footprint_answer-no'> 비공개
			</td>";
		}
		else
		{
			echo "<td style='width:35%'>
				<input type='radio' name='footprint_answer' value='yes' id='footprint_answer-yes'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='footprint_answer' value='no' id='footprint_answer-no' checked='checked'> 비공개
			</td>";
		}
	?>
	</table>

	<table style="width:100%;margin:auto;margin-top:2%">
	<td stlyle="width:25%">
		커뮤니티
	</td>
	<?php
		if($range_footprint_community == 1)
		{
			echo "<td style='width:35%'>
				<input type='radio' name='footprint_community' value='yes' id='footprint_community-yes' checked='checked'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='footprint_community' value='no' id='footprint_community-no'> 비공개
			</td>";
		}
		else
		{
			echo "<td style='width:35%'>
				<input type='radio' name='footprint_community' value='yes' id='footprint_community-yes'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='footprint_community' value='no' id='footprint_community-no' checked='checked'> 비공개
			</td>";
		}
	?>
	</table>

	<table style="width:100%;margin:auto;margin-top:2%">
	<td stlyle="width:25%">
		댓글
	</td>
	<?php
		if($range_footprint_comment == 1)
		{
			echo "<td style='width:35%'>
				<input type='radio' name='footprint_comment' value='yes' id='footprint_comment-yes' checked='checked'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='footprint_comment' value='no' id='footprint_comment-no'> 비공개
			</td>";
		}
		else
		{
			echo "<td style='width:35%'>
				<input type='radio' name='footprint_comment' value='yes' id='footprint_comment-yes'> 공개 
			</td>
			<td style='width:35%'>
				<input type='radio' name='footprint_comment' value='no' id='footprint_comment-no' checked='checked'> 비공개
			</td>";
		}
	?>
	</table>

	</div>


	<div style="width:90%;margin:auto;margin-top:2%">
	<b>1:1 질문받기 허용</b>

	<table style="width:100%;margin:auto;margin-top:2%">
	<td stlyle="width:25%">
		1:1 질문받기
	</td>
	<?php
		if($range_onetoone == 1)
		{
			echo "<td style='width:35%'>
				<input type='radio' name='onetoone' value='yes' id='onetoone-yes' checked='checked'> 허용 
			</td>
			<td style='width:35%'>
				<input type='radio' name='onetoone' value='no' id='onetoone-no'> 비허용
			</td>";
		}
		else
		{
			echo "<td style='width:35%'>
				<input type='radio' name='onetoone' value='yes' id='onetoone-yes'> 허용 
			</td>
			<td style='width:35%'>
				<input type='radio' name='onetoone' value='no' id='onetoone-no' checked='checked'> 비허용
			</td>";
		}
	?>
	</table>
	

	</div>

	<div style='width:90%;margin:auto;margin-top:3%'>
		
			<button type='button' style='width:40%' class='snip1535_list' onclick='javascript:info_range_apply(this.form);'>적용</button>&nbsp;&nbsp;&nbsp;
			<button type='button' style='width:40%' class='snip1535_list' onclick='window.close();'>취소</button>
		
	</div>
	</form>
 </body>

</html>
