<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
global $wp_query;
get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
                
                    $title_suffix = null;

                    if ( $orderby = $wp_query->get( 'orderby' ) ){
                        switch($orderby){
                            case 'popular':
                                $title_suffix = __( "Popular Stations", 'spiff-radio' ); 
                            break;
                            case 'trending':
                                $title_suffix = __( "Popular Last Month", 'spiff-radio' ); 
                            break;
                        }

                    }elseif( is_tag('editors-pick') ){
                        $tag = single_term_title("", false);
                        if ($tag=="editor's pick"){
                            $title_suffix = __( "Editor's Picks", 'spiff-radio' ); 
                        }

                    }
                
                    if ($title_suffix){
                        $title_suffix = ' - ' . $title_suffix;
                    }
                
                    the_archive_title( '<h1 class="page-title">', $title_suffix . '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
            
            <div id="content" class="wpsstm-playlists-loop wpsstm-masonry">
                <?php get_template_part('loop', 'tracklist'); ?>
            </div>

			<?php
            
			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
				'next_text'          => __( 'Next page', 'twentyfifteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>
