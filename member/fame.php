<html>
<head>
	<title>명예의 전당</title>
 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>


	<script language="javascript">


	window.onload = function(){
 
		
        var x = document.getElementById("adopted_category").selectedIndex;
        var y = document.getElementById("adopted_category").options;
        var z = document.getElementById("adopted_category").value;
 
		if(document.getElementById("adopted_category_d").value == "all")
		{
			y[0].selected = true;
			witness ++;
		}
		else if(document.getElementById("adopted_category_d").value == "middle")
		{
			y[1].selected = true;
			witness ++;
		}
		else if(document.getElementById("adopted_category_d").value == "high")
		{
			
			y[2].selected = true;
			witness ++;
		}
		else if(document.getElementById("adopted_category_d").value == "univ")
		{
			y[3].selected = true;
			witness ++;
		}
		else
		{
			alert("예기치 않은 오류가 발생하였습니다.");
		}
        //순서대로 값을 띄워줍니다.
        //alert("Index: " + y[x].index + " is " + y[x].text+" is " + z);
 
    }

		function Adopted_onChanged(val)
		{
		

			if(val == "all")
			{
				document.getElementById("adopted_category_d").value="all";
				location.href="/member/fame.php?adopted_type=all";
			}
			else if(val == "middle")
			{

				document.getElementById("adopted_category_d").value="middle";
				location.href="/member/fame.php?adopted_type=middle";
			}
			else if(val == "high")
			{	
				
				location.href="/member/fame.php?adopted_type=high";
				document.getElementById("adopted_category_d").value="high";
			}
			else if(val == "univ")
			{
				document.getElementById("adopted_category_d").value="univ";
				location.href="/member/fame.php?adopted_type=univ";
			}
			else
				alert("예기치 않은 오류가 발생하였습니다");
		}
	</script>



<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
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

  <!-- DB 연동 -->
  <?php
	 $adopted_type = $_GET["adopted_type"];
	
	 if($adopted_type == "")
		$adopted_type = "all";


	
	 $conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");

	 if($conn->connect_error) {
		die("MYSQL 연동에 실패하였습니다: " . $conn->connect_error); }
	 else { }
  ?>



	<h2>명예의 전당</h2>
	

	<div style="width:50%;float:left;padding:20 0 250 0">
	<font size=4><b>포인트 랭킹</b></font>
		<table style="width:95%">
			<tr>
				<td style="width:15%">순위</td>
				<td style="width:50%">닉네임</td>
				<td style="width:35%">포인트</td>
			</tr>

			<?php
				$sql_points = "select * from member order by points desc";
				$result_points = $conn->query($sql_points);
				
				$num = 1;
				if($result_points)
				{
					while($row_points = $result_points->fetch_assoc())
					{
						echo "<tr>
								<td>" . $num . "</td>
								<td>" . $row_points["nickname"] . "</td>
								<td>" . $row_points["points"] . "</td></tr>";
						$num++;
					}

				}
				else
				{
					echo "쿼리 에러";
				}
			?>

		</table>
	</div>

	<div style="width:50%;float:left;padding:20 0 250 0">
	<font size=4><b>채택수 랭킹&nbsp;&nbsp;&nbsp;&nbsp;</b></font>

	
		<select id="adopted_category" name="adopted_category" style="border:1px solid #ff901e" onchange="javascript:Adopted_onChanged(this.value);">
				<option value="all">종합</option>
				<option value="middle">중등 포럼</option>
				<option value="high">고등 포럼</option>
				<option value="univ">대학 포럼</option>
		</select>
		<?php
			echo "<input id=\"adopted_category_d\" name=\"adopted_category_d\" type=\"hidden\" value=\"" . $adopted_type . "\" />";
		?>
	



		<table style="width:95%">
			<tr>
				<td style="width:15%">순위</td>
				<td style="width:50%">닉네임</td>
				<td style="width:35%">채택수</td>
			</tr>
	
			<?php
				$sql_adopted = "";
				if($adopted_type == "all")
				{
					$sql_adopted = "select * from member order by mi_adopted+hi_adopted+ui_adopted desc";
				}
				else if($adopted_type == "middle")
				{
					$sql_adopted = "select * from member order by mi_adopted desc";
				}
				else if($adopted_type == "high")
				{
					$sql_adopted = "select * from member order by hi_adopted desc";
				}
				else if($adopted_type == "univ")
				{
					$sql_adopted = "select * from member order by ui_adopted desc";
				}
			
				$result_adopted = $conn->query($sql_adopted);
				
				
				$num = 1;
				if($result_adopted)
				{
					while($row_adopted = $result_adopted->fetch_assoc())
					{

						echo "<tr> <td>" . $num . "</td> <td>" . $row_adopted["nickname"] . "</td>";
						echo "<td>"; 
						echo (($adopted_type == "all" || $adopted_type == "middle") ? $row_adopted["mi_adopted"] : 0 ) + 
									(($adopted_type == "all" || $adopted_type == "high") ? $row_adopted["hi_adopted"] : 0 ) + 	
									(($adopted_type == "all" || $adopted_type == "univ") ? $row_adopted["ui_adopted"] : 0 );
						echo "</td></tr>";
						$num ++;
					}
				}
				else
				{
					echo "쿼리 에러";
				}
			?>
		</table>

		</div>
  </div>

  <div id="footer">
	<?php
	include("../frame_bottom.html");
	?>
  </div>
</div>
</body>
