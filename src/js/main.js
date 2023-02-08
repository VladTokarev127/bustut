$(function() {

	$('[data-show-map]').click(function(e) {
		e.preventDefault();
		$('[data-map]').slideToggle(300);
		$(this).find('span').toggle();
	});

	$('[data-copy]').click(function(e) {
		e.preventDefault();
		$(this).addClass('is-active');
		$(this).find('span:last-child').show();
		$(this).find('span:first-child').hide();
		setTimeout(() => {
			$(this).find('span:last-child').hide();
			$(this).find('span:first-child').show();
			$(this).removeClass('is-active');
		}, 2500);
		let copyText = $(this).data('copy');
		let $temp = $('<input>');
		$('body').append($temp);
		$temp.val(copyText).select();
		document.execCommand('copy');
		$temp.remove();
	});

	$('.station__schedule-day span').each(function() {
		if($(this).text() === 'сб' || $(this).text() === 'вс') {
			$(this).addClass('is-holiday');
		}
	})

});
