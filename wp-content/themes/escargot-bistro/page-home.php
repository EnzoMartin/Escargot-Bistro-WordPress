<?php get_header(); ?>
<div class="home">
	<div id="content">
		<div id="inner-content" class="wrap cf">
			<!-- Hide this for mobile -->
			<div class="m-hidden t-2of-3 d-5of7">
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
				            $imageMeta = get_post_meta($post->ID, 'banners_image', true);
				            $image = wp_get_attachment_url($imageMeta, 'fullsize');

				            $subheading = get_post_meta($post->ID, 'banners_text_subheading', true);
				            $caption = get_post_meta($post->ID, 'banners_text_caption', true);
				            $link = get_post_meta($post->ID, 'banners_text_link', true);
				            $linktext = get_post_meta($post->ID, 'banners_text_link_text', true);

				            $banner =
				            '<li class="item ' . $classes . '">
		                        <a href="' . $link . '"><img src="' . $image . '" alt=""></a>
		                        <div class="caption-container">
		                            <div class="carousel-caption">' .
		                                (($link != '') ? '<a href="' . $link . '">' : '') .
		                                '<h5>' . get_the_title() . '</h5>' .
		                                (($subheading != '') ? '<h6>' . $subheading . '</h6>' : '') .
				                        (($link != '') ? '</a>' : '') .
		                            '</div>
	                            </div>
		                    </li>';
					        
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
			<main id="main" class="container decorated m-all t-1of3 d-2of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						<section class="entry-content cf" itemprop="articleBody">
							<?php
							the_content();

							wp_link_pages( array(
								'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
								'after' => '</div>',
								'link_before' => '<span>',
								'link_after' => '</span>',
							) );
							?>
						</section>
					</article>
				<?php endwhile; endif; ?>
				<div id="stamp"><img src="<?php echo get_template_directory_uri(); ?>/library/images/stamp.jpg"/></div>
			</main>
			<div class="m-all t-2of-3 d-5of7">
				<div id="operating-hours" class="container">
					<h2>Opening Hours &amp; Address</h2>
					<?php echo apply_filters( 'the_content',get_option('hours_of_operation')); ?>
					<a href="https://www.google.com/maps/place/Escargot+Bistro/@26.1886258,-80.1304127,17z/data=!4m2!3m1!1s0x0000000000000000:0x0da6a02deb22bddf?hl=en" target="_blank">
						<address>1506 E. Commercial Blvd Oakland Park, FL, 33334</address>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
