<?php
if(preg_match('#/sitemap\-[\d]{1,}\.xml#', REQUEST_URI)) {
	include('sitemap.php');
}
if(preg_match('#/imagesitemap\-[\d]{1,}\.xml#', REQUEST_URI)) {
	include('imagemap.php');
}
if(REQUEST_URI == '/sitemap-index.xml') {
	include('sitemap.php');
}
if(REQUEST_URI == '/imagesitemap-index.xml') {
	include('sitemap.php');
}
