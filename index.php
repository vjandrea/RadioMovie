<?php
	require_once('podcasting.class.php');
?><html>
<head>
	<title>Radio Movie Report</title>
<style>
body {
	background-color: #333;
	color: #FFF;
	margin: 100px;
}
pre {
	background-color: #222;
}
</style>
</head>
</body>
<pre><?php
$feed = new Podcasting("http://podcasting.radiomontecarlo.net/rmc/audio/MonteCarloInTheMusic-rss.xml");
$feed->process('RADIOMOVIE');



//echo $feed->dump_log();

//$feed->dump_xml();

?></pre></body>
</html>