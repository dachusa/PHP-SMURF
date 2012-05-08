<?php
	print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	print "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
	$rootpath = $_SERVER['DOCUMENT_ROOT'] . "/";
	require_once $rootpath . 'includes/bootstrap.php';
	$findRoot = "SELECT * FROM pages";
	$getRoot = @mysqli_query($connect, $findRoot) or die('query error: ' . mysqli_error($connect));
	while($row = mysqli_fetch_array($getRoot)){
		extract($row);
		print "<url>\n";
		print "<loc>http://siteurl.com/$shortURL</loc>\n";
		if($parent==-1){
			print "<priority>1.0</priority>\n";
			print "<changefreq>hourly</changefreq>\n";
		}
		print "</url>\n";
	}
	print "</urlset>";
?>