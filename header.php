<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package chiro-schelle-15
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|Ubuntu:400,500,700,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/jquery/dist/jquery.min.js"></script>

<?php if (is_page_template('contact.php')) { ?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMosxiZ3jRg2z-3DILge7Iazc2tNjdxds"></script>
    <script type="text/javascript">
      	function initialize() {
        	var mapOptions = {
          		center: { lat: 51.124039, lng: 4.336228},
          		zoom: 17
        	};
       	 	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

       	 	var marker = new google.maps.Marker({
			    position: { lat: 51.124039, lng: 4.336228},
			    map: map,
			    title: 'Chiro Schelle'
			});
      	}

      	google.maps.event.addDomListener(window, 'load', initialize);
   	</script>
<?php } ; ?>

<script>
	$(document).ready(function() {

		$("#toggle-menu").click(function() {
			$("#primary-menu").slideToggle();
		});
	});
</script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M6GG6S"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M6GG6S');</script>
<!-- End Google Tag Manager -->


<div class="background"></div>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'chiro-schelle' ); ?></a>
	
	<!-- <div class="top-header">
		<div class="container">
			<ul>
				<li>
					<a href="/contact">Contact</a>
				</li>
				<li>
					<a href="/wp-login.php?action=register">Registreer</a>
				</li>
				<li>
					<a href="/wp-login.php">Login</a>
				</li>
			</ul>
		</div>
	</div> -->

	<header class="site-header">

		<div class="container">
			<div class="site-branding">
				<a href="<?php bloginfo("url") ?>" id="homelink"><img class="site-logo" src="<?php bloginfo('template_directory'); ?>/img/logo-bouw-white-on-black.svg" alt="logo Chiro Schelle" title="logo Chiro Schelle" /></a>
				<!-- <div class="site-info-wrapper">
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div> -->
			</div>
		</div>

	</header>

	<div class="container card main-container">
		<nav class="main-navigation">

			<button class="menu-toggle" id="toggle-menu" aria-controls="primary-menu" aria-expanded="false"><i class="glyphicon glyphicon-chevron-down"></i> Menu</button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>

		</nav>
