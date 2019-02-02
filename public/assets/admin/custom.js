$(function ()
{
	$('.custom-separator').parent().parent().each(function( index )
	{
		$menu_text = $(this).find('.title').html(); 
		$(this).addClass('menu-separator').html('<span class="responsive-separator icon voyager-dot-3"></span><span>' + $menu_text + '</span>'); 
	});
});