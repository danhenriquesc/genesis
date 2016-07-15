$(function(){
	$(".sidebarTabs").click(function(){
		var _content = $(this).attr('id').replace("Tab","Area");
		$(".sidebarTabs").removeClass('tabActive');
		$(".settingsArea").css('display','none');
		$(this).addClass('tabActive');
		$("#" + _content).fadeIn();

		_content = _content.replace("Area","");
		$("#lastPageInput").val(_content);
	});
});