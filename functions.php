<?php

class SpiffV2Theme{
    public $version = '1.0.2';
    function __construct(){
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_script_styles') );
        add_filter( 'the_content', array($this,'reddit_content_notice') );
        add_filter( 'the_content', array($this,'reddit_content_description') );
        add_filter( 'body_class', array($this,'bp_remove_two_column_body_class'), 20, 2);
        add_filter( 'term_link', array($this,'station_term_link'), 10, 3);
    }

    function enqueue_script_styles() {
        wp_register_style( 'parent-style', get_template_directory_uri() . '/style.css' ); //parent style
        wp_enqueue_style( 'spiff', get_stylesheet_directory_uri() . '/_inc/css/spiff.css',array('parent-style'),$this->version );
        wp_enqueue_script( 'spiff',get_stylesheet_directory_uri() . '/_inc/js/spiff.js', array('jquery'),$this->version );
        
        //masonery
        if ( (is_archive() && (get_post_type()=='wpsstm_live_playlist')) || did_action('bp_include') ) { //TO FIX BP check is playlists menu
            //wp_register_script( 'jquery-imagesloaded', 'http://imagesloaded.desandro.com/imagesloaded.pkgd.min.js' );
            wp_enqueue_script( 'spiff-masonry',get_stylesheet_directory_uri() . '/_inc/js/spiff-masonry.js', array('jquery-masonry'));
        }
    }
    
    function reddit_content_notice($content){
        if ( !has_tag('reddit') ) return $content;
        if ( !wpsstm_lastfm()->lastfm_user->is_user_api_logged() ) return $content;
        $notice = '<p id="reddit-scrobbling-notice"><i class="fa fa-lastfm" aria-hidden="true"></i> <small>Tracks datas from <a href="https://www.reddit.com/" target="_blank" rel="noopener noreferrer">Reddit</a> are not always correct.  You should maybe disable the Last.fm scrobbler if it is active.</small></p>';
        return $notice . $content;
    }
    
    function reddit_content_description($content){
        if ( !has_tag('reddit') ) return $content;
        $reddit = '<p id="reddit-description"><small><a href="https://www.reddit.com/" target="_blank" rel="noopener noreferrer">Reddit</a> is an American social news aggregation, web content rating, and discussion website. Reddit\'s registered community members can submit content such as text posts or direct links.  Submissions with the most up-votes appear on the front page or the top of a category. Content entries are organized by areas of interest called "subreddits". Subreddit topics include news, science, gaming, movies, music, books, fitness, food, image-sharing, and many others. (Source: <a href="https://fr.wikipedia.org/wiki/Reddit" target="_blank" rel="noopener noreferrer">Wikipedia</a>)</small></p>';
        return $content.= $reddit;
    }
    
    // Remove the page-two-column CSS class from the body class in BuddyPress pages
    function bp_remove_two_column_body_class($wp_classes) {
        if( function_exists ( 'bp_loaded' ) && !bp_is_blog_page() ) :
            foreach($wp_classes as $key => $value) {
                 if ($value == 'page-two-column') unset($wp_classes[$key]);
            }
        endif;
        return $wp_classes;
    }
    
    function station_term_link($termlink, $term, $taxonomy){
        global $post;
        $post_type = get_post_type($post->ID);
        $is_live_tracklist = ( $post_type == wpsstm()->post_type_live_playlist  );
        if ($is_live_tracklist){
            $termlink = add_query_arg(array('post_type'=>wpsstm()->post_type_live_playlist),$termlink);
        }
        return $termlink;
    }
    
}

$spiff_theme = new SpiffV2Theme();

