<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<!-- Адаптирование страницы для мобильных устройств -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Запрет распознования номера телефона -->
	<meta name="format-detection" content="telephone=no">
	<meta name="SKYPE_TOOLBAR" content ="SKYPE_TOOLBAR_PARSER_COMPATIBLE">

	<!-- Заголовок страницы -->
	<title>Заголовок страницы</title>

	<!-- Традиционная иконка сайта, размер 16x16, прозрачность поддерживается. Рекомендуемый формат: .ico или .png -->
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.png">

	<!-- Изменение цвета панели моб. браузера -->
	<meta name="msapplication-TileColor" content="#45d62d">
	<meta name="theme-color" content="#45d62d">

	<!-- Подключение файлов стилей -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/fancybox.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/styles.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/response_1179.css" media="(max-width: 1179px)">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/response_1023.css" media="(max-width: 1023px)">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/response_767.css" media="(max-width: 767px)">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/response_479.css" media="(max-width: 479px)">
	<?php wp_head(); ?>
</head>

<body>
	<div class="wrap">
		<div class="main">
			<header>
				<div class="info">
					<div class="cont row">

						<button class="mob_menu_btn">
							<span></span>
						</button>

						<a href="<?php bloginfo('siteurl'); ?>" class="logo">
							<img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="">
							<div class="desc">Официальный<br> Сервисный центр</div>
						</a>

						<nav class="menu row">
							<?php wp_nav_menu ( array ( 'theme_location'  => 'header-menu',  
		                        'menu'            => '',   
		                        'container'       => '',   
		                        'container_class' => '',   
		                        'container_id'    => '',  
		                        'menu_class'      => 'menu',   
		                        'menu_id'         => '',  
		                        'echo'            => true,  
		                        'fallback_cb'     => 'wp_page_menu',  
		                        'before'          => '',  
		                        'after'           => '',  
		                        'link_before'     => '',  
		                        'link_after'      => '',  
		                        'depth'           => 0 ,  
		                        'items_wrap'      => '%3$s',                   
		                        ) );  ?> 
						</nav>

						<div class="phone">
							<svg class="icon"><use xlink:href="<?php bloginfo('template_url'); ?>/images/sprite.svg#ic_phone"></use></svg>
							<a href="tel:<?php echo edit_phone(get_field("phone", "option"));?>"><?php the_field("phone", "option"); ?></a>
						</div>

						<a href="tel:<?php echo edit_phone(get_field("phone", "option"));?>" class="mob_phone">
							<svg class="icon"><use xlink:href="<?php bloginfo('template_url'); ?>/images/sprite.svg#ic_phone"></use></svg>
						</a>

					</div>
				</div>
			</header>