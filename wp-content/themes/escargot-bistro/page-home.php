<?php

get_header();

$useragent=$_SERVER['HTTP_USER_AGENT'];
$is_mobile = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));

?>

<div class="home">
	<div id="content">
		<div id="inner-content" class="wrap cf">
			<!-- Hide this for mobile -->
			<?php if(!$is_mobile){ ?>
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
				<?php } ?>
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
