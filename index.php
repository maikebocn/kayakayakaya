<?php
error_reporting(0);
ini_set("display_errors", 0);
require_once('assets/function.php');
require_once('config.php');

### Ngelist file keyword
$kwf = glob("assets/kw/*.txt");
$cch = glob("assets/cache/*.html");
shuffle($kwf);
require_once('assets/maper.php');

if(REQUEST_URI == '/' || REQUEST_URI == '/index.php') {
		$judul = $home_title;
}
elseif(preg_match('/\.php/i', REQUEST_URI)) {
	$judul = $home_title;
}
else {
	if($garing == 1) {
		$judul = str_replace('/', '', REQUEST_URI);
	}
	else {
		$judul = explode('/', trim(REQUEST_URI, '/'));
		$judul = end($judul);
	}
	$judul = urldecode($judul);
	$judul = preg_replace('/[^a-z0-9]|\+|\-|_|%20|"|\'/i', ' ', $judul);
}

$cchname = md5($judul);
$filecch = "assets/cache/".$cchname.".html";
$filemap = "assets/cache/".$cchname.".json";

$kw = $judul;

### Membatasi jumlah kata untuk keyword yg dipakai grab bing
### Untuk membatasi 7 kata seting array_slice nya 7
$kw = explode(' ', $kw);
$kw = array_slice($kw, 0, 7);
$kw = implode('+', $kw);

$judul = strtoupper($judul);
if(file_exists($filecch)) {
	$modified = date("D, d M Y H:i:s", filemtime("assets/cache/".$cchname.".html"));
	header("Last-Modified: ".$modified." GMT");
}
echo "<!DOCTYPE html>\n";
?>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $prefix . $judul . $suffix; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?php echo strtolower(REL_URL); ?>" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">
<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
<style>
body{padding-top:70px;}
.container-fluid{max-width:1200px;}
.margin-t-0{margin-top:0;}
.margin-t-h{margin-top:.5em;}
.margin-t-1{margin-top:1em;}
.margin-t-2{margin-top:2em;}
.margin-t-3{margin-top:3em;}
.margin-b-0{margin-bottom:0;}
.margin-b-h{margin-bottom:.5em;}
.margin-b-1{margin-bottom:1em;}
.margin-b-2{margin-bottom:2em;}
.margin-b-3{margin-bottom:3em;}
.margin-tb-0{margin-top:0;margin-bottom:0;}
.margin-tb-h{margin-top:.5em;margin-bottom:.5em;}
.margin-tb-1{margin-top:1em;margin-bottom:1em;}
.margin-tb-2{margin-top:2em;margin-bottom:2em;}
.margin-tb-3{margin-top:3em;margin-bottom:3em;}
h2,h3{text-align-last: left;}
.col-sm-8{text-align:center;}
div.post{clear:both;}
div.post img{margin-bottom:20px;margin-right:1em;}
.tags,.related{text-align: justify;}
.interest{text-align:left;padding: 0px;}
.img-main{width: 100%;}
.img-list{width:220px;height:auto;margin:10px;}
ul.interest{text-align:left;}
ul.interest li{display:inline;margin-right:1em;line-height:1.5em;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!-- Conditional comment containing JS files for IE6 - 8 -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
<?php
    $file_name = 'head.txt';
    $script_head = file_get_contents( $file_name );
    echo $script_head;
    ?>	
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
<span class="sr-only"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="/"><?php echo $home_title; ?></a>
</div>
</div>
</nav>
<div class="container-fluid">
<div class="row">
<?php
$relat = "<div class='related'><h2>Related with ".strtolower($judul)."</h2>\r\n";
$kiweds = file($kwf[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
shuffle($kiweds);
if(count($kiweds) < $maxfoot) {
	$maxfoot = count($kiweds);
}
for($i=0; $i < $maxfoot; $i++) {
	$kiwed = strtolower($kiweds[$i]);
	$kiwed = preg_replace('/[^a-z0-9]|\+|\-|_|%20|"|\'/i', ' ', $kiwed);
	$kiwed = preg_replace('/\s\s+/', ' ', $kiwed);
	$kiwel = str_replace(' ', '-', $kiwed);
	if($i != $maxfoot - 1) {
		$relat .= '<a href="'.$permalink.'/'.$kiwel.'">'.$kiwed.'</a> , ';
	}
	else {
		$relat .= '<a href="'.$permalink.'/'.$kiwel.'">'.$kiwed.'</a>'."\r\n";
	}
}
$relat .= "</div>\r\n";
if(REQUEST_URI == '/' || REQUEST_URI == '/index.php') {
	echo "<h2>".$home_h2."</h2>\r\n";
	$kiweds = file($kwf[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	shuffle($kiweds);
	if(count($kiweds) < $maxhomelink) {
		$maxhomelink = count($kiweds);
	}
	for($i=0; $i < $maxhomelink; $i++) {
		$kiwed = strtolower($kiweds[$i]);
		$kiwed = preg_replace('/[^a-z0-9]|\+|\-|_|%20|"|\'/i', ' ', $kiwed);
		$kiwed = preg_replace('/\s\s+/', ' ', $kiwed);
		$kiwel = str_replace(' ', '-', $kiwed);
		if($i != $maxhomelink - 1) {
			echo '<a href="'.$permalink.'/'.$kiwel.'">'.$kiwed.'</a> , ';
		}
		else {
			echo '<a href="'.$permalink.'/'.$kiwel.'">'.$kiwed.'</a>'."\r\n";
		}
	}
}
else {
	$isi = '';
	$kiweds = file($kwf[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	shuffle($kiweds);
	if(count($kiweds) < $maxtag) {
		$maxtag = count($kiweds);
	}
	$ngetag = '';
	for($i=0; $i < $maxtag; $i++) {
		$kiwed = strtolower($kiweds[$i]);
		$kiwed = preg_replace('/[^a-z0-9]|\+|\-|_|%20|"|\'/i', ' ', $kiwed);
		$kiwed = preg_replace('/\s\s+/', ' ', $kiwed);
		$kiwel = str_replace(' ', '-', $kiwed);
		if($i != $maxtag - 1) {
			$ngetag .= '<a href="'.$permalink.'/'.$kiwel.'">'.$kiwed.'</a> , ';
		}
		else {
			$ngetag .= '<a href="'.$permalink.'/'.$kiwel.'">'.$kiwed.'</a>'."\r\n";
		}
	}

	if(file_exists($filecch)) {
		$handle = fopen($filecch, "r");
		$isi = fread($handle, filesize($filecch));
		fclose($handle);
	}
	else {	
		$isi .= '<div class="col-sm-8">'."\r\n";
		$isi .= '<h1>'.$judul.'</h1>'."\r\n";
		### API 
		$url = 'https://www.bing.com/images/api/custom/search?q='.$kw.'&imageType=Line&count=99&offset=0';
		#$url = 'https://www.bing.com/images/api/custom/search?q='.$kw.'&imageType=Line&aspect=Wide&count=99&offset=0';

		$urlrel = 'https://www.bing.com/AS/Suggestions?pt=page.home&mkt=en-id&qry='.$kw.'&cp=21&cvid=*';
		$urld = 'https://www.bing.com/search?q='.$kw.'&cp=21&cvid=*';

		$a = snoopget($url);
		$j = json_decode($a, 1);
		$dt = $j['value'];
		
		$jsmap = '{"link":"'.REQUEST_URI.'","image":[';
		
		$gambar = $dt[0]['contentUrl'];
		$thm = $dt[0]['thumbnailUrl'];
		$thm = str_replace('&pid=Api', '', $thm);
		$alt = $dt[0]['name'];
		$alt = preg_replace('/(.*) \–(.*)|(.*) \|(.*)|(.*) -(.*)| \.\.\./', '\1', $alt);
		if(!strstr($gambar, 'wp.com') && !strstr($gambar, '?')) {
			$gambar = preg_replace('/http:\/\/|https:\/\//', 'https://i0.wp.com/', $gambar);
		}
		if(strstr($gambar, '?resize')) {
			$gambar = strstr($gambar, '?resize', true);
		}
		if(strstr($gambar, '?fit')) {
			$gambar = strstr($gambar, '?fit', true);
		}
		if(strstr($gambar, '%5C')) {
			$gambar = strstr($gambar, '?', true);
		}
		$gambar = str_replace('&', '&amp;', $gambar);
		$jsmap .= '{"url":"'.$gambar.'", "alt":"'.$alt.'", "err":"'.$thm.'"},';
		$isi .= '<img src="'.$gambar.'" alt="'.$alt.'" onerror="this.onerror=null;this.src=\''.$thm.'\';" class="img-main"/>'."\n";
		
		$isi .= "<div class='tags'><h3>Tags</h3>\r\n";
		$isi .= "###TAGS###";
		$isi .= "</div>\r\n";
		
		$b = snoopget($urlrel);
		$c = snoopget($urld);
		$c = strstr($c, '<ol id="b_results"');
		$c = strstr($c, '<li class="b_pag">', -1);
		$c = preg_replace('/<cite>(.*)<\/cite>|<div class="irphead">(.*?)<\/div><\/div>/sU', '', $c);
		$c = preg_replace('/\d\d\/\d\d\/\d\d\d\d| \.\.\.|…|&nbsp;|&#0183;|&#32;/sU', '', $c);
		$c = preg_replace('/\.\.+/sU', '.', $c);
		$c = preg_replace('/[\.][\w]{2,4}/sui', '', $c);
		$c = strip_tags($c, '<h2>');
		$c = str_ireplace(array("<h2>", "</h2>", "Some results have been removed"), array("<br/>\r\n<strong>", "</strong><br/>", ""), $c);
		$c = preg_replace("/<h2 (.*)>/sUi", "<br/>\r\n<strong>", $c);
		$isi .= "<div class='content-text'>\r\n".$c."\r\n</div>\r\n";
		if(!empty($b)) {
			$b = strip_tags($b, '<div>');
			$b = preg_match_all('#<div (.*?)>(.*?)<\/div>#u', $b, $li, PREG_SET_ORDER);
			if(count($li) > 1) {
				$isi .= '<ul class="interest"><h3>People also interest with</h3>';
				foreach($li as $lis) {
					$ret = preg_replace('/[^a-z0-9]/i', '-', $lis[2]);
					$ret = preg_replace('/--+/', '-', $ret);
					$isi .= '<li><a href="'.$permalink.'/'.$ret.'">'.$lis[2].'</a></li>';
				}
				$isi .= "</ul>\n";
			}
		}		
		for($i=1; $i < count($dt); $i++) {
			$gambar = $dt[$i]['contentUrl'];
			$thm = $dt[$i]['thumbnailUrl'];
			$thm = str_replace('&pid=Api', '', $thm);
			$alt = $dt[$i]['name'];
			$alt = preg_replace('/(.*) \–(.*)|(.*) \|(.*)|(.*) -(.*)| \.\.\./', '\1', $alt);
			if(!strstr($gambar, 'wp.com') && !strstr($gambar, '?')) {
				$gambar = preg_replace('/http:\/\/|https:\/\//', 'https://i0.wp.com/', $gambar);
			}
			if(strstr($gambar, '?resize')) {
				$gambar = strstr($gambar, '?resize', true);
			}
			if(strstr($gambar, '?fit')) {
				$gambar = strstr($gambar, '?fit', true);
			}
			if(strstr($gambar, '%5C')) {
				$gambar = strstr($gambar, '?', true);
			}
			$gambar = str_replace('&', '&amp;', $gambar);
			$jsmap .= '{"url":"'.$gambar.'", "alt":"'.$alt.'"}';
			if($i != count($dt) - 1) {
				$jsmap .= ',';
			}
			$isi .= '<img src="'.$gambar.'" alt="'.$alt.'" onerror="this.onerror=null;this.src=\''.$thm.'\';" class="img-list"/>'."\n";
		}
		$jsmap .= ']}';
		### write cache
		$myfile = fopen("assets/cache/".$cchname.".html", "w");
		fwrite($myfile, $isi);
		fclose($myfile);
		$myjs = fopen("assets/cachemap/".$cchname.".json", "w");
		fwrite($myjs, $jsmap);
		fclose($myjs);
		### end write cache
	}
	$isi = str_replace("###TAGS###", $ngetag, $isi);
	$isi .= $relat;
	echo $isi;	
?>
</div>
<div class="col-sm-4">
<div class="list-group margin-b-3">
<h3>Recent Files</h3>
<?php
$kiweds = file($kwf[2], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
shuffle($kiweds);
if(count($kiweds) < $maxside) {
	$maxside = count($kiweds);
}
for($i=0; $i < $maxside; $i++) {
	$kiwed = strtolower($kiweds[$i]);
	$kiwed = preg_replace('/[^a-z0-9]|\+|\-|_|%20|"|\'/i', ' ', $kiwed);
	$kiwed = preg_replace('/\s\s+/', ' ', $kiwed);
	$kiwel = str_replace(' ', '-', $kiwed);
	echo '<a href="'.$permalink.'/'.$kiwel.'" class="list-group-item">'.$kiwed.'</a>';
}
?>
</div>
</div>
<?php
}
?>
</div>
<hr>
<footer class="margin-tb-3">
Sitemap: <a href="/sitemap-index.xml">index sitemap</a> ,
<a href="/imagesitemap-index.xml">index image sitemap</a>
<div class="row">
<div class="col-lg-12">
<p>Copyright &copy; <?php echo $_SERVER['HTTP_HOST'] ." ".date('Y'); ?></p>
</div>
</div>
</footer>
</div>
<script src="/assets/js/jquery-1.11.2.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<?php
if(REQUEST_URI != "/" && REQUEST_URI != "/index.php" && !preg_match('/bot|crawl|spy|spider|crawl|link|media|partner/isU', $_SERVER['HTTP_USER_AGENT'])) {
	if($popup == 'on') { require_once('assets/popup.php'); }
	if($autosubmit == 'on') { require_once('assets/autosubmit.php'); }
}
?>
<!-- Statcounter code  -->
<script type="text/javascript">var _Hasync= _Hasync|| [];
_Hasync.push(['Histats.start', '1,3616379,4,0,0,0,00010000']);
_Hasync.push(['Histats.fasi', '1']);
_Hasync.push(['Histats.track_hits', '']);
(function() {
var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
hs.src = ('//s10.histats.com/js15_as.js');
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();</script>
<noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?3616379&101" alt="site stats" border="0"></a></noscript>

<!-- End of Statcounter Code -->
</body>
</html>
