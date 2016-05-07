<?php get_header(); ?>

<div id="content">
	<div id="inner-content" class="wrap cf">
		<main id="main" class="m-all t-3of3 d-7of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php
				get_template_part( 'post-formats/format-menu', get_post_format() );
				?>
			<?php endwhile; ?>
			<?php else : ?>
				<article id="post-not-found" class="hentry cf">
					<header class="article-header">
						<h1><?php _e( 'Page Not Found', 'bonestheme' ); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e( 'Sorry, something is missing.', 'bonestheme' ); ?></p>
					</section>
				</article>
			<?php endif; ?>
		</main>
	</div>
</div>

<?php get_footer(); ?>
