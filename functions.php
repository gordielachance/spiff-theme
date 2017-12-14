<?php

class SpiffV2Theme{
    
    public $version = '1.0.2';
    public $home_picks_count = 16;
    
    /**
    * @var The one true Instance
    */
    private static $instance;

    public static function instance() {
            if ( ! isset( self::$instance ) ) {
                    self::$instance = new SpiffV2Theme;
                    self::$instance->init();
            }
            return self::$instance;
    }

    private function __construct() { /* Do nothing here */ }

    function init(){
        add_action( 'init', array($this,'register_menus') );
        add_filter( 'query_vars', array($this,'add_query_vars') );
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_script_styles') );
        add_filter( 'the_content', array($this,'reddit_content_notice') );
        add_filter( 'the_content', array($this,'reddit_content_description') );
        add_filter( 'body_class', array($this,'bp_remove_two_column_body_class'), 20, 2);
        add_filter( 'term_link', array($this,'station_term_link'), 10, 3);
        
        add_filter( 'pre_get_posts', array($this, 'pre_get_posts_editor'));
        
        add_action( 'template_include', array($this, 'force_tracklist_archive_template') );
        
        add_filter( 'wp_get_nav_menu_items', array($this, 'my_music_menu'), 10, 3 );
        
        //tracklists
        add_filter('wpsstm_input_tracks', array($this,'radiomeuh_input_tracks'),10,2);
        add_filter('wpsstm_input_tracks', array($this,'ness_radio_input_tracks'),10,2);
        add_filter('wpsstm_input_tracks', array($this,'nova_input_tracks'),10,2);
        
    }
    
    function add_query_vars( $qvars ) {
        $qvars[] = 'spiff';
        return $qvars;
    }
    
    function pre_get_posts_editor( $query ) {

        if ( $query->get('spiff') && ( $query->get('post_type')==wpsstm()->post_type_live_playlist ) ){
            $query->set( 'author', 1);
        }

        return $query;
    }
    
    function radiomeuh_input_tracks($tracks,$tracklist){
        $post_slug = get_post_field( 'post_name', $tracklist->post_id );
        if ($post_slug != 'radio-meuh') return $tracks;
        
        //remove jingles
        foreach((array)$tracks as $key=>$track){
            $artist = strtolower($track->artist);
            if ($artist=='jingle'){
                unset($tracks[$key]);
            }
        }
        
        return $tracks;
        
    }
    
    function ness_radio_input_tracks($tracks,$tracklist){
        $post_slug = get_post_field( 'post_name', $tracklist->post_id );
        if ($post_slug != 'ness-radio') return $tracks;
        
        //remove jingles
        foreach((array)$tracks as $key=>$track){
            $artist = strtolower($track->artist);
            $artist = trim($artist);
            if ( $artist == 'www.nessradio.com' ) {
                unset($tracks[$key]);
            }
        }

        return $tracks;
        
    }
    
    function nova_input_tracks($tracks,$tracklist){
        $post_slug = get_post_field( 'post_name', $tracklist->post_id );
        if ($post_slug != 'radio-nova') return $tracks;
        
        //remove default image
        $default_image = 'http://www.novaplanet.com/sites/default/files/imagecache/cetaitkoicetitre_cover/sites/all/themes/nova/images/cover-null.jpg';
        foreach((array)$tracks as $key=>$track){
            if ($track->image_url == $default_image) {
                $track->image_url = null;
            }
        }

        return $tracks;
        
    }
    
    function register_menus() {
        register_nav_menu('spiff-home-picks-menu',__( 'Home picks menu','spiff' ));
    }

    function enqueue_script_styles() {
        wp_register_style( 'parent-style', get_template_directory_uri() . '/style.css' ); //parent style
        wp_enqueue_style( 'spiff', get_stylesheet_directory_uri() . '/_inc/css/spiff.css',array('parent-style'),$this->version );
        wp_enqueue_script( 'spiff',get_stylesheet_directory_uri() . '/_inc/js/spiff.js', array('jquery','jquery-ui-core','jquery-ui-tabs','jquery-masonry','jquery.toggleChildren'),$this->version );
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
    
    function get_station_tags_list(){
        return get_the_term_list( null, 'post_tag', '<div class="spiff-station-tags"><ul><li>', '</li> <li>', '</li></ul></div>' );
    }
    
    /*
    Parent theme has author archives, etc.
    So always load our archive tracklist template here.
    */
    function force_tracklist_archive_template($template){

        if ( is_archive() ){
            $tracklist_post_types = array(
                wpsstm()->post_type_album,
                wpsstm()->post_type_playlist,
                wpsstm()->post_type_live_playlist
            );

            if ( in_array(get_post_type(),$tracklist_post_types) ){
                $template = get_stylesheet_directory() . '/archive-tracklist.php';
            }
        }
        
        return $template;
    }
    
    /*
    Temporary and foirax function to hack the 'My Music' menu and its 'My Playlists' and 'My Live Playlists' submenus.  
    Should be removed once the wpsstm BuddyPress stuff works.
    */
    function my_music_menu($items, $menu, $args) {
        global $wp_query;
        
        if ( is_admin() ) return $items;

        foreach($items as $key=>$item){
            if ( ($item->post_title == 'My Music') || ($item->post_title == 'My Playlists') || ($item->post_title == 'My Live Playlists') ){
                $user_id = get_current_user_id();
                if ( !$user_id ){ //unset menu
                    unset($items[$key]);
                }else{ 
                    //replace %d by current user ID in URL
                    $item->url = sprintf($item->url,(int)$user_id);
                    
                    $query_author = $wp_query->get('author');
                    $query_post_type = $wp_query->get('post_type');
                    
                    if ( in_array($query_post_type,array('wpsstm_playlist','wpsstm_live_playlist')) ){
                        
                        if ( $query_author == $user_id ){
                            if ($item->post_title == 'My Music'){
                                $item->classes[] = 'current-menu-ancestor';
                                $item->classes[] = 'current-menu-parent';
                            }

                            if ( ($query_post_type == 'wpsstm_playlist') && ($item->post_title == 'My Playlists') ){
                                $item->classes[] = 'current-menu-item';
                            }

                            if ( ($query_post_type == 'wpsstm_live_playlist') && ($item->post_title == 'My Live Playlists') ){
                                $item->classes[] = 'current-menu-item';
                            }
                        }
                    }
                    

                    
                }
            }
        }

        return $items;
    }
    
}

function spiff_theme() {
	return SpiffV2Theme::instance();
}

spiff_theme();

