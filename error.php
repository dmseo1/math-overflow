 <html>
<head>
<title>에러 페이지</title>


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


<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="framestyle.css" />
</head>

<body>

<div id="wrap">
  <div id="header">
    <?php
	include("frame_top.html");
    ?>
  </div>

  <div id="sidebar">
    <?php
	include("frame_left.html");
    ?>
  </div>

  <div id="content">

	
	<?php
		echo "<div style=\"width:50%;margin-left:100;margin-top:80;margin-bottom:500\">";
		echo "<table width=100% style=\"border-collapse:separate\"><tr><td colspan=2 style=\"padding-bottom:50px\"><center>비정상적인 접근을 시도하였습니다.<br><br></center></td></tr>";
		echo "<tr><td width=50%><button style=\"width:95%\" type=\"button\" class=\"snip1535_list\" onclick=\"location.href='/index.html'\">홈으로</button></td>
				<td width=50%><button style=\"width:95%\" type=\"button\" class=\"snip1535_list\" onclick=\"history.back();\">뒤로
				</button></td>

		</tr></table></div>";
	?>

  </div>



  <div id="footer">
	<?php
	include("frame_bottom.html");
	?>
  </div>
</div>
</body>

