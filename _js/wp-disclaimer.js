jQuery(document).ready(function($) {

  // Set cookie expiry, default 1 day
	var cookie_expire = parseInt( $('#wpd-vars').children('#wpd-expire').text() );
	var post_id = parseInt( $('#wpd-vars').children('#wpd-id').text() );
	if(!cookie_expire){ cookie_expire = 1; }
	
  // Check for cookie, otherwise show
  if($.cookie('wpd-'+post_id) == 'agreed'){
    // do nothing
  }else{
  
    // Call fancybox
  	$("#wpd-disclaimer").fancybox({
  		maxWidth	: 800,
  		maxHeight	: 600,
  		fitToView	: false,
  		width		: '70%',
  		height		: 'auto',
  		autoSize	: false,
  		openEffect	: 'none',
  		closeEffect	: 'none',
  		closeBtn : false,
  		closeClick  : false,
  		helpers   : { 
        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
      },
      keys : {
        close  : null
      }
  	}).trigger('click');
  	
  	// Agree button
  	$('#wpd-disclaimer .agree').click(function(){
  		//$.cookie('wpd-'+post_id, 'agreed', { expires: cookie_expire });
  		$.fancybox.close();
  		return false; 
  	});
  	
  	// Disagree button
  	$('#wpd-disclaimer .disagree').click(function(){
  		window.location.href = $(this).attr('href')
  	});
	
	}
	
});