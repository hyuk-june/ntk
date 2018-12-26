/*
참고: http://www.domawe.net/2015/08/accordion-menu.html
*/

$.fn.accordionMenu = function(){
    
    $(this).addClass('accmenu');
    
    $('li', this).each(function(i, e){
        
        if($(e).children().size() < 2) return true;
        
        
        $(this).addClass('has-sub');
    });

    $('li.active', this).addClass('open').children('ul').show();
    
    $('li a', this).on('click', function(){
        if($(this).siblings().size() < 1) return;
        
        $(this).removeAttr('href');
        var element = $(this).parent('li');
        //element.addClass('has-sub');
        
        if (element.hasClass('open')) {
            element.removeClass('open');
            element.find('li').removeClass('open');
            element.find('ul').slideUp(200);
        }
        else {
            element.addClass('open');
            element.children('ul').slideDown(200);
            element.siblings('li').children('ul').slideUp(200);
            element.siblings('li').removeClass('open');
            element.siblings('li').find('li').removeClass('open');
            element.siblings('li').find('ul').slideUp(200);
        }
    });
}
