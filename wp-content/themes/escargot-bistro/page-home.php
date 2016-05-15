<?php

get_header();

?>

<div class="home">
	<div id="content" class="container">
		<div id="inner-content" class="row">
			<?php if(!$GLOBALS['is_mobile']){ ?>
			<div class="hidden-sm-down col-xs-12">
				<?php
				$banners = new WP_Query(
				    array(
				        'post_type' => 'banner',
				        'meta_key' => 'banners_text_order',
				        'order' => 'ASC',
				        'orderby' => 'meta_value_num',
				        'nopaging' => true
				    )
				);
				$html = [];
				if ( $banners->have_posts() ) {
				    $classes = 'active';
				    while($banners->have_posts()): $banners->the_post();
				        if(get_post_status() == 'publish') {
				            $imageMeta = get_post_meta($post->ID);

					        //$imageMeta['banners_text_subheading'][0]
				            $image = wp_get_attachment_url($imageMeta['banners_image'][0], 'fullsize');

				            $title = $imageMeta['banners_text_title'][0];
				            $subheading = $imageMeta['banners_text_subheading'][0];
				            $caption = $imageMeta['banners_text_caption'][0];
				            $link = $imageMeta['banners_text_link'][0];
				            $linktext = $imageMeta['banners_text_link_text'][0];

					        $display = $title != '' && $subheading != '';

				            $banner =
				            '<li class="item ' . $classes . '">
		                        <a href="' . $link . '"><img src="' . $image . '" alt=""></a>' .
				                ($display ?
		                        '<div class="caption-container">
		                            <div class="carousel-caption">' .
		                                (($link != '') ? '<a href="' . $link . '">' : '') .
		                                (($title != '') ? '<h5>' . $title . '</h5>' : '') .
		                                (($subheading != '') ? '<h6>' . $subheading . '</h6>' : '') .
				                        (($link != '') ? '</a>' : '') .
		                            '</div>
	                            </div>'
		                        : '') .
		                    '</li>';
					        
				            array_push($html, $banner);
				            $classes = '';
				        }
				    endwhile;
				}
				wp_reset_query();
				?>

				<div id="home-carousel" class="simpleBanner">
					<div class="bannerListWpr">
					    <ul class="bannerList">
					        <?php
					        foreach($html as $banner){
					            echo $banner;
					        }
					        ?>
					    </ul>
					</div>
				    <?php if(count($html) > 1){ ?>
					    <div class="bannerControlsWpr bannerControlsPrev" title="Previous"><div class="bannerControls"></div></div>
					    <div class="bannerIndicators"><ul></ul></div>
					    <div class="bannerControlsWpr bannerControlsNext" title="Next"><div class="bannerControls"></div></div>
				    <?php } ?>
				</div>
			</div>
			<?php } ?>
			<div class="col-xs-12">
				<div class="operating-hours large">
					<h2>Opening Hours &amp; Address</h2>
					<?php
						if (have_posts()) :
							while (have_posts()) : the_post();
								the_content();
							endwhile;
						endif;
					?>
					<a class="address" href="https://www.google.com/maps/place/Escargot+Bistro/@26.1886258,-80.1304127,17z/data=!4m2!3m1!1s0x0000000000000000:0x0da6a02deb22bddf?hl=en" target="_blank">
						<address>1506 E. Commercial Blvd Oakland Park, FL, 33334</address>
					</a>
					<a class="tel hidden-md-up" href="tel:(754)-206-4116">(754)-206-4116</a>
				</div>
			</div>
		</div>
		<div class="row hidden-md-up menu-buttons">
			<div class="col-xs-4 center">
				<a href="/menu/lunch-menu">Lunch Menu</a>
			</div>
			<div class="col-xs-4 center">
				<a href="/menu/dinner-menu">Dinner Menu</a>
			</div>
			<div class="col-xs-4 center">
				<a href="/menu/wine-list">Wine List</a>
			</div>
		</div>
		<div class="row hidden-md-up">
			<div class="col-xs-12">
				<div class="operating-hours small"></div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
