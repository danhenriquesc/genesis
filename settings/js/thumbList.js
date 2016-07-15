$(function(){
	$("img.thumbListItem").click(function(){
		$(this).parent().find('img.thumbListItem.selected').removeClass('selected');
		$(this).addClass('selected');
		var _value = $(this).attr('value');
		var _sp = _value.split("_");
		$('#' + _sp[0]).val(_sp[1]);
	});
});