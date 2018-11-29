<?php
# https://www.bing.com/webmaster/ping.aspx?siteMap=
# https://www.google.com/webmasters/sitemaps/ping?sitemap=
$rsub = fopen("assets/count.txt", "r");
$visit = fread($rsub, filesize("assets/count.txt"));
fclose($rsub);

$visit = $visit + 1;
if($visit == $freqsubmit) {
	echo '<iframe src="https://www.google.com/webmasters/sitemaps/ping?sitemap='.HOME_URL.'/sitemap-index.xml" style="height:1px;width:1px;visibility: hidden;"></iframe>';
	echo '<iframe src="https://www.google.com/webmasters/sitemaps/ping?sitemap='.HOME_URL.'/imagesitemap-index.xml" style="height:1px;width:1px;visibility: hidden;"></iframe>';
	echo '<iframe src="https://www.bing.com/webmaster/ping.aspx?siteMap='.HOME_URL.'/sitemap-index.xml" style="height:1px;width:1px;visibility: hidden;"></iframe>';
	echo '<iframe src="https://www.bing.com/webmaster/ping.aspx?siteMap='.HOME_URL.'/imagesitemap-index.xml" style="height:1px;width:1px;visibility: hidden;"></iframe>';
	$visit = 0;
}
		
$asub = fopen("assets/count.txt", "w");
fwrite($asub, $visit);
fclose($asub);
