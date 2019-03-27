(function($){

    $(document).ready(function($) {

        /*
        Picks
        */

        $( "#homepage-picks" ).tabs({
            childrenSelector:   '.hentry',
            activate: function(event ,ui){
                spiffTilesMasonry();
                /*
                var $container = $('.wpsstm-playlists-loop.spiff-masonry-wrapper');
                var $items = $container.find('.hentry');
                $container.imagesLoaded( function() {
                    $items.fadeIn();
                    $container.masonry({
                        itemSelector : '.hentry',
                        percentPosition: true,
                        columnWidth: '.masonry-sizer'
                    }); 
                });
                */
            }
        });
        $("#homepage-picks, #homepage-picks *").removeClass('ui-widget ui-widget-content ui-widget-header ui-tabs-panel');

        $('#homepage-picks li.ui-tabs-nav a').click(function() {
            /*
            var container = $j('.mini-gallery');

            container.imagesLoaded( function(){
            container.masonry({
                itemSelector : '.small-thumb'
              });
            });
            */
        })


    });
    
})(jQuery); // End jQuery Plugin