<?php 
if ( have_posts() ){
    ?>
    <div class="spiff-masonry-grid">
        <?php

        while( have_posts() ) {
            the_post();
            global $wpsstm_tracklist;
            $tracklist = $wpsstm_tracklist;
            ?>

            <!-- article -->
            <article id="post-<?php the_ID(); ?>" <?php post_class('spiff-masonry-item'); ?>>
                <div class="spiff-masonry-content">
                    <!-- post thumbnail -->
                    <figure class="post-thumbnail">
                        <?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <?php the_post_thumbnail('large'); //array(120,120) // Declare pixel size you need inside the array ?>
                            </a>
                        <?php endif; ?>
                    </figure>
                    <figcaption class="post-content">
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
                        </div>
                    </figcaption>
                    <!-- /post thumbnail -->

                    <?php //edit_post_link(); ?>
                </div>
            </article>
            <!-- /article -->
            <?php
        }
        ?>
    </div>
        <?php
}else{
    ?>
    <!-- article -->
    <article>
        <h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
    </article>
    <!-- /article -->
    <?php
}