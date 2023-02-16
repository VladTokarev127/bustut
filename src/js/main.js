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

	$('.header__search-link').click(function(e) {
		e.preventDefault();
		let parent = $(this).parents('.header__search');
		parent.find('.header__search-form').slideToggle(300);
	});

	$('.js-search').on('keyup', function(e) {
		let target = $(this);
		let val = target.val().toLowerCase();
		let $delay = 500;
		let parent = $(this).parents('.header__search-form');
		clearTimeout(target.data('timer'));
		target.data('timer', setTimeout(function() {
			target.removeData('timer');
			let items = parent.find('.header__search-item');
			items.each(function() {
				$(this).show();
				let text = $(this).text().toLowerCase();
				if (text.indexOf(val) != -1) {
					$(this).show();
				} else {
					$(this).hide();
				}
			})
		}, $delay))
	})

	$('.station__schedule-day span').each(function() {
		if($(this).text() === 'сб' || $(this).text() === 'вс') {
			$(this).addClass('is-holiday');
		}
	});

	if($(window).width() < 768) {
		$('.menu-item-has-children a').click(function(e) {
			e.preventDefault();
			$(this).parent().toggleClass('is-active').find('ul').slideToggle(300);
		})
	} else {
		$('.menu-item-has-children').hover(function() {
			$(this).addClass('is-active').find('ul').stop().slideDown(300);
		}, function() {
			$(this).removeClass('is-active').find('ul').stop().slideUp(300);
		});
	}
	

	$('.header__menu').click(function(e) {
		e.preventDefault();
		$(this).toggleClass('is-active');
		$('.header__nav').toggleClass('is-active');
		$('body').toggleClass('is-fixed');
	})

});
