<?php
/*
 * Template Name: Home Page
 * Description: Just the main page.
 */

$theID = strpos(get_site_url(), "localhost") ==! 0 ? 4 : 7;

get_header();

?>
	<main>

		<section class="home-section">

			<div class="container">

				<div class="home-row local-row">

					<div class="seven columns text-column">

						<div class="hidden-mn">

						</div>

						<div class="text-container">
							<h2><?php echo get_field('block_1_header', $theID); ?></h2>
							<p><?php echo get_field('block_1_content', $theID); ?></p>
						</div>
					</div>

					<div class="five columns image-column">

					</div>

				</div>

			</div>

		</section>

		<div class="home-bar testimonial-bar">

			<div class="container">

				<div class="four columns bubbles-part home-bubbles">
					<?php get_template_part('img/inline', 'bubbles.svg'); ?>
				</div>
	
				<div class="eight columns testimonial-part">
					<blockquote>Excellent service! We have used Sahlstrom's Heating Cooling for years now and have never been disappointed.<cite> - Vicki</cite></blockquote>
				</div>

			</div>

		</div>

		<section class="home-section">

			<div class="container">

				<div class="home-row services-row">

					<div class="five columns image-column">

					</div>

					<div class="seven columns text-column">
						<div class="text-container">
							<h2><?php echo get_field('block_2_header', $theID); ?></h2>
							<p><?php echo get_field('block_2_content', $theID); ?></p>
						</div>
					</div>

				</div>

			</div>

		</section>

		<div class="home-bar call-bar">
			<div class="container">
				<h2>Give Us A Call<span>.</span> <br style="display:none;"><a href="tel:507-629-3734">507-629-3734</a></h2>
			</div>
		</div>

		<section class="home-section">

			<div class="container">

				<div class="home-row contact-section">

					<div class="five columns text-column">
						<div class="text-container">
							<h2><?php echo get_field('block_3_header', $theID); ?></h2>
							<p><?php echo get_field('block_3_content', $theID); ?></p>
							<div class="form-messages"></div>
						</div>
					</div>

					<div class="seven columns form-column">

						<?php get_template_part('partials/form', 'email'); ?>
							
						<div class="form-messages mobile-only"></div>

					</div>

				</div>

			</div>

		</section>

		<!--

		<section class="brands-section">

			<div class="container">

				<h2 class="brands-header">Brands We Carry</h2>

				<ul id="brandsSlider">
					<li><img src="http://placehold.it/350x150"></li>
				  	<li><img src="http://placehold.it/350x150"></li>
				  	<li><img src="http://placehold.it/350x150"></li>
				</ul>

			</div>

		</section>

		-->
	
	</main>

<?php get_footer(); ?>
