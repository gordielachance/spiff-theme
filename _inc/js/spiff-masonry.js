jQuery(document).ready(function($) {    
    //masonry
    var $container = $('.wpsstm-playlists-loop');
    var $items = $container.find('.hentry');

    $container.imagesLoaded( function() {
        $items.fadeIn();

        $container.masonry({
            itemSelector : '.hentry',
            percentPosition: true,
            columnWidth: '.masonry-sizer'
        });    
    });
});