<script>
var ims = $('.img-main').attr('src');
var err = $('.img-main').attr('onerror');
err = err.replace(/(.*)\.src='(.*)'\;/g, "$2");
var alt = $('.img-main').attr('alt');
var judul = '<?php echo $judul; ?>';
var linkoffer = '<?php echo $offerlnk; ?>';
var offr = '<div id="my-modals" class="modals fade" data-backdrop="static" data-keyboard="false" style="display: block;"><div class="modals-dialog"><div class="modals-content"><div class="modals-header"><h4 class="modals-title">'+judul+'</h4></div><div class="modals-body"><div class="row"><div class="small-12 medium-4 columns text-center"><div class="shadow"><img id="coverImage" src="'+ims+'" alt="'+alt+'" onerror="this.onerror=null;this.src=\''+err+'\';"></div></div><br><p class="text-center">Please create a <span style="color: #ff0000; font-weight: bold;">FREE ACCOUNT</span> to continue <span style="color:#1d64a6;font-weight:bold">reading</span> or <span style="color:#1d64a6;font-weight:bold">download</span>!</p><p class="text-center" style="font-size: 16px; font-weight: bold; color:red;">Start Your FREE Month!!</p><div class="small-12 colums text-center" style="font-size:20px"><a href="'+linkoffer+'" target="_self" rel="nofollow tag" class="btn btn-info" role="button">CREATE MY ACCOUNT NOW</a></div><br><div class="secure text-center"></div></div></div></div></div></div>';
$("footer").append(offr);
$('head').append('<link rel="stylesheet" href="/assets/css/modals.css">');
$("#coverImage").each(function() {
	var aspectRatio = $(this).width()/$(this).height();
	$(this).data("aspect-ratio", aspectRatio);
	// Conditional statement
	if(aspectRatio > 1) {
		// Image is landscape
		$(this).css({
			width: "70%",
			height: "auto"
		});
	} else if (aspectRatio < 1) {
		// Image is portrait
		$(this).css({
			width: "50%",
			height: "auto"
		});
	} else {
		// Image is square
		$(this).css({
			width: "80%",
			height: "auto"
		});            
	}
});
$("body").on("contextmenu",function(e){
	return false;
});
</script>