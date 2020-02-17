<html>

<head>
<meta charset="utf-8">
<script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>



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

	<link rel="stylesheet" type="text/css" href="/framestyle.css" />
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
	<title>preview</title>

</head>

<body>
	<?php
		$title = $_GET['title'];
		$message = $_GET['message'];
	
		echo "<table width=95% border=1 style=\"margin:auto;margin-top:10;border-collapse:collapse;border:1px black solid;\">";
		echo "<tr>";
		echo "<td width=10%>제목</td>";
		echo "<td width=90%><pdongmin>" . $title . "</pdongmin></td></tr>";
		echo "<tr>";
		echo "<td width=10%>내용</td>";
		echo "<td width=90%><pdongmin>" . $message . "</pdongmin></td></tr></table>";
		echo "<div style=\"width:100%;margin:auto;margin-top:10;margin-left:100\"><button type='button' onclick='window.close()' style=\"width:300;margin-top:10\" class=\"snip1535_list\"> 닫기 </button></div>";
	?>

</body>


