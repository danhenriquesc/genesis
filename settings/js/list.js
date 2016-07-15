$(function(){
	$(document).on('click','div.listAdd', function(){
		var _table = $(this).parent().parent().parent().parent().parent();
		var _last;
		_table.find('tbody').append(_table.find('tbody').find('tr:last').clone());
		
		_last = _table.find('tbody').find('tr:last');
		var _n = parseInt(_last.find('td:first').html());

		_last.find('td').each(function(){
			$(this).html($(this).html().replace("["+(_n-1)+"]","["+_n+"]"));
		});
		_last.find('td:first').html(_n+1);
		_last.find('input').val("");

		$('div.listRemove').css('display','');
	});

	$(document).on('click','div.listRemove', function(){
		var _table = $(this).parent().parent().parent().parent().parent();
		var _current = $(this).parent().parent().index();
		var _size = $(this).parent().parent().parent().find('tr').size();
		var _tr = $(this).parent().parent();

		if(_size>1){
			for(var _i = _current+1; _i < _size; _i++){
				_tr.parent().find('tr').eq(_i).find('td').each(function(){
					if($(this).find('input').attr('name') != null){
						$(this).find('input').attr('name', $(this).find('input').attr('name').replace("["+_i+"]","["+(_i-1)+"]"));
					}else if($(this).find('select').attr('name') != null){
						$(this).find('select').attr('name', $(this).find('select').attr('name').replace("["+_i+"]","["+(_i-1)+"]"));
					}
				});
				_tr.parent().find('tr').eq(_i).find('td:first').html(_i);
			}

			_tr.remove();

			if(_size == 2){
				$('div.listRemove').css('display','none');
			}
		}
	});
});

