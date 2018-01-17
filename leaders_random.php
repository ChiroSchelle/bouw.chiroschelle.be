<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package chiro-schelle-15
 * Template Name: Leidingspagina Random
 */

//haal de id's op van de groepsleiding:
$groeps_ids = get_user_id('groeps',1);

//haal de rest van de leiding op:
$leiding_ids = get_user_id('rank','leiding');

$groups = [];
for ($i=1;$i<=12;$i++){
	$groupName = maaknummerafdeling($i);
	$groups[$i] = $groupName;
	// $leiding[$afdeling] = sort_op_afdeling($leiding_ids,$i);
}

//zet de leiding in willekeurige volgorde
shuffle($leiding_ids); 

//zet een de afdelingen in willekeurige volgorde
//shuffle($afdeling);
  
// vul afdeling per afdeling de leiding in

$i= 0;
foreach ($groups as $group) {
	$i++;
    $count = count($leiding_ids);

    //bepaal de grootte van de afdelingen    
    // niet zoveel rekenwerk, in het begin grote afdelingen
    //$max = count($leiding_ids)/2 -1;
    // meer rekenwerk, grootte van afdelingen ligt dichter bij elkaar
    // uitleg: sqrt zorgt dat begin afdelingen niet zo groot kunnen zijn,
    // maar hoe kleiner $count wordt, hoe kleiner het verschil tussen de vorige
    // +$i/4 compenseert dit nog wat meer door op het einde de afdelingen 
    // groter te maken.
    // tl;dr: Aantal dingen geprobeerd, deze formule is deftig.
    $max = (int)(sqrt($count)+$i/4);
    
    $grootte = rand(1,$max); //+1 omdat (int) gewoon afkapt
    if($grootte > $count){
      	$grootte = $count;
    }

    // vul de afdeling met $grootte aantal leiders, 
    // en verwijder deze leiders uit de array

    for($ii=0;$ii < $grootte; $ii++){
      	$afdeling[$ii] = array_pop($leiding_ids);
    }
    // zet de afdeling in de normale leiding array.
    $leiding[$group] = $afdeling;
    // maak afdeling array leeg, anders problemen als deze loop
    // nog eens doorlopen wordt.
    unset($afdeling); 
}
  //unset($vb_id);
  //$vb_id = $leiding_ids; //leiding die nu nog overschiet wordt vb.

//haal de veebees op
$vb_ids = get_user_id('rank','vb');

function displayUser($user_id) {
	$l = get_userdata($user_id);
	$author_url = get_bloginfo('url') . '/author/'. $l->user_nicename;
	$edit_url = 'http://www.chiroschelle.be/wp-admin/user-edit.php?user_id=' . $user_id;
	$contact_url = get_bloginfo('url') . '/contact/?uid=' . $user_id;
	?>
	<li>
		<div class="avatar-wrapper"><?php echo get_avatar($l->ID, 180); ?></div>
		<div class="details">
			<p class="name"><a href="<?php echo $author_url; ?>"><?php echo $l->first_name . ' ' . $l->last_name; ?></a></p>
			<p class="street"><?php echo $l->straat . ' ' . $l->nr; ?></p>
			<p class="city"><?php echo $l->postcode . ' ' . $l->gemeente; ?></p>
			<p class="phone"><?php echo $l->telefoon; ?></p>
			<p class="mail"><a href="<?php echo $contact_url; ?>">Contacteer <?php echo $l->first_name; ?></a></p>
		</div>
	</li>
<?php }


get_header(); ?>

	<section class="container highlighted">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php

					// NOOIT COMMENTS TOELATEN BIJ EEN GEWONE PAGINA!

					// If comments are open or we have at least one comment, load up the comment template.
					//if ( comments_open() || get_comments_number() ) :
					//	comments_template();
					//endif;

				?>

			<?php endwhile; // End of the loop. ?>
	</section>
	<section class="container">
			<ul class="leaders">
				<li class="group">
					<h3>Groeps</h3>
					<ul>
				<?php
					foreach($groeps_ids as $l) {
						echo displayUser($l);
					}
				?>
					</ul>
				</li>
				<?php
					foreach($leiding as $group => $members) {

						echo '<li class="group"><h3>' . $group . '</h3><ul>';

						foreach($members as $l) {
							echo displayUser($l);
						}

						echo '</ul></li>';
					}
				?>
				<li class="group">
					<h3>Volwassen begeleiding</h3>
					<ul>
				<?php
					foreach($vb_ids as $l) {
						echo displayUser($l);
					}
				?>
					</ul>
				</li>
			</ul>

	</section>

<?php get_footer(); ?>
