<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo('charset'); ?>">

	<title><?php echo wp_get_document_title(); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="path/to/image.jpg">
	<link rel="shortcut icon" href="" type="image/x-icon">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="x-rim-auto-match" content="none">

	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#000">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#000">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#000">

	<style>body { opacity: 0; overflow-x: hidden; } html { background-color: #fff; }</style>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div class="wrapper">

		<header class="header">
			<div class="container">

				<div class="header__logo">
					<a href="/" class="header__logo-img"><img src="/wp-content/themes/autobus/img/logo.svg" alt=""></a>
					<div class="header__logo-content">
						<div class="header__logo-name">Автовокзал</div>
						<div class="header__search">
							<a href="#" class="header__search-link">Иваново</a>
							<div class="header__search-form">
								<div class="header__search-top">
									<input type="text" class="header__search-input js-search" placeholder="Введите город">
									<button type="button" class="header__search-btn">
										<svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
											<path d="M8.25 14.25C11.5637 14.25 14.25 11.5637 14.25 8.25C14.25 4.93629 11.5637 2.25 8.25 2.25C4.93629 2.25 2.25 4.93629 2.25 8.25C2.25 11.5637 4.93629 14.25 8.25 14.25Z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M15.75 15.75L12.4875 12.4875" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</button>
								</div>
								<div class="header__search-list" data-simplebar>
									<a href="#" class="header__search-item">Иваново</a>
									<a href="#" class="header__search-item">Иваново ЖД</a>
									<a href="#" class="header__search-item">Тейково</a>
									<a href="#" class="header__search-item">Плес</a>
									<a href="#" class="header__search-item">Фурманов КП</a>
									<a href="#" class="header__search-item">Фурманов АП</a>
									<a href="#" class="header__search-item">Вичуга АС</a>
									<a href="#" class="header__search-item">Старая Вичуга АС</a>
									<a href="#" class="header__search-item">Родники АС</a>
									<a href="#" class="header__search-item">Иваново</a>
									<a href="#" class="header__search-item">Иваново ЖД</a>
									<a href="#" class="header__search-item">Тейково</a>
									<a href="#" class="header__search-item">Плес</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="header__nav">
					<nav>
						<ul>
							<li><a href="#">Возврат билета</a></li>
							<li class="menu-item-has-children">
								<a href="#">Пассажирам</a>
								<ul>
									<li><a href="#">Посадка на рейс и возврат билета</a></li>
									<li><a href="#">Расписания автостанций</a></li>
									<li><a href="#">Разработка</a></li>
									<li><a href="#">Администрирование</a></li>
									<li><a href="#">Дизайн</a></li>
									<li><a href="#">Маркетинг</a></li>
									<li><a href="#">Бизнес</a></li>
									<li><a href="#">Личный опыт</a></li>
								</ul>
							</li>
							<li class="menu-item-has-children">
								<a href="#">Поддержка</a>
								<ul>
									<li class="header__nav-tel"><a href="#">8 (800) 700-42-12</a></li>
									<li class="header__nav-faq"><a href="#">Вопросы и ответы</a></li>
								</ul>
							</li>
							<li><a href="#">Контакты</a></li>
						</ul>
					</nav>
				</div>

				<div class="header__loc">
					<div class="header__search">
						<a href="#" class="header__search-link">Иваново</a>
						<div class="header__search-form">
							<div class="header__search-top">
								<input type="text" class="header__search-input js-search" placeholder="Введите город">
								<button type="button" class="header__search-btn">
									<svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
										<path d="M8.25 14.25C11.5637 14.25 14.25 11.5637 14.25 8.25C14.25 4.93629 11.5637 2.25 8.25 2.25C4.93629 2.25 2.25 4.93629 2.25 8.25C2.25 11.5637 4.93629 14.25 8.25 14.25Z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M15.75 15.75L12.4875 12.4875" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</button>
							</div>
							<div class="header__search-list" data-simplebar>
								<a href="#" class="header__search-item">Иваново</a>
								<a href="#" class="header__search-item">Иваново ЖД</a>
								<a href="#" class="header__search-item">Тейково</a>
								<a href="#" class="header__search-item">Плес</a>
								<a href="#" class="header__search-item">Фурманов КП</a>
								<a href="#" class="header__search-item">Фурманов АП</a>
								<a href="#" class="header__search-item">Вичуга АС</a>
								<a href="#" class="header__search-item">Старая Вичуга АС</a>
								<a href="#" class="header__search-item">Родники АС</a>
								<a href="#" class="header__search-item">Иваново</a>
								<a href="#" class="header__search-item">Иваново ЖД</a>
								<a href="#" class="header__search-item">Тейково</a>
								<a href="#" class="header__search-item">Плес</a>
							</div>
						</div>
					</div>
				</div>

				<button class="header__menu">
					<span>Меню</span>
					<span>Закрыть</span>
				</button>

			</div>
		</header>

		<main class="main">