<?php
/**
 * chiro-schelle functions and definitions
 *
 * @package chiro-schelle
 */

require_once('classes/UserMapper.php');

if ( ! function_exists( 'chiro_schelle_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function chiro_schelle_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on chiro-schelle, use a find and replace
	 * to change 'chiro-schelle' to the name of your theme in all the template files
	 */
	//load_theme_textdomain( 'chiro-schelle', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'chiro-schelle' ),
		'info' => esc_html__( 'Info Menu', 'chiro-schelle' ),
		'footer' => esc_html__( 'Footer Menu', 'chiro-schelle' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );
}
endif; // chiro_schelle_setup
add_action( 'after_setup_theme', 'chiro_schelle_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function chiro_schelle_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'chiro_schelle_content_width', 640 );
}
add_action( 'after_setup_theme', 'chiro_schelle_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function chiro_schelle_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'chiro-schelle' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'chiro_schelle_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function chiro_schelle_scripts() {
	wp_enqueue_style( 'chiro-schelle-style', get_stylesheet_uri() );

	wp_enqueue_script( 'chiro-schelle-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'chiro-schelle-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'chiro_schelle_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

add_image_size('avatar', 180, 180, 1);


/**
 * Standaardfiguurtje laten zien als er geen thumbnail is
 */
$aantal = 7;
$i=rand(1,$aantal);
$gebruikt = array();

function chiroschelle_show_default_thumb($archive=0){
	global $i;
	global $gebruikt;
	global $aantal;

	array_push($gebruikt,$i);
	$j = 0;
	while (in_array($i, $gebruikt)) {
   		$i = rand(1,$aantal);
		$j = $j +1;

		if ($j == 7){
			break;
			}
		$i = rand(1,$aantal);
	}

		$imgpath = get_bloginfo('template_url') . "/img/thumbs/thumb_" .	$i .".jpg";

	return "<img class=\"thumb\" src='$imgpath' />";
}


function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body row">
	<?php endif; ?>
	
	<div class="row">
		<div class="avatar col-xs-2">
			<?php echo get_avatar( $comment, 60); ?>
		</div>
		<div class="comment-author vcard col-xs-10">
			<div class="author-name"><?php echo get_comment_author_link(); ?></div>
			<div class="comment-meta commentmetadata">
				op <?php echo get_comment_date() . ' ' . get_comment_time(); ?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="content col-xs-9 col-xs-offset-2 col-md-10">
			<div class="content-body">
				<?php comment_text(); ?>
			</div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => 2 ) ) ); ?>
			</div>

		</div>
	</div>


	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
		<br />
	<?php endif; ?>

	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

/*
Geef user id terug
*/

function get_user_id($meta_key, $meta_value){
	global $wpdb;
	$table_name = $wpdb->prefix . "usermeta";
	$sql = "SELECT DISTINCT user_id as ID  FROM " . $table_name ." WHERE `meta_key` LIKE '". $meta_key ."' AND meta_value LIKE '". $meta_value . "';";
	$result = $wpdb->get_results($sql);
	$i = 0;
	foreach ($result as $row){
		$ids[$i] = $row->ID;
		$i++;
	}
	return $ids;
}

function maaknummerafdeling($afdeling) {
	switch ($afdeling) {
	case 0:
    	$afdeling = 'geen';
	    break;
	case 1:
	   $afdeling = 'Ribbel Jongens';
	    break;
	case 2:
    	$afdeling = 'Ribbel Meisjes';
	    break;
	case 3:
		$afdeling = 'Speelclub Jongens';
    	break;
	case 4:
		$afdeling = 'Speelclub Meisjes';
    	break;
	case 5:
		$afdeling = 'Rakkers';
    	break;
	case 6:
		$afdeling = 'Kwiks';
    	break;
	case 7:
		$afdeling = 'Toppers';
    	break;
	case 8:
		$afdeling = 'Tippers';
    	break;
	case 9:
		$afdeling = 'Kerels';
    	break;
	case 10:
		$afdeling = 'Tiptiens';
    	break;
	case 11:
		$afdeling = 'Aspi Jongens';
    	break;
	case 12:
		$afdeling = 'Aspi Meisjes';
    	break;
	case 13:
		$afdeling = 'IEDEREEN';
		break;
	case 14:
		$afdeling = 'Leiding';
		break;
	case 15:
		$afdeling = 'Muziekkapel';
		break;
	case 16:
	    $afdeling = 'Tikeas';
	    break;
	case 17:
		$afdeling = "Activiteiten";
		}
		return $afdeling;
}

function sort_op_afdeling($user_id, $afdeling){
	global  $wpdb;
	$table_name = $wpdb->prefix . "usermeta";
	$where = "WHERE meta_key LIKE 'afdeling' AND meta_value = $afdeling AND ( ";
	$i = 0;
	foreach ($user_id as $id){
		if ($i>0){
			$where .= " OR ";

		}

		$where .= "user_id = '$id'";
		$i++;
	}

	$where .= ")";
	$sql = "SELECT DISTINCT user_id as ID, meta_value as afdeling FROM $table_name $where ORDER BY afdeling;";



	$result = $wpdb->get_results($sql);
	$i = 0;

	foreach ($result as $row){

		$users[$i] =  $row->ID;

		$i++;

	}
	return $users;
}

#Creëer de kalender:

# PHP Calendar (version 2.3), written by Keith Devens
# http://keithdevens.com/software/php_calendar
#  see example at http://keithdevens.com/weblog
# License: http://keithdevens.com/software/license

function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){
    $first_of_month = gmmktime(0,0,0,$month,1,$year);
    #remember that mktime will automatically correct if invalid dates are entered
    # for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
    # this provides a built in "rounding" feature to generate_calendar()

    $day_names = array(); #generate all the day names according to the current locale
    for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
        $day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name

    list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
    $weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
    $title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names

    #Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03
    @list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable
    if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;';
    if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';
    $calendar = '<table class="calendar">'."\n".
        '<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";

    if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
        #if day_name_length is >3, the full name of the day will be printed
        foreach($day_names as $d)
            $calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
        $calendar .= "</tr>\n<tr>";
    }

    if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
    for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
        if($weekday == 7){
            $weekday   = 0; #start a new week
            $calendar .= "</tr>\n<tr>";
        }
        if(isset($days[$day]) and is_array($days[$day])){
            @list($link, $classes, $content) = $days[$day];
            if(is_null($content))  $content  = $day;
            $calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
                ($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
        }
        else $calendar .= "<td>$day</td>";
    }
    if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days

    return $calendar."</tr>\n</table>\n";
}

#verander formaat van een getal in 01-99, 100-...
function maaktweecijfer($n) {
	switch (strlen($n)){
	case 1:
		$n = '0'.$n;
		break;
	case 2:
		$n = $n;
		break;
	default:
		$n = '';
		break;
	}
	return $n;
}

function maakeencijfer($n) {
	switch (strlen($n)){
	case 1:
		$n = $n;
		break;
	case 2:
		switch ($n) {
			case 1:
			$n = 1;
			break;
			case 2:
			$n = 2;
			break;
			case 3:
			$n = 3;
			break;
			case 4:
			$n = 4;
			break;
			case 5:
			$n = 5;
			break;
			case 6:
			$n = 6;
			break;
			case 7:
			$n=7;
			break;
			case 8:
			$n = 8;
			break;
			case 9:
			$n=9;
			break;
			default:
			$n=$n;
			break;
			}
		break;
	default:
		$n = '';
		break;
	}
	return $n;
}

// Add a default avatar to Settings > Discussion
if ( !function_exists('fb_addgravatar') ) {
	function fb_addgravatar( $avatar_defaults ) {
		$myavatar = 'http://media.chiroschelle.be/2015/12/28173837/avatar.png';
		$avatar_defaults[$myavatar] = 'Chiro Schelle';

		return $avatar_defaults;
	}

	add_filter( 'avatar_defaults', 'fb_addgravatar' );
} 

add_filter( 'jetpack_open_graph_image_default', 'example_change_default_image' );
function example_change_default_image( $image ) {
    return 'http://chiroschelle.be/wp-content/themes/chiroschelle15/img/opengraph.jpg';
}

?>