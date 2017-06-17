jQuery(document).ready(function($) {
    /*
    menu
    */
    var sidebar_menu = $('ul#menu-sidebar');
    //menu click
    sidebar_menu.find('.menu-item-has-children > a').click(function(e) {
        
        e.preventDefault();

        var current_li_el = sidebar_menu.find('current-menu-active');
        
        var li_el = $(this).parent('li');
        var li_submenu_el = li_el.find('> ul');
        
        if ( li_el.is( current_li_el ) ) { //reduce
            li_el.removeClass('current-menu-active');
        } else { //expand
            current_li_el.removeClass('current-menu-active'); //previous expanded menu
            li_submenu_el.find('.sub-menu').slideUp(350);
            li_el.toggleClass('current-menu-active');
        }
        li_submenu_el.slideToggle(350);
    });

    /*
    masonry
    */
    
    var $container = $('.wpsstm-playlists-loop.wpsstm-masonry');
    var $items = $container.find('.hentry');
    $items.hide();
    
    $container.imagesLoaded( function() {
        $items.fadeIn();
        $container.masonry({
            itemSelector : '.hentry',
            percentPosition: true,
            columnWidth: '.masonry-sizer'
        }); 
    });
    
    /*
    Picks
    */
    
    $( "#homepage-picks" ).tabs({
        childrenSelector:   '.hentry'
    });
    
    
    
    
});