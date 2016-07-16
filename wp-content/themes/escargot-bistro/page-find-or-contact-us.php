<?php get_header(); ?>
	<div id="content" class="container">
		<div id="inner-content" class="row">
			<main id="main" class="col-xs-12" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
					<header class="article-header">
						<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
					</header>
					<section class="entry-content cf sub" itemprop="articleBody">
						<?php get_template_part('social'); ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <h2>Operating hours:</h2>
                                <?php echo apply_filters( 'the_content',get_option('hours_of_operation')); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <h2>Address &amp; Contact:</h2>
                                <a class="address" href="https://www.google.com/maps/place/Escargot+Bistro/@26.1886258,-80.1304127,17z/data=!4m2!3m1!1s0x0000000000000000:0x0da6a02deb22bddf?hl=en" target="_blank">
                                    <address>1506 E. Commercial Blvd Oakland Park, FL, 33334</address>
                                </a>
                                <p>Give us a call at: <a href="tel:17542064116">(754)-206-4116</a></p>
                            </div>
                        </div>
						<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) );
						?>
					</section>
				</article>
				<?php endwhile; endif; ?>
			</main>
		</div>
	</div>
<?php get_footer(); ?>
