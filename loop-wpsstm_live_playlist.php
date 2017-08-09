<?php 
if ( have_posts() ){
    ?>
    <div class="masonry-sizer"></div>
    <?php
    
    while( have_posts() ) {
        the_post();
        global $wpsstm_tracklist;
        $tracklist = $wpsstm_tracklist;
        ?>

        <!-- article -->
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- post thumbnail -->
            <?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
                            <div class="post-thumbnail">
                                <a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail('large'); //array(120,120) // Declare pixel size you need inside the array ?>
                                </a>
                            </div>
            <?php endif; ?>
            <!-- /post thumbnail -->
                    <div class="entry-content">
                        <!-- post title -->
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <?php
                        /*
                        if ( $excerpt = get_the_excerpt() ){
                            ?>
                            <p class="entry-excerpt"><?php the_excerpt();?></p>
                            <?php
                        }
                        */
                        ?>
                    </div>
                    <div class="entry-metas">
                        <?php echo spiff_theme()->get_station_tags_list();?>
                        <?php 
                        if ( $rate = $tracklist->get_refresh_rate() ){
                            
                            ?>
                            <div class="spiff-sation-refresh"><i class="fa fa-rss" aria-hidden="true"></i> <?php printf(__('every %s','wpsstm'),$rate);?></div>
                            <?php
                        }
                        ?>
                    </div>

            <?php //edit_post_link(); ?>

        </article>
        <!-- /article -->
        <?php
    }
}else{
    ?>
    <!-- article -->
    <article>
        <h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
    </article>
    <!-- /article -->
    <?php
}