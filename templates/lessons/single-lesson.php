<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Back40_Theme
 */

get_header();

?>

	<main id="main" class="site-main">

        <div class="page-title-wrap">
            <div class="container">
                <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
            </div>
        </div>

        <div class="page-content-wrap">

            <div class="container">

                <div class="b40-breadcrumbs">
                    <?php b40_breadcrumbs(); ?>
                </div>

                <div class="b40-lesson-single">

                    <?php 
                    while ( have_posts() ) :
                    
                    the_post();
                    
                    ?>                        

                    <div class="b40-lesson--content">

                        Lesson Content Here
                        
                        <?php the_content(); ?>

                    </div>

                    <?php endwhile; // End of the loop. ?>
                </div>

                </div>
            </div>
        </div>

	</main><!-- #main -->

<?php
get_footer();