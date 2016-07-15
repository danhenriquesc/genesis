$(function() {
    $("div#responsive_menu_button").click(function(){
    	status = $("div#responsive_menu").css('display');
    	if(status !== "none"){
    		$("div#responsive_menu").slideUp(200,function(){
    			$(this).css('display','none');
    		});
    	}else{
    		$("div#responsive_menu").slideDown(200).css('display','block');
    	}
    });

    $(window).on('resize', function(){
    	   var menu = $("div#responsive_menu");

		   // reset width and height
		   vW = $(window).width();
		   vH = $(window).height();

		   // closing mobile menu if width >= 768
		   if (vW >= '768') {
		    	menu.css('display','none');
		   }
	 });
});