/*
작성자: 권혁준 impactlife@naver.com

keyup 후 지정한 delay 후에 지정한 콜백 실행

사용예)
$(function(){
    $('#test1, #test2').keyupDelayEvent(
        {
            callback:function(){alert('aaa')
        }
    });
});
*/

(function($){
    $.fn.keyupDelayEvent = function(option){
        
        var config = $.extend({
            delay: 500,
            callback: function(){}
        }, option);
        
        var old_time = new Date();
        
        var is_keystart = false;
        
        var interval = null;
        
        function executeCallback(ref){
            if(is_keystart){
                var cur_time = new Date();
                var gap = cur_time.getTime() - old_time.getTime();
                if(gap >= config.delay){
                    config.callback.apply(ref);
                    is_keystart = false;
                    if(interval !== null){
                        clearInterval(interval);
                        interval = null;
                    }
                }
            }
        }
        
        $(this).keyup(function(e){
            var ref = this;
            is_keystart = true;
            old_time = new Date();
            if(interval === null){
                interval = setInterval(function(){
                    executeCallback(ref);
                }, 200);
            }
        });
        
        return this;
    }
    
    
}(jQuery));