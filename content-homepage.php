<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
		twentyfifteen_post_thumbnail();
	?>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content();?>
    </div>
    <div id="homepage-picks">
        <?php wp_nav_menu( array( 'theme_location' => 'spiff-home-picks-menu' ) );?>

        <div id="wpsstm-picks-widgets">
            <?php
            /*
            Megapicks
            */

            $megapicks_args = array(
                'post_type'         => wpsstm()->post_type_live_playlist,
                'tag'               => 'megapick',
                'posts_per_page'    => -1,
                'orderby'           => 'rand',
                'spiff'             => true,
            );
            query_posts($megapicks_args);
            if( have_posts() ){
                ?>
                <div id="wpsstm-widget-megapicks" class="wpsstm-widget-picks">
                    <div class="wpsstm-playlists-loop wpsstm-masonry">
                        <?php get_template_part('loop','tracklist'); ?>
                    </div>
                    <p class="wpsstm-widget-more-picks">
                        <?php 
                        $editorspicks_link = sprintf('<a href="%s">%s</a>',home_url('tag/editors-pick/?post_type=wpsstm_live_playlist&spiff=1'),"#editors-pick");
                        printf(__('Want more ? %s','spiff'),$editorspicks_link);
                        ?>
                    </p>
                </div><!-- .entry-content -->
                <?php
            }

            // reset the query
            wp_reset_query(); 
            ?>

            <?php
            /*
            New
            */

            $newpicks_args = array(
                'post_type'         => wpsstm()->post_type_live_playlist,
                'posts_per_page'    => spiff_theme()->home_picks_count,
                'spiff'             => true,
            );
            query_posts($newpicks_args);
            if( have_posts() ){
                ?>
                <div id="wpsstm-widget-newpicks" class="wpsstm-widget-picks">
                    <div class="wpsstm-playlists-loop wpsstm-masonry">
                        <?php get_template_part('loop','tracklist'); ?>
                    </div>
                    <p class="wpsstm-widget-more-picks">
                        <?php echo sprintf('%s <a href="%s">%s</a>',__('Want more ?','spiff'),home_url('?post_type=wpsstm_live_playlist&spiff=1'),__('New tracklists','spiff'));?>
                    </p>
                </div><!-- .entry-content -->
                <?php
            }

            // reset the query
            wp_reset_query(); 
            ?>

            <?php
            /*
            Trending
            */

            $newpicks_args = array(
                'post_type'         => wpsstm()->post_type_live_playlist,
                'posts_per_page'    => spiff_theme()->home_picks_count,
                'orderby'           => 'trending'
            );
            query_posts($newpicks_args);
            if( have_posts() ){
                ?>
                <div id="wpsstm-widget-trendingpicks" class="wpsstm-widget-picks">
                    <div class="wpsstm-playlists-loop wpsstm-masonry">
                        <?php get_template_part('loop','tracklist'); ?>
                    </div>
                    <p class="wpsstm-widget-more-picks">
                        <?php echo sprintf('%s <a href="%s">%s</a>',__('Want more ?','spiff'),home_url('?post_type=wpsstm_live_playlist&orderby=trending'),__('Trending tracklists','spiff'));?>
                    </p>
                </div><!-- .entry-content -->
                <?php
            }

            // reset the query
            wp_reset_query(); 
            ?>

            <?php
            /*
            Radio
            */

            $newpicks_args = array(
                'post_type'         => wpsstm()->post_type_live_playlist,
                'posts_per_page'    => spiff_theme()->home_picks_count,
                'tag'               => 'radio',
                'orderby'           => 'trending',
                'spiff'             => true,
            );
            query_posts($newpicks_args);
            if( have_posts() ){
                ?>
                <div id="wpsstm-widget-radiopicks" class="wpsstm-widget-picks">
                    <div class="wpsstm-playlists-loop wpsstm-masonry">
                        <?php get_template_part('loop','tracklist'); ?>
                    </div>
                    <p class="wpsstm-widget-more-picks">
                        <?php echo sprintf('%s <a href="%s">%s</a>',__('Want more ?','spiff'),home_url('tag/radio/?post_type=wpsstm_live_playlist&spiff=1'),'#radio');?>
                    </p>
                </div><!-- .entry-content -->
                <?php
            }

            // reset the query
            wp_reset_query(); 
            ?>
                
            
        </div>
	</div><!-- .homepage-picks -->

	<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->
