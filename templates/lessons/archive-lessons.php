<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Back40_Theme
 */

get_header();

$show_cta = get_field( 'show_cta', 'option' );
$page_title_bg = get_field( 'page_title_bg', 'option' );

?>

	<main id="main" class="page-main">

        <div class="page-title-wrap" style="background-image: url(<?php echo $page_title_bg['url']; ?>);">
            <div class="container">
                <h1 class="page-title">Lessons</h1>
            </div>
        </div>

        <div class="page-content-wrap">
            <div class="container">

                <?php b40_breadcrumbs(); ?>

                <div class="page-content">

                    <div class="b40-lessons">

                        <?php
                        while ( have_posts() ) :
                                                    
                            the_post();

                        ?>

                        <article class="b40-lesson">
                            <div class="entry-content">

                                <h2><?php echo get_the_title(); ?></h2>

                                <a href="<?php echo get_the_permalink(); ?>" class="btn btn-default btn-read-more">View Lesson</a>
                                
                            </div><!-- .entry-content -->
                        </article><!-- #post-<?php the_ID(); ?> -->

                        <?php endwhile; ?>

                    </div>

					<div class="b40-pagination">
						<?php echo paginate_links(); ?>
					</div>

                </div>
            </div>
        </div><!-- .page-content -->

	</main><!-- #main -->

<?php
get_footer();