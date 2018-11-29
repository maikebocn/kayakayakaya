<?php
header( 'Content-Type: application/xml' );
echo '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
echo '<?xml-stylesheet type="text/xsl" href="/mod-sitemap.xsl"?>'."\r\n";
$kwl = glob("assets/cachemap/*.json");
shuffle($kwl);
if(count($kwl) < $maxpostimagemap) {
	$max = count($kwl);
}
else {
	$max = $maxpostimagemap;
}
?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xmlns:xhtml="http://www.w3.org/1999/xhtml"
      xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
      xsi:schemaLocation="
            http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php
for($i=0; $i < $max; $i++) {
	$mjs = file_get_contents($kwl[$i]);
	$mjs = json_decode($mjs, 1);
	$imgc = count($mjs['image']);
	$link = explode('/', $mjs['link']);
	$link = end($link);
	if(!empty($link)) {
?>
  <url>
       <loc><?php echo HOME_URL . $permalink . '/' . $link; ?></loc>
       <lastmod><?php echo date("Y-m-d").'T'.date("H:i:s");?>+00:00</lastmod>
       <changefreq>daily</changefreq>
       <priority>1.0000</priority>
	   <?php
	   for($x=0; $x < $imgc; $x++) {
	   ?>
		<image:image>
         <image:loc><?php echo $mjs['image'][$x]['url']; ?></image:loc>
		<?php
		if($mjs['image'][$x]['alt'] != '') {
		?>
			<image:caption><![CDATA[<?php echo $mjs['image'][$x]['alt']; ?>]]></image:caption>
			<image:title><![CDATA[<?php echo $mjs['image'][$x]['alt']; ?>]]></image:title>
			<?php
		 }
		 ?>
		</image:image>
		<?php
	   }
	   ?>
  </url>
<?php
	}
}
?>
</urlset>
<?php
exit();
?>