<?php
/**
 * @package WordPress
 * @subpackage Chiro_Schelle
 * Code by Mante & Jo & Ben
 */
require_once('functions_clean.php');

/**
Thumbnail support voor bij posts
**/
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-thumbnails', array( 'post', 'page' ) ); // Add it for posts and pages


/**
Verwijder default style bij foto-galleries
**/
//add_filter('gallery_style', create_function('$a', 'return preg_replace("%<style type=\'text/css\'>(.*?)</style>%s", "", $a);'));

/**
Sidebar en viavia widget support
**/
if ( function_exists('register_sidebar') ){
	register_sidebar(array('name'=>'links',));
	register_sidebar(array('name'=>'midden',));
	register_sidebar(array('name'=>'rechts',));
	register_sidebar(array('name'=>'kijker',));
}



/*function getImage($num) {
	global $more;
	$more = 1;
	$link = get_permalink();
	$content = get_the_content();
	$count = substr_count($content, '<img');
	$start = 0;
	for($i=1;$i<=$count;$i++) {
	$imgBeg = strpos($content, '<img', $start);
	$post1 = substr($content, $imgBeg);
	$imgEnd = strpos($post1, '>');
	$postOutput = substr($post1, 0, $imgEnd+1);
	$postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', '',$postOutput);;
	$image[$i] = $postOutput;
	$start=$imgEnd+1;
	}
	$j = 0;
	if(stristr($image[$num],'<img')) {
		$imgarray[$j] = $image[$num];
		$j++;
	}
	$more = 0;
	return $imgarray;
}*/

/**
User rank en afdeling ophalen en weergeven
**/

function get_user_rankafdeling($user_id, $toonrank=1, $toonafdeling=1, $symbolen=0){
	$user_info = get_userdata($user_id);
	// maaknummerafdeling zit in een plugin (vragenlijst waarschijnlijk). --Ben 09/12/2011
	$afdeling = function_exists('maaknummerafdeling') ? maaknummerafdeling($user_info->afdeling) : 'sympathisant';
	$rank = get_rank($user_id);

	if ($symbolen==1){
		switch ($afdeling){
			case 'Ribbel Meisjes':
				$afdeling = '<span class="symbool">Ribbel &#9792;</span>';
				break;
			case 'Ribbel Jongens':
				$afdeling = '<span class="symbool">Ribbel &#9794;</span>';
				break;
			case 'Speelclub Meisjes':
				$afdeling = '<span class="symbool">Speelclub &#9792;</span>';
				break;
			case 'Speelclub Jongens':
				$afdeling = '<span class="symbool">Speelclub &#9794;</span>';
				break;
		}
	}

	if (($afdeling == 'sympathisant') || ($afdeling == 'VeeBee') )//|| ($rank='geen'))// || ($rank == 'VB'))
			$toonafdeling=0;

	if ($toonrank==1 && $toonafdeling ==1) {
		echo $rank ."<br/>". $afdeling;
	}elseif ($toonrank == 1) {
		echo $rank;
	}elseif ($toonafdeling==1){
			echo $afdeling;
	}

}

/*
rank ophalen en er byleiding van maken
*/

function byleiding($user_id){
	if (user_id_can('rank_vb', $user_id)){
		return "byvb";
	}
	if (user_id_can('rank_leiding', $user_id)){
		return "byleiding";
	}

}

/*
Commentaar weergeven
*/
function delete_comment_link($id) {
  if (current_user_can('edit_post')) {
	echo " - ";
    echo '<a href="'.admin_url("comment.php?action=cdc&c=$id").'">delete</a>';
	echo " - ";
    echo '<a href="'.admin_url("comment.php?action=cdc&dt=spam&c=$id").'">spam</a>';
	//echo " - ";
  }
}

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(byleiding(get_comment(get_comment_ID())->user_id)); ?> id="li-comment-<?php comment_ID() ?>">
  <div class="nobr" id="comment-<?php comment_ID(); ?>">
    <div class="comment-author vcard">
      <div class="commentauteur">
        <?php //comment_author();?>
        <?php
			
			$comment_author_id = get_comment(get_comment_ID())->user_id;
			
			if ($comment_author_id == 0){
				comment_author();
			}elseif (user_id_can('rank_leiding',$comment_author_id) ){ ?>
        <a href="<?php bloginfo("url"); echo "/author/"; the_author_meta(user_login, get_comment(get_comment_ID())->user_id );?>">
        <?php
                		the_author_meta(first_name, get_comment(get_comment_ID())->user_id );				
						//comment_author();
						?>
        </a>
        <?php }else{ 
					 comment_author();
                   
			}?>
      </div>
      <?php
			if(get_comment(get_comment_ID())->user_id){ //indien gast, geen rankafdeling weergeven
				if(!VERBERG_AFDELING){ // door ben toegevoeg op 19 aug 2010, reden: overgangen
  				get_user_rankafdeling(get_comment(get_comment_ID())->user_id, 1, 1, 1);
  			}
			}
            ?>
      <div class="commentimg">
        <?php
		  if ($comment_author_id == 0){
				echo get_avatar($comment,$size='');
			}elseif (user_id_can('rank_leiding',$comment_author_id)){ ?>
        <a href="<?php bloginfo("url"); echo "/author/"; the_author_meta(user_login, get_comment(get_comment_ID())->user_id );?>"> <?php echo get_avatar($comment,$size='');?> </a>
        <?php }else{ 
					echo get_avatar($comment,$size='');
			}?>
      </div>
      <div class="commentdatum">
        <?php comment_date('d/m/y - H:i');?>
      </div>
    </div>
    <?php if ($comment->comment_approved == '0') : ?>
    <em>
    <?php _e('Je reactie wacht op goedkeuring.') ?>
    </em> <br />
    <?php endif; ?>
    <div class="reply">
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <div class="commentedit">
      <?php edit_comment_link(__('bewerk'),'','') ?>
      <?php delete_comment_link(get_comment_ID()); ?>
    </div>
    <?php comment_text() ?>
  </div>
  <?php
        }


/* Copyright */

function copyright(){
	echo "<li>";
	echo "<h2 class=\"widgettitlecopy\">Over deze site</h2>";
	echo "<ul>";
	echo "<li>";
	echo "&copy; Chiro Schelle " . date('Y');?>
  <p>Gemaakt door: Mante - Jo &amp; Ben</p>
  <?php echo "</li></ul></li>";
}



#Cre�er de kalender:

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





/* extra velden op registratie-pagina */


// This function shows the form fiend on registration page
add_action('register_form','show_first_name_field');

// This is a check to see if you want to make a field required
add_action('register_post','check_fields',10,3);

// This inserts the data
add_action('user_register', 'register_extra_fields');

// This is the forms The Two forms that will be added to the wp register page
function show_first_name_field(){


// First Name Field
?>
  <h3>Verplichte info</h3>
  <br />
  <p>
    <label>Voornaam<br />
      <input id="user_email" class="input" type="text" tabindex="20" size="25" value="<?php echo $_POST['first']; ?>" name="first"/>
    </label>
  </p>
  <?php
// Last Name Field
?>
  <p>
    <label>Achternaam<br />
      <input id="user_email" class="input" type="text" tabindex="20" size="25" value="<?php echo $_POST['last']; ?>" name="last"/>
    </label>
  </p>
  <p>
    <label>Ik ben een<br />
      <br/>
      <select name="afdeling" id="afdeling">
        <option value="0">kies hier</option>
        <option value="20" <?php if ($_POST['afdeling'] == 20) {echo 'selected="selected"';} ?>>Sympathisant</option>
        <option value="18" <?php if ($_POST['afdeling'] == 18) {echo 'selected="selected"';} ?>>Oudleiding</option>
        <option value="0">----------</option>
        <option value="1" <?php if ($_POST['afdeling'] == 1) {echo 'selected="selected"';} ?>>Ribbel Jongen</option>
        <option value="2" <?php if ($_POST['afdeling'] == 2) {echo 'selected="selected"';} ?>>Ribbel Meisje</option>
        <option value="3" <?php if ($_POST['afdeling'] == 3) {echo 'selected="selected"';} ?>>Speelclub Jongen</option>
        <option value="4" <?php if ($_POST['afdeling'] == 4) {echo 'selected="selected"';} ?>>Speelclub Meisje</option>
        <option value="5" <?php if ($_POST['afdeling'] == 5) {echo 'selected="selected"';} ?>>Rakker</option>
        <option value="6" <?php if ($_POST['afdeling'] == 6) {echo 'selected="selected"';} ?>>Kwik</option>
        <option value="7" <?php if ($_POST['afdeling'] == 7) {echo 'selected="selected"';} ?>>Topper</option>
        <option value="8" <?php if ($_POST['afdeling'] == 8) {echo 'selected="selected"';} ?>>Tipper</option>
        <option value="9" <?php if ($_POST['afdeling'] == 9) {echo 'selected="selected"';} ?>>Kerel</option>
        <option value="10" <?php if ($_POST['afdeling'] == 10) {echo 'selected="selected"';} ?>>Tiptien</option>
        <option value="11" <?php if ($_POST['afdeling'] == 11) {echo 'selected="selected"';} ?>>Aspi Jongen</option>
        <option value="12" <?php if ($_POST['afdeling'] == 12) {echo 'selected="selected"';} ?>>Aspi Meisje</option>
        <option value="0">---------</option>
        <!--<option value="15" <?php if ($_POST['afdeling'] == 15) {echo 'selected="selected"';} ?>>Muziekkapel</option>-->
        <option value="19" <?php if ($_POST['afdeling'] == 19) {echo 'selected="selected"';} ?>>VB</option>
      </select>
    </label>
  </p>
  <br/>
  <p>
    <label>Muziekkapellid?
      <input id="user_email" class="input"  type="checkbox" tabindex="20"  value="1" <?php if ($_POST['muziekkapel'] == 1) {echo 'checked="checked"';} ?> name="muziekkapel"/>
    </label>
  </p>
  <hr />
  <br />
  <h3>Extra informatie</h3>
  <br />
  <p>
    <label>Straat<br />
      <input id="user_email" class="input" type="text" tabindex="20" size="25" value="<?php echo $_POST['straat']; ?>" name="straat"/>
    </label>
    <label>Nummer:
      <input id="user_email" class="input" type="text" tabindex="20" size="10" value="<?php echo $_POST['nr']; ?>" name="nr"/>
    </label>
  </p>
  <p>
    <label>Postcode<br />
      <input id="user_email" class="input" type="text" tabindex="20" size="15" value="<?php echo $_POST['postcode']; ?>" name="postcode"/>
    </label>
    <label>Gemeente
      <input id="user_email" class="input" type="text" tabindex="20" size="25" value="<?php echo $_POST['gemeente']; ?>" name="gemeente"/>
    </label>
  </p>
  <p>
    <label>Geboortedatum:<br />
      <?php
				$huidigjaar = date('Y', time());
				$laagstejaar = $huidigjaar - 100;



				if ($_POST['geb_jaar']!=0){
					$geboortejaar = $_POST['geb_jaar'];
				}else{
					$geboortejaar = $huidigjaar - 12;
				}

				$geboortemaand = $_POST['geb_maand'];
				$geboortedag = $_POST['geb_dag'];

				?>
      <select name="geb_dag">
        <?php
					for ($i=1; $i<=31; $i++){
						echo '<option value="' . maaktweecijfer($i) .'" ';
						if ($i == $geboortedag){echo 'selected="selected"';}
						echo ' >' . $i . '</option>';
					}
					?>
      </select>
      <select name="geb_maand">
        <option value="01" <?php if ($geboortemaand == 1){echo 'selected="selected"';} ?> >Januari</option>
        <option value="02" <?php if ($geboortemaand == 2){echo 'selected="selected"';} ?> >Februari</option>
        <option value="03" <?php if ($geboortemaand == 3){echo 'selected="selected"';} ?> >Maart</option>
        <option value="04" <?php if ($geboortemaand == 4){echo 'selected="selected"';} ?> >April</option>
        <option value="05" <?php if ($geboortemaand == 5){echo 'selected="selected"';} ?> >Mei</option>
        <option value="06" <?php if ($geboortemaand == 6){echo 'selected="selected"';} ?> >Juni</option>
        <option value="07" <?php if ($geboortemaand == 7){echo 'selected="selected"';} ?> >Juli</option>
        <option value="08" <?php if ($geboortemaand == 8){echo 'selected="selected"';} ?> >Augustus</option>
        <option value="09" <?php if ($geboortemaand == 9){echo 'selected="selected"';} ?> >September</option>
        <option value="10" <?php if ($geboortemaand == 10){echo 'selected="selected"';} ?> >Oktober</option>
        <option value="11" <?php if ($geboortemaand == 11){echo 'selected="selected"';} ?> >November</option>
        <option value="12" <?php if ($geboortemaand == 12){echo 'selected="selected"';} ?> >December</option>
      </select>
      <select name="geb_jaar">
        <?php
				for ($i=$huidigjaar;$i>$laagstejaar; $i--){
					echo '<option value="' . $i . '"';
					if ($geboortejaar == $i) { echo 'selected="selected"'; }
					echo ' >' . $i . '</option>';

				}
				?>
      </select>
    </label>
  </p>
  <p>
    <label>Telefoon (0000 00 00 00 of 00 000 00 00)<br />
      <input id="user_email" class="input" type="text" tabindex="20" size="25" value="<?php echo $_POST['telefoon']; ?>" name="telefoon"/>
    </label>
  </p>
  <?php
}

// This function checks to see if they didn't enter them
// If no first name or last name display Error
function check_fields($login, $email, $errors) {
	global $firstname, $lastname;
	if ($_POST['first'] == '') {
		$errors->add('empty_realname', "<strong>ERROR</strong>: Please Enter in First Name");
	} else {
		$firstname = $_POST['first'];
	}
	if ($_POST['last'] == '') {
		$errors->add('empty_realname', "<strong>ERROR</strong>: Please Enter in Last Name");
	} else {
		$firstname = $_POST['last'];
	}
	/*if ($_POST['straat'] == '') {
		$errors->add('empty_realname', "<strong>ERROR</strong>: Please Enter in straat");
	}
	if ($_POST['nr'] == '') {
		$errors->add('empty_realname', "<strong>ERROR</strong>: Vul je huisnummer in.");
	}
	if ($_POST['postcode'] == '') {
		$errors->add('empty_realname', "<strong>ERROR</strong>: Vul je postcode in.");
	}
	if ($_POST['gemeente'] == '') {
		$errors->add('empty_realname', "<strong>ERROR</strong>: Vul je gemeente in.");
	}
	*/
	if ($_POST['afdeling'] == 0) {
		$errors->add('empty_realname', "<strong>ERROR</strong>: 'ik ben een' niet gekozen.");
	}
	$ja = trim($_POST['geb_jaar']);
	$m = $_POST['geb_maand'];
	$d = $_POST['geb_dag'];
	$geb_datum = $ja . '-' .$m . '-' . $d;
	//kijk of de sommige maanden meer dan 30 dagen hebben

	if (($m==4 || $m==6 || $m==9 || $m==11) && $d>30){
		$errors->add('empty_realname', "<strong>ERROR</strong>:Je hebt geen juiste geboortedatum ingevuld.</p>");

	}
	// 28 of 29 dagen in februari
	if ($m == 2 && $d >schrikkeljaar($ja)){
		$errors->add('empty_realname', "<strong>ERROR</strong>:Je hebt geen juiste geboortedatum ingevuld.</p>");

	}

}

// This is where the magic happens
function register_extra_fields($user_id, $password="", $meta=array())  {

//Gotta put all the info into an array
$userdata = array();
$userdata['ID'] = $user_id;

// First name
$userdata['first_name'] = $_POST['first'];

// Last Name
$userdata['last_name'] = $_POST['last'];





// Enters into DB
wp_update_user($userdata);

update_usermeta( $user_id, 'afdeling', $_POST['afdeling'] );
if ($_POST['straat']!=''){
	update_usermeta( $user_id, 'straat', $_POST['straat'] );
}
if ($_POST['nr']!=''){
	update_usermeta( $user_id, 'nr', $_POST['nr'] );
}
if ($_POST['postcode']!=''){
	update_usermeta( $user_id, 'postcode', $_POST['postcode'] );
}
if ($_POST['gemeente']!=''){
	update_usermeta( $user_id, 'gemeente', $_POST['gemeente'] );
}
if ($_POST['telefoon']!=''){
	update_usermeta( $user_id, 'telefoon', $_POST['telefoon'] );
}
if ($_POST['geboorte']!=''){
	update_usermeta( $user_id, 'geboorte', $_POST['geb_jaar'].'-'.$_POST['geb_maand'].'-'.$_POST['geb_dag'] );
}



// This is for custom meta data "gender" is the custom key and M is the value
// update_usermeta($user_id, 'gender','M');

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

function sort_op_meta($user_id, $meta_key){
	global  $wpdb;
	$table_name = $wpdb->prefix . "usermeta";
	$where = "WHERE meta_key LIKE '$meta_key' AND ( ";

	$i = 0;
	foreach ($user_id as $id){
		if ($i>0){
			$where .= " OR ";

		}

		$where .= "user_id = '$id'";
		$i++;
	}

	$where .= ")";
	$sql = "SELECT DISTINCT user_id as ID, meta_value as meta_value, meta_key  FROM $table_name $where ORDER BY meta_value;";

	$result = $wpdb->get_results($sql);
	$i = 0;
	foreach ($result as $row){

		$users[$i] =  $row->ID;

		$i++;

	}
	return $users;
}
function getthumbbyid($id){
 //Get images attached to the post
 $args = array(
     'post_type' => 'attachment',
     'post_mime_type' => 'image',
     'numberposts' => -1,
         'order' => 'ASC',
     'post_status' => null,
     'post_parent' => $id
 );
 $attachments = get_posts($args);
 if ($attachments) {
 	$j = 0;
     foreach ($attachments as $attachment) {
         $imgarray[$j] = wp_get_attachment_thumb_url( $attachment->ID );
         $j++;
         break;
         }
 return $imgarray;
 }else {
 	return false;
 }
}

## Verander Dashboard Logo en voeg admin style toe ##
add_action('admin_head', 'admin_chiro_style');


function admin_chiro_style() {
   echo '
   <link href="'. get_bloginfo('template_directory') . '/admin.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="' . get_bloginfo('template_directory') . '/js/show_hide_form.js"></script>
	<style>

/*VERANDER HEADER LOGO*/
#header-logo { background-image: url(' . get_bloginfo('template_url') . '/images/logo.gif) !important; }
   </style>';
}

## Verander login/register logo ##

function chiro_login_logo() {
    echo '<!--[if IE]><style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/login-logo.gif) !important; }
    </style><![endif]-->
    <style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/login-logo.png) !important; }
    </style>
    <link rel="shortcut icon" href="'.get_bloginfo('template_url').'/images/favicon.ico" />
<link rel="icon" type="image/png" href="'.get_bloginfo('template_url').'/images/favicon.png" />';


}

add_action('login_head', 'chiro_login_logo');
//Custom Login Screen


## verander admin footer ##
function remove_footer_admin () {
    echo "&copy;" . date('Y', time()) . " ChiroSchelle.be";
}

add_filter('admin_footer_text', 'remove_footer_admin');

## haal iedereen met capabilty ($cap) op uit $id_list
# $id_list mag single integer, mysql-array (wpdb->get(results(query))),
# integer-array of een combinatie hiervan zijn.
function get_user_id_can($cap, $id_list=false){
	global $wpdb;
	if(!$id_list)
	{ //geen id_list meegegeven, we halen hem zelf op
		$id_list = $wpdb->get_results("SELECT ID from $wpdb->users ");
	}
	foreach($id_list as $item){
		if(is_integer($item)){
			$user_id = $item;
		}
		else{
			$user_id = (int)$item->ID;
		}
		$user = new WP_User($user_id);
		if ( $user->has_cap($cap) ){
			$users_id_can[] = $user_id;
		}
	}
	if (isset($users_id_can)){
		return $users_id_can;
	}
	else{
		return false;
	}
}

function user_id_can($cap, $user_id){
	$user = new WP_User($user_id);
	if ($user->has_cap($cap)){
		return true;
	}
	else{
		return false;
	}
}

## geeft users terug dmv rol of role

function getUsersByRole( $roles ) {
	global $wpdb;
	if ( ! is_array( $roles ) ) {
		$roles = explode( ",", $roles );
		array_walk( $roles, 'trim' );
	}
	$sql = '
		SELECT	ID, display_name
		FROM		' . $wpdb->users . ' INNER JOIN ' . $wpdb->usermeta . '
		ON		' . $wpdb->users . '.ID				=		' . $wpdb->usermeta . '.user_id
		WHERE	' . $wpdb->usermeta . '.meta_key		=		\'' . $wpdb->prefix . 'capabilities\'
		AND		(
	';
	$i = 1;
	foreach ( $roles as $role ) {
		$sql .= ' ' . $wpdb->usermeta . '.meta_value	LIKE	\'%"' . $role . '"%\' ';
		if ( $i < count( $roles ) ) $sql .= ' OR ';
		$i++;
	}
	$sql .= ' ) ';
	$sql .= ' ORDER BY display_name ';
	$userIDs = $wpdb->get_col( $sql );
	return $userIDs;
}


## geef de rank van $user_id
# werkt adhv capabilties.
function get_rank($user_id){
	$user= new WP_User($user_id);
	if (get_the_author_meta( 'rank', $user->ID )=='vb' && $user->has_cap('rank_vb')) {
		return "VB";}
	if($user->has_cap('rank_leiding')){
		return "Leiding";}
	if($user->has_cap('rank_mk')){
		return "Muziekkapel";}
	else{
		return ""; //false bij gebruik van ==, "" bij print en echo
	}
}
## andere default avatar
/**
 * add a default-gravatar to options
 */
if ( !function_exists('fb_addgravatar') ) {
	function fb_addgravatar( $avatar_defaults ) {
		$myavatar = get_bloginfo('template_directory') . '/images/avatar.png';
		$avatar_defaults[$myavatar] = 'chiro';
//		$myavatar2 = get_bloginfo('template_directory') . '/images/myavatar.png';
//		$avatar_defaults[$myavatar2] = 'wpengineer.com';
		return $avatar_defaults;
	}
	add_filter( 'avatar_defaults', 'fb_addgravatar' );
}

/**
* display a html <tr>-element with all relevant info about 1 person
**/
function display_leiding_info($user_id, $left=true)
{
	//get all data
	$user = get_userdata($user_id);
	$author_url = get_bloginfo('url') . '/author/'. $user->user_nicename;
	$edit_url = 'http://www.chiroschelle.be/wp-admin/user-edit.php?user_id=' . $user_id;
	$contact_url = get_bloginfo('url') . '/contact/?uid=' . $user_id;
	$avatar = get_avatar($user_id, $size = '100');
	$first_name = $user->first_name;
	$full_name = $first_name . " " . $user->last_name;
	$address_line1 = $user->straat . " ". $user->nr;
	$address_line2 = $user->postcode . " ". $user->gemeente;
	$telephone = $user->telefoon;
	unset($user);
	
	//display
	echo '<tr>';

	if ($left) {
?>
		<td class="tb_avatar"><a href="<?php echo $author_url; ?>"><?php echo $avatar; ?></a></td>
<?php
	unset($avatar);
	} // left
	else {
?>
		<td class="tb_avatarleeg"></td>
<?php
	}
?>
		<td class="tb_info hoogte">
			<h3>
				<a href="<?php echo $author_url;?>">
					<?php echo $full_name;?>
				</a>
<?php
	if ( current_user_can('edit_users') ) {
?>
				<a class="user-edit-link" href="<?php echo $edit_url;?>"> - Bewerk</a>
<?php
	} //can edit_users
?>
			</h3>
<?php 
			echo $address_line1 . '<br />';
			echo $address_line2 . '<br />';
			echo '<br />';
			echo $telephone . '<br />';
?>
			<a href="<?php echo $contact_url;?>">
				Contacteer <?php echo $first_name;?>
			</a>
		</td>
<?php
	if ($left) {
		echo '<td class="tb_avatarleeg"></td>';
	}
	else {
	
?>
		<td class="tb_avatarrechts"><a href="<?php echo $author_url; ?>"><?php echo $avatar; ?></a></td>
<?php
	} //else left
	echo '</tr>';
}


?>