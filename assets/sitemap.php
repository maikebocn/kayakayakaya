<?php
header( 'Content-Type: application/xml' );
### format last mod <lastmod>2018-11-22T04:30:30+00:00</lastmod>
echo '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
if(preg_match('#/sitemap\-[\d]{1,}\.xml#', REQUEST_URI)) {
	echo '<?xml-stylesheet type="text/xsl" href="'.HOME_URL.'/sitemap.xsl"?>'."\r\n";
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
       <loc>'.HOME_URL.'/</loc>
       <lastmod>'.date("Y-m-d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>daily</changefreq>
       <priority>1.0000</priority>
  </url>
  ';

	$kwl = glob("assets/kw/*.txt");
	shuffle($kwl);
	$kiweds = file($kwl[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	shuffle($kiweds);
	if(count($kiweds) < $maxmapindex) { $maxmapindex = count($kiweds); }
	for($i=0; $i < $maxmapindex; $i++) {
		$kiwed = strtolower($kiweds[$i]);
		$kiwed = preg_replace('/[^a-z0-9]|\+|\-|_|%20|"|\'/i', ' ', $kiwed);
		$kiwed = preg_replace('/\s\s+/', ' ', $kiwed);
		$kiwed = str_replace(' ', '-', $kiwed);
		echo "
		<url>
		<loc>" . HOME_URL . $permalink . "/" . $kiwed . "</loc>
		<lastmod>".date('Y-m-d')."T".date('H:i:s')."+00:00</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.9</priority>
		</url>
		";
	}
	echo "</urlset>";
}
elseif(REQUEST_URI == '/sitemap-index.xml') {
	echo '<?xml-stylesheet type="text/xsl" href="'.HOME_URL.'/sitemap.xsl"?>'."\r\n";
?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
for($i=0; $i < $maxmapindex; $i++) {
	$a = $i + 1;
echo "<sitemap>
<loc>" . HOME_URL . "/sitemap-" . $a . ".xml</loc>
</sitemap>
";
}
?>
</sitemapindex>
<?php
}
elseif(REQUEST_URI == '/imagesitemap-index.xml') {
	echo '<?xml-stylesheet type="text/xsl" href="'.HOME_URL.'/sitemap.xsl"?>'."\r\n";
?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
for($i=0; $i < $maxmapindex; $i++) {
	$a = $i + 1;
echo "<sitemap>
<loc>" . HOME_URL . "/imagesitemap-" . $a . ".xml</loc>
</sitemap>
";
}
?>
</sitemapindex>
<?php
}
exit();
?>


