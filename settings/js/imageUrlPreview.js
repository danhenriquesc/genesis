$(function(){
	$("div.imageURLOption>input").keyup(function(){
		var _content = $.trim($(this).val());
		var _img = new Image();
		_img.src = _content;

		if(_content==""){
			$(this).parent().find("span").css("display","none");
		}else{
			if(_img.height>0){
				$(this).parent().find("span").css("display","");
				$(this).parent().find("span>img").attr("src",_content);
				$(this).parent().find("span>img").css("display","");
				$(this).parent().find("span>p").remove();
			}else{
				$(this).parent().find("span").css("display","");
				$(this).parent().find("span>img").css("display","none");
				$(this).parent().find("span>p").remove();
				$(this).parent().find("span").append("<p>This URL is not a valid image.</p>");
			}
		}
	});
});