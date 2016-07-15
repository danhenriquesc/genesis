$(function(){
	$(document).on('keyup','div.slideshowOption input.slideshowImageURL', function(){
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
				$(this).parent().find("span").append("<p>This URL is not a valid image or your browser not loaded the image.</p>");
			}
		}
	});

	$(document).on('click','div.slideshowMinimize', function(){
		var _action = $.trim($(this).html());
		var _tbody = $(this).parent().parent().parent().parent().find('tbody');
		if (_action == 'Minimize'){
			_tbody.css('display','none');
			$(this).html('Maximize');
		} else if (_action = 'Maximize'){
			_tbody.css('display','');
			$(this).html('Minimize');
		}
	});

	$(document).on('click','div.slideshowAdd', function(){
		var _table = $(this).parent().parent().parent().parent().parent();
		var _last;
		_table.children('tbody').append(_table.children('tbody').children('tr:last').clone());
		
		_last = _table.children('tbody').children('tr:last');
		var _n = parseInt(_last.find('table tr td:first').html().replace("Slider ",""));

		_last.find('table tr td').each(function(){
			$(this).html($(this).html().replace("["+(_n-1)+"]","["+_n+"]"));
		});
		_last.find('table tr td:first').html("Slider " + (_n+1));
		_last.find('table tr td span').css('display','none');
		
		$('div.slideshowRemove').css('display','inline-block');
	});

	$(document).on('click','div.slideshowRemove', function(){
		var _table = $(this).parent().parent().parent().parent().parent();
		var _current = $(this).parent().parent().parent().parent().parent().parent().index();
		var _size = $(this).parent().parent().parent().parent().parent().parent().parent().children('tr').size();

		var _tr = $(this).parent().parent().parent().parent().parent().parent();

		if(_size>1){
			for(var _i = _current+1; _i < _size; _i++){
				_tr.parent().children('tr').eq(_i).find('td table tr td').each(function(){
					if($(this).find('input').attr('name') != null){
						$(this).find('input').attr('name', $(this).find('input').attr('name').replace("["+_i+"]","["+(_i-1)+"]"));
					} else if($(this).find('textarea').attr('name') != null){
						$(this).find('textarea').attr('name', $(this).find('textarea').attr('name').replace("["+_i+"]","["+(_i-1)+"]"));
					}
				});
				_tr.parent().children('tr').eq(_i).find('td table tr td:first').html("Slider " + _i);
			}

			_tr.remove();

			if(_size == 2){
				$('div.slideshowRemove').css('display','none');
			}
		}
	});
});