$(document).ready(function () {
	$('[data-key]').hide()
	$('[data-value]').click(function()
	{
	  $('[data-key = '+$(this).attr('data-value')+']').show()
	  $('[data-id = '+$(this).attr('data-value')+']').hide()
	})
	$('.cancel').click(function()
	{
	  $('[data-id = '+$(this).attr('data-value')+']').show()
	  $('[data-key = '+$(this).attr('data-value')+']').hide()
	})
})