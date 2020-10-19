<?php
define( 'THEME_SLUG',       'root' );
define( 'THEME_TEXTDOMAIN', 'raten');


add_theme_support('menus');

add_theme_support( 'post-thumbnails' );
function peepsakes_custom_excerpt_length( $length ) {
	return 40;
}

function plural_form($number,$before) {
  $cases = array(2,0,1,1,1,2);
  echo $before[($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)]].'  '.$after[($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)]];
}

function artabr_opengraph_fix_yandex($lang) {
 $lang_prefix = 'prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article#  profile: http://ogp.me/ns/profile# fb: http://ogp.me/ns/fb#"';
 $lang_fix = preg_replace('!prefix="(.*?)"!si', $lang_prefix, $lang);
 return $lang_fix;
 }
add_filter( 'language_attributes', 'artabr_opengraph_fix_yandex',20,1);

add_filter( 'disable_wpseo_json_ld_search', '__return_true' );
remove_action('wp_head','feed_links_extra', 3); // ссылки на дополнительные rss категорий
remove_action('wp_head','feed_links', 2); //ссылки на основной rss и комментарии
remove_action('wp_head','rsd_link');  // для сервиса Really Simple Discovery
remove_action('wp_head','wlwmanifest_link'); // для Windows Live Writer
remove_action('wp_head','wp_generator');  // убирает версию wordpress

remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
 
// убираем разные ссылки при отображении поста - следующая, предыдущая запись, оригинальный url и т.п.
remove_action('wp_head','start_post_rel_link',10,0);
remove_action('wp_head','index_rel_link');
remove_action('wp_head','rel_canonical');
remove_action( 'wp_head','adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head','wp_shortlink_wp_head', 10, 0 );


function new_excerpt_more2($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more2');


if( function_exists('acf_add_options_page') ) {
	
	if(!current_user_can('subscriber'))
	{
	 acf_add_options_page();
	}
}

function my_revisions_to_keep( $revisions ) {
    return 0;
}
add_filter( 'wp_revisions_to_keep', 'my_revisions_to_keep' );

/*
function new_excerpt_length($length) {
	return 10; }
add_filter('excerpt_length', 'new_excerpt_length');*/

function new_excerpt_more($excerpt) {
	return str_replace('[...]', '', $excerpt); }
add_filter('wp_trim_excerpt', 'new_excerpt_more');

function peepsakes_register_my_menus() 
{
    register_nav_menus
    (
        array( 'header-menu' => 'Главное меню', 'footer-menu' => 'Подвал', 'footer-menu-2' => 'Подвал 2' )
    );
}

if (function_exists('register_nav_menus'))
{
	add_action( 'init', 'peepsakes_register_my_menus' );
}

add_filter( 'the_content_more_link', 'peepsakes_my_more_link', 10, 2 );

function peepsakes_my_more_link( $more_link, $more_link_text ) {
	return str_replace( $more_link_text, "$more_link_text", $more_link_text );
}

function nofollow_ext($matches){
 $a = $matches[0];
 $site_url = site_url();
 if (strpos($a, 'rel') === false){
 $a = preg_replace("%(href=\S(?!$site_url))%i", 'rel="nofollow" $1', $a);
 } elseif (preg_match("%href=\S(?!$site_url)%i", $a)){
 $a = preg_replace('/rel=S(?!nofollow)\S*/i', 'rel="nofollow"', $a);
 }
 return $a;
}
 
function nofollow_ext_links($content) {
 return preg_replace_callback('/<a[^>]+/', 'nofollow_ext', $content);
}
 
add_filter('the_content', 'nofollow_ext_links');



/* Подсчет количества посещений страниц 
---------------------------------------------------------- */  
add_action('wp_head', 'kama_postviews');  
function kama_postviews() {  
  
/* ------------ Настройки -------------- */  
$meta_key       = 'views';  // Ключ мета поля, куда будет записываться количество просмотров.  
$who_count      = 1;            // Чьи посещения считать? 0 - Всех. 1 - Только гостей. 2 - Только зарегистрированых пользователей.  
$exclude_bots   = 1;            // Исключить ботов, роботов, пауков и прочую нечесть :)? 0 - нет, пусть тоже считаются. 1 - да, исключить из подсчета.  
/* СТОП настройкам */  
  
global $user_ID, $post;  
    if(is_singular()) {  
        $id = (int)$post->ID;  
        static $post_views = false;  
        if($post_views) return true; // чтобы 1 раз за поток  
        $post_views = (int)get_post_meta($id,$meta_key, true);  
        $should_count = false;  
        switch( (int)$who_count ) {  
            case 0: $should_count = true;  
                break;  
            case 1:  
                if( (int)$user_ID == 0 )  
                    $should_count = true;  
                break;  
            case 2:  
                if( (int)$user_ID > 0 )  
                    $should_count = true;  
                break;  
        }  
        if( (int)$exclude_bots==1 && $should_count ){  
            $useragent = $_SERVER['HTTP_USER_AGENT'];  
            $notbot = "Mozilla|Opera"; //Chrome|Safari|Firefox|Netscape - все равны Mozilla  
            $bot = "Bot/|robot|Slurp/|yahoo"; //Яндекс иногда как Mozilla представляется  
            if ( !preg_match("/$notbot/i", $useragent) || preg_match("!$bot!i", $useragent) )  
                $should_count = false;  
        }  
  
        if($should_count)  
            if( !update_post_meta($id, $meta_key, ($post_views+1)) ) add_post_meta($id, $meta_key, 1, true);  
    }  
    return true;  
}  


function wp_corenavi() {
  global $wp_query;
  $pages = '';
  $max = $wp_query->max_num_pages;
  if (!$current = get_query_var('paged')) $current = 1;
  $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
  $a['total'] = $max;
  $a['current'] = $current;

  $total = 0; //1 - выводить текст "Страница N из N", 0 - не выводить
  $a['mid_size'] = 3; //сколько ссылок показывать слева и справа от текущей
  $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
  $a['prev_text'] = '<span></span>'; //текст ссылки "Предыдущая страница"
  $a['next_text'] = '<span></span>'; //текст ссылки "Следующая страница"

  if ($max > 1) echo '<div class="pagination alignright">';
  if ($total == 1 && $max > 1) $pages = '<span class="pages">Страница ' . $current . ' из ' . $max . '</span>'."\r\n";
  $pa =  $pages . paginate_links($a);

  $pa = str_replace("page/1/", "", $pa);
  echo $pa;
  if ($max > 1) echo '</div>';
}

function dimox_breadcrumbs() {

    /* === ОПЦИИ === */
    $text['home']     = 'Главная'; // текст ссылки "Главная"
    $text['category'] = '%s'; // текст для страницы рубрики
    $text['search']   = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска
    $text['tag']      = 'Записи с тегом "%s"'; // текст для страницы тега
    $text['author']   = 'Статьи автора %s'; // текст для страницы автора
    $text['404']      = 'Ошибка 404'; // текст для страницы 404
    $text['page']     = 'Страница %s'; // текст 'Страница N'
    $text['cpage']    = 'Страница комментариев %s'; // текст 'Страница комментариев N'

    $wrap_before    = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // открывающий тег обертки
    $wrap_after     = '</div><!-- .breadcrumbs -->'; // закрывающий тег обертки
    $sep            = '<span class="sep"></span>'; // разделитель между "крошками"
    $before         = '<span class="breadcrumbs__current">'; // тег перед текущей "крошкой"
    $after          = '</span>'; // тег после текущей "крошки"

    $show_on_home   = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
    $show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
    $show_current   = 1; // 1 - показывать название текущей страницы, 0 - не показывать
    $show_last_sep  = 0; // 1 - показывать последний разделитель, когда название текущей страницы не отображается, 0 - не показывать
    /* === КОНЕЦ ОПЦИЙ === */

    global $post;
    $home_url       = home_url('/');
    $link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
    $link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
    $link          .= '<meta itemprop="position" content="%3$s" />';
    $link          .= '</span>';
    $parent_id      = ( $post ) ? $post->post_parent : '';
    $home_link      = sprintf( $link, $home_url, $text['home'], 1 );

    if ( is_home() || is_front_page() ) {

        if ( $show_on_home ) echo $wrap_before . $home_link . $wrap_after;

    } else {

        $position = 0;

        echo $wrap_before;

        if ( $show_home_link ) {
            $position += 1;
            echo $home_link;
        }

        if ( is_category() ) {
            $parents = get_ancestors( get_query_var('cat'), 'category' );
            foreach ( array_reverse( $parents ) as $cat ) {
                $position += 1;
                if ( $position > 1 ) echo $sep;
                echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
            }
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                $cat = get_query_var('cat');
                echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
                echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_current ) {
                    if ( $position >= 1 ) echo $sep;
                    echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
                } elseif ( $show_last_sep ) echo $sep;
            }

        } elseif ( is_search() ) {
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                if ( $show_home_link ) echo $sep;
                echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
                echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_current ) {
                    if ( $position >= 1 ) echo $sep;
                    echo $before . sprintf( $text['search'], get_search_query() ) . $after;
                } elseif ( $show_last_sep ) echo $sep;
            }

        } elseif ( is_year() ) {
            if ( $show_home_link && $show_current ) echo $sep;
            if ( $show_current ) echo $before . get_the_time('Y') . $after;
            elseif ( $show_home_link && $show_last_sep ) echo $sep;

        } elseif ( is_month() ) {
            if ( $show_home_link ) echo $sep;
            $position += 1;
            echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
            if ( $show_current ) echo $sep . $before . get_the_time('F') . $after;
            elseif ( $show_last_sep ) echo $sep;

        } elseif ( is_day() ) {
            if ( $show_home_link ) echo $sep;
            $position += 1;
            echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
            $position += 1;
            echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
            if ( $show_current ) echo $sep . $before . get_the_time('d') . $after;
            elseif ( $show_last_sep ) echo $sep;

        } elseif ( is_single() && ! is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $position += 1;
                $post_type = get_post_type_object( get_post_type() );
                if ( $position > 1 ) echo $sep;
                echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
                if ( $show_current ) echo $sep . $before . get_the_title() . $after;
                elseif ( $show_last_sep ) echo $sep;
            } else {
                $cat = get_the_category(); $catID = $cat[0]->cat_ID;
                $parents = get_ancestors( $catID, 'category' );
                $parents = array_reverse( $parents );
                $parents[] = $catID;
                foreach ( $parents as $cat ) {
                    $position += 1;
                    if ( $position > 1 ) echo $sep;
                    echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
                }
                if ( get_query_var( 'cpage' ) ) {
                    $position += 1;
                    echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
                    echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
                } else {
                    if ( $show_current ) echo $sep . $before . get_the_title() . $after;
                    elseif ( $show_last_sep ) echo $sep;
                }
            }

        } elseif ( is_post_type_archive() ) {
            $post_type = get_post_type_object( get_post_type() );
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                if ( $position > 1 ) echo $sep;
                echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
                echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_home_link && $show_current ) echo $sep;
                if ( $show_current ) echo $before . $post_type->label . $after;
                elseif ( $show_home_link && $show_last_sep ) echo $sep;
            }

        } elseif ( is_attachment() ) {
            $parent = get_post( $parent_id );
            $cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
            $parents = get_ancestors( $catID, 'category' );
            $parents = array_reverse( $parents );
            $parents[] = $catID;
            foreach ( $parents as $cat ) {
                $position += 1;
                if ( $position > 1 ) echo $sep;
                echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
            }
            $position += 1;
            echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
            if ( $show_current ) echo $sep . $before . get_the_title() . $after;
            elseif ( $show_last_sep ) echo $sep;

        } elseif ( is_page() && ! $parent_id ) {
            if ( $show_home_link && $show_current ) echo $sep;
            if ( $show_current ) echo $before . get_the_title() . $after;
            elseif ( $show_home_link && $show_last_sep ) echo $sep;

        } elseif ( is_page() && $parent_id ) {
            $parents = get_post_ancestors( get_the_ID() );
            foreach ( array_reverse( $parents ) as $pageID ) {
                $position += 1;
                if ( $position > 1 ) echo $sep;
                echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
            }
            if ( $show_current ) echo $sep . $before . get_the_title() . $after;
            elseif ( $show_last_sep ) echo $sep;

        } elseif ( is_tag() ) {
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                $tagID = get_query_var( 'tag_id' );
                echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
                echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_home_link && $show_current ) echo $sep;
                if ( $show_current ) echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
                elseif ( $show_home_link && $show_last_sep ) echo $sep;
            }

        } elseif ( is_author() ) {
            $author = get_userdata( get_query_var( 'author' ) );
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
                echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_home_link && $show_current ) echo $sep;
                if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
                elseif ( $show_home_link && $show_last_sep ) echo $sep;
            }

        } elseif ( is_404() ) {
            if ( $show_home_link && $show_current ) echo $sep;
            if ( $show_current ) echo $before . $text['404'] . $after;
            elseif ( $show_last_sep ) echo $sep;

        } elseif ( has_post_format() && ! is_singular() ) {
            if ( $show_home_link && $show_current ) echo $sep;
            echo get_post_format_string( get_post_format() );
        }

        echo $wrap_after;

    }
} // end of dimox_breadcrumbs()


// Возвращаем сопоставление символов файлам
add_action( 'init', 'classic_smilies_init', 1 );
function classic_smilies_init() {
	global $wpsmiliestrans;
	$wpsmiliestrans = array(
    ':p'        => '20x20-adore.png',
    ':-p'        => '20x20-after_boom.png',  
    '8)'        => '20x20-ah.png',
    '8-)'        => '20x20-amazed.png', 
    ':lang:'      => '20x20-angry.png',
    ':lol:'      => '20x20-bad_smelly.png',
    ':-pp'        => 'smile1.png',  
	);
	add_filter( 'smilies_src', 'classic_smilies_src', 10, 2 );
 
// Отключаем загрузку скриптов и стилей Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );	
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'classic_smilies_rm_tinymce_emoji' );
add_filter( 'the_content', 'classic_smilies_rm_additional_styles', 11 );
add_filter( 'the_excerpt', 'classic_smilies_rm_additional_styles', 11 );
add_filter( 'comment_text', 'classic_smilies_rm_additional_styles', 21 );
}
 
// Отключаем Emoji в визуальном редакторе TinyMCE
function classic_smilies_rm_tinymce_emoji( $plugins ) {
	return array_diff( $plugins, array( 'wpemoji' ) );
}
 
// Убираем размеры смайликов равные 1em (новые задаются для класса .wp-smiley)
function classic_smilies_rm_additional_styles( $content ) {
	return str_replace( 'class="wp-smiley" style="height: 1em; max-height: 1em;"', 'class="wp-smiley"', $content );
}



add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method() {
	// отменяем зарегистрированный jQuery
	wp_deregister_script('jquery-core');
	wp_deregister_script('jquery');

	// регистрируем
	wp_register_script('jquery-core', '//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', false, null, true);
	wp_register_script('jquery', false, array('jquery-core'), null, true);

	// подключаем
	wp_enqueue_script( 'jquery' );
}    

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
// add_action('wp_print_styles', 'theme_name_scripts'); // можно использовать этот хук он более поздний
function theme_name_scripts() {
   /* wp_enqueue_style( 'styles', get_template_directory_uri() . '/css/styles.css', array(), '1.0.0');
    wp_enqueue_style( 'response_1023', get_template_directory_uri() . '/css/response_1023.css', array(), '1.0.0', '(max-width: 1023px)');
    wp_enqueue_style( 'response_767', get_template_directory_uri() . '/css/response_767.css', array(), '1.0.0', '(max-width: 767px)');
    wp_enqueue_style( 'response_479', get_template_directory_uri() . '/css/response_479.css', array(), '1.0.0', '(max-width: 479px)');
    wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/css/fancybox.css', array(), '1.0.0');*/
}




 /* ноиндекс страницы пагинации */
function my_meta_noindex () {
		if (
			is_paged() // Все и любые страницы пагинации
		) {echo "".'<meta name="robots" content="noindex,nofollow" />'."\n";}
	}
add_action('wp_head', 'my_meta_noindex', 3); //


/*Обработка контактной формы */



/* Добавляем адаптивный контейнер для видео */
function alx_embed_html( $html ) {
return '<div class="video-container">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'alx_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'alx_embed_html' ); // Поддержка Jetpack

function div_wrapper($content) {
    // match any iframes
    $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        // wrap matched iframe with div
        $wrappedframe = '<div class="video-container">' . $match . '</div>';

        //replace original iframe with new in content
        $content = str_replace($match, $wrappedframe, $content);
    }

    return $content;    
}
add_filter('the_content', 'div_wrapper');

// canonical для пагинации
function return_canon () {
	$canon_page = get_pagenum_link(0);
	return $canon_page;
}
 
function canon_paged() {
	if (is_paged()) {
		add_filter( 'wpseo_canonical', 'return_canon' );
	}
} 
add_filter('wpseo_head','canon_paged');


/*** удаляем replytocom ***/
function mayak_replycom_remove( $mayak_remove ) {
$cut = "!<a(.*?)href='(.*?)'(.*?)>(.*?)</a>!si";
$insert = "<span class='comment-reply-link' \\3>\\4</span>";
return preg_replace($cut, $insert, $mayak_remove);
}
add_filter( 'comment_reply_link', 'mayak_replycom_remove' );


add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );
function special_nav_class($classes, $item){
    $classes[] = "nav-item"; 
    return $classes;
}




add_action('wp_ajax_form', 'my_action_form');
add_action('wp_ajax_nopriv_form', 'my_action_form');
function my_action_form() {   

    $from          = 'admin@msi-service.info';   

    $title ="Заявка с айта MSI";
    
    if($_POST['name'])
    {
        $body .= "Имя: ".$_POST['name']." \n\n";   
    }

    if($_POST['email'])
    {
        $body .= "E-mail: ".$_POST['email']." \n\n";   
    }

    if($_POST['phone'])
    {
        $body .= "Телефон: ".$_POST['phone']." \n\n";   
    }  

    if($_POST['text'])
    {
        $body .= "Сообщение: ".$_POST['text']." \n\n";   
    }  
    
    $emailTo = get_option("admin_email");    
   
    $subject = $title;   
    
    $headers = 'From: '.$name.' <'.$from.'>' . "\r\n" . 'Reply-To: ' . $email;

    $emailSent =  wp_mail($emailTo, $subject, $body, $headers); 

    if($emailSent == true){
        echo 1; //Ваша заявка принята. Менеджер свяжется с Вами в ближайшее время.
    }
    else
    {
        echo 2; //Сообщение не отправлено...
    }
    // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
    wp_die();
}



function edit_phone($phone){
    $phone =  strip_tags($phone);
    $phone = str_replace("-", "", $phone);
    $phone = str_replace(" ", "", $phone);
    return  $phone;
}

// Функция для изменения имени отправителя
function devise_sender_name( $original_email_from ) {
    return 'MSI';
}

add_filter( 'wp_mail_from_name', 'devise_sender_name' );