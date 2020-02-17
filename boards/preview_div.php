<html>

<head>

<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js">
MathJax.Hub.Config({
 extensions: ["tex2jax.js","TeX/AMSmath.js","TeX/AMSsymbols.js"],
 jax: ["input/TeX", "output/HTML-CSS"],
 tex2jax: {
     inlineMath: [ ['$','$'], ["\\(","\\)"] ],
     displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
 },
 "HTML-CSS": { availableFonts: ["TeX"] },
  TeX: { equationNumbers: {autoNumber: "AMS"} } //수식번호 옵션
});
</script> 

<script src="/MathJax/MathJax.js">
  MathJax.Hub.Config({
    extensions: ["tex2jax.js"],
    jax: ["input/TeX","output/HTML-CSS"],
    tex2jax: {inlineMath: [["$","$"],["\\(","\\)"]]}
  });
</script>

<meta charset="utf-8">
	<script>

		

	</script>
 <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
</head>

<body>

<div>
<?php
	echo $_GET['message'];




?>
</div>

</body>
</html>
