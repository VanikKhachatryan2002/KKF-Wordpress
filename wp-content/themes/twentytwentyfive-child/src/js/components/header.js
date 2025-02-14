jQuery(document).ready(function($) {
    const works_nav = $('.works-nav');
    const header = $('#header1');
    const menu = $('#menu');
    let timeout;

    works_nav.on('click', function(e) {
        e.preventDefault();
        if (menu.is(':visible')) {
            menu.fadeOut(300).addClass('hidden');
        } else {
            menu.fadeIn(300).removeClass('hidden');
        }
    });
 
    if($(window).width() > 1024){
        works_nav.on('mouseenter', function() {
            menu.stop(true, true).fadeIn(300).removeClass('hidden');
        });
    
        header.on('mouseleave', function() {
            timeout = setTimeout(() => {
                menu.fadeOut(300, function() {
                    $(this).addClass('hidden');
                });
            }, 300);  
        });
    
        menu.on('mouseenter', function() {
            clearTimeout(timeout);
        });
    
        menu.on('mouseleave', function() {
            menu.fadeOut(300, function() {
                $(this).addClass('hidden');
            });
        });
    }
   
});