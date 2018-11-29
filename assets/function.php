<?php
if(@$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'http') {
	header('Location: https://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], TRUE,301); exit;
}
$requri = $_SERVER['REQUEST_URI'];
$requri = preg_replace('/(.*)\?(.*)/', '\1', $requri);
define('REQUEST_URI', $requri);
if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
	$_SERVER['HTTPS'] = 'on';
}
define('REL_URL', ($_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . REQUEST_URI);
define('HOME_URL', ($_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);
function snoopget($url) {
	include_once('snoopy.php');
	$agen = $_SERVER['HTTP_USER_AGENT'];
	$headere = array ('Accept-Language: en-us,en;q=0.7', 'Accept: text/xml,text/javascript,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5');
	$parse = parse_url($url);
	$h = gethostbyname($parse['host']);
	$ref = $parse['scheme'].'://'.$parse['host'].$parse['path'];
	$snoopy = new Snoopy();
	$snoopy->agent = $agen;
	$snoopy->referer = $ref;
	foreach($headere as $hd) {
		$hdr = explode(': ', $hd);
		$snoopy->rawheaders[$hdr[0]] = $hdr[1];
	}
	$snoopy->headers;
	$snoopy->fetch($url);
	$out = $snoopy->results;
	return $out;
}
$garing = substr_count(REQUEST_URI,'/');

if(REQUEST_URI == '/robots.txt') {
	header( 'Content-Type: text/plain' );
	echo "Sitemap: ".HOME_URL."/sitemap-index.xml\r\n";
	echo "Sitemap: ".HOME_URL."/imagesitemap-index.xml\r\n\r\n";
	exit();
}