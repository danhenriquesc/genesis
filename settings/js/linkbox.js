$(function(){
	$(document).on('click','div.linkboxMinimize', function(){
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

	$(document).on('click','div.linkboxAdd', function(){
		var _table = $(this).parent().parent().parent().parent().parent();
		var _last;
		_table.children('tbody').append(_table.children('tbody').children('tr:last').clone());
		
		_last = _table.children('tbody').children('tr:last');
		_last.find('input').val("");
		var _n = parseInt(_last.find('table tr td:first').html().replace("Link Box ",""));

		_last.find('table tr td').each(function(){
			$(this).html($(this).html().replace("["+(_n-1)+"]","["+_n+"]"));
		});
		_last.find('table tr td:first').html("Link Box " + (_n+1));
		_last.find('table tr td span').css('display','none');
		
		$('div.linkboxRemove').css('display','inline-block');
	});

	$(document).on('click','div.linkboxRemove', function(){
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
					} else if($(this).find('select').attr('name') != null){
						$(this).find('select').attr('name', $(this).find('select').attr('name').replace("["+_i+"]","["+(_i-1)+"]"));
					} 
				});
				_tr.parent().children('tr').eq(_i).find('td table tr td:first').html("Link Box " + _i);
			}

			_tr.remove();

			if(_size == 2){
				$('div.linkboxRemove').css('display','none');
			}
		}
	});
});