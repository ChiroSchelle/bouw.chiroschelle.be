<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package chiro-schelle-15
 */

?>

	<!-- End main-container -->
	</div>

	<footer class="site-footer" role="contentinfo">
		<div class="container">
			<div class="row">
				
				<div class="col-md-3 hidden-sm hidden-xs">
					<img src="<?php bloginfo('template_directory'); ?>/img/logo_geef_kleur.png" alt="">
				</div>	

				<div class="col-md-3 col-sm-3 col-sm-offset-1 col-xs-5">
					<h3><span class="border">Op de website</span></h3>
					<div class="footer-menu">
					<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu' ) ); ?>
					</div>
				</div>
				
				<div class="col-md-4 col-sm-7 col-xs-7">
					<div class="news-letter">
						<!-- Begin MailChimp Signup Form -->
						<div id="mc_embed_signup">
							<form action="//chiroschelle.us11.list-manage.com/subscribe/post?u=fe567bc2602efaa5c7eb040e8&amp;id=2d1ff2357d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="mailchimp validate" target="_blank" novalidate>
							    <div id="mc_embed_signup_scroll">
								<h3><span class="border">Schrijf je in op onze nieuwsbrief</span></h3>

								<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Vul hier je email adres in">

								<div id="mce-responses" class="clear">
									<div class="response" id="mce-error-response" style="display:none"></div>
									<div class="response" id="mce-success-response" style="display:none"></div>
								</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							    <div style="position: absolute; left: -5000px;"><input type="text" name="b_fe567bc2602efaa5c7eb040e8_2d1ff2357d" tabindex="-1" value=""></div>
							    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
							    </div>
							</form>
						</div>
						<!--End mc_embed_signup-->
					</div>
					<div class="contact-wrapper">
						<h3><span class="border">Contacteer ons</span></h3>
						<address>
							<div class="adress">
								<span class="street">Ceulemansstraat 88</span>
								<span class="city">2627 Schelle</span>
							</div>
							<span class="mail">info [at] chiroschelle.be</span>
						</address>
					</div>

					<div class="social-wrapper">
						<h3><span class="border">Social media</span></h3>
							<ul class="social">
								<li><a class="facebook" href="https://www.facebook.com/chiroschelle">Facebook</a></li>
								<li><a class="twitter" href="https://twitter.com/chiroschelle">Twitter</a></li>
								<li><a class="youtube" href="https://www.youtube.com/user/ChiroSchelle">Youtube</a></li>
							</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/lightbox.min.js"></script>
</body>
</html>
