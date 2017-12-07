<?php get_header(); ?>
    <div id="content" class="container">
        <div id="inner-content" class="row">
            <main id="main" class="col-xs-12" role="main">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?>>
                    <header class="article-header">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </header>
                    <section class="entry-content cf sub">
                        <?php get_template_part('social'); ?>
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
